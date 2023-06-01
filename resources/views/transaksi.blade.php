@extends('layouts.frontend')

@section('title','Halaman Transaksi')

@section('content')
@push('down-script')
    <style>
        th {
            padding: 10px !important;
        }
        td {
            padding: 10px !important;
        }
        .btn {
            height: 30px;
        }
    </style>
@endpush
<div class="bg-light py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mb-0"><a href="{{ url('/') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Transaksi</strong></div>
      </div>
    </div>
  </div>

  <div class="site-section">
    <div class="container">
      <div class="row mb-5">
        <form class="col-md-12" method="post">
          <div class="site-blocks-table">
            <h5>List Data Transaksi</h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tanggal Transaksi</th>
                  <th>Kode</th>
                  <th>Status</th>
                  <th>Ongkos Kirim</th>
                  <th>Harga</th>
                  <th>Total Harga</th>
                  <th>Jenis Pembayaran</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($transaksi as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>
                        @if ($item->status == 'SELESAI')
                        <span class="badge badge-success">SELESAI</span>
                        @elseif ($item->status == 'PENDING')
                        <span class="badge badge-warning">PENDING</span>
                        @elseif ($item->status == 'SUDAH BAYAR')
                        <span class="badge badge-success">SUDAH BAYAR</span>
                        @elseif ($item->status == 'SEDANG DIKIRIM')
                        <span class="badge badge-warning">SEDANG DIKIRIM</span>
                        @else
                        <span class="badge badge-danger">BATAL</span>
                        @endif
                    </td>
                    <td>FREE</td>
                    <td>Rp{{ number_format($item->harga) }}</td>
                    <td>Rp{{ number_format($item->total_harga) }}</td>
                    <td>{{ $item->jenis_transaksi == 'COD' ? 'COD' : 'Non Tunai' }}</td>
                    <td>
                        <a
                            style="color: #fff"
                            onclick="detailTransaction({{ $item->id }})"
                            data-toggle="modal"
                            data-target="#modal-detail"
                            class="btn btn-info">Detail
                        </a>
                        @if ($item->status == 'PENDING')
                        <a href="{{ url($item->link_pembayaran) }}" target="_blank" class="btn btn-success">Bayar</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="8">Tidak Ada Data</td>
                </tr>
                @endforelse


              </tbody>
            </table>
          </div>
        </form>
      </div>


    </div>
  </div>

  {{-- MODAL --}}

<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document" style="margin-top: 120px">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Transaksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm">
                <thead>
                  <tr>
                    <th>Nama Produk</th>
                    <th>Variant</th>
                    <th>Quantity</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
                  </tr>
                </thead>
                <tbody id="data-detail"></tbody>
              </table>
        </div>
</div>
</div>
</div>

  @push('down-script')
  <script>
      function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
      function detailTransaction(transaction_id) {
            $('#data-detail').html('');
            $.ajax({
                url: window.location.origin + "/transaksi/detail/" + transaction_id,
                method: 'get',
                dataType: 'json',
                success: function(e) {
                    let html = '';
                    e.forEach((val, item) => {
                        html += `
                            <tr>
                                <td>${val.produk.nama_produk}</td>
                                <td>${val.variant}</td>
                                <td>${val.qty}</td>
                                <td>Rp${numberWithCommas(val.harga)}</td>
                                <td>Rp${numberWithCommas(val.total_harga)}</td>
                            </tr>
                        `;
                    })
                    $('#data-detail').append(html)
                },error: function(e) {
                }
            })
        }
  </script>
  @endpush

@endsection
