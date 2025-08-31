<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reviews Management</title>
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
        .star-rating {
            color: #ffc107;
        }
        .review-item {
            border-left: 4px solid #007bff;
            padding-left: 15px;
            margin-bottom: 15px;
        }
        .review-item.hotel {
            border-left-color: #28a745;
        }
        .review-item.room {
            border-left-color: #17a2b8;
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
                    <a class="nav-link text-white" href="{{ route('admin.special-offers.index') }}">
                        <i class="fas fa-tags me-2"></i>Special Offers
                    </a>
                    <a class="nav-link text-white active" href="{{ route('admin.reviews.index') }}">
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
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-star me-2"></i>
                        Review Management
                    </h1>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.reviews.pending') }}" class="btn btn-warning">
                            <i class="fas fa-clock me-1"></i>
                            Pending Reviews
                        </a>
                        <a href="{{ route('admin.reviews.approved') }}" class="btn btn-success">
                            <i class="fas fa-check me-1"></i>
                            Approved Reviews
                        </a>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Reviews
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-star fa-2x text-gray-300"></i>
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
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Approved Reviews
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['approved'] }}</div>
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
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Pending Reviews
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
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
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Hotel Reviews
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['hotel_reviews'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-hotel fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">All Reviews</h6>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success btn-sm" onclick="bulkApprove()">
                                <i class="fas fa-check me-1"></i>Bulk Approve
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">
                                <i class="fas fa-trash me-1"></i>Bulk Delete
                            </button>
                        </div>
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

                        <form id="bulk-form" method="POST" action="{{ route('admin.reviews.bulk-approve') }}">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered" id="reviewsTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">
                                                <input type="checkbox" id="select-all">
                                            </th>
                                            <th width="15%">Reviewer</th>
                                            <th width="20%">Item</th>
                                            <th width="10%">Rating</th>
                                            <th width="25%">Comment</th>
                                            <th width="10%">Status</th>
                                            <th width="10%">Date</th>
                                            <th width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reviews as $review)
                                            <tr class="review-item {{ $review->reviewable_type === 'App\Models\Hotel' ? 'hotel' : 'room' }}">
                                                <td>
                                                    <input type="checkbox" name="selected_reviews[]" value="{{ $review->id }}" class="review-checkbox">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                            <span class="text-white fw-bold">{{ substr($review->user->name, 0, 1) }}</span>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $review->user->name }}</div>
                                                            <small class="text-muted">{{ $review->user->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <div class="fw-bold">
                                                            @if($review->reviewable_type === 'App\Models\Hotel')
                                                                <i class="fas fa-hotel text-success me-1"></i>
                                                                {{ $review->reviewable->name }}
                                                            @else
                                                                <i class="fas fa-bed text-info me-1"></i>
                                                                {{ $review->reviewable->room_number }} - {{ $review->reviewable->type }}
                                                            @endif
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ $review->reviewable_type === 'App\Models\Hotel' ? 'Hotel' : 'Room' }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="star-rating">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <small class="text-muted">{{ $review->rating }}/5</small>
                                                </td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $review->comment }}">
                                                        {{ Str::limit($review->comment, 100) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($review->is_approved)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>Approved
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock me-1"></i>Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small>{{ $review->created_at->format('M d, Y') }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if(!$review->is_approved)
                                                            <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Approve" onclick="return confirm('Approve this review?')">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this review?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-star fa-3x mb-3"></i>
                                                        <h5>No reviews found</h5>
                                                        <p>Reviews will appear here once users start rating hotels and rooms.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <!-- Pagination -->
                        @if($reviews->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $reviews->links() }}
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
            // Initialize DataTable
            $('#reviewsTable').DataTable({
                "pageLength": 25,
                "order": [[6, "desc"]], // Sort by date column
                "language": {
                    "search": "Search reviews:",
                    "lengthMenu": "Show _MENU_ reviews per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ reviews",
                    "infoEmpty": "Showing 0 to 0 of 0 reviews",
                    "infoFiltered": "(filtered from _MAX_ total reviews)"
                }
            });

            // Select all functionality
            $('#select-all').change(function() {
                $('.review-checkbox').prop('checked', $(this).is(':checked'));
            });

            // Update select all when individual checkboxes change
            $('.review-checkbox').change(function() {
                if (!$(this).is(':checked')) {
                    $('#select-all').prop('checked', false);
                } else {
                    var allChecked = $('.review-checkbox:checked').length === $('.review-checkbox').length;
                    $('#select-all').prop('checked', allChecked);
                }
            });
        });

        function bulkApprove() {
            var selected = $('.review-checkbox:checked').length;
            if (selected === 0) {
                alert('Please select reviews to approve.');
                return;
            }
            
            if (confirm('Approve ' + selected + ' selected review(s)?')) {
                $('#bulk-form').attr('action', '{{ route("admin.reviews.bulk-approve") }}').submit();
            }
        }

        function bulkDelete() {
            var selected = $('.review-checkbox:checked').length;
            if (selected === 0) {
                alert('Please select reviews to delete.');
                return;
            }
            
            if (confirm('Delete ' + selected + ' selected review(s)? This action cannot be undone.')) {
                $('#bulk-form').attr('action', '{{ route("admin.reviews.bulk-delete") }}').submit();
            }
        }
    </script>
</body>
</html>
