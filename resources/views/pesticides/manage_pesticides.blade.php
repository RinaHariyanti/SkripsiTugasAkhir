@extends('layouts.app')
@include('layouts.sidebar')
@section('content')
<div id="content">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-9">
                <h1 class="h3 mb-2 text-gray-800">List of Pesticides</h1>
            </div>
            <div class="col-3 text-right">
                <a href={{ route('pesticides.create') }} class="btn btn-primary">Add Pesticide</a>
            </div>
        </div>
        
        @include('layouts.messages')
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Pestisida</th>
                                <th>Kriteria</th>
                                <th>Spesifikasi</th>
                                <th>Action</th> <!-- Tambah kolom action -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($response as $pesticide)
                                @if(count($pesticide['criteria']) > 0)
                                    @foreach($pesticide['criteria'] as $index => $criteria)
                                        <tr>
                                            @if($index === 0)
                                                <td rowspan="{{ count($pesticide['criteria']) }}">{{ $pesticide['name'] }}</td>
                                            @endif
                                            <td>{{ $criteria['name'] }}</td>
                                            <td>{{ $criteria['description'] }}</td>
                                            @if($index === 0)
                                                <td rowspan="{{ count($pesticide['criteria']) }}"> <!-- Jika ini adalah baris pertama, tambahkan action -->
                                                    <div class="row ">
                                                        <div class="col text-right">
                                                            <a href="{{ route('pesticides.edit', $pesticide['id']) }}" class="btn btn-primary btn-sm">Edit</a>
                                                        </div>
                                                        <div class="col text-left">
                                                            <form action="{{ route('pesticides.destroy', $pesticide['id']) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    {{-- <a href="{{ route('pesticides.edit', $pesticide['id']) }}" class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="{{ route('pesticides.destroy', $pesticide['id']) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form> --}}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>{{ $pesticide['name'] }}</td>
                                        <td colspan="2">Tidak ada kriteria</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('pesticides.edit', $pesticide['id']) }}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{ route('pesticides.destroy', $pesticide['id']) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
