@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('layouts.messages')
            <br>
            <div class="card">
                <div class="card-header bg-primary text-white">Tambah Kriteria Baru</div>
                <div class="card-body">
                    <form action="{{ route('criteria.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nama:</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>

                        <div class="form-group">
                            <label for="kind">Jenis:</label>
                            <select name="kind" id="kind" class="form-control">
                                <option value="benefit">Benefit</option>
                                <option value="cost">Cost</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
