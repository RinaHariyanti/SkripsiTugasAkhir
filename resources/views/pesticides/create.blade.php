@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('layouts.messages')
            <div class="card">
                <div class="card-header bg-primary text-white">Create Pesticide</div>
                <div class="card-body">
                    <form action="{{ route('pesticides.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>

                        <hr>

                        <h4 class="mb-3">Criteria:</h4>
                        @foreach($criteria as $criterion)
                        <div class="form-group row">
                            <!-- Add hidden input for criterion ID -->
                            <input type="hidden" name="criterias[{{ $loop->index }}][id]" value="{{ $criterion->id }}">
                            <label for="criteria_{{ $criterion->id }}_description" class="col-md-4 col-form-label">{{ $criterion->name }}:</label>
                            <div class="col-md-8">
                                <input type="text" name="criterias[{{ $loop->index }}][description]" class="form-control" id="criteria_{{ $criterion->id }}_description">
                            </div>
                        </div>
                        @endforeach

                        <hr>

                        <button type="submit" class="btn btn-primary btn-block">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
