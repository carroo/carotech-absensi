<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(){
        return view('kelas.index',[
            'data' => Kelas::get(),
            'guru' => User::where('role','guru')->get()
        ]);
    }
    public function tambah(Request $request){
        Kelas::create($request->all());
        return back()->with('message','Data berhasil ditambahkan');
    }
    public function update(Request $request,$id){
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return back()->with('message_error', 'Data tidak ditemukan');
        }
        $requestData = $request->except(['_token']);
        $kelas->update($requestData);
        return back()->with('message', 'Data berhasil diperbarui');
    }
    public function hapus($id){
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return back()->with('message_error', 'Data tidak ditemukan');
        }
        $kelas->delete();
        return back()->with('message','Data berhasil dihapus');
    }
}
