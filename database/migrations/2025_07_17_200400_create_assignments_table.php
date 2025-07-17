<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('file_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name'); // e.g. "Translate pages 1-5"
            $table->enum('role', ['translator', 'editor', 'proofreader', 'interpreter']);
            $table->enum('type', ['translation', 'interpretation', 'proofreading', 'editing', 'localization']);
            $table->string('language_pair'); // e.g. "EN→ES"
            $table->enum('status', ['not_started', 'in_progress', 'submitted', 'approved', 'rejected'])->default('not_started');
            $table->date('due_date')->nullable();
            $table->integer('word_count')->nullable();
            $table->decimal('rate_per_word', 8, 4)->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
