<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reviews - BookMyStay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .star-rating {
            color: #ffc107;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.hotels') }}">
                            <i class="fas fa-home me-1"></i>Hotels
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.bookings') }}">
                            <i class="fas fa-calendar me-1"></i>My Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.notifications') }}">
                            <i class="fas fa-bell me-1"></i>Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.reviews') }}">
                            <i class="fas fa-star me-1"></i>My Reviews
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('user.bookings') }}">My Bookings</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.notifications') }}">Notifications</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.reviews') }}">My Reviews</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold">
                        <i class="fas fa-star me-3"></i>My Reviews
                    </h1>
                    <p class="lead mb-0">Track and manage all your hotel and room reviews</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex justify-content-md-end">
                        <div class="text-center me-4">
                            <div class="h3 mb-0">{{ $stats['total'] }}</div>
                            <small>Total Reviews</small>
                        </div>
                        <div class="text-center me-4">
                            <div class="h3 mb-0">{{ $stats['approved'] }}</div>
                            <small>Approved</small>
                        </div>
                        <div class="text-center">
                            <div class="h3 mb-0">{{ $stats['pending'] }}</div>
                            <small>Pending</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-star fa-2x mb-2"></i>
                        <h4>{{ $stats['total'] }}</h4>
                        <p class="mb-0">Total Reviews</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h4>{{ $stats['approved'] }}</h4>
                        <p class="mb-0">Approved</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h4>{{ $stats['pending'] }}</h4>
                        <p class="mb-0">Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-hotel fa-2x mb-2"></i>
                        <h4>{{ $stats['hotel_reviews'] }}</h4>
                        <p class="mb-0">Hotel Reviews</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>All My Reviews
                </h5>
            </div>
            <div class="card-body">
                @if($reviews->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                    <tr class="review-item {{ $review->reviewable_type === 'App\Models\Hotel' ? 'hotel' : 'room' }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-{{ $review->reviewable_type === 'App\Models\Hotel' ? 'success' : 'info' }} text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-{{ $review->reviewable_type === 'App\Models\Hotel' ? 'hotel' : 'bed' }}"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">
                                                        @if($review->reviewable_type === 'App\Models\Hotel')
                                                            {{ $review->reviewable->name }}
                                                        @else
                                                            Room {{ $review->reviewable->room_number }} - {{ $review->reviewable->type }}
                                                        </div>
                                                        <small class="text-muted">{{ $review->reviewable->hotel->name }}</small>
                                                        @endif
                                                    </div>
                                                </div>
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
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewReview({{ $review->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($reviews->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-star fa-3x mb-3"></i>
                            <h5>No reviews yet</h5>
                            <p>Start reviewing hotels and rooms to help other travelers!</p>
                            <a href="{{ route('user.hotels') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Find Hotels to Review
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Review Detail Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Review Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="reviewModalBody">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        function viewReview(reviewId) {
            // This would typically load review details via AJAX
            // For now, we'll just show a placeholder
            $('#reviewModalBody').html(`
                <div class="text-center py-4">
                    <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                    <p>Loading review details...</p>
                </div>
            `);
            $('#reviewModal').modal('show');
        }
    </script>
</body>
</html>
