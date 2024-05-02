@extends('layouts.app')
@include('layouts.sidebar')
@section('content')
<div id="content">
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Edit Pesticide</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('pesticides.update', $pesticide->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $pesticide->name }}" required>
                    </div>

                    <hr>

                    <h4 class="mb-3">Criteria:</h4>
                    @foreach($pesticide->criterias as $criterion)
                    <div class="form-group row">
                        <label for="criteria_{{ $criterion->id }}_description" class="col-md-4 col-form-label">{{ $criterion->name }}:</label>
                        <div class="col-md-8">
                            <input type="text" name="criterias[{{ $criterion->id }}][description]" class="form-control" id="criteria_{{ $criterion->id }}_description" value="{{ $criterion->pivot->description }}">
                        </div>
                    </div>
                    @endforeach

                    <hr>

                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
