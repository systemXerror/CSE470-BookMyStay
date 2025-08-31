<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->json('extra_services')->nullable()->after('special_requests');
            $table->decimal('extra_services_amount', 10, 2)->default(0)->after('extra_services');
            $table->decimal('base_amount', 10, 2)->after('extra_services_amount');
            $table->boolean('breakfast_included')->default(false)->after('base_amount');
            $table->boolean('parking_included')->default(false)->after('breakfast_included');
            $table->boolean('wifi_included')->default(false)->after('parking_included');
            $table->date('cancellation_deadline')->nullable()->after('wifi_included');
            $table->decimal('cancellation_fee', 10, 2)->default(0)->after('cancellation_deadline');
            $table->text('cancellation_reason')->nullable()->after('cancellation_fee');
            $table->timestamp('cancelled_at')->nullable()->after('cancellation_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'extra_services',
                'extra_services_amount',
                'base_amount',
                'breakfast_included',
                'parking_included',
                'wifi_included',
                'cancellation_deadline',
                'cancellation_fee',
                'cancellation_reason',
                'cancelled_at'
            ]);
        });
    }
};
