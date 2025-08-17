
<div class="container">
    <h2>Car Valuation Form</h2>
    <form method="POST" action="{{ route('car-valuation.submit') }}">
        @csrf
        <div class="mb-3">
            <label for="make" class="form-label">Make</label>
            <input type="text" class="form-control" id="make" name="make" required>
        </div>
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" class="form-control" id="model" name="model" required>
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" class="form-control" id="year" name="year" min="1900" max="{{ date('Y') }}" required>
        </div>
        <div class="mb-3">
            <label for="mileage" class="form-label">Mileage</label>
            <input type="number" class="form-control" id="mileage" name="mileage" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Get Valuation</button>
    </form>
</div>

