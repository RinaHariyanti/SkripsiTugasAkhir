@extends('layouts.app')
@include('layouts.sidebar')
@section('content')
    <div class="container-fluid px-5">
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Matriks Hasil Pengkuadratan</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-left">
                                <thead>
                                    <tr>
                                        <th></th>
                                        @foreach($criteriaNames as $name)
                                            <th>{{ $name }}</th>
                                        @endforeach
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($squaredMatrix as $i => $row)
                                        <tr>
                                            {{-- {{ dd($squaredMatrix) }} --}}
                                            <td>{{ $criteriaNames[$i] }}</td>
                                            @foreach($row as $value)
                                                <td>{{ number_format($value, 2) }}</td>
                                            @endforeach
                                            <td>{{ number_format(array_sum($row), 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
            <div class="col-md-4">
            <div class="card">
                <div class="card-header">Nilai Eigenvector</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Kriteria</th>
                                    <th>Nilai</th>
                                    <th>Persentase (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($normalizedVector as $i => $value)
                                <tr>
                                    <td>{{ $criteriaNames[$i] }}</td>
                                    <td>{{ number_format($value, 4) }}</td>
                                    {{-- {{ dd($totalEigenvector) }} --}}
                                    <td>{{ number_format(($value * 100)) }}%</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td><strong>Lambda Max</strong></td>
                                    <td colspan="2">{{ number_format($totalEigenvector, 4) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>CI</strong></td>
                                    <td colspan="2">{{ number_format($CI, 4) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>CR</strong></td>
                                    <td colspan="2">{{ number_format($CR, 4) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-{{ $CR <= 0.1 ? 'success' : 'danger' }}" role="alert">
                        @if ($CR <= 0.1)
                            Nilai CR kurang dari atau sama dengan 0.1, hasil perhitungan konsisten.
                            <button type="button" class="btn btn-primary btn-sm mt-2">
                                <a href="/user/compare/alternatives/0" class="text-white">Lanjutkan ke perbandingan alternatif</a>
                            </button>
                        @else
                            Nilai CR lebih dari 10%, penilaian data judgment harus diperbaiki.
                            <br>
                            <button type="button" class="btn btn-danger btn-sm mt-2"> 
                                <a href="/user/compare/criteria" class="text-white">Kembali ke halaman perbandingan</a>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            </div>
            
        </div>
    </div>
@endsection