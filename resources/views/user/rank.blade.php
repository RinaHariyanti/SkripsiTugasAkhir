@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-3 justify-content-center">

    @include('layouts.messages')
    <div class="card shadow mb-4 col-9">
        <div class="card-body">
            <div class="header row mb-3">
                    <h4><strong>List of History</strong></h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SPK Code</th>
                            <th>User</th>
                            <th>Email User</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formattedData as $data)
                        <tr>
                            <td>{{ $data['spk_code'] }}</td>
                            <td>{{ $data['user'] }}</td>
                            <td>{{ $data['email'] }}</td>   
                            <td>{{ $data['created_at'] }}</td>
                            <td>
                                <a href="{{ route('results.show', $data['group_id']) }}" class="btn btn-primary btn-sm">Result</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
