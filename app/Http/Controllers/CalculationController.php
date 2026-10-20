<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use App\Models\GreenAreaRate;
use App\Models\HardItem;
use App\Models\SoftRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalculationController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        $sort = $request->query('sort', 'newest');

        $query = Calculation::query();

        if ($q !== '') {
            $query->where('development_type', 'like', "%{$q}%");
        }

        match ($sort) {
            'oldest'  => $query->oldest(),
            'highest' => $query->orderByDesc('grand_total'),
            'lowest'  => $query->orderBy('grand_total'),
            default   => $query->latest(),
        };

        return view('calculations.index', [
            'calculations' => $query->get(),
            'q'            => $q,
            'sort'         => $sort,
        ]);
    }

    public function create()
    {
        return view('calculations.create', [
            'greenRates' => GreenAreaRate::orderBy('id')->get(),
            'softRates'  => SoftRate::orderBy('id')->get(),
            'hardItems'  => HardItem::orderBy('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateCalculation($request);

        DB::transaction(function () use ($data) {
            $calculation = Calculation::create($this->buildTotals($data));
            $calculation->items()->createMany($this->buildItems($data));
        });

        return redirect()->route('calculations.index')
            ->with('success', 'Pengiraan berjaya disimpan.');
    }

    public function show(Calculation $calculation)
    {
        $calculation->load('greenAreaRate', 'items');

        return view('calculations.show', compact('calculation'));
    }

    public function edit(Calculation $calculation)
    {
        $calculation->load('greenAreaRate', 'items');

        // Reconstruct soft rows (section B) for the form
        $softRows = $calculation->items
            ->where('section', 'B')
            ->map(fn ($item) => [
                'rate_id' => SoftRate::where('name', $item->name)->value('id'),
                'detail'  => $item->detail,
                'qty'     => $item->qty,
            ])->values();

        // Reconstruct hard rows (section C)
        $hardRows = $calculation->items
            ->where('section', 'C')
            ->map(fn ($item) => [
                'item_id' => HardItem::where('name', $item->name)->value('id'),
                'qty'     => $item->qty,
                'detail'  => $item->detail,
            ])->values();

        return view('calculations.edit', [
            'calculation' => $calculation,
            'greenRates'  => GreenAreaRate::orderBy('id')->get(),
            'softRates'   => SoftRate::orderBy('id')->get(),
            'hardItems'   => HardItem::orderBy('id')->get(),
            'softRows'    => $softRows,
            'hardRows'    => $hardRows,
        ]);
    }

    public function update(Request $request, Calculation $calculation)
    {
        $data = $this->validateCalculation($request);

        DB::transaction(function () use ($data, $calculation) {
            $calculation->items()->delete();
            $calculation->update($this->buildTotals($data));
            $calculation->items()->createMany($this->buildItems($data));
        });

        return redirect()->route('calculations.show', $calculation)
            ->with('success', 'Pengiraan berjaya dikemaskini.');
    }

    public function duplicate(Calculation $calculation)
    {
        $calculation->load('items');

        DB::transaction(function () use ($calculation) {
            $newCalc = $calculation->replicate();
            $newCalc->development_type = $calculation->development_type . ' (Salinan)';
            $newCalc->created_at = now();
            $newCalc->updated_at = now();
            $newCalc->save();

            foreach ($calculation->items as $item) {
                $newItem = $item->replicate();
                $newItem->calculation_id = $newCalc->id;
                $newItem->save();
            }
        });

        return redirect()->route('calculations.index')
            ->with('success', 'Pengiraan berjaya disalin.');
    }

    public function destroy(Calculation $calculation)
    {
        $calculation->delete();

        return redirect()->route('calculations.index')
            ->with('success', 'Pengiraan telah dipadam.');
    }

    // ── Shared helpers ────────────────────────────────────────────────────────

    private function validateCalculation(Request $request): array
    {
        return $request->validate([
            'development_type'    => 'nullable|string|max:255',
            'green_area_rate_id'  => 'required|exists:green_area_rates,id',
            'soft'                => 'nullable|array',
            'soft.*.rate_id'      => 'required|exists:soft_rates,id',
            'soft.*.detail'       => 'nullable|string|max:255',
            'soft.*.qty'          => 'required|numeric|min:0.01',
            'hard'                => 'nullable|array',
            'hard.*.item_id'      => 'required|exists:hard_items,id',
            'hard.*.qty'          => 'required|numeric|min:0.01',
            'hard.*.detail'       => 'nullable|string|max:255',
        ]);
    }

    private function buildItems(array $data): array
    {
        $items = [];

        foreach ($data['soft'] ?? [] as $row) {
            $rate = SoftRate::findOrFail($row['rate_id']);
            $subtotal = round($rate->rate * $row['qty'] * 12, 2);
            $items[] = [
                'section'  => 'B',
                'name'     => $rate->name,
                'detail'   => $row['detail'] ?? null,
                'qty'      => $row['qty'],
                'rate'     => $rate->rate,
                'unit'     => $rate->unit,
                'months'   => 12,
                'subtotal' => $subtotal,
            ];
        }

        foreach ($data['hard'] ?? [] as $row) {
            $item = HardItem::findOrFail($row['item_id']);
            $subtotal = round($item->rate * $row['qty'], 2);
            $items[] = [
                'section'  => 'C',
                'name'     => $item->name,
                'detail'   => $item->unit === 'l/s' ? ($row['detail'] ?? null) : null,
                'qty'      => $row['qty'],
                'rate'     => $item->rate,
                'unit'     => $item->unit,
                'months'   => null,
                'subtotal' => $subtotal,
            ];
        }

        return $items;
    }

    private function buildTotals(array $data): array
    {
        $green  = GreenAreaRate::findOrFail($data['green_area_rate_id']);
        $totalB = 0;
        $totalC = 0;

        foreach ($data['soft'] ?? [] as $row) {
            $rate    = SoftRate::findOrFail($row['rate_id']);
            $totalB += round($rate->rate * $row['qty'] * 12, 2);
        }

        foreach ($data['hard'] ?? [] as $row) {
            $item    = HardItem::findOrFail($row['item_id']);
            $totalC += round($item->rate * $row['qty'], 2);
        }

        return [
            'development_type'   => $data['development_type'],
            'green_area_rate_id' => $green->id,
            'total_a'            => $green->amount,
            'total_b'            => $totalB,
            'total_c'            => $totalC,
            'grand_total'        => $green->amount + $totalB + $totalC,
        ];
    }
}