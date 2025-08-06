<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BookMyStay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                <h2 class="mb-4">Dashboard</h2>
                
                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Hotels</h5>
                                <h3>{{ $totalHotels }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Rooms</h5>
                                <h3>{{ $totalRooms }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Bookings</h5>
                                <h3>{{ $totalBookings }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <h3>{{ $totalUsers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Revenue</h5>
                                <h3>${{ number_format($totalRevenue, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Bookings</h5>
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
                                        <th>Check-out</th>
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
                                            <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                                            <td>${{ number_format($booking->total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No recent bookings</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
