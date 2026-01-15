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
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|numeric|min_digits:10|unique:customers,phone',
            'latitude' => 'required',
            'longitude' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.min' => 'Nama minimal 3 karakter',

            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',

            'phone.required' => 'Nomor HP wajib diisi',
            'phone.numeric' => 'Nomor HP tidak valid',
            'phone.min_digits' => 'Nomor HP minimal 10 digit',

            'latitude.required' => 'Lokasi belum dipilih',
            'longitude.required' => 'Lokasi belum dipilih',
        ], [
            'email.unique' => 'Email sudah terdaftar',
            'phone.unique' => 'Nomor HP sudah terdaftar',
        ]);

        Customer::create($request->all());

        return redirect()
            ->route('form.index')
            ->with('success', 'Pendaftaran berhasil dikirim!');
    }
}
