@extends('layouts.template')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="text-dark mb-0">Table Siswa</h2>
                <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i data-feather="plus-circle" width="20"></i>
                        Tambah Siswa
                    </button>
                </div>
            </div>


            <div class="card-body p-4">
                <table class="table table-sm dttb .table-responsive">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th>Foto</th>
                            <th>Kelas</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $key => $value)
                        <tr>
                            <td>{{ $value->nomor_induk }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->nomor_telepon }}</td>
                            <td>{{ $value->alamat }}</td>
                            <td>{{ $value->tanggal_lahir }}</td>
                            <td><img src="{{ asset('foto/'.$value->foto) }}" class="img-fluid" width="100px" alt=""></td>
                            <td>{{ $value->ks->nama }}</td>
                            <td class="">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#edit-{{ $value->id }}" title="update">
                                        <i data-feather="edit" width="16"></i>
                                    </button>
                                    <a href="#" onclick="confirmAlert('{{ route('user.hapus',$value->id) }}','Apa anda yakin ingin menghapus?')"
                                        type="button" class="btn btn-danger btn-sm" title="hapus">
                                        <i data-feather="trash" width="16"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>

            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('user.tambah','siswa') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">NISN</label>
                                    <input type="text" class="form-control" name="nomor_induk" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Siswa</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="text" class="form-control" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" name="nomor_telepon" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas_id" class="form-label">Kelas</label>
                                    <select name="kelas_id" class="form-control" required >
                                        <option value="" disabled selected>Pilih Kelas</option>
                                        @foreach ($kelas as $v)
                                            <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                        @endforeach
                                    </select>   
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Foto</label>
                                    <input type="file" class="form-control" name="foto" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @foreach ($data as $value)
            <div class="modal fade" id="edit-{{ $value->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('user.update',$value->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">NISN</label>
                                    <input type="text" class="form-control" name="nomor_induk" value="{{ $value->nomor_induk }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Siswa</label>
                                    <input type="text" class="form-control" name="name" value="{{ $value->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ $value->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Password (optionl)</label>
                                    <input type="text" class="form-control" name="password" >
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" name="nomor_telepon" value="{{ $value->nomot_telepon }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" value="{{ $value->alamat }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" value="{{ $value->tanggal_lahir }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="guru_id" class="form-label">kelas</label>
                                    <select name="guru_id" class="form-control" required >
                                        <option value="" disabled selected>Pilih Kelas</option>
                                        @foreach ($kelas as $v)
                                            <option value="{{ $v->id }}" {{ $v->id == $value->kelas_id ? 'selected' : '' }}>{{ $v->nama }}</option>
                                        @endforeach
                                    </select>   
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Foto (optionl)</label>
                                    <input type="file" class="form-control" name="foto">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
@endsection