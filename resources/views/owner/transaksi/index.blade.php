@extends('layouts.dashboard')

@section('title','Halaman Transaksi')

@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Transaksi</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Transaksi</a></li>
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
                        <strong class="card-title">Tabel Transaksi</strong>
                    </div>
                    <div class="row input-daterange ml-2 mt-2">
                        <div class="col-md-4">
                            <input type="date" name="from_date" id="from_date" value="{{ date('Y-m-d', strtotime('-7 days')) }}" class="form-control"
                                placeholder="From Date" />
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="to_date" id="to_date"  value="{{ date('Y-m-d') }}" class="form-control"
                                placeholder="To Date" />
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="filter" id="filter" class="btn btn-primary">Filter</button>
                            <button type="button" name="refresh" id="refresh"
                                class="btn btn-default">Refresh</button>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="table-data" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Tanggal Transaksi</th>
                                        <th>Kode</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Total Harga</th>
                                        @if (Auth::user()->roles == 'OWNER' || Auth::user()->roles == 'ADMIN')
                                        <th style="width: 15%">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <th id="total"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Data Transaksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="form-edit" action="#" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status Transaksi</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Pilih Status Transaksi</option>
                            <option value="PENDING">PENDING</option>
                            <option value="SELESAI">SELESAI</option>
                            <option value="SEDANG DIKIRIM">SEDANG DIKIRIM</option>
                            <option value="SUDAH BAYAR">SUDAH BAYAR</option>
                            <option value="BATAL">BATAL</option>
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
<link href="https://nightly.datatables.net/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
    $(document).on('click', '#edit', function(){
        var id = $(this).data('id');
        var roles = "{{ Auth::user()->roles }}";
        var status = $(this).data('status');
        $('#status').val(status).change();

        if(roles == 'OWNER') {
            $('#form-edit').attr('action','/owner/transaksi/update/' + id);
        }else {
            $('#form-edit').attr('action','/admin/transaksi/update/' + id);
        }
    });
</script>
<script>
        $(document).ready(function() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            load_data(from_date, to_date);

            $('#filter').click(function() {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                if (from_date != '' && to_date != '') {
                    $('#table-data').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    alert('Silahkan Pilih Tanggal')
                }
            });

            $('#refresh').click(function() {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#table-data').DataTable().destroy();
                load_data();
            });

            function load_data(from_date = '', to_date = '') {
                var datatable = $('#table-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ordering: true,
                    ajax: {
                        url: '{!! url()->current() !!}',
                        type: 'GET',
                        data: {
                            from_date: from_date,
                            to_date: to_date
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'pdfHtml5',
                            orientation: 'potrait',
                            footer: true,
                        },
                        {
                            extend: 'excelHtml5',
                            footer: true,
                        }
                    ],

                    columns: [
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'kode',
                            name: 'kode'
                        },
                        {
                            data: 'user.name',
                            name: 'user.name'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'total_harga',
                            name: 'total_harga',
                            render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searcable: false,
                            width: '15%',
                        }
                    ],

                    "footerCallback": function(row, data) {
                        var api = this.api(),
                            data;

                        var intVal = function(i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };

                        total = api
                            .column(4)
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Total over this page
                        price = api
                            .column(4, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        $(api.column(4).footer()).html(
                            'Rp' + price
                        );

                        var numFormat = $.fn.dataTable.render.number('\,', 'Rp').display;
                        $(api.column(4).footer()).html(
                            'Rp ' + numFormat(price)
                        );
                    }

                });
            }


        });
    </script>


@endpush
@endsection
