<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user();
        $tanggal = Carbon::now()->format('Y-m-d');
        $kelas_id = 0;
        $datakelas = null;
        $dataabsen = [];
        if ($request->kelas_id && $request->tanggal) {
            $tanggal = $request->tanggal;
            $kelas_id = $request->kelas_id;
            $datakelas = Kelas::find($kelas_id);
            foreach ($datakelas->siswa as $k => $v) {
                Absensi::firstOrCreate([
                    'siswa_id' => $v->id,
                    'tanggal' => $tanggal
                ], [
                    'siswa_id' => $v->id,
                    'tanggal' => $tanggal
                ]);
                $dataabsen[] = Absensi::where('siswa_id', $v->id)->where('tanggal', $tanggal)->first();
            }
        }
        return view('absensi.index', [
            'kelas' => Kelas::where('guru_id', $guru->id)->get(),
            'tanggal' => $tanggal,
            'kelas_id' => $kelas_id,
            'datakelas' => $datakelas,
            'dataabsen' => $dataabsen
        ]);
    }
    public function simpan(Request $request)
    {
        if ($request->guru_id != Auth::user()->id) {
            return back()->with('message_error', 'Absensi gagal diperbarui');
        }
        foreach ($request->status as $key => $value) {
            Absensi::where('id', $request->absensi_id[$key])->update([
                'status' => $value
            ]);
        }
        return back()->with('message', 'Absensi Berhasil Disimpan');
    }
    public function laporan(Request $request)
    {
        $tanggal = Carbon::now()->format('Y-m');
        $kelas_id = 0;
        $datakelas = null;
        $dataabsen = [];
        if ($request->kelas_id && $request->tanggal) {
            $tanggal = $request->tanggal;
            $kelas_id = $request->kelas_id;
            $datakelas = Kelas::find($kelas_id);
            foreach ($datakelas->siswa as $k => $v) {
                $dataabsen[$k]['nama'] = $v->name;
                $dataabsen[$k]['nisn'] = $v->nomor_induk;
                $dataabsen[$k]['hadir'] = Absensi::where('siswa_id', $v->id)->where('status', 'hadir')->where('tanggal', 'LIKE', $tanggal . '%')->count();
                $dataabsen[$k]['izin'] = Absensi::where('siswa_id', $v->id)->where('status', 'izin')->where('tanggal', 'LIKE', $tanggal . '%')->count();
                $dataabsen[$k]['sakit'] = Absensi::where('siswa_id', $v->id)->where('status', 'sakit')->where('tanggal', 'LIKE', $tanggal . '%')->count();
                $dataabsen[$k]['bolos'] = Absensi::where('siswa_id', $v->id)->where('status', 'tanpa keterangan')->where('tanggal', 'LIKE', $tanggal . '%')->count();
            }
        }
        return view('absensi.laporan', [
            'kelas' => Kelas::get(),
            'tanggal' => $tanggal,
            'kelas_id' => $kelas_id,
            'datakelas' => $datakelas,
            'dataabsen' => $dataabsen
        ]);
    }
}
