<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function siswa()
    {
        return view('users.siswa', [
            'data' => User::where('role', 'siswa')->get(),
            'kelas' => Kelas::get()
        ]);
    }
    public function guru()
    {
        return view('users.guru', [
            'data' => User::where('role', 'guru')->get(),
        ]);
    }
    public function administrasi()
    {
        return view('users.administrasi', [
            'data' => User::where('role', 'admin')->get(),
        ]);
    }
    public function tambah(Request $request, $role)
    {
        $requestData = $request->except(['_token']);

        // Jika ada file foto yang diunggah, simpan file tersebut
        if ($request->hasFile('foto')) {
            // Ambil file foto dari request
            $foto = $request->file('foto');

            // Tentukan nama unik untuk file foto
            $nama_foto = time() . '_' . $foto->getClientOriginalName();

            // Simpan file foto ke dalam direktori yang ditentukan 
            $foto->move('foto', $nama_foto);

            // Set nama file foto dalam data yang akan disimpan ke database
            $requestData['foto'] = $nama_foto;
        }

        // Enkripsi password sebelum disimpan ke database
        $requestData['password'] = Hash::make($request->password);

        $requestData['role'] = $role;
        // simpan data
        User::create($requestData);

        // Redirect kembali dengan pesan sukses
        return back()->with('message', 'Data berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'Data tidak ditemukan');
        }
        if (Auth::user()->role != 'admin') {
            if (Auth::user()->id != $user->id) {
                return back()->with('error', 'Terjadi Kesalahan');
            }
        }

        $requestData = $request->except(['_token']);

        // Jika ada file foto yang diunggah, simpan file tersebut
        if ($request->hasFile('foto')) {
            // Ambil file foto dari request
            $foto = $request->file('foto');

            // Tentukan nama unik untuk file foto
            $nama_foto = time() . '_' . $foto->getClientOriginalName();

            // Simpan file foto ke dalam direktori yang ditentukan 
            $foto->move('foto', $nama_foto);

            // Set nama file foto dalam data yang akan disimpan ke database
            $requestData['foto'] = $nama_foto;

            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::delete('foto/' . $user->foto);
            }
        }

        // Jika password diisi, enkripsi password baru
        if ($request->filled('password')) {
            $requestData['password'] = Hash::make($request->password);
        } else {
            // Jika password tidak diisi, hapus key 'password' dari array $requestData
            unset($requestData['password']);
        }

        // Update data user dengan data baru
        $user->update($requestData);

        return back()->with('message', 'Data berhasil diperbarui');
    }
    public function hapus($id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'Data tidak ditemukan');
        }
        $user->delete();
        return back()->with('message', 'Data berhasil dihapus');
    }
    public function profile()
    {
        return view('users.profile');
    }
}
