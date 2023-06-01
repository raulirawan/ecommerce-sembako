@extends('layouts.dashboard')

@section('title', 'Halaman Transaksi Detail')

@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Transaksi Detail</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Dashboard</a></li>
                                <li><a href="#">Transaksi Detail</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ url()->previous() }}" class="btn btn-primary mt-3 btn-sm d-inline-block" style="float: right">Kembali</a>

                            <strong class="card-title">Detail Transaksi</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 400px">Jenis Transaksi</th>
                                        <td>{{ $transaksi->jenis_transaksi }}</td>
                                    </tr>

                                    <tr>
                                        <th style="width: 400px">Status</th>
                                        @if ($transaksi->status == 'SELESAI')
                                            <td>
                                                <span class="badge badge-success text-white">SELESAI</span>
                                            </td>
                                        @elseif ($transaksi->status == 'PENDING')
                                        <td>
                                            <span class="badge badge-warning text-white">PENDING</span>
                                        </td>
                                        @elseif ($transaksi->status == 'SUDAH BAYAR')
                                        <td>
                                            <span class="badge badge-success text-white">SUDAH BAYAR</span>
                                        </td>
                                        @elseif ($transaksi->status == 'SEDANG DIKIRIM')
                                        <td>
                                            <span class="badge badge-warning text-white">SEDANG DIKIRIM</span>
                                        </td>
                                        @else
                                        <td>
                                            <span class="badge badge-danger text-white">BATAL</span>
                                        </td>
                                        @endif
                                    </tr>
                                    {{-- <tr>
                                        <th style="width: 400px">No Resi</th>
                                        <td>{{ $transaksi->no_resi != NULL ? $transaksi->no_resi : 'Tidak Ada' }}</td>
                                    </tr> --}}
                                    <tr>
                                        <th style="width: 400px">Tanggal Transaksi</th>
                                        <td>{{ $transaksi->created_at }}</td>
                                    </tr>

                                    <tr>
                                        <th style="width: 400px">Kode Transaksi</th>
                                        <td>{{ $transaksi->kode }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 400px">Nama Customer</th>
                                        <td>{{ $transaksi->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 400px">Nama Kurir</th>
                                        <td>{{ $transaksi->kurir->name ?? 'Tidak Ada' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 400px">Nama Admin</th>
                                        <td>{{ $transaksi->admin->name ?? 'Tidak Ada' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 400px">Alamat</th>
                                        <td>{{ $transaksi->alamat_pengiriman }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 400px">Provinsi</th>
                                        <td>{{ $transaksi->provinsi }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 400px">Kota</th>
                                        <td>{{ $transaksi->kota }}</td>
                                    </tr>
                                      <tr>
                                        <th style="width: 400px">Kecamatan</th>
                                        <td>{{ $transaksi->kecamatan }}</td>
                                    </tr>
                                      <tr>
                                        <th style="width: 400px">Kelurahan</th>
                                        <td>{{ $transaksi->kelurahan }}</td>
                                    </tr>

                                    <tr>
                                        <th style="width: 400px">Ongkos Kirim</th>
                                        <td>
                                            @if($transaksi->ongkos_kirim == 0)
                                            FREE
                                            @else
                                            Rp{{ number_format($transaksi->ongkos_kirim) }}
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <th style="width: 400px">Harga</th>
                                        <td>Rp{{ number_format($transaksi->harga) }}</td>
                                    </tr> --}}
                                    <tr>
                                        <th style="width: 400px">Total Harga</th>
                                        <td>Rp{{ number_format($transaksi->total_harga) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                           @if ($transaksi->status == 'SUCCESS')
                           <form action="{{ route('owner.transaksi.update.resi', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="no_resi" placeholder="Masukan No Resi" class="form-control">
                                    <button class="btn btn-primary mt-3" style="display: inline; float: left">Update Resi</button>
                                </div>
                            </div>
                        </form>
                           @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">List Produk</strong>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">

                                <table id="table-data" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th>Nama Produk</th>
                                            <th style="width: 15%">Variant</th>
                                            <th style="width: 5%">Quantity</th>
                                            <th>Harga</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksi->detail as $val)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $val->produk->nama_produk }}</td>
                                            <td>{{ $val->variant }}</td>
                                            <td>{{ $val->qty }}</td>
                                            <td>Rp{{ number_format($val->harga) }}</td>
                                            <td>Rp{{ number_format($val->total_harga) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->


    @push('down-script')
        <script src="{{ asset('/') }}assets/js/lib/data-table/datatables.min.js"></script>
        <script src="{{ asset('/') }}assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
        <script src="{{ asset('/') }}assets/js/lib/data-table/dataTables.buttons.min.js"></script>
        <script src="{{ asset('/') }}assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
        <script src="{{ asset('/') }}assets/js/lib/data-table/jszip.min.js"></script>
        <script src="{{ asset('/') }}assets/js/lib/data-table/vfs_fonts.js"></script>
        <script src="{{ asset('/') }}assets/js/lib/data-table/buttons.html5.min.js"></script>
        <script src="{{ asset('/') }}assets/js/lib/data-table/buttons.print.min.js"></script>
        <script src="{{ asset('/') }}assets/js/lib/data-table/buttons.colVis.min.js"></script>
        <script src="{{ asset('/') }}assets/js/init/datatables-init.js"></script>
    @endpush
@endsection
