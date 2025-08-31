<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hotel->name }} Reviews - BookMyStay</title>
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
        .review-card {
            border-left: 4px solid #28a745;
            padding-left: 15px;
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
                        <a class="nav-link" href="{{ route('user.reviews') }}">
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

    <!-- Hotel Information -->
    <div class="bg-light py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3">
                    @if($hotel->image)
                        <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="img-fluid rounded">
                    @else
                        <div class="bg-white rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                            <i class="fas fa-hotel fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <h2 class="mb-2">{{ $hotel->name }}</h2>
                    <p class="text-muted mb-2">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $hotel->full_address }}
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fas fa-phone me-1"></i>
                        {{ $hotel->phone }}
                    </p>
                </div>
                <div class="col-md-3 text-md-end">
                    <div class="text-center">
                        <div class="star-rating mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $hotel->rating ? '' : '-o' }} fa-2x"></i>
                            @endfor
                        </div>
                        <h4 class="mb-1">{{ number_format($hotel->rating, 1) }}/5</h4>
                        <p class="text-muted mb-0">{{ $hotel->total_reviews }} reviews</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <!-- Action Buttons -->
        <div class="row mb-4">
            <div class="col-md-6">
                <a href="{{ route('user.hotel.detail', $hotel->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Hotel Details
                </a>
            </div>
            <div class="col-md-6 text-md-end">
                @if(auth()->check() && !$hotel->reviews()->where('user_id', auth()->id())->exists())
                    <a href="{{ route('user.reviews.create-hotel', $hotel->id) }}" class="btn btn-primary">
                        <i class="fas fa-star me-2"></i>Write a Review
                    </a>
                @endif
            </div>
        </div>

        <!-- Reviews List -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-star me-2"></i>Customer Reviews ({{ $reviews->total() }})
                </h5>
            </div>
            <div class="card-body">
                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div class="review-card">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
                                        <span class="fw-bold">{{ substr($review->user->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1">{{ $review->user->name }}</h6>
                                            <div class="star-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                @endfor
                                                <span class="ms-2 text-muted">{{ $review->rating }}/5</span>
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                    </div>
                                    <p class="mb-0">{{ $review->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

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
                            <p>Be the first to review this hotel!</p>
                            @if(auth()->check())
                                <a href="{{ route('user.reviews.create-hotel', $hotel->id) }}" class="btn btn-primary">
                                    <i class="fas fa-star me-2"></i>Write the First Review
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Review
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
