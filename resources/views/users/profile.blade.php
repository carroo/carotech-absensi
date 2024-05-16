@extends('layouts.template')

@section('content')
    <section class="section mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h2 class="card-title text-center">User Profile</h2>
                    </div>
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <div class="aspect-ratio-1x1">
                                <img class="avatar"
                                    src="{{ asset('foto/' . Auth::user()->foto) }}" alt="User profile picture" width="200px" height="200px">
                            </div>
                        </div>
                        <h3 class="profile-username text-center mt-4">{{ Auth::user()->name }}</h3>
                        <p class="text-muted text-center">{{ Auth::user()->role }}</p>
                    </div>

                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Profile</h4>
                    </div>
                    <form action="{{ route('user.update', Auth::user()->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ Auth::user()->name }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ Auth::user()->email }}" required>
                                    </div>
                                </div>
                                @if (Auth::user()->role != 'admin')
                                    <div class="col-md-6">


                                        <div class="mb-3">
                                            <label for=""
                                                class="form-label">{{ Auth::user()->role == 'guru' ? 'NIP' : 'NISN' }}</label>
                                            <input type="text" class="form-control" name="nomor_induk"
                                                value="{{ Auth::user()->nomor_induk }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" name="nomor_telepon"
                                                value="{{ Auth::user()->nomor_telepon }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tanggal_lahir"
                                                value="{{ Auth::user()->tanggal_lahir }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="mb-3">
                                            <label for="" class="form-label">Alamat</label>
                                            <textarea name="alamat" id="" class="form-control" rows="5">{!! Auth::user()->alamat !!}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="guru_id" class="form-label">kelas</label>
                                            @if (Auth::user()->role == 'siswa')
                                                <input type="text" class="form-control" readonly
                                                    value="{{ Auth::user()->ks->nama }}">
                                            @else
                                                <input type="text" class="form-control" readonly
                                                    value="@foreach (Auth::user()->kg as $v) {{ $v->nama }} , @endforeach">
                                            @endif
                                        </div>

                                    </div>
                                @endif
                                <div class="col-md-12">

                                    <div class="mb-3">
                                        <label for="" class="form-label">Password (optionl)</label>
                                        <input type="text" class="form-control" name="password">
                                    </div>

                                    <div class="">
                                        <label for="" class="form-label">Foto (optionl)</label>
                                        <input type="file" class="form-control" name="foto">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
