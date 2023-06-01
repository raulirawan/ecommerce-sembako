<?php

namespace App\Http\Controllers\Owner;

use App\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                if ($request->from_date === $request->to_date) {
                    $query  = Transaksi::query();
                    $query->with(['user'])
                        ->whereDate('created_at', $request->from_date);
                } else {
                    $query  = Transaksi::query();
                    $query->with(['user'])
                        ->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
                }
            } else {
                $today = date('Y-m-d');
                $query  = Transaksi::query();
                $query->with(['user'])
                    ->whereDate('created_at', $today);
            }

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    if (Auth::user()->roles == 'OWNER') {
                        return '<a href="' . route('owner.transaksi.detail', $item->id) . '" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Detail</a>
                        <button
                        id="edit"
                        data-toggle="modal"
                        data-target="#modal-edit"
                        class="btn btn-primary btn-sm"
                        data-id="' . $item->id . '"
                        data-status="' . $item->status . '"
                        >Edit</button> ';
                    } else  {
                        return '<a href="' . route('admin.transaksi.detail', $item->id) . '" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Detail</a>
                        <button
                        id="edit"
                        data-toggle="modal"
                        data-target="#modal-edit"
                        class="btn btn-primary btn-sm"
                        data-id="' . $item->id . '"
                        data-status="' . $item->status . '"
                        >Edit</button> ';
                    }
                })
                ->editColumn('status', function ($item) {
                    if ($item->status == 'SELESAI') {
                        return '<span class="badge badge-success">SELESAI</span>';
                    } elseif ($item->status == 'PENDING') {
                        return '<span class="badge badge-warning">PENDING</span>';
                    } elseif ($item->status == 'SUDAH BAYAR') {
                        return '<span class="badge badge-success">SUDAH BAYAR</span>';
                    } elseif ($item->status == 'SEDANG DIKIRIM') {
                        return '<span class="badge badge-warning">SEDANG DIKIRIM</span>';
                    } else {
                        return '<span class="badge badge-danger">BATAL</span>';
                    }
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at;
                })

                ->rawColumns(['action', 'status'])
                ->make();
        }
        return view('owner.transaksi.index');
    }
    public function update(Request $request, $id)
    {
        $data = Transaksi::findOrFail($id);

        $data->status = $request->status;
        $data->save();

        if ($data != null) {
            return redirect()->route(Auth::user()->roles == 'OWNER' ? 'owner.transaksi.index' : 'admin.transaksi.index')->with('success', 'Data Berhasil di Update');
        } else {
            return redirect()->route(Auth::user()->roles == 'OWNER' ? 'owner.transaksi.index' : 'admin.transaksi.index')->with('error', 'Data Gagal di Update');
        }
    }

    public function detail($id)
    {
        $transaksi = Transaksi::with(['detail', 'user'])->findOrFail($id);
        return view('owner.transaksi.detail', compact('transaksi'));
    }

    public function updateResi(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->no_resi = $request->no_resi;
        $transaksi->save();

        if ($transaksi != null) {
            return redirect()->route('owner.transaksi.detail', $id)->with('success', 'Data Resi Berhasil di Update');
        } else {
            return redirect()->route('owner.transaksi.detail', $id)->with('error', 'Data Resi Gagal di Update');
        }
    }

    public function terima(Request $request, $transaksi_id)
    {
        $transaksi = Transaksi::findOrFail($transaksi_id);
        $transaksi->kurir_id = $request->kurir_id;
        $transaksi->admin_id = Auth::user()->id;
        $transaksi->status = 'SEDANG DIKIRIM';
        $transaksi->save();

        if ($transaksi != null) {
            return redirect()->route(Auth::user()->roles == 'OWNER' ? 'owner.dashboard.index' : 'admin.dashboard.index')->with('success', 'Data Order Berhasil di Update');
        } else {
            return redirect()->route(Auth::user()->roles == 'OWNER' ? 'owner.dashboard.index' : 'admin.dashboard.index')->with('error', 'Data Order Gagal di Update');
        }
    }
}
