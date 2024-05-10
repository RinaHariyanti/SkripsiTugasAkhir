@extends('layouts.app')
@include('layouts.sidebar')
@section('content')

<div id="content mt-5">
    <div class="container-fluid mt-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="header">
                    <h4><strong>List of Pesticides</strong></h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Pestisida</th>
                                <th>Kriteria</th>
                                <th>Spesifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($response as $index => $pesticide)
                                <tr>
                                    <td rowspan="{{ max(count($pesticide['criteria']), 1) }}">{{ $pesticide['name'] }}</td>
                                    @if(count($pesticide['criteria']) > 0)
                                        @foreach($pesticide['criteria'] as $criteria)
                                            <td>{{ $criteria['name'] }}</td>
                                            <td>{{ $criteria['description'] }}</td>
                                        </tr>
                                        <tr>
                                        @endforeach
                                    @else
                                        <td colspan="3">Tidak ada kriteria</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
