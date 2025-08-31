<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $room->room_type }} - {{ $room->hotel->name }} - BookMyStay</title>
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
        .room-image {
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
        }
        .info-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .amenity-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 10px;
            background: #f8f9fa;
        }
        .amenity-icon {
            width: 40px;
            color: #667eea;
            margin-right: 15px;
            font-size: 1.2rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .price-display {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }
        .availability-badge {
            font-size: 1.1rem;
            padding: 8px 20px;
            border-radius: 25px;
        }
        .image-gallery {
            border-radius: 15px;
            overflow: hidden;
        }
        .gallery-thumb {
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 8px;
            transition: opacity 0.3s ease;
        }
        .gallery-thumb:hover {
            opacity: 0.8;
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
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.hotels') }}" class="text-white">Hotels</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.hotel.detail', $room->hotel->id) }}" class="text-white">{{ $room->hotel->name }}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ $room->room_type }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-5 mb-3">{{ $room->room_type }}</h1>
                    <p class="lead mb-3">
                        <i class="fas fa-hotel me-2"></i>{{ $room->hotel->name }}
                    </p>
                    <div class="d-flex align-items-center mb-3">
                        <span class="price-display me-3">${{ $room->price_per_night }}/night</span>
                        @if($isAvailable)
                            <span class="badge bg-success availability-badge">
                                <i class="fas fa-check me-2"></i>Available
                            </span>
                        @else
                            <span class="badge bg-danger availability-badge">
                                <i class="fas fa-times me-2"></i>Not Available
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{ $room->image }}" class="img-fluid room-image" alt="{{ $room->room_type }}">
                </div>
            </div>
        </div>
    </section>

    <!-- Room Details -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Room Information -->
                <div class="col-lg-8">
                    <div class="info-card">
                        <h3 class="mb-4">Room Details</h3>
                        <p class="lead">{{ $room->description }}</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle me-2"></i>Room Information</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Room Type:</strong> {{ $room->room_type }}</li>
                                    <li class="mb-2"><strong>Capacity:</strong> Up to {{ $room->capacity }} guests</li>
                                    @if($room->size_sqm)
                                        <li class="mb-2"><strong>Size:</strong> {{ $room->size_sqm }} sqm</li>
                                    @endif
                                    <li class="mb-2"><strong>Price:</strong> ${{ $room->price_per_night }} per night</li>
                                    <li class="mb-2"><strong>Status:</strong> 
                                        <span class="badge bg-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-hotel me-2"></i>Hotel Information</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Hotel:</strong> {{ $room->hotel->name }}</li>
                                    <li class="mb-2"><strong>Location:</strong> {{ $room->hotel->city }}, {{ $room->hotel->state }}</li>
                                    <li class="mb-2"><strong>Rating:</strong> {{ $room->hotel->rating }}/5 ({{ $room->hotel->total_reviews }} reviews)</li>
                                    <li class="mb-2"><strong>Star Rating:</strong> {{ $room->hotel->star_rating }} Stars</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Room Amenities -->
                    @if($room->amenities->count() > 0)
                        <div class="info-card">
                            <h3 class="mb-4">Room Amenities</h3>
                            <div class="row">
                                @foreach($room->amenities as $amenity)
                                    <div class="col-md-6">
                                        <div class="amenity-item">
                                            <i class="{{ $amenity->icon }} amenity-icon"></i>
                                            <div>
                                                <strong>{{ $amenity->name }}</strong>
                                                @if($amenity->description)
                                                    <br><small class="text-muted">{{ $amenity->description }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Image Gallery -->
                    @if($room->images && count($room->images) > 1)
                        <div class="info-card">
                            <h3 class="mb-4">Room Gallery</h3>
                            <div class="row">
                                @foreach($room->images as $index => $image)
                                    <div class="col-md-3 mb-3">
                                        <img src="{{ $image }}" class="img-fluid gallery-thumb" 
                                             alt="{{ $room->room_type }} - Image {{ $index + 1 }}"
                                             onclick="openImageModal('{{ $image }}')">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Booking Sidebar -->
                <div class="col-lg-4">
                    <div class="info-card">
                        <h4 class="mb-4">Check Availability & Book</h4>
                        
                        <form method="GET" action="{{ route('user.room.detail', ['hotel' => $room->hotel->id, 'room' => $room->id]) }}">
                            <div class="mb-3">
                                <label for="check_in" class="form-label">Check-in Date</label>
                                <input type="date" class="form-control" id="check_in" name="check_in" 
                                       value="{{ request('check_in') }}" min="{{ date('Y-m-d') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="check_out" class="form-label">Check-out Date</label>
                                <input type="date" class="form-control" id="check_out" name="check_out" 
                                       value="{{ request('check_out') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="guests" class="form-label">Number of Guests</label>
                                <select class="form-select" id="guests" name="guests">
                                    @for($i = 1; $i <= $room->capacity; $i++)
                                        <option value="{{ $i }}" {{ request('guests', 1) == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-search me-2"></i>Check Availability
                            </button>
                        </form>

                        @if(request('check_in') && request('check_out'))
                            <div class="mt-4">
                                @if($isAvailable)
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <strong>Available!</strong> This room is available for your selected dates.
                                    </div>
                                    
                                    @auth
                                        <a href="{{ route('user.booking.form', ['hotel' => $room->hotel->id, 'room' => $room->id]) }}?check_in={{ request('check_in') }}&check_out={{ request('check_out') }}&guests={{ request('guests', 1) }}" class="btn btn-success w-100">
                                            <i class="fas fa-calendar-check me-2"></i>Book Now
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-success w-100">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login to Book
                                        </a>
                                    @endauth
                                @else
                                    <div class="alert alert-danger">
                                        <i class="fas fa-times-circle me-2"></i>
                                        <strong>Not Available</strong> This room is not available for your selected dates.
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-calculator me-2"></i>Price Breakdown</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Price per night:</span>
                            <span>${{ $room->price_per_night }}</span>
                        </div>
                        @if(request('check_in') && request('check_out'))
                            @php
                                $checkIn = new DateTime(request('check_in'));
                                $checkOut = new DateTime(request('check_out'));
                                $nights = $checkIn->diff($checkOut)->days;
                                $totalPrice = $nights * $room->price_per_night;
                            @endphp
                            <div class="d-flex justify-content-between mb-2">
                                <span>Number of nights:</span>
                                <span>{{ $nights }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span>${{ $totalPrice }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Hotel Location</h5>
                        <p class="mb-2"><strong>Address:</strong></p>
                        <p class="text-muted">{{ $room->hotel->address }}<br>
                        {{ $room->hotel->city }}, {{ $room->hotel->state }} {{ $room->hotel->country }}</p>
                        
                        <div class="d-flex justify-content-between">
                            <span><strong>Phone:</strong></span>
                            <span>{{ $room->hotel->phone }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><strong>Email:</strong></span>
                            <span>{{ $room->hotel->email }}</span>
                        </div>
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
                                Room Reviews
                            </h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('user.reviews.room', $room->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>
                                    View All Reviews
                                </a>
                                @auth
                                    @if(App\Models\Review::canUserReview(auth()->id(), 'App\Models\Room', $room->id))
                                        <a href="{{ route('user.reviews.create-room', $room->id) }}" class="btn btn-primary">
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

                        @if($room->approvedReviews->count() > 0)
                            <div class="row">
                                @foreach($room->approvedReviews->take(3) as $review)
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
                            @if($room->approvedReviews->count() > 3)
                                <div class="text-center mt-3">
                                    <a href="{{ route('user.reviews.room', $room->id) }}" class="btn btn-outline-primary">
                                        View All {{ $room->approvedReviews->count() }} Reviews
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Reviews Yet</h5>
                                <p class="text-muted">Be the first to review this room!</p>
                                @auth
                                    @if(App\Models\Review::canUserReview(auth()->id(), 'App\Models\Room', $room->id))
                                        <a href="{{ route('user.reviews.create-room', $room->id) }}" class="btn btn-primary">
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

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Room Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Room Image">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }
    </script>
</body>
</html> 