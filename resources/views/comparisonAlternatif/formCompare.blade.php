@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"> <strong> Compare {{ $firstCriteriaName }} </strong></div>
                <div class="card-header">
                    @foreach ($criteriaNames as $idx => $value)
                    <span class="{{ $index >= $idx ? 'badge badge-primary' : 'badge badge-secondary' }}">
                        {{ $value->name }}
                    </span>
                    @if ($idx < count($criteriaNames) - 1)
                        >
                    @endif
                @endforeach
                
                </div>
                <div class="card-body">
                    <form action="/compare/alternatives/show/{{ $index }}" method="POST">
                        @csrf

                        <table class="table" id="comparisonTable">
                            <thead>
                                <tr>
                                    <th>Kriteria 1</th>
                                    <th>Prioritas Petani</th>
                                    <th>Kriteria 2</th>
                                    <th>Perbandingan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatives as $outerIndex => $outerName)
                                    @foreach ($alternatives as $innerIndex => $innerName)
                                        @if ($outerIndex < $innerIndex)
                                            <tr>
                                                <td> <strong>{{ $outerName }}</strong>
                                                    <div>
                                                    <span> {{ $detailsCriteria[$outerIndex]->description }}</span>
                                                    </div>
                                                </td>
                                                <td id="priority_{{ $outerIndex }}_{{ $innerIndex }}">Sama pentingnya</td>
                                                <td> <strong>{{ $innerName }}</strong>
                                                    <div>
                                                    <span> {{ $detailsCriteria[$innerIndex]->description }}</span>
                                                    </div>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="comparison_{{ $outerIndex }}_{{ $innerIndex }}">Perbandingan</label>
                                                        <select class="form-control comparison-select" data-outer-index="{{ $outerIndex }}" data-inner-index="{{ $innerIndex }}" id="comparison_{{ $outerIndex }}_{{ $innerIndex }}" name="comparison[{{ $outerIndex }}][{{ $innerIndex }}]">
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Matriks Perbandingan</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                @foreach ($alternatives as $index => $name)
                                    <th>{{ $name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody id="comparisonMatrixBody">
                            @foreach ($alternatives as $outerIndex => $outerName)
                                <tr>
                                    <td>{{ $outerName }}</td>
                                    @foreach ($alternatives as $innerIndex => $innerName)
                                        <td>
                                            @if ($outerIndex == $innerIndex)
                                                1
                                            @else
                                                <span id="matrixCell_{{ $outerIndex }}_{{ $innerIndex }}">0</span>
                                            @endif
                                        </td>
                                    @endforeach
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var comparisonSelects = document.querySelectorAll('.comparison-select');
        comparisonSelects.forEach(function(select) {
            select.addEventListener('change', function() {
                var outerIndex = this.getAttribute('data-outer-index');
                var innerIndex = this.getAttribute('data-inner-index');
                var value = parseInt(this.value);

                // Update priority based on comparison value
                var priorityCell = document.getElementById('priority_' + outerIndex + '_' + innerIndex);
                var priorityText = '';
                switch (value) {
                    case 1:
                        priorityText = 'Sama pentingnya';
                        break;
                    case 2:
                        priorityText = 'Antara sama dan sedikit lebih penting';
                        break;
                    case 3:
                        priorityText = 'Sedikit lebih penting';
                        break;
                    case 4:
                        priorityText = 'Antara sedikit lebih dan lebih penting';
                        break;
                    case 5:
                        priorityText = 'Lebih penting';
                        break;
                    case 6:
                        priorityText = 'Antara lebih dan sangat lebih penting';
                        break;
                    case 7:
                        priorityText = 'Sangat lebih penting';
                        break;
                    case 8:
                        priorityText = 'Antara sangat lebih dan mutlak lebih penting';
                        break;
                    case 9:
                        priorityText = 'Mutlak lebih penting';
                        break;
                    default:
                        priorityText = 'Sama pentingnya';
                }
                priorityCell.textContent = priorityText;

                // Update matrix cell
                var matrixCell = document.getElementById('matrixCell_' + outerIndex + '_' + innerIndex);
                matrixCell.textContent = value;

                // If the comparison is reciprocal, update the reciprocal cell
                var reciprocalCell = document.getElementById('matrixCell_' + innerIndex + '_' + outerIndex);
                reciprocalCell.textContent = (1 / value).toFixed(2);
            });
        });
    });
</script>
