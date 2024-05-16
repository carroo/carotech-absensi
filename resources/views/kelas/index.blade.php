@extends('layouts.template')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="text-dark mb-0">Table Kelas</h2>
                <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i data-feather="plus-circle" width="20"></i>
                        Tambah kelas
                    </button>
                </div>
            </div>


            <div class="card-body p-4">
                <table class="table table-striped table-md dttb .table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>kelas</th>
                            <th>Wali Kelas</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $key => $value)
                            
                        
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->waliGuru->name }}</td>
                            <td class="">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#edit-{{ $value->id }}" title="update">
                                        <i data-feather="edit" width="16"></i>
                                    </button>
                                    <a href="#" onclick="confirmAlert('{{ route('kelas.hapus',$value->id) }}','Apa anda yakin ingin menghapus?')"
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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah kelas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('kelas.tambah') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama kelas</label>
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="guru_id" class="form-label">Wali Kelas</label>
                                    <select name="guru_id" class="form-control" required >
                                        <option value="" disabled selected>Pilih Wali Kelas</option>
                                        @foreach ($guru as $v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>   
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit kelas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('kelas.update',$value->id) }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama kelas</label>
                                    <input type="text" class="form-control" name="nama" required value="{{ $value->nama }}">
                                </div>
                                <div class="mb-3">
                                    <label for="guru_id" class="form-label">Wali Kelas</label>
                                    <select name="guru_id" class="form-control" required >
                                        <option value="" disabled selected>Pilih Wali Kelas</option>
                                        @foreach ($guru as $v)
                                            <option value="{{ $v->id }}" {{ $v->id == $value->guru_id ? 'selected' : '' }}>{{ $v->name }}</option>
                                        @endforeach
                                    </select>   
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