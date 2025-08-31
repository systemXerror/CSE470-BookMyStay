<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Special Offer</title>
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
                    <a class="nav-link text-white" href="{{ route('admin.rooms.index') }}">
                        <i class="fas fa-bed me-2"></i>Room Management
                    </a>
                    <a class="nav-link text-white active" href="{{ route('admin.special-offers.index') }}">
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
                    <h1 class="h3 mb-0 text-gray-800">Edit Special Offer</h1>
                    <a href="{{ route('admin.special-offers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left fa-sm"></i> Back to Offers
                    </a>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Offer Details</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.special-offers.update', $specialOffer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Offer Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" name="name" value="{{ old('name', $specialOffer->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="code">Discount Code <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                                           id="code" name="code" value="{{ old('code', $specialOffer->code) }}" required>
                                                    <button type="button" class="btn btn-outline-secondary" id="generateCode">
                                                        <i class="fas fa-magic"></i> Generate
                                                    </button>
                                                </div>
                                                @error('code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Unique code for customers to use</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="3" required>{{ old('description', $specialOffer->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="type">Discount Type <span class="text-danger">*</span></label>
                                                <select class="form-control @error('type') is-invalid @enderror" 
                                                        id="type" name="type" required>
                                                    <option value="">Select Type</option>
                                                    <option value="percentage" {{ old('type', $specialOffer->type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                                    <option value="fixed_amount" {{ old('type', $specialOffer->type) == 'fixed_amount' ? 'selected' : '' }}>Fixed Amount</option>
                                                </select>
                                                @error('type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="discount_value">Discount Value <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" min="0" 
                                                           class="form-control @error('discount_value') is-invalid @enderror" 
                                                           id="discount_value" name="discount_value" 
                                                           value="{{ old('discount_value', $specialOffer->discount_value) }}" required>
                                                    <span class="input-group-text" id="discount_suffix">{{ $specialOffer->type === 'percentage' ? '%' : '$' }}</span>
                                                </div>
                                                @error('discount_value')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="minimum_amount">Minimum Amount <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" step="0.01" min="0" 
                                                           class="form-control @error('minimum_amount') is-invalid @enderror" 
                                                           id="minimum_amount" name="minimum_amount" 
                                                           value="{{ old('minimum_amount', $specialOffer->minimum_amount) }}" required>
                                                </div>
                                                @error('minimum_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Minimum booking amount to apply discount</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                                       id="start_date" name="start_date" 
                                                       value="{{ old('start_date', $specialOffer->start_date->format('Y-m-d')) }}" required>
                                                @error('start_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="end_date">End Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                                       id="end_date" name="end_date" 
                                                       value="{{ old('end_date', $specialOffer->end_date->format('Y-m-d')) }}" required>
                                                @error('end_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="max_uses">Maximum Uses</label>
                                                <input type="number" min="0" class="form-control @error('max_uses') is-invalid @enderror" 
                                                       id="max_uses" name="max_uses" 
                                                       value="{{ old('max_uses', $specialOffer->max_uses) }}" placeholder="Leave empty for unlimited">
                                                @error('max_uses')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Leave empty for unlimited uses</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="applicable_hotels">Applicable Hotels</label>
                                                <select class="form-control @error('applicable_hotels') is-invalid @enderror" 
                                                        id="applicable_hotels" name="applicable_hotels[]" multiple>
                                                    @foreach($hotels as $hotel)
                                                        <option value="{{ $hotel->id }}" 
                                                            {{ in_array($hotel->id, old('applicable_hotels', $specialOffer->applicable_hotels ?? [])) ? 'selected' : '' }}>
                                                            {{ $hotel->name }} - {{ $hotel->city }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('applicable_hotels')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple hotels. Leave empty for all hotels.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="applicable_room_types">Applicable Room Types</label>
                                        <select class="form-control @error('applicable_room_types') is-invalid @enderror" 
                                                id="applicable_room_types" name="applicable_room_types[]" multiple>
                                            <option value="Standard" {{ in_array('Standard', old('applicable_room_types', $specialOffer->applicable_room_types ?? [])) ? 'selected' : '' }}>Standard</option>
                                            <option value="Deluxe" {{ in_array('Deluxe', old('applicable_room_types', $specialOffer->applicable_room_types ?? [])) ? 'selected' : '' }}>Deluxe</option>
                                            <option value="Suite" {{ in_array('Suite', old('applicable_room_types', $specialOffer->applicable_room_types ?? [])) ? 'selected' : '' }}>Suite</option>
                                            <option value="Executive" {{ in_array('Executive', old('applicable_room_types', $specialOffer->applicable_room_types ?? [])) ? 'selected' : '' }}>Executive</option>
                                            <option value="Presidential" {{ in_array('Presidential', old('applicable_room_types', $specialOffer->applicable_room_types ?? [])) ? 'selected' : '' }}>Presidential</option>
                                        </select>
                                        @error('applicable_room_types')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple room types. Leave empty for all room types.</small>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active" 
                                                   name="is_active" value="1" 
                                                   {{ old('is_active', $specialOffer->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Offer is active and available for use
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Offer
                                        </button>
                                        <a href="{{ route('admin.special-offers.index') }}" class="btn btn-secondary">
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
                                <h6 class="m-0 font-weight-bold text-primary">Offer Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>Created:</strong> {{ $specialOffer->created_at->format('M d, Y H:i') }}
                                </div>
                                <div class="mb-3">
                                    <strong>Last Updated:</strong> {{ $specialOffer->updated_at->format('M d, Y H:i') }}
                                </div>
                                <div class="mb-3">
                                    <strong>Status:</strong> 
                                    <span class="badge bg-{{ $specialOffer->is_active ? 'success' : 'danger' }}">
                                        {{ $specialOffer->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <strong>Used Count:</strong> {{ $specialOffer->used_count }}
                                    @if($specialOffer->max_uses)
                                        / {{ $specialOffer->max_uses }}
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <strong>Days Remaining:</strong> {{ $specialOffer->days_remaining }}
                                </div>
                                @if($specialOffer->max_uses)
                                <div class="mb-3">
                                    <strong>Usage Percentage:</strong> {{ number_format($specialOffer->usage_percentage, 1) }}%
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
                                        Use clear, memorable discount codes
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        Set reasonable minimum amounts
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        Limit usage to prevent abuse
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        Target specific hotels or room types
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
            // Update discount suffix based on type
            $('#type').change(function() {
                var type = $(this).val();
                if (type === 'percentage') {
                    $('#discount_suffix').text('%');
                    $('#discount_value').attr('max', '100');
                } else if (type === 'fixed_amount') {
                    $('#discount_suffix').text('$');
                    $('#discount_value').removeAttr('max');
                }
            });

            // Generate random discount code
            $('#generateCode').click(function() {
                var code = generateRandomCode();
                $('#code').val(code);
            });

            function generateRandomCode() {
                var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                var code = '';
                for (var i = 0; i < 8; i++) {
                    code += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return code;
            }

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

                // Check date validation
                var startDate = new Date($('#start_date').val());
                var endDate = new Date($('#end_date').val());
                
                if (endDate <= startDate) {
                    $('#end_date').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#end_date').removeClass('is-invalid');
                }

                return isValid;
            });
        });
    </script>
</body>
</html>
