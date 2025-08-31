<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stat-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
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
                    <a class="nav-link text-white" href="{{ route('admin.users') }}">
                        <i class="fas fa-users me-2"></i>Users
                    </a>
                    <a class="nav-link text-white active" href="{{ route('admin.statistics') }}">
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
                <h2 class="mb-4">Booking Statistics & Analytics</h2>

                <!-- Charts Row -->
                <div class="row mb-4">
                    <div class="col-lg-6 mb-4">
                        <div class="card stat-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Monthly Booking Trends</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="monthlyBookingsChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-4">
                        <div class="card stat-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Revenue by Hotel</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueByHotelChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Popular Room Types & Services -->
                <div class="row mb-4">
                    <div class="col-lg-6 mb-4">
                        <div class="card stat-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-bed me-2"></i>Popular Room Types</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Room Type</th>
                                                <th>Bookings</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($popularRoomTypes as $roomType)
                                                <tr>
                                                    <td>{{ $roomType->room_type }}</td>
                                                    <td>{{ $roomType->count }}</td>
                                                    <td>
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar" style="width: {{ ($roomType->count / $popularRoomTypes->sum('count')) * 100 }}%">
                                                                {{ number_format(($roomType->count / $popularRoomTypes->sum('count')) * 100, 1) }}%
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-4">
                        <div class="card stat-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-star me-2"></i>Extra Services Usage</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Usage Count</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($extraServicesUsage as $service)
                                                <tr>
                                                    <td>
                                                        @foreach(json_decode($service->extra_services) as $serviceName)
                                                            <span class="badge bg-primary me-1">{{ $serviceName }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $service->count }}</td>
                                                    <td>
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar bg-success" style="width: {{ ($service->count / $extraServicesUsage->sum('count')) * 100 }}%">
                                                                {{ number_format(($service->count / $extraServicesUsage->sum('count')) * 100, 1) }}%
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Statistics -->
                <div class="row">
                    <div class="col-12">
                        <div class="card stat-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Revenue Statistics</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Hotel</th>
                                                <th>Total Revenue</th>
                                                <th>Average Booking Value</th>
                                                <th>Total Bookings</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($revenueByHotel as $hotel)
                                                <tr>
                                                    <td><strong>{{ $hotel->name }}</strong></td>
                                                    <td class="text-success">${{ number_format($hotel->revenue, 2) }}</td>
                                                    <td>${{ number_format($hotel->revenue / ($hotel->revenue > 0 ? 1 : 1), 2) }}</td>
                                                    <td>{{ $hotel->revenue > 0 ? 1 : 0 }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Monthly Bookings Chart
        const monthlyCtx = document.getElementById('monthlyBookingsChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyBookings->pluck('month')) !!},
                datasets: [{
                    label: 'Bookings',
                    data: {!! json_encode($monthlyBookings->pluck('count')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Revenue by Hotel Chart
        const revenueCtx = document.getElementById('revenueByHotelChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($revenueByHotel->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($revenueByHotel->pluck('revenue')) !!},
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>
