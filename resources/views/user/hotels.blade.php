<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookMyStay - Find Your Perfect Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        .search-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .hotel-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        .hotel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .hotel-image {
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
            padding: 5px 15px;
            font-weight: bold;
        }
        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
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
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                        @endif
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
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 mb-4">Find Your Perfect Stay</h1>
                    <p class="lead mb-5">Discover amazing hotels with the best prices and amenities</p>
                    
                    <!-- Search Box -->
                    <div class="search-box">
                        <form method="GET" action="{{ route('user.hotels') }}">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="location" 
                                           placeholder="Where are you going?" value="{{ request('location') }}">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" name="star_rating">
                                        <option value="">All Star Ratings</option>
                                        <option value="5" {{ request('star_rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                                        <option value="4" {{ request('star_rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                                        <option value="3" {{ request('star_rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                                        <option value="2" {{ request('star_rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                                        <option value="1" {{ request('star_rating') == '1' ? 'selected' : '' }}>1 Star</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" name="rating">
                                        <option value="">All Ratings</option>
                                        <option value="4.5" {{ request('rating') == '4.5' ? 'selected' : '' }}>4.5+ Stars</option>
                                        <option value="4.0" {{ request('rating') == '4.0' ? 'selected' : '' }}>4.0+ Stars</option>
                                        <option value="3.5" {{ request('rating') == '3.5' ? 'selected' : '' }}>3.5+ Stars</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search me-2"></i>Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="py-4">
        <div class="container">
            <div class="filter-section">
                <form method="GET" action="{{ route('user.hotels') }}" class="row g-3">
                    <input type="hidden" name="location" value="{{ request('location') }}">
                    <input type="hidden" name="star_rating" value="{{ request('star_rating') }}">
                    <input type="hidden" name="rating" value="{{ request('rating') }}">
                    
                    <div class="col-md-3">
                        <label class="form-label">Price Range (per night)</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="number" class="form-control" name="min_price" 
                                       placeholder="Min" value="{{ request('min_price') }}">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control" name="max_price" 
                                       placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Sort By</label>
                        <select class="form-select" name="sort">
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <a href="{{ route('user.hotels') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-2"></i>Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Hotels Listing -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-4">Available Hotels ({{ $hotels->total() }})</h2>
                </div>
            </div>
            
            <div class="row">
                @forelse($hotels as $hotel)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card hotel-card h-100">
                            <img src="{{ $hotel->image }}" class="card-img-top hotel-image" alt="{{ $hotel->name }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $hotel->name }}</h5>
                                    <span class="price-badge">
                                        From ${{ $hotel->rooms->min('price_per_night') }}
                                    </span>
                                </div>
                                
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $hotel->city }}, {{ $hotel->state }}
                                </p>
                                
                                <div class="d-flex align-items-center mb-2">
                                    <div class="rating-stars me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $hotel->star_rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-muted">({{ $hotel->total_reviews }} reviews)</span>
                                </div>
                                
                                <p class="card-text">{{ Str::limit($hotel->description, 100) }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-success">{{ $hotel->rooms->count() }} rooms available</span>
                                    <a href="{{ route('user.hotel.detail', $hotel->id) }}" class="btn btn-primary">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4>No hotels found</h4>
                        <p class="text-muted">Try adjusting your search criteria</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($hotels->hasPages())
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="Hotels pagination">
                            {{ $hotels->appends(request()->query())->links() }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 