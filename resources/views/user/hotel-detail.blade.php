<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hotel->name }} - BookMyStay</title>
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
        .hotel-image {
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
        }
        .room-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            overflow: hidden;
        }
        .room-card:hover {
            transform: translateY(-5px);
        }
        .room-image {
            height: 200px;
            object-fit: cover;
        }
        .rating-stars {
            color: #ffc107;
        }
        .price-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: bold;
        }
        .amenity-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .amenity-icon {
            width: 30px;
            color: #667eea;
            margin-right: 10px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .info-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.my-bookings') }}">My Bookings</a>
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
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 mb-3">{{ $hotel->name }}</h1>
                    <p class="lead mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        {{ $hotel->full_address }}
                    </p>
                    <div class="d-flex align-items-center mb-3">
                        <div class="rating-stars me-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $hotel->star_rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="me-3">{{ $hotel->rating }}/5 ({{ $hotel->total_reviews }} reviews)</span>
                        <span class="badge bg-light text-dark">{{ $hotel->star_rating }} Star Hotel</span>
                    </div>
                    <a href="{{ route('user.hotels') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>Back to Hotels
                    </a>
                </div>
                <div class="col-lg-4">
                    <img src="{{ $hotel->image }}" class="img-fluid hotel-image" alt="{{ $hotel->name }}">
                </div>
            </div>
        </div>
    </section>

    <!-- Hotel Details -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Hotel Information -->
                <div class="col-lg-8">
                    <div class="info-card">
                        <h3 class="mb-4">About {{ $hotel->name }}</h3>
                        <p class="lead">{{ $hotel->description }}</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5><i class="fas fa-phone me-2"></i>Contact Information</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Phone:</strong> {{ $hotel->phone }}</li>
                                    <li><strong>Email:</strong> {{ $hotel->email }}</li>
                                    @if($hotel->website)
                                        <li><strong>Website:</strong> <a href="{{ $hotel->website }}" target="_blank">{{ $hotel->website }}</a></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle me-2"></i>Hotel Details</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Location:</strong> {{ $hotel->location }}</li>
                                    <li><strong>City:</strong> {{ $hotel->city }}, {{ $hotel->state }}</li>
                                    <li><strong>Country:</strong> {{ $hotel->country }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Available Rooms -->
                    <div class="info-card">
                        <h3 class="mb-4">Available Rooms</h3>
                        
                        @if($hotel->rooms->count() > 0)
                            <div class="row">
                                @foreach($hotel->rooms as $room)
                                    <div class="col-lg-6 mb-4">
                                        <div class="card room-card h-100">
                                            <img src="{{ $room->image }}" class="card-img-top room-image" alt="{{ $room->room_type }}">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h5 class="card-title mb-0">{{ $room->room_type }}</h5>
                                                    <span class="price-badge">${{ $room->price_per_night }}/night</span>
                                                </div>
                                                
                                                <p class="text-muted mb-2">
                                                    <i class="fas fa-users me-1"></i>
                                                    Up to {{ $room->capacity }} guests
                                                    @if($room->size_sqm)
                                                        • {{ $room->size_sqm }} sqm
                                                    @endif
                                                </p>
                                                
                                                <p class="card-text">{{ Str::limit($room->description, 80) }}</p>
                                                
                                                @if($room->amenities->count() > 0)
                                                    <div class="mb-3">
                                                        <small class="text-muted">Amenities:</small>
                                                        <div class="d-flex flex-wrap">
                                                            @foreach($room->amenities->take(3) as $amenity)
                                                                <span class="badge bg-light text-dark me-1 mb-1">
                                                                    <i class="{{ $amenity->icon }} me-1"></i>{{ $amenity->name }}
                                                                </span>
                                                            @endforeach
                                                            @if($room->amenities->count() > 3)
                                                                <span class="badge bg-secondary me-1 mb-1">+{{ $room->amenities->count() - 3 }} more</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                <a href="{{ route('user.room.detail', ['hotel' => $hotel->id, 'room' => $room->id]) }}" 
                                                   class="btn btn-primary w-100">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                                <h5>No rooms available</h5>
                                <p class="text-muted">Please check back later for availability</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-star me-2"></i>Hotel Rating</h5>
                        <div class="d-flex align-items-center mb-3">
                            <div class="rating-stars me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $hotel->star_rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="h5 mb-0">{{ $hotel->rating }}/5</span>
                        </div>
                        <p class="text-muted">{{ $hotel->total_reviews }} reviews</p>
                    </div>

                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-bed me-2"></i>Room Summary</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Total Rooms:</strong> {{ $hotel->rooms->count() }}
                            </li>
                            <li class="mb-2">
                                <strong>Price Range:</strong> 
                                ${{ $hotel->rooms->min('price_per_night') }} - ${{ $hotel->rooms->max('price_per_night') }}
                            </li>
                            <li class="mb-2">
                                <strong>Room Types:</strong> {{ $hotel->rooms->unique('room_type')->count() }}
                            </li>
                        </ul>
                    </div>

                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Location</h5>
                        <p class="mb-2"><strong>Address:</strong></p>
                        <p class="text-muted">{{ $hotel->address }}<br>
                        {{ $hotel->city }}, {{ $hotel->state }} {{ $hotel->country }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="info-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="mb-0">
                                <i class="fas fa-star me-2"></i>
                                Customer Reviews
                            </h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('user.reviews.hotel', $hotel->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>
                                    View All Reviews
                                </a>
                                @auth
                                    @if(App\Models\Review::canUserReview(auth()->id(), 'App\Models\Hotel', $hotel->id))
                                        <a href="{{ route('user.reviews.create-hotel', $hotel->id) }}" class="btn btn-primary">
                                            <i class="fas fa-star me-1"></i>
                                            Write a Review
                                        </a>
                                    @else
                                        <button class="btn btn-secondary" disabled>
                                            <i class="fas fa-check me-1"></i>
                                            Already Reviewed
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                        Login to Review
                                    </a>
                                @endauth
                            </div>
                        </div>

                        @if($hotel->approvedReviews->count() > 0)
                            <div class="row">
                                @foreach($hotel->approvedReviews->take(3) as $review)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                            <span class="fw-bold small">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $review->user->name }}</h6>
                                                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="d-flex align-items-center">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $review->rating)
                                                                    <i class="fas fa-star text-warning me-1"></i>
                                                                @else
                                                                    <i class="far fa-star text-warning me-1"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="card-text">{{ Str::limit($review->comment, 100) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($hotel->approvedReviews->count() > 3)
                                <div class="text-center mt-3">
                                    <a href="{{ route('user.reviews.hotel', $hotel->id) }}" class="btn btn-outline-primary">
                                        View All {{ $hotel->approvedReviews->count() }} Reviews
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Reviews Yet</h5>
                                <p class="text-muted">Be the first to review this hotel!</p>
                                @auth
                                    @if(App\Models\Review::canUserReview(auth()->id(), 'App\Models\Hotel', $hotel->id))
                                        <a href="{{ route('user.reviews.create-hotel', $hotel->id) }}" class="btn btn-primary">
                                            <i class="fas fa-star me-1"></i>
                                            Write the First Review
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                        Login to Review
                                    </a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 