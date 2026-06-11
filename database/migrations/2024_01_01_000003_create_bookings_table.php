<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // e.g. EM-2024-0001
            $table->string('group_name');
            $table->enum('group_type', ['church', 'ngo', 'company', 'school', 'other']);
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->date('arrival_date');
            $table->date('departure_date');
            $table->integer('pax_count');
            $table->enum('accommodation_type', ['dormitory', 'outdoor_camp', 'both', 'none']);
            $table->decimal('total_quote', 10, 2)->default(0);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->text('special_requirements')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
