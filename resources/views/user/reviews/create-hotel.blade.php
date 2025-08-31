<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review {{ $hotel->name }} - BookMyStay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .rating-stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
        }
        .rating-input {
            display: none;
        }
        .rating-star {
            cursor: pointer;
            font-size: 2rem;
            color: #ddd;
            transition: color 0.2s ease;
        }
        .rating-star:hover,
        .rating-star:hover ~ .rating-star,
        .rating-input:checked ~ .rating-star {
            color: #ffc107;
        }
        .rating-star i {
            transition: transform 0.2s ease;
        }
        .rating-star:hover i,
        .rating-star:hover ~ .rating-star i,
        .rating-input:checked ~ .rating-star i {
            transform: scale(1.1);
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-star me-2"></i>
                            Review {{ $hotel->name }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Hotel Information -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                @if($hotel->image)
                                    <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="img-fluid rounded">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                        <i class="fas fa-hotel fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h5>{{ $hotel->name }}</h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $hotel->full_address }}
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-phone me-1"></i>
                                    {{ $hotel->phone }}
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('user.reviews.store-hotel', $hotel->id) }}" method="POST">
                            @csrf
                            
                            <!-- Rating -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Your Rating</label>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="rating-input" required>
                                        <label for="star{{ $i }}" class="rating-star">
                                            <i class="far fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                                <div class="rating-text mt-2">
                                    <span id="rating-text" class="text-muted">Select your rating</span>
                                </div>
                                @error('rating')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Comment -->
                            <div class="mb-4">
                                <label for="comment" class="form-label fw-bold">Your Review</label>
                                <textarea 
                                    name="comment" 
                                    id="comment" 
                                    rows="6" 
                                    class="form-control @error('comment') is-invalid @enderror" 
                                    placeholder="Share your experience with this hotel..."
                                    required
                                >{{ old('comment') }}</textarea>
                                <div class="form-text">
                                    Minimum 10 characters. Be honest and helpful to other travelers.
                                </div>
                                @error('comment')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('user.hotel.detail', $hotel->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Back to Hotel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i>
                                    Submit Review
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Rating text update
            $('.rating-input').change(function() {
                var rating = $(this).val();
                var ratingTexts = {
                    1: 'Poor - Not recommended',
                    2: 'Fair - Below average',
                    3: 'Good - Average experience',
                    4: 'Very Good - Above average',
                    5: 'Excellent - Highly recommended'
                };
                $('#rating-text').text(ratingTexts[rating]);
            });

            // Form validation
            $('form').submit(function() {
                var rating = $('input[name="rating"]:checked').val();
                var comment = $('#comment').val().trim();
                
                if (!rating) {
                    alert('Please select a rating');
                    return false;
                }
                
                if (comment.length < 10) {
                    alert('Please write a review with at least 10 characters');
                    return false;
                }
                
                return true;
            });
        });
    </script>
</body>
</html>
