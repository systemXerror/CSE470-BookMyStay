<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($room->room_type); ?> - <?php echo e($room->hotel->name); ?> - BookMyStay</title>
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
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.hotels')); ?>" class="text-white">Hotels</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.hotel.detail', $room->hotel->id)); ?>" class="text-white"><?php echo e($room->hotel->name); ?></a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page"><?php echo e($room->room_type); ?></li>
                        </ol>
                    </nav>
                    <h1 class="display-5 mb-3"><?php echo e($room->room_type); ?></h1>
                    <p class="lead mb-3">
                        <i class="fas fa-hotel me-2"></i><?php echo e($room->hotel->name); ?>

                    </p>
                    <div class="d-flex align-items-center mb-3">
                        <span class="price-display me-3">$<?php echo e($room->price_per_night); ?>/night</span>
                        <?php if($isAvailable): ?>
                            <span class="badge bg-success availability-badge">
                                <i class="fas fa-check me-2"></i>Available
                            </span>
                        <?php else: ?>
                            <span class="badge bg-danger availability-badge">
                                <i class="fas fa-times me-2"></i>Not Available
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="<?php echo e($room->image); ?>" class="img-fluid room-image" alt="<?php echo e($room->room_type); ?>">
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
                        <p class="lead"><?php echo e($room->description); ?></p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle me-2"></i>Room Information</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Room Type:</strong> <?php echo e($room->room_type); ?></li>
                                    <li class="mb-2"><strong>Capacity:</strong> Up to <?php echo e($room->capacity); ?> guests</li>
                                    <?php if($room->size_sqm): ?>
                                        <li class="mb-2"><strong>Size:</strong> <?php echo e($room->size_sqm); ?> sqm</li>
                                    <?php endif; ?>
                                    <li class="mb-2"><strong>Price:</strong> $<?php echo e($room->price_per_night); ?> per night</li>
                                    <li class="mb-2"><strong>Status:</strong> 
                                        <span class="badge bg-<?php echo e($room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'warning' : 'danger')); ?>">
                                            <?php echo e(ucfirst($room->status)); ?>

                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-hotel me-2"></i>Hotel Information</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Hotel:</strong> <?php echo e($room->hotel->name); ?></li>
                                    <li class="mb-2"><strong>Location:</strong> <?php echo e($room->hotel->city); ?>, <?php echo e($room->hotel->state); ?></li>
                                    <li class="mb-2"><strong>Rating:</strong> <?php echo e($room->hotel->rating); ?>/5 (<?php echo e($room->hotel->total_reviews); ?> reviews)</li>
                                    <li class="mb-2"><strong>Star Rating:</strong> <?php echo e($room->hotel->star_rating); ?> Stars</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Room Amenities -->
                    <?php if($room->amenities->count() > 0): ?>
                        <div class="info-card">
                            <h3 class="mb-4">Room Amenities</h3>
                            <div class="row">
                                <?php $__currentLoopData = $room->amenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6">
                                        <div class="amenity-item">
                                            <i class="<?php echo e($amenity->icon); ?> amenity-icon"></i>
                                            <div>
                                                <strong><?php echo e($amenity->name); ?></strong>
                                                <?php if($amenity->description): ?>
                                                    <br><small class="text-muted"><?php echo e($amenity->description); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Image Gallery -->
                    <?php if($room->images && count($room->images) > 1): ?>
                        <div class="info-card">
                            <h3 class="mb-4">Room Gallery</h3>
                            <div class="row">
                                <?php $__currentLoopData = $room->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 mb-3">
                                        <img src="<?php echo e($image); ?>" class="img-fluid gallery-thumb" 
                                             alt="<?php echo e($room->room_type); ?> - Image <?php echo e($index + 1); ?>"
                                             onclick="openImageModal('<?php echo e($image); ?>')">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Booking Sidebar -->
                <div class="col-lg-4">
                    <div class="info-card">
                        <h4 class="mb-4">Check Availability & Book</h4>
                        
                        <form method="GET" action="<?php echo e(route('user.room.detail', ['hotel' => $room->hotel->id, 'room' => $room->id])); ?>">
                            <div class="mb-3">
                                <label for="check_in" class="form-label">Check-in Date</label>
                                <input type="date" class="form-control" id="check_in" name="check_in" 
                                       value="<?php echo e(request('check_in')); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="check_out" class="form-label">Check-out Date</label>
                                <input type="date" class="form-control" id="check_out" name="check_out" 
                                       value="<?php echo e(request('check_out')); ?>" min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="guests" class="form-label">Number of Guests</label>
                                <select class="form-select" id="guests" name="guests">
                                    <?php for($i = 1; $i <= $room->capacity; $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e(request('guests', 1) == $i ? 'selected' : ''); ?>>
                                            <?php echo e($i); ?> <?php echo e($i == 1 ? 'Guest' : 'Guests'); ?>

                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-search me-2"></i>Check Availability
                            </button>
                        </form>

                        <?php if(request('check_in') && request('check_out')): ?>
                            <div class="mt-4">
                                <?php if($isAvailable): ?>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <strong>Available!</strong> This room is available for your selected dates.
                                    </div>
                                    
                                    <?php if(auth()->guard()->check()): ?>
                                        <a href="<?php echo e(route('user.booking.form', ['hotel' => $room->hotel->id, 'room' => $room->id])); ?>?check_in=<?php echo e(request('check_in')); ?>&check_out=<?php echo e(request('check_out')); ?>&guests=<?php echo e(request('guests', 1)); ?>" class="btn btn-success w-100">
                                            <i class="fas fa-calendar-check me-2"></i>Book Now
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('login')); ?>" class="btn btn-success w-100">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login to Book
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-times-circle me-2"></i>
                                        <strong>Not Available</strong> This room is not available for your selected dates.
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-calculator me-2"></i>Price Breakdown</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Price per night:</span>
                            <span>$<?php echo e($room->price_per_night); ?></span>
                        </div>
                        <?php if(request('check_in') && request('check_out')): ?>
                            <?php
                                $checkIn = new DateTime(request('check_in'));
                                $checkOut = new DateTime(request('check_out'));
                                $nights = $checkIn->diff($checkOut)->days;
                                $totalPrice = $nights * $room->price_per_night;
                            ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Number of nights:</span>
                                <span><?php echo e($nights); ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span>$<?php echo e($totalPrice); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="info-card">
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Hotel Location</h5>
                        <p class="mb-2"><strong>Address:</strong></p>
                        <p class="text-muted"><?php echo e($room->hotel->address); ?><br>
                        <?php echo e($room->hotel->city); ?>, <?php echo e($room->hotel->state); ?> <?php echo e($room->hotel->country); ?></p>
                        
                        <div class="d-flex justify-content-between">
                            <span><strong>Phone:</strong></span>
                            <span><?php echo e($room->hotel->phone); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><strong>Email:</strong></span>
                            <span><?php echo e($room->hotel->email); ?></span>
                        </div>
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
</html> <?php /**PATH D:\Xampp\htdocs\hotel_management\resources\views/user/room-detail.blade.php ENDPATH**/ ?>