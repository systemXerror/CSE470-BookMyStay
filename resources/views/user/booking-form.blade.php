<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book {{ $room->room_type }} - {{ $room->hotel->name }} - BookMyStay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        .booking-form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .room-image {
            height: 300px;
            object-fit: cover;
        }
        .price-display {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .info-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .amenity-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 8px;
            background: #f8f9fa;
        }
        .amenity-icon {
            width: 30px;
            color: #667eea;
            margin-right: 10px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .service-option {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .service-option:hover {
            border-color: #667eea;
            background-color: #f8f9ff;
        }
        .service-option.selected {
            border-color: #667eea;
            background-color: #e8f2ff;
        }
        .service-price {
            color: #28a745;
            font-weight: bold;
        }
        .price-breakdown {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .price-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .price-total {
            border-top: 2px solid #dee2e6;
            padding-top: 10px;
            font-weight: bold;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.hotels') }}">
                <i class="fas fa-hotel me-2"></i>BookMyStay
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.hotels') }}">Hotels</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.my-bookings') }}">My Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.notifications') }}">
                            Notifications
                            @if(auth()->user()->unread_notifications_count > 0)
                                <span class="badge bg-danger">{{ auth()->user()->unread_notifications_count }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.reviews') }}">
                            <i class="fas fa-star me-1"></i>My Reviews
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.hotels') }}" class="text-white">Hotels</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.hotel.detail', $room->hotel->id) }}" class="text-white">{{ $room->hotel->name }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.room.detail', ['hotel' => $room->hotel->id, 'room' => $room->id]) }}" class="text-white">{{ $room->room_type }}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Book Now</li>
                        </ol>
                    </nav>
                    <h1 class="display-5 mb-3">Book Your Stay</h1>
                    <p class="lead mb-3">
                        <i class="fas fa-hotel me-2"></i>{{ $room->hotel->name }} - {{ $room->room_type }}
                    </p>
                    <div class="d-flex align-items-center mb-3">
                        <span class="price-display me-3">${{ $room->price_per_night }}/night</span>
                        @if($isAvailable)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check me-2"></i>Available
                            </span>
                        @else
                            <span class="badge bg-danger fs-6">
                                <i class="fas fa-times me-2"></i>Not Available
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{ $room->image }}" class="img-fluid room-image rounded" alt="{{ $room->room_type }}">
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Form -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Booking Form -->
                <div class="col-lg-8">
                    <div class="booking-form-card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Complete Your Booking</h3>
                        </div>
                        <div class="card-body p-4">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(!$isAvailable)
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Room Not Available</strong> This room is not available for the selected dates. Please choose different dates.
                                </div>
                            @endif

                            <form method="POST" action="{{ route('user.booking.store', ['hotel' => $room->hotel->id, 'room' => $room->id]) }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="check_in_date" class="form-label">Check-in Date</label>
                                        <input type="date" class="form-control @error('check_in_date') is-invalid @enderror" 
                                               id="check_in_date" name="check_in_date" 
                                               value="{{ $checkIn ?? '' }}" 
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                        @error('check_in_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="check_out_date" class="form-label">Check-out Date</label>
                                        <input type="date" class="form-control @error('check_out_date') is-invalid @enderror" 
                                               id="check_out_date" name="check_out_date" 
                                               value="{{ $checkOut ?? '' }}" 
                                               min="{{ date('Y-m-d', strtotime('+2 days')) }}" required>
                                        @error('check_out_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="guests" class="form-label">Number of Guests</label>
                                        <select class="form-select @error('guests') is-invalid @enderror" id="guests" name="guests" required>
                                            @for($i = 1; $i <= $room->capacity; $i++)
                                                <option value="{{ $i }}" {{ $guests == $i ? 'selected' : '' }}>
                                                    {{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('guests')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Room Type</label>
                                        <input type="text" class="form-control" value="{{ $room->room_type }}" readonly>
                                    </div>
                                </div>

                                <!-- Extra Services Section -->
                                <div class="mb-4">
                                    <h5 class="mb-3"><i class="fas fa-plus-circle me-2"></i>Customize Your Stay</h5>
                                    
                                    <!-- Basic Services -->
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="service-option" onclick="toggleService('breakfast')">
                                                <input type="checkbox" id="breakfast_included" name="breakfast_included" value="1" class="d-none">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="fas fa-utensils me-2 text-primary"></i>
                                                        <strong>Breakfast</strong>
                                                    </div>
                                                    <span class="service-price">$15/night</span>
                                                </div>
                                                <small class="text-muted">Daily breakfast included</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <div class="service-option" onclick="toggleService('parking')">
                                                <input type="checkbox" id="parking_included" name="parking_included" value="1" class="d-none">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="fas fa-parking me-2 text-primary"></i>
                                                        <strong>Parking</strong>
                                                    </div>
                                                    <span class="service-price">$10/night</span>
                                                </div>
                                                <small class="text-muted">Free parking space</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <div class="service-option" onclick="toggleService('wifi')">
                                                <input type="checkbox" id="wifi_included" name="wifi_included" value="1" class="d-none">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="fas fa-wifi me-2 text-primary"></i>
                                                        <strong>WiFi</strong>
                                                    </div>
                                                    <span class="service-price">$5/night</span>
                                                </div>
                                                <small class="text-muted">High-speed internet</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Services -->
                                    <div class="mb-3">
                                        <label class="form-label">Additional Services (Optional)</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="extra_services[]" value="Room Service" id="room_service">
                                                    <label class="form-check-label" for="room_service">
                                                        Room Service <span class="text-success">($20/night)</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="extra_services[]" value="Spa Access" id="spa_access">
                                                    <label class="form-check-label" for="spa_access">
                                                        Spa Access <span class="text-success">($50/night)</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="extra_services[]" value="Gym Access" id="gym_access">
                                                    <label class="form-check-label" for="gym_access">
                                                        Gym Access <span class="text-success">($10/night)</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="extra_services[]" value="Airport Transfer" id="airport_transfer">
                                                    <label class="form-check-label" for="airport_transfer">
                                                        Airport Transfer <span class="text-success">($15/night)</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="special_requests" class="form-label">Special Requests (Optional)</label>
                                    <textarea class="form-control @error('special_requests') is-invalid @enderror" 
                                              id="special_requests" name="special_requests" rows="3" 
                                              placeholder="Any special requests or preferences...">{{ old('special_requests') }}</textarea>
                                    @error('special_requests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Discount Code -->
                                <div class="mb-4">
                                    <h5 class="mb-3"><i class="fas fa-tag me-2"></i>Have a Discount Code?</h5>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control @error('discount_code') is-invalid @enderror" 
                                                   id="discount_code" name="discount_code" 
                                                   placeholder="Enter your discount code" 
                                                   value="{{ old('discount_code') }}">
                                            @error('discount_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-outline-primary w-100" onclick="applyDiscount()">
                                                <i class="fas fa-check me-1"></i>Apply
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-muted">Enter a valid discount code to get special offers</small>
                                    @if($activeOffers->count() > 0)
                                        <div class="mt-2">
                                            <small class="text-info">
                                                <strong>Available codes:</strong>
                                                @foreach($activeOffers as $offer)
                                                    {{ $offer->code }} 
                                                    @if($offer->type === 'percentage')
                                                        ({{ $offer->discount_value }}% off)
                                                    @else
                                                        (${{ $offer->discount_value }} off)
                                                    @endif
                                                    @if(!$loop->last), @endif
                                                @endforeach
                                            </small>
                                        </div>
                                    @endif
                                </div>

                                <!-- Price Breakdown -->
                                <div class="price-breakdown" id="price-breakdown" style="display: none;">
                                    <h6 class="mb-3"><i class="fas fa-calculator me-2"></i>Price Breakdown</h6>
                                    <div id="price-items"></div>
                                    <div class="price-item price-total" id="price-total"></div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg" {{ !$isAvailable ? 'disabled' : '' }}>
                                        <i class="fas fa-credit-card me-2"></i>Confirm Booking
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Room Details Sidebar -->
                <div class="col-lg-4">
                    <div class="info-card">
                        <h4 class="mb-3"><i class="fas fa-info-circle me-2"></i>Room Details</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Room Type:</strong> {{ $room->room_type }}</li>
                            <li class="mb-2"><strong>Capacity:</strong> Up to {{ $room->capacity }} guests</li>
                            @if($room->size_sqm)
                                <li class="mb-2"><strong>Size:</strong> {{ $room->size_sqm }} sqm</li>
                            @endif
                            <li class="mb-2"><strong>Price:</strong> ${{ $room->price_per_night }} per night</li>
                            <li class="mb-2"><strong>Hotel:</strong> {{ $room->hotel->name }}</li>
                            <li class="mb-2"><strong>Location:</strong> {{ $room->hotel->city }}, {{ $room->hotel->state }}</li>
                        </ul>
                    </div>

                    @if($room->amenities->count() > 0)
                        <div class="info-card">
                            <h5 class="mb-3"><i class="fas fa-concierge-bell me-2"></i>Room Amenities</h5>
                            @foreach($room->amenities->take(6) as $amenity)
                                <div class="amenity-item">
                                    <i class="{{ $amenity->icon }} amenity-icon"></i>
                                    <span>{{ $amenity->name }}</span>
                                </div>
                            @endforeach
                            @if($room->amenities->count() > 6)
                                <small class="text-muted">+{{ $room->amenities->count() - 6 }} more amenities</small>
                            @endif
                        </div>
                    @endif

                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Hotel Location</h5>
                        <p class="mb-2"><strong>Address:</strong></p>
                        <p class="text-muted">{{ $room->hotel->address }}<br>
                        {{ $room->hotel->city }}, {{ $room->hotel->state }} {{ $room->hotel->country }}</p>
                        
                        <div class="d-flex justify-content-between">
                            <span><strong>Phone:</strong></span>
                            <span>{{ $room->hotel->phone }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><strong>Email:</strong></span>
                            <span>{{ $room->hotel->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const pricePerNight = {{ $room->price_per_night }};
        let currentNights = 0;

        // Auto-calculate total when dates change
        document.getElementById('check_in_date').addEventListener('change', calculateTotal);
        document.getElementById('check_out_date').addEventListener('change', calculateTotal);

        // Add event listeners for extra services
        document.querySelectorAll('input[name="extra_services[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotal);
        });

        function toggleService(service) {
            const checkbox = document.getElementById(service + '_included');
            const option = checkbox.closest('.service-option');
            
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                option.classList.add('selected');
            } else {
                option.classList.remove('selected');
            }
            
            calculateTotal();
        }

        function calculateTotal() {
            const checkIn = document.getElementById('check_in_date').value;
            const checkOut = document.getElementById('check_out_date').value;

            if (checkIn && checkOut) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                currentNights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
                
                const baseAmount = currentNights * pricePerNight;
                let extraServicesAmount = 0;
                const services = [];

                // Calculate basic services
                if (document.getElementById('breakfast_included').checked) {
                    extraServicesAmount += 15 * currentNights;
                    services.push({ name: 'Breakfast', amount: 15 * currentNights });
                }
                if (document.getElementById('parking_included').checked) {
                    extraServicesAmount += 10 * currentNights;
                    services.push({ name: 'Parking', amount: 10 * currentNights });
                }
                if (document.getElementById('wifi_included').checked) {
                    extraServicesAmount += 5 * currentNights;
                    services.push({ name: 'WiFi', amount: 5 * currentNights });
                }

                // Calculate additional services
                const additionalServices = {
                    'Room Service': 20,
                    'Spa Access': 50,
                    'Gym Access': 10,
                    'Airport Transfer': 15
                };

                document.querySelectorAll('input[name="extra_services[]"]:checked').forEach(checkbox => {
                    const serviceName = checkbox.value;
                    const servicePrice = additionalServices[serviceName] * currentNights;
                    extraServicesAmount += servicePrice;
                    services.push({ name: serviceName, amount: servicePrice });
                });

                const totalAmount = baseAmount + extraServicesAmount;

                // Update price breakdown
                updatePriceBreakdown(baseAmount, services, totalAmount);
            }
        }

        let appliedDiscount = 0;
        let discountCode = '';

        function applyDiscount() {
            const code = document.getElementById('discount_code').value.trim();
            if (!code) {
                alert('Please enter a discount code');
                return;
            }

            // Get current total amount
            const baseAmount = {{ $room->price_per_night }} * currentNights;
            let extraServicesAmount = 0;
            
            if (document.getElementById('breakfast_included').checked) {
                extraServicesAmount += 15 * currentNights;
            }
            if (document.getElementById('parking_included').checked) {
                extraServicesAmount += 10 * currentNights;
            }
            if (document.getElementById('wifi_included').checked) {
                extraServicesAmount += 5 * currentNights;
            }

            const additionalServices = {
                'Room Service': 20,
                'Spa Access': 50,
                'Gym Access': 10,
                'Airport Transfer': 15
            };

            document.querySelectorAll('input[name="extra_services[]"]:checked').forEach(checkbox => {
                const serviceName = checkbox.value;
                const servicePrice = additionalServices[serviceName] * currentNights;
                extraServicesAmount += servicePrice;
            });

            const totalAmount = baseAmount + extraServicesAmount;

            // Make AJAX call to validate discount code
            console.log('Sending discount code validation request:', {
                code: code,
                amount: totalAmount,
                hotel_id: {{ $room->hotel->id }},
                room_type: '{{ $room->room_type }}'
            });

            fetch('{{ route("user.validate-discount-code") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    code: code,
                    amount: totalAmount,
                    hotel_id: {{ $room->hotel->id }},
                    room_type: '{{ $room->room_type }}'
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.valid) {
                    appliedDiscount = parseFloat(data.discount_amount) || 0;
                    discountCode = data.code;
                    alert(data.message);
                    calculateTotal();
                } else {
                    let errorMessage = data.message;
                    if (data.debug) {
                        console.log('Debug info:', data.debug);
                        // Add more specific error messages based on debug info
                        if (data.debug.amount_provided < data.debug.minimum_amount) {
                            errorMessage = `Minimum amount required: $${data.debug.minimum_amount}. Your booking amount: $${data.debug.amount_provided}`;
                        }
                        if (data.debug.applicable_hotels && data.debug.applicable_hotels.length > 0) {
                            errorMessage += `\nApplicable hotels: ${JSON.stringify(data.debug.applicable_hotels)}`;
                        }
                        if (data.debug.applicable_room_types && data.debug.applicable_room_types.length > 0) {
                            errorMessage += `\nApplicable room types: ${JSON.stringify(data.debug.applicable_room_types)}`;
                        }
                    }
                    alert(errorMessage);
                    appliedDiscount = 0;
                    discountCode = '';
                    calculateTotal();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while validating the discount code. Please try again.\nError: ' + error.message);
                appliedDiscount = 0;
                discountCode = '';
                calculateTotal();
            });
        }

        function updatePriceBreakdown(baseAmount, services, totalAmount) {
            const breakdown = document.getElementById('price-breakdown');
            const itemsContainer = document.getElementById('price-items');
            const totalElement = document.getElementById('price-total');

            itemsContainer.innerHTML = `
                <div class="price-item">
                    <span>Room Rate (${currentNights} nights)</span>
                    <span>$${baseAmount.toFixed(2)}</span>
                </div>
            `;

            services.forEach(service => {
                itemsContainer.innerHTML += `
                    <div class="price-item">
                        <span>${service.name}</span>
                        <span>$${service.amount.toFixed(2)}</span>
                    </div>
                `;
            });

            // Add discount if applied
            if (appliedDiscount && appliedDiscount > 0) {
                const discountAmount = parseFloat(appliedDiscount) || 0;
                itemsContainer.innerHTML += `
                    <div class="price-item text-success">
                        <span>Discount (${discountCode})</span>
                        <span>-$${discountAmount.toFixed(2)}</span>
                    </div>
                `;
                totalAmount -= discountAmount;
            }

            totalElement.innerHTML = `
                <span>Total Amount</span>
                <span>$${totalAmount.toFixed(2)}</span>
            `;

            breakdown.style.display = 'block';
        }
    </script>
</body>
</html> 