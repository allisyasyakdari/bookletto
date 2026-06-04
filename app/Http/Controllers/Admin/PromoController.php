<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::orderByDesc('created_at')->paginate(12);
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'subtitle' => 'nullable|string|max:191',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'code' => 'required|string|max:50|unique:promos,code',
            'discount_type' => 'required|in:percent,fixed',
            'discount' => 'nullable|integer|min:0|max:100',
            'discount_amount' => 'nullable|integer|min:0',
            'min_purchase' => 'nullable|integer|min:0',
            'expired_at' => 'nullable|date',
        ]);

        Promo::create($data);

        return redirect()->route('admin.promos.index')->with('status', 'Promo created.');
    }

    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'subtitle' => 'nullable|string|max:191',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'code' => 'required|string|max:50|unique:promos,code,' . $promo->id,
            'discount_type' => 'required|in:percent,fixed',
            'discount' => 'nullable|integer|min:0|max:100',
            'discount_amount' => 'nullable|integer|min:0',
            'min_purchase' => 'nullable|integer|min:0',
            'expired_at' => 'nullable|date',
        ]);

        $promo->update($data);

        return redirect()->route('admin.promos.index')->with('status', 'Promo updated.');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('admin.promos.index')->with('status', 'Promo deleted.');
    }
}
