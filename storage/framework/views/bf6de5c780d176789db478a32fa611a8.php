<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?php echo e($room->room_type); ?> - <?php echo e($room->hotel->name); ?> - BookMyStay</title>
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
        .booking-form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .room-image {
            height: 300px;
            object-fit: cover;
        }
        .price-display {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
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
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 8px;
            background: #f8f9fa;
        }
        .amenity-icon {
            width: 30px;
            color: #667eea;
            margin-right: 10px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .alert {
            border-radius: 10px;
            border: none;
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
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.room.detail', ['hotel' => $room->hotel->id, 'room' => $room->id])); ?>" class="text-white"><?php echo e($room->room_type); ?></a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Book Now</li>
                        </ol>
                    </nav>
                    <h1 class="display-5 mb-3">Book Your Stay</h1>
                    <p class="lead mb-3">
                        <i class="fas fa-hotel me-2"></i><?php echo e($room->hotel->name); ?> - <?php echo e($room->room_type); ?>

                    </p>
                    <div class="d-flex align-items-center mb-3">
                        <span class="price-display me-3">$<?php echo e($room->price_per_night); ?>/night</span>
                        <?php if($isAvailable): ?>
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check me-2"></i>Available
                            </span>
                        <?php else: ?>
                            <span class="badge bg-danger fs-6">
                                <i class="fas fa-times me-2"></i>Not Available
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="<?php echo e($room->image); ?>" class="img-fluid room-image rounded" alt="<?php echo e($room->room_type); ?>">
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Form -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Booking Form -->
                <div class="col-lg-8">
                    <div class="booking-form-card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Complete Your Booking</h3>
                        </div>
                        <div class="card-body p-4">
                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if(!$isAvailable): ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Room Not Available</strong> This room is not available for the selected dates. Please choose different dates.
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="<?php echo e(route('user.booking.store', ['hotel' => $room->hotel->id, 'room' => $room->id])); ?>">
                                <?php echo csrf_field(); ?>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="check_in_date" class="form-label">Check-in Date</label>
                                        <input type="date" class="form-control <?php $__errorArgs = ['check_in_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="check_in_date" name="check_in_date" 
                                               value="<?php echo e($checkIn ?? ''); ?>" 
                                               min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" required>
                                        <?php $__errorArgs = ['check_in_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="check_out_date" class="form-label">Check-out Date</label>
                                        <input type="date" class="form-control <?php $__errorArgs = ['check_out_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="check_out_date" name="check_out_date" 
                                               value="<?php echo e($checkOut ?? ''); ?>" 
                                               min="<?php echo e(date('Y-m-d', strtotime('+2 days'))); ?>" required>
                                        <?php $__errorArgs = ['check_out_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="guests" class="form-label">Number of Guests</label>
                                        <select class="form-select <?php $__errorArgs = ['guests'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="guests" name="guests" required>
                                            <?php for($i = 1; $i <= $room->capacity; $i++): ?>
                                                <option value="<?php echo e($i); ?>" <?php echo e($guests == $i ? 'selected' : ''); ?>>
                                                    <?php echo e($i); ?> <?php echo e($i == 1 ? 'Guest' : 'Guests'); ?>

                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                        <?php $__errorArgs = ['guests'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Room Type</label>
                                        <input type="text" class="form-control" value="<?php echo e($room->room_type); ?>" readonly>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="special_requests" class="form-label">Special Requests (Optional)</label>
                                    <textarea class="form-control <?php $__errorArgs = ['special_requests'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="special_requests" name="special_requests" rows="3" 
                                              placeholder="Any special requests or preferences..."><?php echo e(old('special_requests')); ?></textarea>
                                    <?php $__errorArgs = ['special_requests'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <?php if($nights > 0): ?>
                                    <div class="alert alert-info">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Duration:</strong> <?php echo e($nights); ?> <?php echo e($nights == 1 ? 'night' : 'nights'); ?>

                                            </div>
                                            <div class="col-md-6">
                                                <strong>Total Amount:</strong> $<?php echo e(number_format($totalPrice, 2)); ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg" <?php echo e(!$isAvailable ? 'disabled' : ''); ?>>
                                        <i class="fas fa-credit-card me-2"></i>Confirm Booking
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Room Details Sidebar -->
                <div class="col-lg-4">
                    <div class="info-card">
                        <h4 class="mb-3"><i class="fas fa-info-circle me-2"></i>Room Details</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Room Type:</strong> <?php echo e($room->room_type); ?></li>
                            <li class="mb-2"><strong>Capacity:</strong> Up to <?php echo e($room->capacity); ?> guests</li>
                            <?php if($room->size_sqm): ?>
                                <li class="mb-2"><strong>Size:</strong> <?php echo e($room->size_sqm); ?> sqm</li>
                            <?php endif; ?>
                            <li class="mb-2"><strong>Price:</strong> $<?php echo e($room->price_per_night); ?> per night</li>
                            <li class="mb-2"><strong>Hotel:</strong> <?php echo e($room->hotel->name); ?></li>
                            <li class="mb-2"><strong>Location:</strong> <?php echo e($room->hotel->city); ?>, <?php echo e($room->hotel->state); ?></li>
                        </ul>
                    </div>

                    <?php if($room->amenities->count() > 0): ?>
                        <div class="info-card">
                            <h5 class="mb-3"><i class="fas fa-concierge-bell me-2"></i>Room Amenities</h5>
                            <?php $__currentLoopData = $room->amenities->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="amenity-item">
                                    <i class="<?php echo e($amenity->icon); ?> amenity-icon"></i>
                                    <span><?php echo e($amenity->name); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($room->amenities->count() > 6): ?>
                                <small class="text-muted">+<?php echo e($room->amenities->count() - 6); ?> more amenities</small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-calculate total when dates change
        document.getElementById('check_in_date').addEventListener('change', calculateTotal);
        document.getElementById('check_out_date').addEventListener('change', calculateTotal);

        function calculateTotal() {
            const checkIn = document.getElementById('check_in_date').value;
            const checkOut = document.getElementById('check_out_date').value;
            const pricePerNight = <?php echo e($room->price_per_night); ?>;

            if (checkIn && checkOut) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
                const totalPrice = nights * pricePerNight;

                // Update the total display
                const totalElement = document.querySelector('.alert-info');
                if (totalElement) {
                    totalElement.innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Duration:</strong> ${nights} ${nights == 1 ? 'night' : 'nights'}
                            </div>
                            <div class="col-md-6">
                                <strong>Total Amount:</strong> $${totalPrice.toFixed(2)}
                            </div>
                        </div>
                    `;
                }
            }
        }
    </script>
</body>
</html> <?php /**PATH D:\Xampp\htdocs\hotel_management\resources\views/user/booking-form.blade.php ENDPATH**/ ?>