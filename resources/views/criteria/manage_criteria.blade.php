@extends('layouts.app')
@include('layouts.sidebar')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('layouts.messages')
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-9">
                            <h4>Criteria List</h4>
                        </div>
                        <div class="col-3 text-right">
                            <a href={{ route('pesticides.create') }} class="btn btn-primary">Add Criteria</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Jenis</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criteria as $criterion)
                            <tr>
                                <td>{{ $criterion->id }}</td>
                                <td>{{ $criterion->name }}</td>
                                <td>{{ $criterion->kind }}</td>
                                <td>
                                    {{-- <a href="{{ route('criteria.show', $criterion->id) }}" class="btn btn-info btn-sm">View</a> --}}
                                    <a href="{{ route('criteria.edit', $criterion->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('criteria.destroy', $criterion->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
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

