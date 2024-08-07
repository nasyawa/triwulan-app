@extends('layout.template')
@php
    use Illuminate\Support\Collection;
@endphp

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Indikator Kinerja Utama </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Realisasi Anggaran</a></li>
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

                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-auto">
                            <form action="{{ route('sub_iku.index') }}" method="GET">
                                <div class="input-group input-group">
                                    <input type="text" id="realisasi" name="nama" class="form-control"
                                       placeholder="Cari misi RPJMD...">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('sub_iku.index') }}">
                                <div class="input-group input-group">
                                    <select name="year" class="form-control">
                                        <option value="">Pilih Awal Tahun</option>
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = 2022;
                                        @endphp
                                        @for ($tahun = $currentYear; $tahun >= $startYear; $tahun--)
                                            <option value="{{ $tahun }}" @if($tahun == $first_year) selected @endif >{{ $tahun }}</option>
                                        @endfor
                                    </select>
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('sub_iku.create') }}" class="btn btn-success my-2">
                                Tambah Data
                            </a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                        {{-- @dd($data) --}}
                        <tr>
                            <th colspan="14" style="text-align: center;">SUB IKU</th>
                        </tr>
                        <tr>
                            <th rowspan="2" style="align-content: center">No</th>
                            <th rowspan="2" style="align-content: center;">MISI RPJMD</th>
                            <th rowspan="2" style="align-content: center;">TUJUAN RPJMD</th>
                            <th rowspan="2" style="align-content: center;">SASARAN RPJMD</th>
                            <th rowspan="2" style="align-content: center;">TUJUAN PD</th>
                            <th rowspan="2" style="align-content: center;">SASARAN PD</th>
                            <th rowspan="2" style="align-content: center;">INDIKATOR TUJUAN / SASARAN DP</th>
                            <th rowspan="2" style="align-content: center;">FORMULA / RUMUS</th>
                            <th rowspan="2" style="align-content: center;">Kondisi Awal Kinerja Tahun 2021</th>
                            <th colspan="5" style="align-content: center;">Target Kinerja Sasaran Pada Tahun</th>
                        </tr>
                        <tr>
                            @foreach (range($first_year, $first_year + 4) as $year)
                                <th>{{ $year }}</th>
                            @endforeach
                        <tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $i => $item)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $item->misi_rpjmd }}</td>
                                <td>{{ $item->tujuan_rpjmd }}</td>
                                <td>{{ $item->sasaran_rpjmd }}</td>
                                <td>{{ $item->tujuan_pd }}</td>
                                @foreach ($item->subIkuSasaran as $item_sasaran)
                                    <td>{{ $item_sasaran->sasaran_pd }}</td>
                                    <td>{{ $item_sasaran->indikator_tujuan }}</td>
                                    <td>
                                        <img class="img-size-50" src="{{ asset('storage').'/'.$item_sasaran->formula }}" alt="{{ $item_sasaran->formula }}">
                                    </td>
                                    <td>{{ $item->kondisi_awal }}</td>
                                    @foreach (range($first_year, $first_year + 4) as $year)
                                        @php
                                            $found = [];
                                            $found[$year] = false;
                                        @endphp
                                        @foreach ($item_sasaran->sub_iku_kinerja as $item_kinerja)
                                            @if ($year == $item_kinerja->tahun && !$found[$year])
                                                <td>{{ $item_kinerja->angka_kinerja }} {{ $item_kinerja->satuan }}
                                                </td>
                                                @php
                                                    $found[$year] = true;
                                                @endphp
                                            @endif
                                        @endforeach

                                        @if ($found[$year] === false)
                                            <td>-</td>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('custom_css')
    <style>
        th {
        }

        .card {
            overflow: auto;
        }

        .table {
            overflow: auto;
        }

        th {
            text-align: center;
        }
    </style>
@endpush
