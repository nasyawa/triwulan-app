@extends('layout.template')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Indikator Kinerja</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"> Home</a></li>
                            <li class="breadcrumb-item"><a href="#"> Tables</a></li>
                            <li class="breadcrumb-item active">Data tables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">LIST</h3>
                </div>

                <div class="card-body">
                    <form action="" style="display: flex">
                        <div class="col-2">
                            <select name="tahun" class="form-control" placeholder="Cari Tahun">
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-success">Pilih Tahun</button>
                        </div>
                    </form>

                    <a href="{{ url('/indikator_kinerja/create') }}" class="btn btn-sm btn-success my-2">Tambah
                        Indikator</a>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Rekening</th>
                                <th>Sub Kegiatan</th>
                                <th>Indikator </th>
                                <th>Target</th>
                                <th>Satuan</th>
                                <th>Pagu Anggaran (Rp)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i => $datas)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $datas->subkegiatan->no_rekening }}</td>
                                    <td>{{ $datas->subkegiatan->nama_subkegiatan }}</td>
                                    <td>{{ $datas->indikator }}</td>
                                    <td>{{ $datas->target }}</td>
                                    <td>{{ $datas->satuan }}</td>
                                    <td>{{ $datas->pagu }}</td>
                                    <td>
                                        <a href="{{ url('/indikator_kinerja/' . $datas->id . '/edit') }}"
                                            class="btn btn-sm btn-warning"><i class="fas fa-pen" style="color: white"></a>

                                        <form method="POST" action="{{ url('/indikator_kinerja/' . $datas->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete()"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('custom_js')
    <script>
        function confirmDelete() {
            if (confirm('Apakah Anda yakin? Data akan dihapus. Apakah Anda ingin melanjutkan?')) {
                document.getElementById('form').submit();
            } else {
                event.preventDefault();
            }
        }
    </script>
@endpush
