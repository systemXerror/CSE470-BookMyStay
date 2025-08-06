<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookMyStay - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            font-size: 2.5rem;
            color: #667eea;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('user.hotels')); ?>">
                <i class="fas fa-hotel me-2"></i>BookMyStay
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('user.hotels')); ?>">
                            <i class="fas fa-search me-1"></i>Find Hotels
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('user.my-bookings')); ?>">
                            <i class="fas fa-calendar-check me-1"></i>My Bookings
                        </a>
                    </li>
                    <?php if(Auth::user()->isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">
                                <i class="fas fa-cog me-1"></i>Admin Panel
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i><?php echo e(Auth::user()->name); ?>

                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-link dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Dashboard</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar-check card-icon mb-3"></i>
                        <h5 class="card-title">Total Bookings</h5>
                        <p class="card-text display-6"><?php echo e($totalBookings); ?></p>
                        <a href="<?php echo e(route('user.my-bookings')); ?>" class="btn btn-primary">View All</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-clock card-icon mb-3"></i>
                        <h5 class="card-title">Active Bookings</h5>
                        <p class="card-text display-6"><?php echo e($activeBookings); ?></p>
                        <a href="<?php echo e(route('user.my-bookings')); ?>" class="btn btn-success">View Active</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-check-circle card-icon mb-3"></i>
                        <h5 class="card-title">Completed</h5>
                        <p class="card-text display-6"><?php echo e($completedBookings); ?></p>
                        <a href="<?php echo e(route('user.my-bookings')); ?>" class="btn btn-info">View History</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-dollar-sign card-icon mb-3"></i>
                        <h5 class="card-title">Total Spent</h5>
                        <p class="card-text display-6">$<?php echo e(number_format($totalSpent, 2)); ?></p>
                        <a href="<?php echo e(route('user.my-bookings')); ?>" class="btn btn-warning">View Details</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo e(route('user.hotels')); ?>" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-search me-2"></i>Find Hotels
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo e(route('user.my-bookings')); ?>" class="btn btn-outline-success w-100">
                                    <i class="fas fa-calendar-check me-2"></i>My Bookings
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo e(route('user.hotels')); ?>" class="btn btn-outline-info w-100">
                                    <i class="fas fa-star me-2"></i>Browse Hotels
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo e(route('user.my-bookings')); ?>" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-history me-2"></i>Booking History
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Section -->
        <?php if($recentBookings->count() > 0): ?>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Bookings</h5>
                        <a href="<?php echo e(route('user.my-bookings')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Hotel</th>
                                        <th>Room</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($booking->room->hotel->name); ?></td>
                                        <td><?php echo e($booking->room->room_number); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y')); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y')); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'secondary')); ?>">
                                                <?php echo e(ucfirst($booking->status)); ?>

                                            </span>
                                        </td>
                                        <td>$<?php echo e(number_format($booking->total_amount, 2)); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Upcoming Bookings Section -->
        <?php if($upcomingBookings->count() > 0): ?>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Upcoming Bookings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php $__currentLoopData = $upcomingBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-3">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo e($booking->room->hotel->name); ?></h6>
                                        <p class="card-text">
                                            <small class="text-muted">Room <?php echo e($booking->room->room_number); ?></small><br>
                                            <strong>Check-in:</strong> <?php echo e(\Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y')); ?><br>
                                            <strong>Check-out:</strong> <?php echo e(\Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y')); ?><br>
                                            <strong>Amount:</strong> $<?php echo e(number_format($booking->total_amount, 2)); ?>

                                        </p>
                                        <span class="badge bg-<?php echo e($booking->status === 'confirmed' ? 'success' : 'warning'); ?>">
                                            <?php echo e(ucfirst($booking->status)); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Favorite Hotels Section -->
        <?php if($favoriteHotels->count() > 0): ?>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Your Favorite Hotels</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php $__currentLoopData = $favoriteHotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="<?php echo e($hotel->image); ?>" class="card-img-top" alt="<?php echo e($hotel->name); ?>" style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo e($hotel->name); ?></h6>
                                        <p class="card-text">
                                            <small class="text-muted"><?php echo e($hotel->city); ?>, <?php echo e($hotel->state); ?></small><br>
                                            <span class="text-warning">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star<?php echo e($i <= $hotel->star_rating ? '' : '-o'); ?>"></i>
                                                <?php endfor; ?>
                                            </span>
                                            <span class="ms-2"><?php echo e($hotel->rating); ?>/5</span>
                                        </p>
                                        <a href="<?php echo e(route('user.hotel.detail', $hotel->id)); ?>" class="btn btn-sm btn-outline-primary">View Hotel</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> <?php /**PATH D:\Xampp\htdocs\hotel_management\resources\views/dashboard.blade.php ENDPATH**/ ?>