<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('form.index');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'      => 'required|string|max:100',
                'email'     => 'required|email|max:100|unique:customers,email',
                'phone'     => 'required|string|max:20|unique:customers,phone',
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
            ],
            [
                'email.unique' => 'Email sudah terdaftar',
                'phone.unique' => 'Nomor sudah terdaftar',
                'latitude.required' => 'Silakan pilih lokasi pada peta',
            ]
        );

        Customer::create($request->all());

        return redirect()
            ->route('form.index')
            ->with('success', 'Pendaftaran berhasil');
    }
}
