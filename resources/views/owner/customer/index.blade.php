@extends('layouts.dashboard')

@section('title','Halaman Customer')

@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Customer</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Customer</a></li>
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
                        <strong class="card-title">Tabel Customer</strong>
                        <button data-toggle="modal" data-target="#modal-create" class="btn btn-info btn-sm mb-3 float-right">Tambah Customer</button>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->no_hp ?? 'Tidak Ada' }}</td>
                                            <td>
                                                <button
                                                id="edit"
                                                data-toggle="modal"
                                                data-target="#modal-edit"
                                                class="btn btn-primary btn-sm float-left mr-1"
                                                data-id="{{ $item->id }}"
                                                data-nama_customer="{{ $item->name }}"
                                                data-no_hp="{{ $item->no_hp }}"
                                                >Edit</button>
                                                <form action="{{ route('owner.customer.delete', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ?')">Hapus</button>
                                                </form>
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
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('owner.customer.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Customer</label>
                        <input type="text" class="form-control"
                            value="{{ old('nama_customer') }}" name="nama_customer" placeholder="Masukan Nama Customer" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Customer</label>
                        <input type="email" class="form-control"
                            value="{{ old('email') }}" name="email" placeholder="Masukan Email" required>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control"
                            value="{{ old('password') }}" name="password" placeholder="Masukan Password" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No HP</label>
                        <input type="number" class="form-control"
                            value="{{ old('no_hp') }}" name="no_hp" placeholder="Masukan Nomor HP Customer" required>
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

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Data Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="form-edit" action="#" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Customer</label>
                        <input type="text" class="form-control"
                             id="nama_customer" name="nama_customer" placeholder="Masukan Nama Customer" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nomor Handphone</label>
                        <input type="number" class="form-control"
                             id="no_hp" name="no_hp" placeholder="Masukan Nomor Handphone" required>
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
@push('down-script')
@if (count($errors) > 0)
<script type="text/javascript">
    $('#modal-create').modal('show');
</script>
@endif
<script>

    $(document).on('click', '#edit', function(){
        // e.preventDefault();
        var id = $(this).data('id');
        var nama_customer = $(this).data('nama_customer');
        var no_hp = $(this).data('no_hp');
        $('#nama_customer').val(nama_customer);
        $('#no_hp').val(no_hp);

        $('#form-edit').attr('action','/admin/customer/update/' + id);
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
