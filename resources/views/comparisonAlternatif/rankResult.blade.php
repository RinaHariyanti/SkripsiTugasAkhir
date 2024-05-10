@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="header">
                        <h4><strong>Final Result</strong></h4>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>Rank</th>
                                <th>Pesticide</th>
                                <th>Result</th>
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
                        <h5>Benefit Result</h5>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>Rank</th>
                                <th>Pesticide</th>
                                <th>Result</th>
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
                                <th>Rank</th>
                                <th>Pesticide</th>
                                <th>Result</th>
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
            
        </div>
    </div>
</div>
@endsection
