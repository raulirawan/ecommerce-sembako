<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        return view('profil');
    }

    public function update(Request $request)
    {
        $data = User::findOrFail(Auth::user()->id);
        $data->name = $request->name;
        $data->no_hp = $request->no_hp;
        $data->save();

        if($data != null) {
            return redirect()->route('profil.index')->with('success','Berhasil Ubah Data Profil');
        } else {
            return redirect()->route('profil.index')->with('error','Gagal Ubah Data Profil');
        }
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request,[
            'oldPassword' => 'required',
            'password' => 'required|confirmed',

            ]);

            if(!(Hash::check($request->get('oldPassword'), Auth::user()->password))){

                return redirect()->route('profil.index')->with('error','Password Lama Anda Salah');

            }

            if(strcmp($request->get('oldPassword'), $request->get('password')) == 0){

                return redirect()->route('profil.index')->with('error','Password Lama Anda Tidak Boleh Sama Dengan Password Baru');
            }

            $user = Auth::user();
            $user->password = bcrypt($request->get('password'));
            $user->save();

            return redirect()->route('profil.index')->with('success','Password Anda Berhasil di Ganti');
    }
}
