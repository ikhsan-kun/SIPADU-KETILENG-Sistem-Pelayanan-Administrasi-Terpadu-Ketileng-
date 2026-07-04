<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('message');
            $table->string('icon')->default('bell'); // 'bell', 'check', 'document', 'x'
            $table->string('color')->default('blue'); // 'blue', 'green', 'red', 'yellow'
            $table->string('url')->nullable(); // Opsional: link saat notif diklik
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
