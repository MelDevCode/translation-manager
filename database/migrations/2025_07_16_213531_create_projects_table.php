<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('set null');
            $table->string('name');
            $table->string('source_language');
            $table->string('target_language');
            $table->enum('status', ['not_started', 'in_progress', 'delivered', 'cancelled'])->default('not_started');
            $table->timestamp('deadline')->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
