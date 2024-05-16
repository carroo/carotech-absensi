@extends('layouts.template')

@section('content')
    <section class="section mt-4 mb-3">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pilih Tanggal Dan Juga Kelas Untuk Mengabsen</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('absensi') }}" method="GET">
                        <div class="input-group">
                            <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}"
                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
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
                    <form action="{{ route('absensi.simpan') }}" method="POST">
                        @csrf
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title">Absensi Kelas {{ $datakelas->nama }} pada
                                {{ date('d F Y', strtotime($tanggal)) }}</h4>
                            <input type="hidden" value="{{ $datakelas->guru_id }}" name="guru_id">
                            <button class="btn btn-success">Simpan Absensi</button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($dataabsen as $k => $v)
                                    <div class="" style="width: 20%">
                                        <div class="card ">
                                            <img src="{{ asset('foto/' . $v->siswa->foto) }}" class="card-img-top"
                                                alt="..." width="200px" height="180px">
                                            <div class="card-body" style="padding: 8px 10px">
                                                <h4 class="card-text text-truncate" style="max-width: 100%;">
                                                    {{ $v->siswa->name }}</h4>
                                            </div>

                                            <div class="card-footer" style="padding: 5px 10px">
                                                <input type="hidden" name="absensi_id[]" value="{{ $v->id }}">
                                                <select name="status[]" class="form-select select-status"
                                                    id="status_{{ $k }}">
                                                    <option value="" disabled selected>Pilih Kehadiran</option>
                                                    <option class="bg-success" value="hadir"
                                                        {{ $v->status == 'hadir' ? 'selected' : '' }}>
                                                        Hadir</option>
                                                    <option class="bg-info" value="izin"
                                                        {{ $v->status == 'izin' ? 'selected' : '' }}>
                                                        Izin</option>
                                                    <option class="bg-warning" value="sakit"
                                                        {{ $v->status == 'sakit' ? 'selected' : '' }}>
                                                        Sakit</option>
                                                    <option class="bg-danger" value="tanpa keterangan"
                                                        {{ $v->status == 'tanpa keterangan' ? 'selected' : '' }}>
                                                        Tanpa Keterangan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </section>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var selects = document.querySelectorAll('.select-status');
            selects.forEach(function(select) {
                var selectedOption = select.options[select.selectedIndex];
                var selectedClass = selectedOption.className;
                select.classList.add(selectedClass);
                select.addEventListener('change', function() {
                    var selectedOption = this.options[this.selectedIndex];
                    var selectedClass = selectedOption.className;
                    this.className = 'form-select ' + selectedClass;
                });
            });
        });
    </script>
@endsection
