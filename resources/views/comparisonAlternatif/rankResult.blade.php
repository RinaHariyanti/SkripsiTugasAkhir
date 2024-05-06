@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
<div class="container">
    <h5>Rank Result</h5>

    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
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
    </div>
</div>
@endsection
