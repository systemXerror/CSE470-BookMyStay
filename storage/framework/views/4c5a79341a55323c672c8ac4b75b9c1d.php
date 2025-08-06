<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($hotel->name); ?> - BookMyStay</title>
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
            <a class="navbar-brand" href="<?php echo e(route('user.hotels')); ?>">
                <i class="fas fa-hotel me-2"></i>BookMyStay
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('user.hotels')); ?>">Hotels</a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('user.my-bookings')); ?>">My Bookings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                                </button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 mb-3"><?php echo e($hotel->name); ?></h1>
                    <p class="lead mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <?php echo e($hotel->full_address); ?>

                    </p>
                    <div class="d-flex align-items-center mb-3">
                        <div class="rating-stars me-3">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <?php if($i <= $hotel->star_rating): ?>
                                    <i class="fas fa-star"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <span class="me-3"><?php echo e($hotel->rating); ?>/5 (<?php echo e($hotel->total_reviews); ?> reviews)</span>
                        <span class="badge bg-light text-dark"><?php echo e($hotel->star_rating); ?> Star Hotel</span>
                    </div>
                    <a href="<?php echo e(route('user.hotels')); ?>" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>Back to Hotels
                    </a>
                </div>
                <div class="col-lg-4">
                    <img src="<?php echo e($hotel->image); ?>" class="img-fluid hotel-image" alt="<?php echo e($hotel->name); ?>">
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
                        <h3 class="mb-4">About <?php echo e($hotel->name); ?></h3>
                        <p class="lead"><?php echo e($hotel->description); ?></p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5><i class="fas fa-phone me-2"></i>Contact Information</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Phone:</strong> <?php echo e($hotel->phone); ?></li>
                                    <li><strong>Email:</strong> <?php echo e($hotel->email); ?></li>
                                    <?php if($hotel->website): ?>
                                        <li><strong>Website:</strong> <a href="<?php echo e($hotel->website); ?>" target="_blank"><?php echo e($hotel->website); ?></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle me-2"></i>Hotel Details</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Location:</strong> <?php echo e($hotel->location); ?></li>
                                    <li><strong>City:</strong> <?php echo e($hotel->city); ?>, <?php echo e($hotel->state); ?></li>
                                    <li><strong>Country:</strong> <?php echo e($hotel->country); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Available Rooms -->
                    <div class="info-card">
                        <h3 class="mb-4">Available Rooms</h3>
                        
                        <?php if($hotel->rooms->count() > 0): ?>
                            <div class="row">
                                <?php $__currentLoopData = $hotel->rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-lg-6 mb-4">
                                        <div class="card room-card h-100">
                                            <img src="<?php echo e($room->image); ?>" class="card-img-top room-image" alt="<?php echo e($room->room_type); ?>">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h5 class="card-title mb-0"><?php echo e($room->room_type); ?></h5>
                                                    <span class="price-badge">$<?php echo e($room->price_per_night); ?>/night</span>
                                                </div>
                                                
                                                <p class="text-muted mb-2">
                                                    <i class="fas fa-users me-1"></i>
                                                    Up to <?php echo e($room->capacity); ?> guests
                                                    <?php if($room->size_sqm): ?>
                                                        • <?php echo e($room->size_sqm); ?> sqm
                                                    <?php endif; ?>
                                                </p>
                                                
                                                <p class="card-text"><?php echo e(Str::limit($room->description, 80)); ?></p>
                                                
                                                <?php if($room->amenities->count() > 0): ?>
                                                    <div class="mb-3">
                                                        <small class="text-muted">Amenities:</small>
                                                        <div class="d-flex flex-wrap">
                                                            <?php $__currentLoopData = $room->amenities->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <span class="badge bg-light text-dark me-1 mb-1">
                                                                    <i class="<?php echo e($amenity->icon); ?> me-1"></i><?php echo e($amenity->name); ?>

                                                                </span>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($room->amenities->count() > 3): ?>
                                                                <span class="badge bg-secondary me-1 mb-1">+<?php echo e($room->amenities->count() - 3); ?> more</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <a href="<?php echo e(route('user.room.detail', ['hotel' => $hotel->id, 'room' => $room->id])); ?>" 
                                                   class="btn btn-primary w-100">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                                <h5>No rooms available</h5>
                                <p class="text-muted">Please check back later for availability</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-star me-2"></i>Hotel Rating</h5>
                        <div class="d-flex align-items-center mb-3">
                            <div class="rating-stars me-2">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= $hotel->star_rating): ?>
                                        <i class="fas fa-star"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <span class="h5 mb-0"><?php echo e($hotel->rating); ?>/5</span>
                        </div>
                        <p class="text-muted"><?php echo e($hotel->total_reviews); ?> reviews</p>
                    </div>

                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-bed me-2"></i>Room Summary</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Total Rooms:</strong> <?php echo e($hotel->rooms->count()); ?>

                            </li>
                            <li class="mb-2">
                                <strong>Price Range:</strong> 
                                $<?php echo e($hotel->rooms->min('price_per_night')); ?> - $<?php echo e($hotel->rooms->max('price_per_night')); ?>

                            </li>
                            <li class="mb-2">
                                <strong>Room Types:</strong> <?php echo e($hotel->rooms->unique('room_type')->count()); ?>

                            </li>
                        </ul>
                    </div>

                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Location</h5>
                        <p class="mb-2"><strong>Address:</strong></p>
                        <p class="text-muted"><?php echo e($hotel->address); ?><br>
                        <?php echo e($hotel->city); ?>, <?php echo e($hotel->state); ?> <?php echo e($hotel->country); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> <?php /**PATH D:\Xampp\htdocs\hotel_management\resources\views/user/hotel-detail.blade.php ENDPATH**/ ?>