@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
            <!-- Widgets  -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-1">
                                    <i class="pe-7s-cash"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="">Rp{{ number_format($pendapatan) }}</span></div>
                                        <div class="stat-heading">Pendapatan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-2">
                                    <i class="pe-7s-cart"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $produk }}</span></div>
                                        <div class="stat-heading">Produk</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-1">
                                    <i class="pe-7s-check"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $success }}</span></div>
                                        <div class="stat-heading">Transaksi Sukses</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-4">
                                    <i class="pe-7s-users"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $customer }}</span></div>
                                        <div class="stat-heading">Customer</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Widgets -->
            <!--  Traffic  -->

            <!--  /Traffic -->
            <div class="clearfix"></div>
            <!-- Orders -->
            <div class="orders">
                <div class="row">
                    <div class="col-xl-12">
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
                            <div class="card-body">
                                <h4 class="box-title">Orderan Masuk</h4>
                            </div>
                            <div class="card-body--">
                                <div class="table-stats order-table ov-h">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Kode</th>
                                                <th>Nama Customer</th>
                                                <th>Total Harga</th>
                                                <th>Jenis Transaksi</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse (App\Transaksi::whereIn('status', ['SUDAH BAYAR', 'PENDING'])->orderBy('created_at','DESC')->get() as $transaksi)
                                                <tr>

                                                    <td>{{ $transaksi->created_at }}</td>
                                                    <td>{{ $transaksi->kode }}</td>
                                                    <td>{{ $transaksi->user->name }}</td>
                                                    <td>{{ number_format($transaksi->total_harga) }}</>
                                                    </td>
                                                    <td>{{ $transaksi->jenis_transaksi ?? 'Tidak Ada' }}</td>
                                                    <td>
                                                        @if ($transaksi->status == 'PENDING')
                                                            <span class="badge badge-warning">PENDING</span>
                                                        @elseif ($transaksi->status == 'SUDAH BAYAR')
                                                            <span class="badge badge-success">SUDAH BAYAR</span>
                                                        @else
                                                            <span class="badge badge-danger">UNDEFINED</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (Auth::user()->roles == 'OWNER')
                                                        <a href="{{ route('owner.transaksi.detail', $transaksi->id) }}" class="btn btn-primary badge text-white">Detail</a>
                                                        @else
                                                        <a href="{{ route('admin.transaksi.detail', $transaksi->id) }}" class="btn btn-primary badge text-white">Detail</a>

                                                        @endif
                                                        @if ($transaksi->status == 'SUDAH BAYAR')
                                                        <button class="btn btn-success badge"
                                                            id="terima"
                                                            data-toggle="modal"
                                                            data-target="#modal-terima"
                                                            data-id="{{ $transaksi->id }}">Terima</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak Ada Data Order Masuk</td>
                                            </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div> <!-- /.table-stats -->
                            </div>
                        </div> <!-- /.card -->
                    </div> <!-- /.col-lg-8 -->


                </div>
            </div>
            <div class="modal fade" id="modal-terima" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pilih Kurir</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="form-terima" action="#" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Kurir</label>
                                        <select name="kurir_id" id="kurir_id" class="form-control" required>
                                            <option value="">Pilih Kurir</option>
                                            @foreach (App\User::where('roles', 'KURIR')->get() as $kurir)
                                                <option value="{{ $kurir->id }}">{{ $kurir->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- .animated -->
    </div>
@endsection
@push('down-script')
    <script>
        $(document).on('click', '#terima', function() {
            var id = $(this).data('id');
            var roles = "{{ Auth::user()->roles }}";

            if(roles == 'OWNER') {
                $('#form-terima').attr('action', '/owner/terima/order/' + id);
            }else {
                $('#form-terima').attr('action', '/admin/terima/order/' + id);
            }

        });
    </script>
@endpush
