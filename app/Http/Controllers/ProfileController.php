<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile_view()
    {
        $parseData = [
            'title' => 'Ubah Profil | ' . Auth::user()->level . '',
        ];
        return view('profile.index', $parseData);
    }

    public function profile_process(Request $r)
    {
        $r->validate([
            'name' => 'required'
        ]);

        $user = User::find(Auth::user()->id);

        if ($r->password && $r->password_baru) {
            if (Hash::check($r->password, $user->password)) {
                $user->password = Hash::make($r->password_baru);
            }
        }

        $user->name = $r->name;

        if ($user->save()) {
            return redirect('/profil')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menyimpan data profil!'));
        } else {
            return redirect('/profil')->with($this->messageSweetAlert('success', 'Gagal!', 'Anda telah gagal menyimpan data profil!'));
        }
    }
}
