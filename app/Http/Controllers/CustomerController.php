<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('pages.form');
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|max:100',
            'phone'     => 'required|string|max:20',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Customer::create($validated);

        return redirect()
            ->route('customer.index')
            ->with('success', 'Data berhasil disimpan.');
    }
}
