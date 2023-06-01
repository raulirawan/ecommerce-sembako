@extends('layouts.frontend')

@section('title','Halaman Profil')

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
        <div class="col-md-12 mb-0"><a href="{{ url('/') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Profil</strong></div>
      </div>
    </div>
  </div>

  <div class="site-section">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md-12" >
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
          <div class="site-blocks-table">
            <div class="row">
                <div class="col-md-6">
                    <h5>Data Profil</h5>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('update.profil') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-12">
                                    <label for="c_fname" class="text-black">Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="name" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="c_fname" class="text-black">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                    </div>
                                    <div class="col-md-12">
                                    <label for="c_lname" class="text-black">Nomor Handphone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  value="{{ Auth::user()->no_hp }}" name="no_hp" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <h5>Ganti Password</h5>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('update.password') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-12">
                                    <label for="c_fname" class="text-black">Password Lama<span class="text-danger">*</span></label>
                                    <input type="password" name="oldPassword"
                                            class="form-control @error('oldPassword') is-invalid @enderror"
                                            autocomplete="off" placeholder="Password Lama" required>
                                    <div class="invalid-feedback">
                                        Masukan Password Lama
                                    </div>
                                    </div>
                                    <div class="col-md-12">
                                    <label for="c_lname" class="text-black">Password Baru <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Password Baru" required>
                                    <div class="invalid-feedback">
                                        Konfirmasi Password Baru Tidak Sesuai
                                    </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="c_lname" class="text-black">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Konfirmasi Password Baru" required>
                                        <div class="invalid-feedback">
                                        Konfirmasi Password Baru Tidak Sesuai
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
          </div>
        </div>
      </div>


    </div>
  </div>

@endsection
