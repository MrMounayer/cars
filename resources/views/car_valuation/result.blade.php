
<div class="container">
    <h2>Car Valuation Result</h2>
    <p><strong>Make:</strong> {{ $data['make'] }}</p>
    <p><strong>Model:</strong> {{ $data['model'] }}</p>
    <p><strong>Year:</strong> {{ $data['year'] }}</p>
    <p><strong>Mileage:</strong> {{ $data['mileage'] }}</p>
    <hr>
    @if(is_array($valuation) && isset($valuation['min'], $valuation['max']))
        <h3>Estimated Value Range:</h3>
        <ul>
            <li><strong>Min:</strong> ${{ number_format($valuation['min'], 2) }}</li>
            <li><strong>Max:</strong> ${{ number_format($valuation['max'], 2) }}</li>
            <li><strong>Average:</strong> $
                {{ number_format(($valuation['min'] * 0.4 + $valuation['max'] * 0.6), 2) }}
                <!-- Example weighted average: 40% min, 60% max -->
            </li>
        </ul>
    @else
        <div class="alert alert-warning">No valuation found for the specified car.</div>
    @endif
    <a href="{{ route('car-valuation.form') }}" class="btn btn-secondary mt-3">Back</a>
</div>
