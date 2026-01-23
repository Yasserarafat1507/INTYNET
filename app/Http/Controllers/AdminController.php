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

    public function data()
    {
        return DataTables::of(Customer::latest())
            ->addIndexColumn()

            ->addColumn('kordinat', function ($row) {
                return $row->latitude . ', ' . $row->longitude;
            })

            ->addColumn('status', function ($row) {
                $waiting = config('constants.status.waiting');
                $accepted = config('constants.status.accepted');
                $rejected = config('constants.status.rejected');

                if ($row->status == $waiting) {
                    return '<span class="flex justify-center bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    Waiting
                </span>';
                }

                if ($row->status == $accepted) {
                    return '<span class="flex justify-center bg-green-50 border border-green-200 text-green-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    Accepted
                </span>';
                }

                if ($row->status == $rejected) {
                    return '<span class="flex justify-center bg-red-50 border border-red-200 text-red-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    Rejected
                </span>';
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

            ->rawColumns(['status', 'action'])
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
