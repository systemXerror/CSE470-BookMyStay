<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - BookMyStay</title>
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
        .notification-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.3s ease;
            border-left: 4px solid #667eea;
        }
        .notification-card:hover {
            transform: translateY(-2px);
        }
        .notification-card.unread {
            border-left-color: #dc3545;
            background-color: #fff5f5;
        }
        .notification-card.read {
            opacity: 0.8;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .notification-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 15px;
        }
        .notification-icon.booking-confirmation {
            background-color: #d4edda;
            color: #155724;
        }
        .notification-icon.booking-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .notification-icon.booking-status-changed {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        .filter-buttons {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.my-bookings') }}">My Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.notifications') }}">
                            Notifications
                            @if(auth()->user()->unread_notifications_count > 0)
                                <span class="badge bg-danger">{{ auth()->user()->unread_notifications_count }}</span>
                            @endif
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 mb-3">Notifications</h1>
                    <p class="lead mb-0">Stay updated with your booking status and important updates</p>
                </div>
                <div class="col-lg-4 text-end">
                    @if(auth()->user()->unread_notifications_count > 0)
                        <form method="POST" action="{{ route('user.notifications.read-all') }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-light">
                                <i class="fas fa-check-double me-2"></i>Mark All Read
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Buttons -->
    <section class="py-3">
        <div class="container">
            <div class="filter-buttons">
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary w-100" onclick="filterNotifications('all')">
                            <i class="fas fa-list me-2"></i>All ({{ $notifications->total() }})
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-danger w-100" onclick="filterNotifications('unread')">
                            <i class="fas fa-envelope me-2"></i>Unread ({{ auth()->user()->unread_notifications_count }})
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-success w-100" onclick="filterNotifications('read')">
                            <i class="fas fa-envelope-open me-2"></i>Read ({{ $notifications->total() - auth()->user()->unread_notifications_count }})
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-info w-100" onclick="filterNotifications('booking')">
                            <i class="fas fa-calendar-check me-2"></i>Bookings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Notifications List -->
    <section class="py-4">
        <div class="container">
            @if($notifications->count() > 0)
                <div class="row">
                    <div class="col-12">
                        @foreach($notifications as $notification)
                            <div class="notification-card p-3 {{ $notification->read ? 'read' : 'unread' }}" 
                                 data-type="{{ $notification->type }}" data-status="{{ $notification->read ? 'read' : 'unread' }}">
                                <div class="d-flex align-items-start">
                                    <div class="notification-icon {{ $notification->type }}">
                                        @switch($notification->type)
                                            @case('booking_confirmation')
                                                <i class="fas fa-check"></i>
                                                @break
                                            @case('booking_cancelled')
                                                <i class="fas fa-times"></i>
                                                @break
                                            @case('booking_status_changed')
                                                <i class="fas fa-sync-alt"></i>
                                                @break
                                            @default
                                                <i class="fas fa-bell"></i>
                                        @endswitch
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6 class="mb-1">{{ $notification->title }}</h6>
                                            <div class="d-flex align-items-center">
                                                @if(!$notification->read)
                                                    <span class="badge bg-danger me-2">New</span>
                                                @endif
                                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <p class="mb-2 text-muted">{{ $notification->message }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @if(isset($notification->data['booking_id']))
                                                    <a href="{{ route('user.booking.confirmation', $notification->data['booking_id']) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i>View Booking
                                                    </a>
                                                @endif
                                            </div>
                                            @if(!$notification->read)
                                                <form method="POST" action="{{ route('user.notifications.read', $notification->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-check me-1"></i>Mark Read
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Pagination -->
                @if($notifications->hasPages())
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="Notifications pagination">
                                {{ $notifications->links() }}
                            </nav>
                        </div>
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-bell-slash"></i>
                    </div>
                    <h3>No Notifications</h3>
                    <p class="text-muted mb-4">You don't have any notifications yet. We'll notify you about important updates!</p>
                    <a href="{{ route('user.hotels') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Browse Hotels
                    </a>
                </div>
            @endif
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterNotifications(filter) {
            const notifications = document.querySelectorAll('.notification-card');
            
            notifications.forEach(notification => {
                const type = notification.dataset.type;
                const status = notification.dataset.status;
                
                let show = false;
                
                switch(filter) {
                    case 'all':
                        show = true;
                        break;
                    case 'unread':
                        show = status === 'unread';
                        break;
                    case 'read':
                        show = status === 'read';
                        break;
                    case 'booking':
                        show = type.includes('booking');
                        break;
                }
                
                notification.style.display = show ? 'block' : 'none';
            });
        }

        // Show success message if exists
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.createElement('div');
                toast.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                toast.innerHTML = `
                    <div class="toast" role="alert">
                        <div class="toast-header bg-success text-white">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong class="me-auto">Success!</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                new bootstrap.Toast(toast.querySelector('.toast')).show();
            });
        @endif
    </script>
</body>
</html>
