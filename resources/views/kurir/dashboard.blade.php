@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
            <!-- Widgets  -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-1">
                                    <i class="pe-7s-gift"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span
                                                class="">{{ App\Transaksi::where('kurir_id', Auth::user()->id)->count() }}</span>
                                        </div>
                                        <div class="stat-heading">Total Barang</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-1">
                                    <i class="pe-7s-check"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span
                                                class="">{{ App\Transaksi::where(['kurir_id' => Auth::user()->id, 'status' => 'SELESAI'])->count() }}</span>
                                        </div>
                                        <div class="stat-heading">Selesai</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib text-warning">
                                    <i class="pe-7s-more"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span
                                                class="">{{ App\Transaksi::where(['kurir_id' => Auth::user()->id, 'status' => 'SEDANG DIKIRIM'])->count() }}</span>
                                        </div>
                                        <div class="stat-heading">Sedang Dikirim</div>
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
                                <h4 class="box-title">Data Pekerjaan</h4>
                            </div>
                            <div class="card-body--">
                                <div class="table-stats order-table ov-h">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Kode</th>
                                                <th>Nama Customer</th>
                                                <th>Alamat</th>
                                                <th>Jenis Transaksi</th>
                                                <th>Total Harga</th>
                                                <th>Bukti Pengiriman</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse (App\Transaksi::where('kurir_id', Auth::user()->id)->whereIn('status', ['SEDANG DIKIRIM','SELESAI'])->orderBy('created_at','DESC')->get() as $transaksi)
                                                <tr>

                                                    <td>{{ $transaksi->created_at }}</td>
                                                    <td>{{ $transaksi->kode }}</td>
                                                    <td>{{ $transaksi->user->name }}</td>
                                                    <td>
                                                        <button id="detail-alamat" data-toggle="modal"
                                                            data-target="#modal-detail-alamat"
                                                            data-kode="{{ $transaksi->kode }}"
                                                            data-provinsi="{{ $transaksi->provinsi }}"
                                                            data-kota="{{ $transaksi->kota }}"
                                                            data-kecamatan="{{ $transaksi->kecamatan }}"
                                                            data-kelurahan="{{ $transaksi->kelurahan }}"
                                                            data-alamat_pengiriman="{{ $transaksi->alamat_pengiriman }}"
                                                            class="btn btn-primary badge">Detail Alamat</button>
                                                    </td>
                                                    <td>{{ $transaksi->jenis_transaksi ?? 'Tidak Ada' }}</td>
                                                    <td>Rp{{ number_format($transaksi->total_harga) }}</td>
                                                    <td>
                                                        @if ($transaksi->bukti_pengiriman)
                                                        <img src="{{ asset($transaksi->bukti_pengiriman) }}" style="width: 100px">
                                                        @else
                                                        Tidak Ada
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($transaksi->status == 'SEDANG DIKIRIM')
                                                            <span class="badge badge-warning">SEDANG DIKIRIM</span>
                                                        @elseif ($transaksi->status == 'SELESAI')
                                                            <span class="badge badge-success">SELESAI</span>
                                                        @else
                                                            <span class="badge badge-danger">UNDEFINED</span>
                                                        @endif
                                                    </td>
                                                    @if (!$transaksi->bukti_pengiriman)
                                                    <td>
                                                        <a id="kirim" data-id="{{ $transaksi->id }}"
                                                            data-toggle="modal" data-target="#modal-kirim"
                                                            class="btn btn-primary badge text-white">Kirim</a>

                                                    </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak Ada Data Pekerjaan</td>
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
            <div class="modal fade" id="modal-kirim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upload Bukti Pengiriman</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="form-kirim" action="#" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Bukti Pengiriman</label>
                                        <input type="file" name="bukti_pengiriman" class="form-control" required>
                                        @if ($errors->has('bukti_pengiriman'))
                                            <span class="text-danger">{{ $errors->first('bukti_pengiriman') }}</span>
                                        @endif
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

            <div class="modal fade" id="modal-detail-alamat" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-title">Detail Alamat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">Provinsi</th>
                                        <td id="provinsi"></td>
                                    </tr>
                                    <tr>
                                        <th>Kota</th>
                                        <td id="kota"></td>
                                    </tr>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <td id="kecamatan"></td>
                                    </tr>
                                    <tr>
                                        <th>Kelurahan</th>
                                        <td id="kelurahan"></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td id="alamat_pengiriman"></td>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .animated -->
    </div>
@endsection
@push('down-script')
    @if ($errors->has('bukti_pengiriman'))
        <script>
            $("#modal-kirim").modal('show');
        </script>
    @endif
    <script>
        $(document).on('click', '#kirim', function() {
            var id = $(this).data('id');

            $('#form-kirim').attr('action', '/kurir/kirim/' + id);

        });

        $(document).on('click', '#detail-alamat', function() {
            var kode = $(this).data('kode');
            var provinsi = $(this).data('provinsi');
            var kota = $(this).data('kota');
            var kecamatan = $(this).data('kecamatan');
            var kelurahan = $(this).data('kelurahan');
            var alamat_pengiriman = $(this).data('alamat_pengiriman');

            $('#modal-title').text(`Detail Alamat ${kode}`);
            $('#provinsi').text(provinsi);
            $('#kota').text(kota);
            $('#kecamatan').text(kecamatan);
            $('#kelurahan').text(kelurahan);
            $('#alamat_pengiriman').text(alamat_pengiriman);

        });
    </script>
@endpush
