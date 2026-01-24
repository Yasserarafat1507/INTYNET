<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function data(Request $request)
    {
        $query = Customer::latest();

        if ($request->has('filter_status') && $request->filter_status != '') {
            
            if ($request->filter_status == 'waiting') {
                $query->where('status', config('constants.status.waiting'));
            } 
            elseif ($request->filter_status == 'accepted') {
                $query->where('status', config('constants.status.accepted'));
            } 
            elseif ($request->filter_status == 'rejected') {
                $query->where('status', config('constants.status.rejected'));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('kordinat', function ($row) {
                // HTML Tombol Peta
                return '<button type="button" 
                            class="btn-view-map text-blue-600 hover:text-blue-900 hover:underline font-medium flex items-center gap-1"
                            data-lat="' . $row->latitude . '" 
                            data-lng="' . $row->longitude . '">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Lihat Peta
                        </button>';
            })

            ->addColumn('status', function ($row) {
                $waiting = config('constants.status.waiting');
                $accepted = config('constants.status.accepted');
                $rejected = config('constants.status.rejected');

                // HTML Badge Status (Manual IF)
                if ($row->status == $waiting) {
                    return '<span class="flex justify-center bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-medium px-2.5 py-0.5 rounded-full">Waiting</span>';
                }

                if ($row->status == $accepted) {
                    return '<span class="flex justify-center bg-green-50 border border-green-200 text-green-700 text-xs font-medium px-2.5 py-0.5 rounded-full">Accepted</span>';
                }

                if ($row->status == $rejected) {
                    return '<span class="flex justify-center bg-red-50 border border-red-200 text-red-700 text-xs font-medium px-2.5 py-0.5 rounded-full">Rejected</span>';
                }

                return '';
            })

            ->addColumn('action', function ($row) {
                $waiting = config('constants.status.waiting');

                if ($row->status === $waiting) {
                    return view('admin.menu', ['row' => $row])->render();
                }

                return '';
            })

            ->rawColumns(['status', 'action', 'kordinat'])
            ->make(true);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:customers,id',
            'status' => 'required'
        ]);

        $customer = Customer::find($request->id);

        if ($customer) {
            $customer->status = $request->status;
            $customer->save();

            return response()->json(['success' => true, 'message' => 'Status berhasil diubah!']);
        }

        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
    }
}