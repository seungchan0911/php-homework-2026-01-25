<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Store;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::all();

        return view('store.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('store.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'logo' => 'nullable',
        ]);

        if ($request->hasFile('logo')) $validated['logo'] = $request->file('logo')->store('logos', 'public');

        Store::create($validated);

        return redirect()->route('stores.index')->with('message', "서점이 등록되었습니다!");
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        $store = Store::find($id);

        return view('store.view', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        return view('store.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        $validated = $request->validate([
            'name' => 'required',
            'logo' => 'nullable',
        ]);

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }

            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $store->update($validated);

        return redirect()->route('stores.show', $store->id)->with('message', "서점이 수정되었습니다!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        if ($store->logo) {
            Storage::disk('public')->delete($store->logo);
        }

        $store->delete();

        return redirect()->route('stores.index')->with('message', "삭제가 완료되었습니다!");
    }
}
