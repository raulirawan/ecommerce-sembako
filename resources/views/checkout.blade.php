@extends('layouts.frontend')

@section('title', 'Halaman Checkout')

@section('content')
    <style>
        @-webkit-keyframes spinner-border {
            to {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @keyframes spinner-border {
            to {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: text-bottom;
            border: .25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: spinner-border .75s linear infinite;
            animation: spinner-border .75s linear infinite
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: .2em
        }
    </style>
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="{{ route('home.index') }}">Home</a> <span class="mx-2 mb-0">/</span> <a
                        href="cart.html">Cart</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Checkout</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">

            <div class="row">
                <div class="col-md-6 mb-5 mb-md-0">
                    <h2 class="h3 mb-3 text-black">Data Informasi</h2>
                    <div class="p-3 p-lg-5 border">

                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="c_lname" class="text-black">Nama<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" name="provinsi" id="provinces">
                                        <option value="" disable="true" selected="true">Pilih Provinsi
                                        <option>
                                            @foreach (App\Models\Province::all() as $provincy)
                                        <option value="{{ $provincy->id }}">{{ $provincy->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" name="kota" id="regencies">
                                        <option value="" disable="true" selected="true"> Pilih Kota </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" name="kecamatan" id="districts">
                                        <option value="" disable="true" selected="true"> Pilih Kecamatan </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" name="kelurahan" id="villages">
                                        <option value="" disable="true" selected="true"> Pilih Kelurahan</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <select id="kurir" class="form-control" name="kurir" required disabled>
                                        <option value="">Pilih Kurir</option>
                                        <option value="jne">JNE</option>
                                        <option value="pos">POS</option>
                                        <option value="tiki">TIKI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select id="layanan" class="form-control" name="layanan" required disabled>
                                        <option value="">Pilih Layanan</option>
                                    </select>
                                </div>
                            </div> --}}
                        </div>

                        <div class="form-group">
                            <label for="" class="text-black">Alamat Lengkap<span
                                    class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat Lengkap"></textarea>
                        </div>


                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h2 class="h3 mb-3 text-black">Orderan Anda</h2>
                            <div class="p-3 p-lg-5 border">
                                <table class="table site-block-order-table mb-5">
                                    <thead>
                                        <th>Product</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($carts as $cart)
                                            <tr>
                                                <td>{{ $cart->produk->nama_produk }} <strong class="mx-2">x</strong>
                                                    {{ $cart->qty }}</td>
                                                <td>Rp{{ number_format($cart->harga) }}</td>
                                                <td>Rp{{ number_format($cart->total_harga) }}</td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Sub Total</strong></td>
                                            <td class="text-black font-weight-bold"></td>
                                            <td class="text-black font-weight-bold">
                                                <strong>Rp{{ number_format($total) }}</strong>
                                            </td>
                                            <input type="hidden" value="{{ $total }}" id="sub_total">
                                        </tr>
                                        <tr id="ongkos_kirim">
                                            <td class="text-black font-weight-bold"><strong>Ongkos Kirim</strong></td>
                                            <td class="text-black font-weight-bold"></td>
                                            <td class="text-black font-weight-bold">FREE</td>
                                        </tr>
                                        <tr id="total-tr">
                                            <td class="text-black font-weight-bold"><strong>Total</strong></td>
                                            <td class="text-black font-weight-bold"><strong id="total"></strong></td>
                                            <td class="text-black font-weight-bold">Rp{{ number_format($total) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <select name="jenis_transaksi" id="jenis_transaksi" class="form-control">
                                                    <option value="">Pilih Pembayaran</option>
                                                    <option value="PEMBAYARAN OTOMATIS">Pembayaran Otomatis</option>
                                                    <option value="COD">COD</option>
                                                </select>
                                            </td>

                                        </tr>
                                        {{-- <tr id="ongkos_kirim" class="d-none">
                        <td class="text-black font-weight-bold"><strong>Ongkos Kirim</strong></td>
                      </tr>
                    <tr class="d-none" id="total-tr">
                      <td class="text-black font-weight-bold"><strong>Total</strong></td>
                      <td class="text-black font-weight-bold"><strong id="total"></strong></td>
                    </tr> --}}
                                    </tbody>
                                </table>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" id="button-pesanan" onclick="buatPesanan()">Buat
                                        Pesanan</button>
                                    <button class="btn btn-primary btn-lg btn-block d-none" id="button-loading" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- </form> -->
        </div>
    </div>

    @push('down-script')
        <script>
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            $('#provinces').on('change', function(e) {
                var province_id = e.target.value;
                $.get('/regencies?province_id=' + province_id, function(data) {
                    $('#regencies').empty();
                    $('#regencies').append(
                        '<option value="0" disable="true" selected="true"> Pilih Kota </option>');
                    $('#districts').empty();
                    $('#districts').append(
                        '<option value="0" disable="true" selected="true"> Pilih Kecamatan </option>');
                    $('#villages').empty();
                    $('#villages').append(
                        '<option value="0" disable="true" selected="true"> Pilih Kelurahan</option>');
                    $.each(data, function(index, regenciesObj) {
                        $('#regencies').append('<option value="' + regenciesObj.id + '">' + regenciesObj
                            .name + '</option>');
                    })
                });
            });
            $('#regencies').on('change', function(e) {
                var regencies_id = e.target.value;
                $.get('/districts?regencies_id=' + regencies_id, function(data) {
                    $('#districts').empty();
                    $('#districts').append(
                        '<option value="0" disable="true" selected="true"> Pilih Kecamatan </option>');
                    $.each(data, function(index, districtsObj) {
                        $('#districts').append('<option value="' + districtsObj.id + '">' + districtsObj
                            .name + '</option>');
                    })
                });
            });
            $('#districts').on('change', function(e) {
                var districts_id = e.target.value;
                $.get('/village?districts_id=' + districts_id, function(data) {
                    $('#villages').empty();
                    $('#villages').append(
                        '<option value="0" disable="true" selected="true"> Pilih Kelurahan</option>');
                    $.each(data, function(index, villagesObj) {
                        $('#villages').append('<option value="' + villagesObj.id + '">' + villagesObj
                            .name + '</option>');
                        console.log("|" + villagesObj.id + "|" + villagesObj.district_id + "|" +
                            villagesObj.name);
                    })
                });
            });
            // $('#kota').on('change', function(e) {
            //     $("#kurir").prop('disabled', false);
            // });
            // $('#kurir').on('change', function(e) {
            //     $('#ongkos_kirim').addClass('d-none');
            //     $('#total-tr').addClass('d-none');

            //     $("#kurir").prop('disabled', false);
            //     var provinsi_id = $('select[name=provinsi] option').filter(':selected').val();
            //     var kota_id = $('select[name=kota] option').filter(':selected').val();
            //     var kurir = $('select[name=kurir] option').filter(':selected').val();
            //     $('#layanan').empty();
            //     $('#layanan').append('<option value="0" disable="true" selected="true">Pilih Layanan</option>');
            //     $.ajax({
            //         type: "POST",
            //         url: "{{ route('get.ongkir') }}",
            //         headers: {
            //             "X-CSRF-TOKEN": "{{ csrf_token() }}"
            //         },
            //         data: {
            //             "provinsi_id": provinsi_id,
            //             "kota_id": kota_id,
            //             "kurir": kurir,
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             $('#layanan').prop('disabled', false);
            //             let html = '';
            //             var data = response.costs;
            //             $.each(data, function(index, value) {
            //                 var value = data[index].cost[0].value;
            //                 html += `
    //                 <option value="${value}" disable="true">${data[index].service} (${numberWithCommas(value)})</option>
    //             `;
            //             });
            //             $('#layanan').append(html);
            //         }
            //     });
            // });

            // $('#layanan').on('change', function(e) {
            //     $('#text-ongkir').remove();
            //     $('#ongkir').remove();

            //     var layanan = $('select[name=layanan] option').filter(':selected').val();

            //     let html = '';
            //     html += `
    //     <td class="text-black" id="text-ongkir"><strong>Rp${numberWithCommas(layanan)}</strong></td>
    //     <input type="hidden"  id="ongkir" value="${layanan}" />
    // `;
            //     $('#ongkos_kirim').removeClass('d-none');
            //     $('#ongkos_kirim').append(html);

            //     var ongkir = parseInt($("#ongkir").val());
            //     var sub_total = parseInt($("#sub_total").val());
            //     var total_harga = ongkir + sub_total;

            //     $('#total-tr').removeClass('d-none');
            //     $('#total').text('Rp' + numberWithCommas(total_harga));

            // });

            function buatPesanan() {
        if (confirm("Buat Pesanan ?")) {
                    var ongkir = parseInt($("#ongkir").val());
                    var alamat = $("#alamat").val();
                    var provinsi = $('select[name=provinsi] option').filter(':selected').text();
                    var kota = $('select[name=kota] option').filter(':selected').text();
                    var kecamatan = $('select[name=kecamatan] option').filter(':selected').text();
                    var kelurahan = $('select[name=kelurahan] option').filter(':selected').text();
                    var jenis_transaksi = $('select[name=jenis_transaksi] option').filter(':selected').val();

                    if (provinsi.length == 0) {
                        alert('Provinsi Tidak Boleh Kosong!');
                        return false;
                    }
                    if (kota.length == 0) {
                        alert('Kota Tidak Boleh Kosong!');
                        return false;
                    }
                    if (kecamatan.length == 0) {
                        alert('Kecamatan Tidak Boleh Kosong!');
                        return false;
                    }
                    if (kelurahan.length == 0) {
                        alert('Kelurahan Tidak Boleh Kosong!');
                        return false;
                    }
                    if (alamat.length == 0) {
                        alert('Alamat Tidak Boleh Kosong!');
                        return false;
                    }
                     if (jenis_transaksi.length == 0) {
                        alert('Jenis Transaksi Tidak Boleh Kosong!');
                        return false;
                    }

                    $("#button-loading").removeClass('d-none');
                    $("#button-pesanan").addClass('d-none');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('checkout.post') }}",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        data: {
                            "ongkir": ongkir,
                            "alamat": alamat,
                            "provinsi": provinsi,
                            "kota": kota,
                            "kecamatan": kecamatan,
                            "kelurahan": kelurahan,
                            "jenis_transaksi": jenis_transaksi,
                        },
                        dataType: 'json',
                        success: function(result, textStatus, jqXHR) {
                            if (result.status == 'success') {
                                alert(result.message);
                                window.location.replace(result.url);
                            } else {
                                alert(result.message);
                                window.location.replace(result.url);
                            }
                            $("#button-loading").addClass('d-none');
                            $("#button-pesanan").removeClass('d-none');
                        }
                    });
                }


            }
        </script>
    @endpush
@endsection
