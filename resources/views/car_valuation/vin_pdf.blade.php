<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VIN Decoder Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #14244a; }
        .header { text-align: center; margin-bottom: 30px; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #233366; padding: 8px; }
        .table th { background: #4ea1ff; color: #fff; }
    </style>
</head>
<body>
    <div class="header">
        <h1>VIN Decoder Report</h1>
        <p>VIN: <strong>{{ $vin }}</strong></p>
    </div>
    <div class="section">
        <h2>Decoded Information</h2>
        <table class="table">
            <tbody>
            @foreach($results as $key => $value)
                <tr>
                    <th>{{ ucfirst($key) }}</th>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <footer style="margin-top:40px; text-align:center; font-size:12px; color:#233366;">
        &copy; {{ date('Y') }} Car Valuation App
    </footer>
</body>
</html>
