<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SpecialOffer;
use App\Models\Room;
use App\Models\Hotel;

class TestDiscountCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:discount-code {code} {--amount=150} {--hotel=1} {--room-type=Standard}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test discount code validation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $code = $this->argument('code');
        $amount = $this->option('amount');
        $hotelId = $this->option('hotel');
        $roomType = $this->option('room-type');

        $this->info("Testing discount code: {$code}");
        $this->info("Amount: \${$amount}");
        $this->info("Hotel ID: {$hotelId}");
        $this->info("Room Type: {$roomType}");
        $this->info("");

        // Find the special offer
        $specialOffer = SpecialOffer::where('code', $code)->first();

        if (!$specialOffer) {
            $this->error("❌ Special offer with code '{$code}' not found!");
            $this->info("");
            $this->info("Available discount codes:");
            SpecialOffer::all()->each(function($offer) {
                $this->info("- {$offer->code}: {$offer->name}");
            });
            return Command::FAILURE;
        }

        $this->info("✅ Found special offer: {$specialOffer->name}");
        $this->info("Type: {$specialOffer->type}");
        $this->info("Discount Value: {$specialOffer->discount_value}");
        $this->info("Minimum Amount: \${$specialOffer->minimum_amount}");
        $this->info("Is Active: " . ($specialOffer->is_active ? 'Yes' : 'No'));
        $this->info("Start Date: {$specialOffer->start_date->format('Y-m-d')}");
        $this->info("End Date: {$specialOffer->end_date->format('Y-m-d')}");
        $this->info("Max Uses: " . ($specialOffer->max_uses ?? 'Unlimited'));
        $this->info("Used Count: {$specialOffer->used_count}");
        $this->info("Applicable Hotels: " . ($specialOffer->applicable_hotels ? json_encode($specialOffer->applicable_hotels) : 'All'));
        $this->info("Applicable Room Types: " . ($specialOffer->applicable_room_types ? json_encode($specialOffer->applicable_room_types) : 'All'));
        $this->info("");

        // Test validation
        $isValid = $specialOffer->isValid();
        $canBeApplied = $specialOffer->canBeApplied($amount, $hotelId, $roomType);
        $discountAmount = $specialOffer->calculateDiscount($amount);

        $this->info("Validation Results:");
        $this->info("Is Valid: " . ($isValid ? '✅ Yes' : '❌ No'));
        $this->info("Can Be Applied: " . ($canBeApplied ? '✅ Yes' : '❌ No'));
        $this->info("Discount Amount: \${$discountAmount}");
        $this->info("");

        if (!$isValid) {
            $this->error("❌ Special offer is not valid!");
            if (!$specialOffer->is_active) {
                $this->error("  - Offer is not active");
            }
            if ($specialOffer->start_date > now()) {
                $this->error("  - Start date has not been reached");
            }
            if ($specialOffer->end_date < now()) {
                $this->error("  - End date has passed");
            }
            if ($specialOffer->max_uses && $specialOffer->used_count >= $specialOffer->max_uses) {
                $this->error("  - Maximum uses reached");
            }
        }

        if (!$canBeApplied) {
            $this->error("❌ Special offer cannot be applied!");
            if ($amount < $specialOffer->minimum_amount) {
                $this->error("  - Amount (\${$amount}) is less than minimum (\${$specialOffer->minimum_amount})");
            }
            if ($specialOffer->applicable_hotels) {
                $applicableHotels = is_string($specialOffer->applicable_hotels) ? json_decode($specialOffer->applicable_hotels, true) : $specialOffer->applicable_hotels;
                if ($applicableHotels && !in_array((int)$hotelId, array_map('intval', $applicableHotels))) {
                    $this->error("  - Hotel ID ({$hotelId}) is not in applicable hotels: " . json_encode($applicableHotels));
                }
            }
            if ($specialOffer->applicable_room_types) {
                $applicableRoomTypes = is_string($specialOffer->applicable_room_types) ? json_decode($specialOffer->applicable_room_types, true) : $specialOffer->applicable_room_types;
                if ($applicableRoomTypes && !in_array($roomType, $applicableRoomTypes)) {
                    $this->error("  - Room type ({$roomType}) is not in applicable room types: " . json_encode($applicableRoomTypes));
                }
            }
        }

        if ($isValid && $canBeApplied) {
            $this->info("✅ Discount code is valid and can be applied!");
            $this->info("Final amount after discount: \${" . ($amount - $discountAmount) . "}");
        }

        return Command::SUCCESS;
    }
}
