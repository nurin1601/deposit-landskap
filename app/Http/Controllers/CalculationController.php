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
            'oldest' => $query->oldest(),
            'highest' => $query->orderByDesc('grand_total'),
            'lowest' => $query->orderBy('grand_total'),
            default => $query->latest(),
        };

        return view('calculations.index', [
            'calculations' => $query->get(),
            'q' => $q,
            'sort' => $sort,
        ]);
    }

    public function create()
    {
        return view('calculations.create', [
            'greenRates' => GreenAreaRate::orderBy('id')->get(),
            'softRates' => SoftRate::orderBy('id')->get(),
            'hardItems' => HardItem::orderBy('id')->get(),
        ]);
    }

    public function show(Calculation $calculation)
    {
        $calculation->load('greenAreaRate', 'items');

        return view('calculations.show', compact('calculation'));
    }

    public function destroy(Calculation $calculation)
    {
        $calculation->delete();

        return redirect()->route('calculations.index')
            ->with('success', 'Pengiraan telah dipadam.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'development_type' => 'nullable|string|max:255',
            'development_type' => 'nullable|string|max:255',
            'green_area_rate_id' => 'required|exists:green_area_rates,id',
            'soft' => 'nullable|array',
            'soft.*.rate_id' => 'required|exists:soft_rates,id',
            'soft.*.detail' => 'nullable|string|max:255',
            'soft.*.qty' => 'required|numeric|min:0.01',
            'hard' => 'nullable|array',
            'hard.*.item_id' => 'required|exists:hard_items,id',
            'hard.*.qty' => 'required|numeric|min:0.01',
            'hard.*.detail' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($data) {
            $green = GreenAreaRate::findOrFail($data['green_area_rate_id']);
            $items = [];
            $totalB = 0;
            $totalC = 0;

            foreach ($data['soft'] ?? [] as $row) {
                $rate = SoftRate::findOrFail($row['rate_id']);
                $subtotal = round($rate->rate * $row['qty'] * 12, 2);
                $totalB += $subtotal;
                $items[] = [
                    'section' => 'B',
                    'name' => $rate->name,
                    'detail' => $row['detail'] ?? null,
                    'qty' => $row['qty'],
                    'rate' => $rate->rate,
                    'unit' => $rate->unit,
                    'months' => 12,
                    'subtotal' => $subtotal,
                ];
            }

            foreach ($data['hard'] ?? [] as $row) {
                $item = HardItem::findOrFail($row['item_id']);
                $subtotal = round($item->rate * $row['qty'], 2);
                $totalC += $subtotal;
                $items[] = [
                    'section' => 'C',
                    'name' => $item->name,
                    'detail' => $item->unit === 'l/s' ? ($row['detail'] ?? null) : null,
                    'qty' => $row['qty'],
                    'rate' => $item->rate,
                    'unit' => $item->unit,
                    'months' => null,
                    'subtotal' => $subtotal,
                ];
            }

            $calculation = Calculation::create([
                'development_type' => $data['development_type'],
                'green_area_rate_id' => $green->id,
                'total_a' => $green->amount,
                'total_b' => $totalB,
                'total_c' => $totalC,
                'grand_total' => $green->amount + $totalB + $totalC,
            ]);

            $calculation->items()->createMany($items);
        });

        return redirect()->route('calculations.index')
            ->with('success', 'Pengiraan berjaya disimpan.');
    }
}