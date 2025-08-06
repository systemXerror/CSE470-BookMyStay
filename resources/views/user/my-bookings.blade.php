<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - BookMyStay</title>
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
        .booking-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            overflow: hidden;
        }
        .booking-card:hover {
            transform: translateY(-5px);
        }
        .hotel-image {
            height: 200px;
            object-fit: cover;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 20px;
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
                        <a class="nav-link active" href="{{ route('user.my-bookings') }}">My Bookings</a>
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
                    <h1 class="display-5 mb-3">My Bookings</h1>
                    <p class="lead mb-0">Manage your hotel reservations and upcoming stays</p>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('user.hotels') }}" class="btn btn-outline-light">
                        <i class="fas fa-search me-2"></i>Book New Stay
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $bookings->total() }}</div>
                        <p class="text-muted mb-0">Total Bookings</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $bookings->where('status', 'confirmed')->count() }}</div>
                        <p class="text-muted mb-0">Confirmed</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $bookings->where('status', 'completed')->count() }}</div>
                        <p class="text-muted mb-0">Completed</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $bookings->where('status', 'cancelled')->count() }}</div>
                        <p class="text-muted mb-0">Cancelled</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bookings List -->
    <section class="py-5">
        <div class="container">
            @if($bookings->count() > 0)
                <div class="row">
                    @foreach($bookings as $booking)
                        <div class="col-lg-6 mb-4">
                            <div class="card booking-card h-100">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ $booking->room->image }}" class="img-fluid hotel-image h-100 w-100" 
                                             alt="{{ $booking->room->room_type }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="card-title mb-0">{{ $booking->room->hotel->name }}</h5>
                                                <span class="badge {{ $booking->status_badge_class }}">{{ ucfirst($booking->status) }}</span>
                                            </div>
                                            
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-bed me-1"></i>{{ $booking->room->room_type }}
                                            </p>
                                            
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted">Check-in</small><br>
                                                    <strong>{{ $booking->check_in_date->format('M j, Y') }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Check-out</small><br>
                                                    <strong>{{ $booking->check_out_date->format('M j, Y') }}</strong>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted">Duration</small><br>
                                                    <strong>{{ $booking->nights }} {{ $booking->nights == 1 ? 'night' : 'nights' }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Guests</small><br>
                                                    <strong>{{ $booking->guests }} {{ $booking->guests == 1 ? 'guest' : 'guests' }}</strong>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="text-success fw-bold">${{ number_format($booking->total_amount, 2) }}</span>
                                                    <br><small class="text-muted">Total Amount</small>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" 
                                                            data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#" onclick="viewBookingDetails({{ $booking->id }})">
                                                                <i class="fas fa-eye me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        @if($booking->status == 'confirmed')
                                                            <li>
                                                                <a class="dropdown-item" href="#" onclick="cancelBooking({{ $booking->id }})">
                                                                    <i class="fas fa-times me-2"></i>Cancel Booking
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item" href="#" onclick="printBooking({{ $booking->id }})">
                                                                <i class="fas fa-print me-2"></i>Print Confirmation
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($bookings->hasPages())
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="Bookings pagination">
                                {{ $bookings->links() }}
                            </nav>
                        </div>
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3>No Bookings Found</h3>
                    <p class="text-muted mb-4">You haven't made any bookings yet. Start exploring our hotels!</p>
                    <a href="{{ route('user.hotels') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Browse Hotels
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Booking Details Modal -->
    <div class="modal fade" id="bookingDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="bookingDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Booking Modal -->
    <div class="modal fade" id="cancelBookingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this booking? This action cannot be undone.</p>
                    <p class="text-muted"><small>Note: Bookings can only be cancelled at least 24 hours before check-in.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Booking</button>
                    <form id="cancelBookingForm" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger">Cancel Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewBookingDetails(bookingId) {
            // In a real application, you would load the booking details via AJAX
            // For now, we'll just show a simple message
            document.getElementById('bookingDetailsContent').innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-info-circle fa-3x text-primary mb-3"></i>
                    <h5>Booking Details</h5>
                    <p class="text-muted">Detailed booking information would be displayed here.</p>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('bookingDetailsModal')).show();
        }

        function cancelBooking(bookingId) {
            const form = document.getElementById('cancelBookingForm');
            form.action = `/bookings/${bookingId}/cancel`;
            new bootstrap.Modal(document.getElementById('cancelBookingModal')).show();
        }

        function printBooking(bookingId) {
            // In a real application, you would redirect to a print-friendly page
            window.open(`/bookings/${bookingId}/print`, '_blank');
        }

        // Show success message if exists
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.createElement('div');
                toast.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                toast.innerHTML = `
                    <div class="toast" role="alert">
                        <div class="toast-header bg-success text-white">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong class="me-auto">Success!</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                new bootstrap.Toast(toast.querySelector('.toast')).show();
            });
        @endif

        // Show error message if exists
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.createElement('div');
                toast.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                toast.innerHTML = `
                    <div class="toast" role="alert">
                        <div class="toast-header bg-danger text-white">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong class="me-auto">Error!</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                new bootstrap.Toast(toast.querySelector('.toast')).show();
            });
        @endif
    </script>
</body>
</html> 