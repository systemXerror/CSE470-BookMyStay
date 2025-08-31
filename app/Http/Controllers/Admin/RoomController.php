<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Amenity;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('hotel')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $stats = [
            'total' => Room::count(),
            'available' => Room::where('is_available', true)->count(),
            'occupied' => Room::where('is_available', false)->count(),
            'hotels_with_rooms' => Hotel::has('rooms')->count(),
        ];
        
        return view('admin.rooms.index', compact('rooms', 'stats'));
    }

    public function create()
    {
        $hotels = Hotel::all();
        $amenities = Amenity::all();
        
        return view('admin.rooms.create', compact('hotels', 'amenities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_number' => 'required|string|max:50',
            'room_type' => 'required|string|max:100',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'size' => 'nullable|numeric|min:0',
            'floor' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'image' => 'nullable|url',
        ]);

        $room = Room::create($request->except('amenities'));
        
        if ($request->amenities) {
            $room->amenities()->attach($request->amenities);
        }

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room created successfully!');
    }

    public function show(Room $room)
    {
        $room->load(['hotel', 'amenities', 'bookings' => function ($query) {
            $query->orderBy('created_at', 'desc')->take(10);
        }]);
        
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $hotels = Hotel::all();
        $amenities = Amenity::all();
        
        return view('admin.rooms.edit', compact('room', 'hotels', 'amenities'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_number' => 'required|string|max:50',
            'room_type' => 'required|string|max:100',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'size' => 'nullable|numeric|min:0',
            'floor' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'image' => 'nullable|url',
        ]);

        $room->update($request->except('amenities'));
        
        if ($request->amenities) {
            $room->amenities()->sync($request->amenities);
        } else {
            $room->amenities()->detach();
        }

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room)
    {
        // Check if room has any bookings
        if ($room->bookings()->exists()) {
            return back()->with('error', 'Cannot delete room that has bookings');
        }

        $room->amenities()->detach();
        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully!');
    }

    public function toggleAvailability(Room $room)
    {
        $room->update(['is_available' => !$room->is_available]);

        $status = $room->is_available ? 'available' : 'unavailable';
        return back()->with('success', "Room marked as {$status} successfully!");
    }

    public function hotelRooms($hotelId)
    {
        $hotel = Hotel::with('rooms.amenities')->findOrFail($hotelId);
        $rooms = $hotel->rooms()->paginate(15);
        
        return view('admin.rooms.hotel-rooms', compact('hotel', 'rooms'));
    }
}
