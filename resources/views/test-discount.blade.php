<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Discount Codes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Discount Code Test Page</h1>
        <p>This page helps test discount code validation.</p>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Test Discount Code</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="discount_code" class="form-label">Discount Code</label>
                            <input type="text" class="form-control" id="discount_code" placeholder="Enter discount code">
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" value="150" min="0" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label for="hotel_id" class="form-label">Hotel ID</label>
                            <input type="number" class="form-control" id="hotel_id" value="1" min="1">
                        </div>
                        <div class="mb-3">
                            <label for="room_type" class="form-label">Room Type</label>
                            <input type="text" class="form-control" id="room_type" value="Standard">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="testDiscountCode()">Test Code</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Available Test Codes</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>WELCOME10</strong> - 10% off (min $100)
                            </li>
                            <li class="list-group-item">
                                <strong>SUMMER50</strong> - $50 off (min $200)
                            </li>
                            <li class="list-group-item">
                                <strong>LUXURY20</strong> - 20% off luxury suites (min $300)
                            </li>
                            <li class="list-group-item">
                                <strong>WEEKEND25</strong> - 25% off (min $150)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Test Results</h5>
                    </div>
                    <div class="card-body">
                        <pre id="results" class="bg-light p-3 rounded">Results will appear here...</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function testDiscountCode() {
            const code = document.getElementById('discount_code').value.trim();
            const amount = parseFloat(document.getElementById('amount').value);
            const hotelId = parseInt(document.getElementById('hotel_id').value);
            const roomType = document.getElementById('room_type').value;
            
            if (!code) {
                alert('Please enter a discount code');
                return;
            }
            
            document.getElementById('results').textContent = 'Testing...';
            
            fetch('{{ route("user.validate-discount-code") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    code: code,
                    amount: amount,
                    hotel_id: hotelId,
                    room_type: roomType
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                document.getElementById('results').textContent = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('results').textContent = 'Error: ' + error.message;
            });
        }
    </script>
</body>
</html>
