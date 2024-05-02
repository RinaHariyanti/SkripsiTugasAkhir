@extends('layouts.app')
@include('layouts.sidebar')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('layouts.messages') 
            <div class="card">
                <div class="card-header">Edit Criteria</div>
                <div class="card-body">
                    <form action="{{ route('criteria.update', $criterion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $criterion->name }}" required>
                        </div>

                        <div class="form-group row">
                            <label for="kind" class="col-md-4 col-form-label">Jenis:</label>
                            <div class="col-md-8">
                                <select name="kind" id="kind" class="form-control">
                                    <option value="benefit" {{ $criterion->kind == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                    <option value="cost" {{ $criterion->kind == 'cost' ? 'selected' : '' }}>Cost</option>
                                </select>
                            </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
