@extends('layouts.app')
@include('layouts.sidebar')

@section('content')

@include('layouts.messages')
<div class="container-fluid">
    <div class="row justify-content-center mt-4">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('Pairwise Comparison') }}</div>
                <div class="card-body">
                    <form action="{{ route('compare.storeComparison') }}" method="POST">
                        @csrf

                        <table class="table" id="comparisonTable">
                            <thead>
                                <tr>
                                    <th colspan="2">Pilih Kriteria yang Lebih Penting</th>
                                    <th>Perbandingan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($criteriaNames as $outerIndex => $outerName)
                                    @foreach ($criteriaNames as $innerIndex => $innerName)
                                        @if ($outerIndex < $innerIndex)
                                            <tr>
                                                <td>{{ $outerName }}
                                                    <div>
                                                        <input type="radio" name="priority[{{ $outerIndex }}][{{ $innerIndex }}]" value="1" checked>
                                                        <label for="priority_{{ $outerIndex }}_{{ $innerIndex }}_1">1</label>
                                                    </div>
                                                </td>
                                                
                                                <td>{{ $innerName }}
                                                    <div>
                                                        <input type="radio" name="priority[{{ $outerIndex }}][{{ $innerIndex }}]" value="2">
                                                        <label for="priority_{{ $outerIndex }}_{{ $innerIndex }}_2">2</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="comparison_{{ $outerIndex }}_{{ $innerIndex }}">Perbandingan</label>
                                                        <select class="form-control comparison-select" data-outer-index="{{ $outerIndex }}" data-inner-index="{{ $innerIndex }}" id="comparison_{{ $outerIndex }}_{{ $innerIndex }}" name="comparison[{{ $outerIndex }}][{{ $innerIndex }}]">
                                                            <option value="1" selected>1 = Sama pentingnya</option>
                                                            <option value="2">2 = Antara sama dan sedikit lebih penting</option>
                                                            <option value="3">3 = Sedikit lebih penting</option>
                                                            <option value="4">4 = Antara sedikit lebih dan lebih penting</option>
                                                            <option value="5">5 = Lebih penting</option>
                                                            <option value="6">6 = Antara lebih dan sangat lebih penting</option>
                                                            <option value="7">7 = Sangat lebih penting</option>
                                                            <option value="8">8 = Antara sangat lebih dan mutlak lebih penting</option>
                                                            <option value="9">9 = Mutlak lebih penting</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="priority-description">
                                                <td colspan="3" class="text-center">
                                                    <span> <b> {{ $outerName }} & {{ $innerName }}</b></span>: 
                                                    <span id="priority_{{ $outerIndex }}_{{ $innerIndex }}"> <b> Sama pentingnya</b></span>
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

                var radioButtons = document.getElementsByName('priority[' + outerIndex + '][' + innerIndex + ']');
                var selectedValue;
                for (var i = 0; i < radioButtons.length; i++) {
                    if (radioButtons[i].checked) {
                        selectedValue = radioButtons[i].value;
                        break; // Exit the loop after finding the selected radio button
                    }
                }

                // Update comparison matrix
                if (selectedValue == 1) {
                    document.getElementById('matrixCell_' + outerIndex + '_' + innerIndex).textContent = value;
                    document.getElementById('matrixCell_' + innerIndex + '_' + outerIndex).textContent = (1 / value).toFixed(2);
                } else {
                    document.getElementById('matrixCell_' + outerIndex + '_' + innerIndex).textContent = (1 / value).toFixed(2);
                    document.getElementById('matrixCell_' + innerIndex + '_' + outerIndex).textContent = value;
                }
            });
        });
    });
</script>

<style>
    .priority-description {
        background-color: #f9f9f9;
    }
</style>
