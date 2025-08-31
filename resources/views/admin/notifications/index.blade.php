<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .notification-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .notification-card:hover {
            transform: translateY(-2px);
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 bg-dark text-white p-3 min-vh-100">
                <h4 class="mb-4">
                    <i class="fas fa-hotel me-2"></i>Admin Panel
                </h4>
                <nav class="nav flex-column">
                    <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.hotels') }}">
                        <i class="fas fa-building me-2"></i>Hotels
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.bookings') }}">
                        <i class="fas fa-calendar-check me-2"></i>Bookings
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.users') }}">
                        <i class="fas fa-users me-2"></i>Users
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.statistics') }}">
                        <i class="fas fa-chart-bar me-2"></i>Statistics
                    </a>
                    <a class="nav-link text-white active" href="{{ route('admin.notifications') }}">
                        <i class="fas fa-bell me-2"></i>Notifications
                    </a>
                    <hr class="my-3">
                    <a class="nav-link text-white" href="{{ route('user.hotels') }}">
                        <i class="fas fa-home me-2"></i>View Site
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white text-start w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>System Notifications</h2>
                    <div>
                        <span class="badge bg-primary me-2">Total: {{ $notificationStats['total'] }}</span>
                        <span class="badge bg-danger me-2">Unread: {{ $notificationStats['unread'] }}</span>
                        <span class="badge bg-success">Read: {{ $notificationStats['read'] }}</span>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Filter Buttons -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary w-100" onclick="filterNotifications('all')">
                                    <i class="fas fa-list me-2"></i>All ({{ $notifications->total() }})
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-danger w-100" onclick="filterNotifications('unread')">
                                    <i class="fas fa-envelope me-2"></i>Unread ({{ $notificationStats['unread'] }})
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-success w-100" onclick="filterNotifications('read')">
                                    <i class="fas fa-envelope-open me-2"></i>Read ({{ $notificationStats['read'] }})
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

                <!-- Notifications List -->
                @if($notifications->count() > 0)
                    <div class="row">
                        <div class="col-12">
                            @foreach($notifications as $notification)
                                <div class="card notification-card mb-3 {{ $notification->read ? 'opacity-75' : '' }}" 
                                     data-type="{{ $notification->type }}" data-status="{{ $notification->read ? 'read' : 'unread' }}">
                                    <div class="card-body">
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
                                                        <small class="text-muted">
                                                            <i class="fas fa-user me-1"></i>{{ $notification->user->name }}
                                                        </small>
                                                        @if(isset($notification->data['booking_id']))
                                                            <a href="{{ route('admin.bookings') }}?booking={{ $notification->data['booking_id'] }}" 
                                                               class="btn btn-sm btn-outline-primary ms-2">
                                                                <i class="fas fa-eye me-1"></i>View Booking
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        @if(!$notification->read)
                                                            <button class="btn btn-sm btn-outline-success" onclick="markAsRead({{ $notification->id }})">
                                                                <i class="fas fa-check me-1"></i>Mark Read
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
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
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <h4>No Notifications</h4>
                            <p class="text-muted">There are no notifications in the system yet.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

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

        function markAsRead(notificationId) {
            // In a real application, you would make an AJAX call here
            // For now, we'll just hide the notification
            const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notification) {
                notification.classList.add('opacity-75');
                notification.dataset.status = 'read';
            }
        }
    </script>
</body>
</html>
