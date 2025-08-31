<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpecialOffer;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Support\Str;

class SpecialOfferController extends Controller
{
    public function index()
    {
        $specialOffers = SpecialOffer::orderBy('created_at', 'desc')->paginate(15);
        
        $stats = [
            'total' => SpecialOffer::count(),
            'active' => SpecialOffer::active()->count(),
            'expired' => SpecialOffer::where('end_date', '<', now())->count(),
            'total_uses' => SpecialOffer::sum('used_count'),
        ];
        
        return view('admin.special-offers.index', compact('specialOffers', 'stats'));
    }

    public function create()
    {
        $hotels = Hotel::all();
        $roomTypes = Room::distinct()->pluck('room_type')->filter();
        
        return view('admin.special-offers.create', compact('hotels', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:special_offers,code',
            'description' => 'required|string',
            'type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'minimum_amount' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'applicable_hotels' => 'nullable|array',
            'applicable_hotels.*' => 'exists:hotels,id',
            'applicable_room_types' => 'nullable|array',
            'applicable_room_types.*' => 'string',
        ]);

        // Validate discount value based on type
        if ($request->type === 'percentage' && $request->discount_value > 100) {
            return back()->withErrors(['discount_value' => 'Percentage discount cannot exceed 100%']);
        }

        $data = $request->all();
        $data['applicable_hotels'] = $request->applicable_hotels ?: null;
        $data['applicable_room_types'] = $request->applicable_room_types ?: null;

        SpecialOffer::create($data);

        return redirect()->route('admin.special-offers.index')
            ->with('success', 'Special offer created successfully!');
    }

    public function show(SpecialOffer $specialOffer)
    {
        $specialOffer->load(['bookings' => function ($query) {
            $query->orderBy('created_at', 'desc')->take(10);
        }]);

        return view('admin.special-offers.show', compact('specialOffer'));
    }

    public function edit(SpecialOffer $specialOffer)
    {
        $hotels = Hotel::all();
        $roomTypes = Room::distinct()->pluck('room_type')->filter();
        
        return view('admin.special-offers.edit', compact('specialOffer', 'hotels', 'roomTypes'));
    }

    public function update(Request $request, SpecialOffer $specialOffer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:special_offers,code,' . $specialOffer->id,
            'description' => 'required|string',
            'type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'minimum_amount' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'applicable_hotels' => 'nullable|array',
            'applicable_hotels.*' => 'exists:hotels,id',
            'applicable_room_types' => 'nullable|array',
            'applicable_room_types.*' => 'string',
        ]);

        // Validate discount value based on type
        if ($request->type === 'percentage' && $request->discount_value > 100) {
            return back()->withErrors(['discount_value' => 'Percentage discount cannot exceed 100%']);
        }

        // Validate max_uses is not less than current used_count
        if ($request->max_uses && $request->max_uses < $specialOffer->used_count) {
            return back()->withErrors(['max_uses' => 'Maximum uses cannot be less than current usage count']);
        }

        $data = $request->all();
        $data['applicable_hotels'] = $request->applicable_hotels ?: null;
        $data['applicable_room_types'] = $request->applicable_room_types ?: null;

        $specialOffer->update($data);

        return redirect()->route('admin.special-offers.index')
            ->with('success', 'Special offer updated successfully!');
    }

    public function destroy(SpecialOffer $specialOffer)
    {
        if ($specialOffer->used_count > 0) {
            return back()->with('error', 'Cannot delete special offer that has been used');
        }

        $specialOffer->delete();

        return redirect()->route('admin.special-offers.index')
            ->with('success', 'Special offer deleted successfully!');
    }

    public function toggleStatus(SpecialOffer $specialOffer)
    {
        $specialOffer->update(['is_active' => !$specialOffer->is_active]);

        $status = $specialOffer->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Special offer {$status} successfully!");
    }

    public function generateCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (SpecialOffer::where('code', $code)->exists());

        return response()->json(['code' => $code]);
    }
}
