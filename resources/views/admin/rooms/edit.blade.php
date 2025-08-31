<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .form-group {
            margin-bottom: 1rem;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
                    <a class="nav-link text-white" href="{{ route('admin.notifications') }}">
                        <i class="fas fa-bell me-2"></i>Notifications
                    </a>
                    <a class="nav-link text-white active" href="{{ route('admin.rooms.index') }}">
                        <i class="fas fa-bed me-2"></i>Room Management
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.special-offers.index') }}">
                        <i class="fas fa-tags me-2"></i>Special Offers
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.reviews.index') }}">
                        <i class="fas fa-star me-2"></i>Reviews
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
                <!-- Page Header -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Edit Room</h1>
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left fa-sm"></i> Back to Rooms
                    </a>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Room Details</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hotel_id">Hotel <span class="text-danger">*</span></label>
                                                <select class="form-control @error('hotel_id') is-invalid @enderror" 
                                                        id="hotel_id" name="hotel_id" required>
                                                    <option value="">Select Hotel</option>
                                                    @foreach($hotels as $hotel)
                                                        <option value="{{ $hotel->id }}" {{ old('hotel_id', $room->hotel_id) == $hotel->id ? 'selected' : '' }}>
                                                            {{ $hotel->name }} - {{ $hotel->city }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('hotel_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="room_number">Room Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('room_number') is-invalid @enderror" 
                                                       id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}" required>
                                                @error('room_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="room_type">Room Type <span class="text-danger">*</span></label>
                                                <select class="form-control @error('room_type') is-invalid @enderror" 
                                                        id="room_type" name="room_type" required>
                                                    <option value="">Select Type</option>
                                                    <option value="Standard" {{ old('room_type', $room->room_type) == 'Standard' ? 'selected' : '' }}>Standard</option>
                                                    <option value="Deluxe" {{ old('room_type', $room->room_type) == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                                                    <option value="Suite" {{ old('room_type', $room->room_type) == 'Suite' ? 'selected' : '' }}>Suite</option>
                                                    <option value="Executive" {{ old('room_type', $room->room_type) == 'Executive' ? 'selected' : '' }}>Executive</option>
                                                    <option value="Presidential" {{ old('room_type', $room->room_type) == 'Presidential' ? 'selected' : '' }}>Presidential</option>
                                                </select>
                                                @error('room_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="capacity">Capacity <span class="text-danger">*</span></label>
                                                <input type="number" min="1" max="10" class="form-control @error('capacity') is-invalid @enderror" 
                                                       id="capacity" name="capacity" value="{{ old('capacity', $room->capacity) }}" required>
                                                @error('capacity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="3" required>{{ old('description', $room->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="price_per_night">Price per Night <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" step="0.01" min="0" 
                                                           class="form-control @error('price_per_night') is-invalid @enderror" 
                                                           id="price_per_night" name="price_per_night" 
                                                           value="{{ old('price_per_night', $room->price_per_night) }}" required>
                                                </div>
                                                @error('price_per_night')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="size_sqm">Size (sq m)</label>
                                                <input type="number" min="0" class="form-control @error('size_sqm') is-invalid @enderror" 
                                                       id="size_sqm" name="size_sqm" value="{{ old('size_sqm', $room->size_sqm) }}">
                                                @error('size_sqm')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control @error('status') is-invalid @enderror" 
                                                        id="status" name="status">
                                                    <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                                                    <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                                    <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Image URL</label>
                                        <input type="url" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" value="{{ old('image', $room->image) }}" 
                                               placeholder="https://example.com/image.jpg">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Amenities</label>
                                        <div class="row">
                                            @foreach($amenities as $amenity)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" 
                                                               name="amenities[]" value="{{ $amenity->id }}" 
                                                               id="amenity_{{ $amenity->id }}"
                                                               {{ in_array($amenity->id, old('amenities', $room->amenities->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="amenity_{{ $amenity->id }}">
                                                            <i class="{{ $amenity->icon }} me-1"></i>
                                                            {{ $amenity->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_available" 
                                                   name="is_available" value="1" 
                                                   {{ old('is_available', $room->is_available) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_available">
                                                Room is available for booking
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Room
                                        </button>
                                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Room Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>Created:</strong> {{ $room->created_at->format('M d, Y H:i') }}
                                </div>
                                <div class="mb-3">
                                    <strong>Last Updated:</strong> {{ $room->updated_at->format('M d, Y H:i') }}
                                </div>
                                <div class="mb-3">
                                    <strong>Current Status:</strong> 
                                    <span class="badge bg-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </div>
                                @if($room->bookings_count > 0)
                                <div class="mb-3">
                                    <strong>Total Bookings:</strong> {{ $room->bookings_count }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Quick Tips</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        Room numbers should be unique within each hotel
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        Set appropriate capacity based on room type
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        Include detailed descriptions for better user experience
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        Add relevant amenities to attract guests
                                    </li>
                                </ul>
                            </div>
                        </div>
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
            // Form validation
            $('form').submit(function() {
                var isValid = true;
                
                // Check required fields
                $('input[required], select[required], textarea[required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                return isValid;
            });
        });
    </script>
</body>
</html>
