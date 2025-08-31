<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - BookMyStay</title>
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
        .confirmation-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .success-icon {
            font-size: 4rem;
            color: #28a745;
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
        .booking-detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .booking-detail:last-child {
            border-bottom: none;
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
        .qr-code {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .service-badge {
            background: #e8f5e8;
            color: #28a745;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-right: 5px;
            margin-bottom: 5px;
            display: inline-block;
        }
        .price-breakdown {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 15px;
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
        .cancellation-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
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
        <div class="container text-center">
            <div class="success-icon mb-3">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="display-4 mb-3">Booking Confirmed!</h1>
            <p class="lead mb-0">Your reservation has been successfully created</p>
        </div>
    </section>

    <!-- Confirmation Details -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="confirmation-card">
                        <div class="card-header bg-success text-white">
                            <h3 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Booking Details</h3>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="booking-detail">
                                        <span><strong>Booking ID:</strong></span>
                                        <span class="badge bg-primary fs-6">#{{ $booking->id }}</span>
                                    </div>
                                    <div class="booking-detail">
                                        <span><strong>Hotel:</strong></span>
                                        <span>{{ $booking->room->hotel->name }}</span>
                                    </div>
                                    <div class="booking-detail">
                                        <span><strong>Room Type:</strong></span>
                                        <span>{{ $booking->room->room_type }}</span>
                                    </div>
                                    <div class="booking-detail">
                                        <span><strong>Check-in Date:</strong></span>
                                        <span>{{ $booking->check_in_date->format('F j, Y') }}</span>
                                    </div>
                                    <div class="booking-detail">
                                        <span><strong>Check-out Date:</strong></span>
                                        <span>{{ $booking->check_out_date->format('F j, Y') }}</span>
                                    </div>
                                    <div class="booking-detail">
                                        <span><strong>Duration:</strong></span>
                                        <span>{{ $booking->nights }} {{ $booking->nights == 1 ? 'night' : 'nights' }}</span>
                                    </div>
                                    <div class="booking-detail">
                                        <span><strong>Number of Guests:</strong></span>
                                        <span>{{ $booking->guests }} {{ $booking->guests == 1 ? 'guest' : 'guests' }}</span>
                                    </div>
                                    <div class="booking-detail">
                                        <span><strong>Status:</strong></span>
                                        <span class="badge {{ $booking->status_badge_class }}">{{ ucfirst($booking->status) }}</span>
                                    </div>
                                    @if($booking->special_requests)
                                        <div class="booking-detail">
                                            <span><strong>Special Requests:</strong></span>
                                            <span class="text-muted">{{ $booking->special_requests }}</span>
                                        </div>
                                    @endif

                                    <!-- Extra Services -->
                                    @if($booking->extra_services_list && count($booking->extra_services_list) > 0)
                                        <div class="booking-detail">
                                            <span><strong>Extra Services:</strong></span>
                                            <div class="text-end">
                                                @foreach($booking->extra_services_list as $service)
                                                    <span class="service-badge">{{ $service }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Price Breakdown -->
                                    <div class="price-breakdown">
                                        <h6 class="mb-3"><i class="fas fa-calculator me-2"></i>Price Breakdown</h6>
                                        <div class="price-item">
                                            <span>Room Rate ({{ $booking->nights }} nights)</span>
                                            <span>${{ number_format($booking->base_amount, 2) }}</span>
                                        </div>
                                        @if($booking->extra_services_amount > 0)
                                            <div class="price-item">
                                                <span>Extra Services</span>
                                                <span>${{ number_format($booking->extra_services_amount, 2) }}</span>
                                            </div>
                                        @endif
                                        @if($booking->discount_amount > 0)
                                            <div class="price-item text-success">
                                                <span>Discount ({{ $booking->discount_code }})</span>
                                                <span>-${{ number_format($booking->discount_amount, 2) }}</span>
                                            </div>
                                        @endif
                                        <div class="price-item price-total">
                                            <span>Total Amount</span>
                                            <span>${{ number_format($booking->total_amount, 2) }}</span>
                                        </div>
                                    </div>

                                    <!-- Cancellation Information -->
                                    <div class="cancellation-info">
                                        <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Cancellation Policy</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small><strong>Deadline:</strong> {{ $booking->cancellation_deadline->format('M j, Y g:i A') }}</small>
                                            </div>
                                            <div class="col-md-6">
                                                <small><strong>Fee:</strong> ${{ number_format($booking->cancellation_fee, 2) }}</small>
                                            </div>
                                        </div>
                                        <small class="text-muted">You can cancel this booking up to 24 hours before check-in for a partial refund.</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="qr-code">
                                        <i class="fas fa-qrcode fa-3x text-muted mb-2"></i>
                                        <p class="mb-0 text-muted">Scan at check-in</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row justify-content-center mt-4">
                <div class="col-lg-8 text-center">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('user.my-bookings') }}" class="btn btn-primary me-md-2">
                            <i class="fas fa-list me-2"></i>View All Bookings
                        </a>
                        <a href="{{ route('user.hotels') }}" class="btn btn-outline-primary me-md-2">
                            <i class="fas fa-search me-2"></i>Book Another Stay
                        </a>
                        <button class="btn btn-outline-success" onclick="printBooking()">
                            <i class="fas fa-print me-2"></i>Print Confirmation
                        </button>
                    </div>
                </div>
            </div>

            <!-- Hotel Information -->
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8">
                    <div class="info-card">
                        <h4 class="mb-3"><i class="fas fa-hotel me-2"></i>Hotel Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Hotel:</strong> {{ $booking->room->hotel->name }}</p>
                                <p><strong>Address:</strong> {{ $booking->room->hotel->address }}</p>
                                <p><strong>City:</strong> {{ $booking->room->hotel->city }}, {{ $booking->room->hotel->state }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Phone:</strong> {{ $booking->room->hotel->phone }}</p>
                                <p><strong>Email:</strong> {{ $booking->room->hotel->email }}</p>
                                <p><strong>Check-in Time:</strong> 3:00 PM</p>
                                <p><strong>Check-out Time:</strong> 11:00 AM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Information -->
            <div class="row justify-content-center mt-4">
                <div class="col-lg-8">
                    <div class="info-card">
                        <h4 class="mb-3"><i class="fas fa-info-circle me-2"></i>Important Information</h4>
                        <div class="alert alert-info">
                            <h6><i class="fas fa-bell me-2"></i>Booking Confirmation</h6>
                            <p class="mb-2">A confirmation email has been sent to your registered email address.</p>
                            <p class="mb-0">Please keep this booking confirmation for your records.</p>
                        </div>
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-clock me-2"></i>Check-in Instructions</h6>
                            <ul class="mb-0">
                                <li>Please arrive at the hotel with a valid ID and the credit card used for booking</li>
                                <li>Early check-in is subject to availability</li>
                                <li>Late check-in is available 24/7</li>
                            </ul>
                        </div>
                        <div class="alert alert-success">
                            <h6><i class="fas fa-credit-card me-2"></i>Payment Information</h6>
                            <p class="mb-0">Your payment has been processed successfully. No additional charges will be made unless you add extra services during your stay.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Notification Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="bookingToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Booking Confirmed!</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                Your booking for {{ $booking->room->hotel->name }} has been confirmed. Check your email for details.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show notification toast
        document.addEventListener('DOMContentLoaded', function() {
            const toast = new bootstrap.Toast(document.getElementById('bookingToast'));
            toast.show();
        });

        // Print booking confirmation
        function printBooking() {
            window.print();
        }

        // Auto-hide notification after 5 seconds
        setTimeout(function() {
            const toast = bootstrap.Toast.getInstance(document.getElementById('bookingToast'));
            if (toast) {
                toast.hide();
            }
        }, 5000);
    </script>
</body>
</html> 