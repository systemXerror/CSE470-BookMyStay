<div class="row g-0">
    <div class="col-md-4">
        <img src="{{ $booking->room->image }}" class="img-fluid hotel-image h-100 w-100" 
             alt="{{ $booking->room->room_type }}">
    </div>
    <div class="col-md-8">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h5 class="card-title mb-0">{{ $booking->room->hotel->name }}</h5>
                <span class="badge {{ $booking->status_badge_class }}">{{ ucfirst($booking->status) }}</span>
            </div>
            
            <p class="text-muted mb-2">
                <i class="fas fa-bed me-1"></i>{{ $booking->room->room_type }}
            </p>
            
            <div class="row mb-2">
                <div class="col-6">
                    <small class="text-muted">Check-in</small><br>
                    <strong>{{ $booking->check_in_date->format('M j, Y') }}</strong>
                </div>
                <div class="col-6">
                    <small class="text-muted">Check-out</small><br>
                    <strong>{{ $booking->check_out_date->format('M j, Y') }}</strong>
                </div>
            </div>
            
            <div class="row mb-2">
                <div class="col-6">
                    <small class="text-muted">Duration</small><br>
                    <strong>{{ $booking->nights }} {{ $booking->nights == 1 ? 'night' : 'nights' }}</strong>
                </div>
                <div class="col-6">
                    <small class="text-muted">Guests</small><br>
                    <strong>{{ $booking->guests }} {{ $booking->guests == 1 ? 'guest' : 'guests' }}</strong>
                </div>
            </div>

            <!-- Extra Services -->
            @if($booking->extra_services_list && count($booking->extra_services_list) > 0)
                <div class="mb-2">
                    <small class="text-muted">Services:</small><br>
                    @foreach($booking->extra_services_list as $service)
                        <span class="service-badge">{{ $service }}</span>
                    @endforeach
                </div>
            @endif

            <!-- Cancellation Info for Upcoming Bookings -->
            @if($booking->status == 'confirmed' && $booking->check_in_date->isFuture())
                <div class="cancellation-info">
                    <small>
                        <i class="fas fa-info-circle me-1"></i>
                        <strong>Cancellation Deadline:</strong> {{ $booking->cancellation_deadline->format('M j, Y g:i A') }}
                        @if($booking->canBeCancelled())
                            <br><span class="text-success">✓ Can be cancelled</span>
                        @else
                            <br><span class="text-danger">✗ Cannot be cancelled</span>
                        @endif
                    </small>
                </div>
            @endif
            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <span class="text-success fw-bold">${{ number_format($booking->total_amount, 2) }}</span>
                    <br><small class="text-muted">Total Amount</small>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" 
                            data-bs-toggle="dropdown">
                        Actions
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('user.booking.confirmation', $booking->id) }}">
                                <i class="fas fa-eye me-2"></i>View Details
                            </a>
                        </li>
                        @if($booking->status == 'confirmed' && $booking->canBeCancelled())
                            <li>
                                <a class="dropdown-item" href="#" 
                                   onclick="cancelBooking({{ $booking->id }}, true, '{{ number_format($booking->getCancellationRefundAmount(), 2) }}')">
                                    <i class="fas fa-times me-2"></i>Cancel Booking
                                </a>
                            </li>
                        @elseif($booking->status == 'confirmed' && !$booking->canBeCancelled())
                            <li>
                                <a class="dropdown-item" href="#" 
                                   onclick="cancelBooking({{ $booking->id }}, false, 0)">
                                    <i class="fas fa-times me-2"></i>Cancel Booking
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="dropdown-item" href="#" onclick="printBooking({{ $booking->id }})">
                                <i class="fas fa-print me-2"></i>Print Confirmation
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
