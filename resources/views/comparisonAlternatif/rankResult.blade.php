@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-md-8">

            @if (count($finalResult) > 0)
            <div class="card">
                <div class="card-body">
                    <div class="header">
                        <h4><strong>Perankingan</strong></h4>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>Ranking</th>
                                <th>Nama Pestisida</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($finalResult as $index => $data)
                            <tr>
                                <td>
                                    @if ($index == 0)
                                    <i class="bi bi-award-fill text-warning"></i> <!-- Icon bintang untuk peringkat pertama -->
                                    @endif
                                    {{ $index + 1 }}
                                </td>
                                <td>{{ $data['Name'] }}</td>
                                <td>{{ $data['Data'] }}</td>
                            </tr>
                            @if (count($finalResult) > 0)
                        <p style="font-size: large; color:black">Pestisida {{ $data['Name'] }} menjadi pestisida terbaik {{ $index + 1 }} dengan nilai {{ $data['Data']}} </p>
                        @endif
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <h4>Pestisida {{ $data['Name'] }} menjadi pestisida terbaik {{ $index + 1 }} dengan nilai {{ $data['Data'] }} </h4> --}}
                </div>
            </div>
            @else
            <div class="alert alert-warning mt-3">
                Data Ranking Masih kosong.<br>
                Lakukan Perbandingan Kriteria dan Alternatif Terlebih Dahulu!!
            </div>
            @endif
        </div>
        {{-- <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="header">
                        <h5>Benefit Result</h5>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>Ranking</th>
                                <th>Nama Pestisida</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($combinedDataBenefit as $index => $data)
                            <tr>
                                <td>
                                    @if ($index == 0)
                                    <i class="bi bi-award-fill text-warning"></i> <!-- Icon bintang untuk peringkat pertama -->
                                    @endif
                                    {{ $index + 1 }}
                                </td>
                                <td>{{ $data['Name'] }}</td>
                                <td>{{ $data['Data'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="header">
                        <h5>Cost Result</h5>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>Ranking</th>
                                <th>Nama Pestisida</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($combinedDataCost as $index => $data)
                            <tr>
                                <td>
                                    @if ($index == 0)
                                    <i class="bi bi-award-fill text-warning"></i> <!-- Icon bintang untuk peringkat pertama -->
                                    @endif
                                    {{ $index + 1 }}
                                </td>
                                <td>{{ $data['Name'] }}</td>
                                <td>{{ $data['Data'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div> --}}
    </div>
</div>
@endsection
