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
        .section-header {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        .cancellation-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
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
                        <div class="stats-number">{{ $upcomingBookings->total() + $pastBookings->total() + $activeBookings->count() }}</div>
                        <p class="text-muted mb-0">Total Bookings</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $upcomingBookings->total() }}</div>
                        <p class="text-muted mb-0">Upcoming</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $activeBookings->count() }}</div>
                        <p class="text-muted mb-0">Active</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $pastBookings->total() }}</div>
                        <p class="text-muted mb-0">Past</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Active Bookings -->
    @if($activeBookings->count() > 0)
        <section class="py-3">
            <div class="container">
                <div class="section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-clock text-warning me-2"></i>Current Stay
                    </h3>
                </div>
                <div class="row">
                    @foreach($activeBookings as $booking)
                        <div class="col-lg-6 mb-4">
                            <div class="card booking-card h-100 border-warning">
                                <div class="card-header bg-warning text-dark">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-clock me-2"></i>Currently Staying</span>
                                        <span class="badge bg-success">Active</span>
                                    </div>
                                </div>
                                @include('user.partials.booking-card-content', ['booking' => $booking])
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Upcoming Bookings -->
    @if($upcomingBookings->count() > 0)
        <section class="py-3">
            <div class="container">
                <div class="section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>Upcoming Bookings
                    </h3>
                </div>
                <div class="row">
                    @foreach($upcomingBookings as $booking)
                        <div class="col-lg-6 mb-4">
                            <div class="card booking-card h-100">
                                @include('user.partials.booking-card-content', ['booking' => $booking])
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination for Upcoming -->
                @if($upcomingBookings->hasPages())
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="Upcoming bookings pagination">
                                {{ $upcomingBookings->links() }}
                            </nav>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Past Bookings -->
    @if($pastBookings->count() > 0)
        <section class="py-3">
            <div class="container">
                <div class="section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-history text-muted me-2"></i>Past Bookings
                    </h3>
                </div>
                <div class="row">
                    @foreach($pastBookings as $booking)
                        <div class="col-lg-6 mb-4">
                            <div class="card booking-card h-100 opacity-75">
                                @include('user.partials.booking-card-content', ['booking' => $booking])
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination for Past -->
                @if($pastBookings->hasPages())
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="Past bookings pagination">
                                {{ $pastBookings->links() }}
                            </nav>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Empty State -->
    @if($upcomingBookings->count() == 0 && $pastBookings->count() == 0 && $activeBookings->count() == 0)
        <section class="py-5">
            <div class="container">
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
            </div>
        </section>
    @endif

    <!-- Cancel Booking Modal -->
    <div class="modal fade" id="cancelBookingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this booking?</p>
                    <div id="cancellationDetails"></div>
                    <form id="cancelBookingForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="cancellation_reason" class="form-label">Reason for cancellation (optional)</label>
                            <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3" 
                                      placeholder="Please let us know why you're cancelling..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Booking</button>
                    <button type="submit" form="cancelBookingForm" class="btn btn-danger">Cancel Booking</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function cancelBooking(bookingId, canCancel, refundAmount) {
            const form = document.getElementById('cancelBookingForm');
            const details = document.getElementById('cancellationDetails');
            
            form.action = `/bookings/${bookingId}/cancel`;
            
            if (canCancel) {
                details.innerHTML = `
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Refund Amount:</strong> $${refundAmount}
                        <br><small class="text-muted">A 10% cancellation fee will be applied.</small>
                    </div>
                `;
            } else {
                details.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Cannot Cancel:</strong> This booking cannot be cancelled as it's within 24 hours of check-in.
                    </div>
                `;
                document.querySelector('#cancelBookingForm button[type="submit"]').disabled = true;
            }
            
            new bootstrap.Modal(document.getElementById('cancelBookingModal')).show();
        }

        function printBooking(bookingId) {
            // Open booking confirmation page in new window for printing
            window.open(`/bookings/${bookingId}/confirmation`, '_blank');
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