@extends('layouts.app')
@include('layouts.sidebar')
@section('content')
    <div class="container-fluid px-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Matriks Perbandingan Berpasangan</div>
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
                                    @foreach($criteriaMatrix as $i => $row)
                                        <tr>
                                            <td>{{ $criteriaNames[$i] }}</td>
                                            @foreach($row as $value)
                                                <td>{{ number_format($value, 2) }}</td>
                                            @endforeach
                                            <td>{{ number_format(array_sum($row), 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>Jumlah</td>
                                        @foreach($columnSums as $sum)
                                            <td>{{ number_format($sum, 2) }}</td>
                                        @endforeach
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
            <div class="col-md-6">
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
            </div>
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
                                    {{-- <td>{{ number_format(($value / $totalEigenvector) * 100, 2) }}%</td> --}}
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
                        @else
                            Nilai CR lebih dari 10%, penilaian data judgment harus diperbaiki.
                        @endif
                    </div>
                    <button class="btn btn-primary" onclick="window.location.href='/compare/alternatives/{{ $nextIndex }}'">Next</button>
                </div>
            </div>
            
        </div>
    </div>
@endsection