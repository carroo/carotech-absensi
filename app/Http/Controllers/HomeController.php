<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pesan = '';
        if(Auth::user()->role == 'siswa'){
            $cek = Absensi::where('siswa_id',Auth::user()->id)->where('tanggal', Carbon::now()->format('Y-m-d'))->first();
            if(!$cek){
                $pesan = "Anda Belum Terabsen Hari Ini";
            }
            $absensihadir = Absensi::where('siswa_id',Auth::user()->id)->where('status', 'hadir')->where('tanggal', 'LIKE', Carbon::now()->format('Y-m') . '%')->count();
            $absensiizin = Absensi::where('siswa_id',Auth::user()->id)->where('status', 'izin')->where('tanggal', 'LIKE', Carbon::now()->format('Y-m') . '%')->count();
            $absensisakit = Absensi::where('siswa_id',Auth::user()->id)->where('status', 'sakit')->where('tanggal', 'LIKE', Carbon::now()->format('Y-m') . '%')->count();
            $absensibolos = Absensi::where('siswa_id',Auth::user()->id)->where('status', 'tanpa keterangan')->where('tanggal', 'LIKE', Carbon::now()->format('Y-m') . '%')->count();
        }else{
            $absensihadir = Absensi::where('status', 'hadir')->where('tanggal', 'LIKE', Carbon::now()->format('Y-m') . '%')->count();
            $absensiizin = Absensi::where('status', 'izin')->where('tanggal', 'LIKE', Carbon::now()->format('Y-m') . '%')->count();
            $absensisakit = Absensi::where('status', 'sakit')->where('tanggal', 'LIKE', Carbon::now()->format('Y-m') . '%')->count();
            $absensibolos = Absensi::where('status', 'tanpa keterangan')->where('tanggal', 'LIKE', Carbon::now()->format('Y-m') . '%')->count();
        }
        return view('home', [
            'guru' => User::where('role', 'guru')->count(),
            'kelas' => Kelas::count(),
            'siswa' => User::where('role', 'siswa')->count(),
            'absensihadir' => $absensihadir,
            'absensiizin' => $absensiizin,
            'absensisakit' => $absensisakit,
            'absensibolos' => $absensibolos,
            'pesan' => $pesan
        ]);
    }
}
