@extends('layouts.template')

@section('content')
    <section class="section mt-4 mb-3">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pilih Tanggal Dan Juga Kelas Untuk Mengabsen</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan') }}" method="GET">
                        <div class="input-group">
                            <input type="month" name="tanggal" class="form-control" value="{{ $tanggal }}"
                                max="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                            <select class="form-select" name="kelas_id" id="">
                                <option value="" disabled selected>Pilih kelas</option>
                                @foreach ($kelas as $v)
                                    <option value="{{ $v->id }}" {{ $kelas_id == $v->id ? 'selected' : '' }}>
                                        {{ $v->nama }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit">Absensi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if ($datakelas)
            <div class="row">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Absensi Kelas {{ $datakelas->nama }} pada
                            {{ date('F Y', strtotime($tanggal)) }}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">NISN</th>
                                    <th rowspan="2">Nama</th>
                                    <th colspan="4">Kehadiran</th>
                                </tr>
                                <tr>
                                    <th>Hadir</th>
                                    <th>Izin</th>
                                    <th>Sakit</th>
                                    <th>Tanpa Keterangan</th>
                                </tr>
                            </thead>
                            <thead>
                                @php
                                    $jh = 0;
                                    $ji = 0;
                                    $js = 0;
                                    $jb = 0;
                                @endphp
                                @forelse ($dataabsen as $k => $v)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $v['nisn'] }}</td>
                                        <td>{{ $v['nama'] }}</td>
                                        <td class="text-success">{{ $v['hadir'] }}</td>
                                        <td class="text-info">{{ $v['izin'] }}</td>
                                        <td class="text-warning">{{ $v['sakit'] }}</td>
                                        <td class="text-danger">{{ $v['bolos'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Data Kosong</td>
                                    </tr>
                                @endforelse
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection
