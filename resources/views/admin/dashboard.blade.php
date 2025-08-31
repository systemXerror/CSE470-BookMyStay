<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BookMyStay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .stat-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        .activity-item {
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .service-badge {
            background: #e8f5e8;
            color: #28a745;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 0.7rem;
            margin-right: 3px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 bg-dark text-white p-3 min-vh-100">
                <h4 class="mb-4">
                    <i class="fas fa-hotel me-2"></i>Admin Panel
                </h4>
                <nav class="nav flex-column">
                    <a class="nav-link text-white active" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.hotels') }}">
                        <i class="fas fa-building me-2"></i>Hotels
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.bookings') }}">
                        <i class="fas fa-calendar-check me-2"></i>Bookings
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.users') }}">
                        <i class="fas fa-users me-2"></i>Users
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.statistics') }}">
                        <i class="fas fa-chart-bar me-2"></i>Statistics
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.notifications') }}">
                        <i class="fas fa-bell me-2"></i>Notifications
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.rooms.index') }}">
                        <i class="fas fa-bed me-2"></i>Room Management
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.special-offers.index') }}">
                        <i class="fas fa-tags me-2"></i>Special Offers
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.reviews.index') }}">
                        <i class="fas fa-star me-2"></i>Reviews
                    </a>
                    <hr class="my-3">
                    <a class="nav-link text-white" href="{{ route('user.hotels') }}">
                        <i class="fas fa-home me-2"></i>View Site
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white text-start w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4">Dashboard Overview</h2>
                
                <!-- Basic Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Hotels</h5>
                                        <h3>{{ $totalHotels }}</h3>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-building"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Rooms</h5>
                                        <h3>{{ $totalRooms }}</h3>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Bookings</h5>
                                        <h3>{{ $totalBookings }}</h3>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Users</h5>
                                        <h3>{{ $totalUsers }}</h3>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Status Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white stat-card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Confirmed</h5>
                                <h3>{{ $confirmedBookings }}</h3>
                                <small>Active bookings</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white stat-card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Pending</h5>
                                <h3>{{ $pendingBookings }}</h3>
                                <small>Awaiting confirmation</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-danger text-white stat-card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Cancelled</h5>
                                <h3>{{ $cancelledBookings }}</h3>
                                <small>Cancelled bookings</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white stat-card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Completed</h5>
                                <h3>{{ $completedBookings }}</h3>
                                <small>Past stays</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-success text-white stat-card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Total Revenue</h5>
                                <h3>${{ number_format($totalRevenue, 2) }}</h3>
                                <small>From confirmed bookings</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white stat-card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Extra Services</h5>
                                <h3>${{ number_format($extraServicesRevenue, 2) }}</h3>
                                <small>Additional revenue</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-warning text-white stat-card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Cancellation Fees</h5>
                                <h3>${{ number_format($cancellationFees, 2) }}</h3>
                                <small>From cancelled bookings</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row mb-4">
                    <!-- Recent Bookings -->
                    <div class="col-lg-8 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Recent Bookings</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Guest</th>
                                                <th>Hotel</th>
                                                <th>Room</th>
                                                <th>Check-in</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentBookings as $booking)
                                                <tr>
                                                    <td>{{ $booking->user->name }}</td>
                                                    <td>{{ $booking->room->hotel->name }}</td>
                                                    <td>{{ $booking->room->room_type }}</td>
                                                    <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                                                    <td>${{ number_format($booking->total_amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($booking->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No recent bookings</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Users -->
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Recent Users</h5>
                            </div>
                            <div class="card-body">
                                @forelse($recentUsers as $user)
                                    <div class="activity-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $user->name }}</strong>
                                                <br><small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted">No recent users</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Popular Services & Upcoming Check-ins -->
                <div class="row">
                    <!-- Popular Services -->
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-star me-2"></i>Popular Extra Services</h5>
                            </div>
                            <div class="card-body">
                                @forelse($popularServices as $service)
                                    <div class="activity-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @foreach(json_decode($service->extra_services) as $serviceName)
                                                    <span class="service-badge">{{ $serviceName }}</span>
                                                @endforeach
                                            </div>
                                            <span class="badge bg-primary">{{ $service->count }} bookings</span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted">No extra services data</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Check-ins -->
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Upcoming Check-ins (Next 7 Days)</h5>
                            </div>
                            <div class="card-body">
                                @forelse($upcomingCheckIns as $booking)
                                    <div class="activity-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $booking->user->name }}</strong>
                                                <br><small class="text-muted">{{ $booking->room->hotel->name }} - {{ $booking->room->room_type }}</small>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted">{{ $booking->check_in_date->format('M d, Y') }}</small>
                                                <br><span class="badge bg-success">${{ number_format($booking->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted">No upcoming check-ins</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
