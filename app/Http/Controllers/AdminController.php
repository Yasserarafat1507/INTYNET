<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Yajra\DataTables\Facades\DataTables;
// use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function data()
    {
        return DataTables::of(Customer::query())
            ->addIndexColumn()

            ->addColumn('kordinat', function ($row) {
                return $row->latitude . ', ' . $row->longitude;
            })

            ->addColumn('status', function ($row) {
                $statusMap = [
                    config('constants.status.waiting')  => '<span class="badge bg-warning">Waiting</span>',
                    config('constants.status.accepted') => '<span class="badge bg-success">Accepted</span>',
                    config('constants.status.rejected') => '<span class="badge bg-danger">Rejected</span>',
                ];

                return $statusMap[$row->status] ?? '-';
            })

            ->addColumn('action', function ($row) {
                $waiting  = config('constants.status.waiting');
                $accepted = config('constants.status.accepted');
                $rejected = config('constants.status.rejected');

                if ($row->status === $waiting) {
                    return '
            <button class="btn btn-sm btn-success" data-id="' . $row->id . '" data-status="' . $accepted . '">
                Accept
            </button>
            <button class="btn btn-sm btn-danger" data-id="' . $row->id . '" data-status="' . $rejected . '">
                Reject
            </button>
        ';
                }

                if ($row->status === $accepted) {
                    return '<span class="badge bg-success">Accepted</span>';
                }

                if ($row->status === $rejected) {
                    return '<span class="badge bg-danger">Rejected</span>';
                }

                return '-';
            })


            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
