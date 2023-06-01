@extends('layouts.dashboard')

@section('title','Halaman List Produk')

@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>List Produk</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">List Produk</a></li>
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
                        <strong class="card-title">Tabel List Produk</strong>
                        <button data-toggle="modal" data-target="#modal-create" class="btn btn-info btn-sm mb-3 float-right">Tambah List Produk</button>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Nama</th>
                                        <th style="width: 15%">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listProduk as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_kategori }}</td>
                                            <td>
                                                <a
                                                id="edit"
                                                href="{{ route('owner.produk.index', $item->id)}}"
                                                class="btn btn-primary btn-sm float-left mr-1"
                                                >Detail</a>

                                            </td>
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
<script>
    $(document).on('click', '#edit', function(){
        var id = $(this).data('id');
        var nama_list produk = $(this).data('nama_list produk');
        var kategori = $(this).data('kategori');
        var stok = $(this).data('stok');
        var gambar = $(this).data('gambar');
        var harga = $(this).data('harga');
        var url = '{{ url('/') }}';

        $('#nama_list produk').val(nama_list produk);
        $('#kategori_edit').val(kategori).change();
        $('#stok').val(stok);
        $('#gambar').attr('src', url + '/' + gambar);
        $('#harga').val(harga);

        $('#form-edit').attr('action','/admin/list produk/update/' + id);
    });
</script>
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
