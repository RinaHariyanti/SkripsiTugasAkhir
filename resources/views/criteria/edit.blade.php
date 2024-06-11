@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('layouts.messages')
            <br>
            <div class="card">
                <div class="card-header bg-primary text-white">Edit Kriteria</div>
                <div class="card-body">
                    <form action="{{ route('criteria.update', $criterion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama:</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $criterion->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="kind">Jenis:</label>
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
