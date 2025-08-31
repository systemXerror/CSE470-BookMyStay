<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Activity - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .activity-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .activity-card:hover {
            transform: translateY(-2px);
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
                    <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.hotels') }}">
                        <i class="fas fa-building me-2"></i>Hotels
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.bookings') }}">
                        <i class="fas fa-calendar-check me-2"></i>Bookings
                    </a>
                    <a class="nav-link text-white active" href="{{ route('admin.users') }}">
                        <i class="fas fa-users me-2"></i>Users
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.statistics') }}">
                        <i class="fas fa-chart-bar me-2"></i>Statistics
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.notifications') }}">
                        <i class="fas fa-bell me-2"></i>Notifications
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>User Activity - {{ $user->name }}</h2>
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Users
                    </a>
                </div>

                <!-- User Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card activity-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>User Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Name:</strong> {{ $user->name }}</p>
                                        <p><strong>Email:</strong> {{ $user->email }}</p>
                                        <p><strong>Joined:</strong> {{ $user->created_at->format('M j, Y') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Total Bookings:</strong> {{ $user->bookings->count() }}</p>
                                        <p><strong>Total Notifications:</strong> {{ $user->notifications->count() }}</p>
                                        <p><strong>Last Activity:</strong> {{ $user->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card activity-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Booking Statistics</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <h4 class="text-primary">{{ $user->bookings->where('status', 'confirmed')->count() }}</h4>
                                        <small class="text-muted">Confirmed</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="text-success">{{ $user->bookings->where('status', 'completed')->count() }}</h4>
                                        <small class="text-muted">Completed</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="text-danger">{{ $user->bookings->where('status', 'cancelled')->count() }}</h4>
                                        <small class="text-muted">Cancelled</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card activity-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Recent Bookings</h5>
                            </div>
                            <div class="card-body">
                                @if($recentBookings->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Hotel</th>
                                                    <th>Room</th>
                                                    <th>Check-in</th>
                                                    <th>Check-out</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentBookings as $booking)
                                                    <tr>
                                                        <td>{{ $booking->room->hotel->name }}</td>
                                                        <td>{{ $booking->room->room_type }}</td>
                                                        <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                                                        <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                                                        <td>${{ number_format($booking->total_amount, 2) }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'danger') }}">
                                                                {{ ucfirst($booking->status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $booking->created_at->diffForHumans() }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-center text-muted">No bookings found for this user.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Notifications -->
                <div class="row">
                    <div class="col-12">
                        <div class="card activity-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Recent Notifications</h5>
                            </div>
                            <div class="card-body">
                                @if($recentNotifications->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Title</th>
                                                    <th>Message</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentNotifications as $notification)
                                                    <tr>
                                                        <td>
                                                            <span class="badge bg-{{ $notification->type == 'booking_confirmation' ? 'success' : ($notification->type == 'booking_cancelled' ? 'danger' : 'info') }}">
                                                                {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $notification->title }}</td>
                                                        <td>{{ Str::limit($notification->message, 50) }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $notification->read ? 'secondary' : 'danger' }}">
                                                                {{ $notification->read ? 'Read' : 'Unread' }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-center text-muted">No notifications found for this user.</p>
                                @endif
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
