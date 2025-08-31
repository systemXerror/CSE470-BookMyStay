<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Special Offers Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .stat-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .discount-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
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
                    <a class="nav-link text-white" href="{{ route('admin.statistics') }}">
                        <i class="fas fa-chart-bar me-2"></i>Statistics
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.notifications') }}">
                        <i class="fas fa-bell me-2"></i>Notifications
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.rooms.index') }}">
                        <i class="fas fa-bed me-2"></i>Room Management
                    </a>
                    <a class="nav-link text-white active" href="{{ route('admin.special-offers.index') }}">
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
                <!-- Page Header -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Special Offers & Discount Codes</h1>
                    <a href="{{ route('admin.special-offers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus fa-sm"></i> Create New Offer
                    </a>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Offers</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Offers</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Expired Offers</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['expired'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Uses</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_uses'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Special Offers Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">All Special Offers</h6>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($specialOffers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th>Discount</th>
                                            <th>Status</th>
                                            <th>Usage</th>
                                            <th>Valid Period</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($specialOffers as $offer)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <div class="fw-bold">{{ $offer->name }}</div>
                                                        <small class="text-muted">{{ Str::limit($offer->description, 50) }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $offer->code }}</span>
                                                </td>
                                                <td>
                                                    @if($offer->type === 'percentage')
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-percent me-1"></i>Percentage
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-dollar-sign me-1"></i>Fixed Amount
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="fw-bold text-success">
                                                        @if($offer->type === 'percentage')
                                                            {{ $offer->discount_value }}%
                                                        @else
                                                            ${{ number_format($offer->discount_value, 2) }}
                                                        @endif
                                                    </div>
                                                    @if($offer->minimum_amount > 0)
                                                        <small class="text-muted">Min: ${{ number_format($offer->minimum_amount, 2) }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($offer->is_active && $offer->isValid())
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>Active
                                                        </span>
                                                    @elseif(!$offer->is_active)
                                                        <span class="badge bg-secondary">
                                                            <i class="fas fa-pause me-1"></i>Inactive
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times me-1"></i>Expired
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                                            <div class="progress-bar bg-{{ $offer->usage_percentage > 80 ? 'danger' : ($offer->usage_percentage > 50 ? 'warning' : 'success') }}" 
                                                                 style="width: {{ $offer->usage_percentage }}%"></div>
                                                        </div>
                                                        <small>{{ $offer->used_count }}/{{ $offer->max_uses ?: '∞' }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <small class="text-muted">From: {{ $offer->start_date->format('M d, Y') }}</small><br>
                                                        <small class="text-muted">To: {{ $offer->end_date->format('M d, Y') }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.special-offers.show', $offer->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.special-offers.edit', $offer->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form method="POST" action="{{ route('admin.special-offers.toggle-status', $offer->id) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-{{ $offer->is_active ? 'warning' : 'success' }}" 
                                                                    title="{{ $offer->is_active ? 'Deactivate' : 'Activate' }}">
                                                                <i class="fas fa-{{ $offer->is_active ? 'pause' : 'play' }}"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.special-offers.destroy', $offer->id) }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" 
                                                                    onclick="return confirm('Are you sure you want to delete this offer?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($specialOffers->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $specialOffers->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-tags fa-3x mb-3"></i>
                                    <h5>No special offers found</h5>
                                    <p>Create your first special offer to attract more customers.</p>
                                    <a href="{{ route('admin.special-offers.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Create First Offer
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "pageLength": 25,
                "order": [[6, "desc"]], // Sort by valid period
                "language": {
                    "search": "Search offers:",
                    "lengthMenu": "Show _MENU_ offers per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ offers",
                    "infoEmpty": "Showing 0 to 0 of 0 offers",
                    "infoFiltered": "(filtered from _MAX_ total offers)"
                }
            });
        });
    </script>
</body>
</html>
