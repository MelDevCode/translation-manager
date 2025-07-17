<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('glossary_id')->constrained()->onDelete('cascade');
            $table->string('source_term');
            $table->string('target_term');
            $table->enum('type', ['word', 'phrase', 'acronym', 'abbreviation', 'idiom', 'collocation'])->nullable();
            $table->enum ('part_of_speech', ['noun', 'verb', 'adjective', 'adverb', 'pronoun', 'preposition', 'conjunction', 'interjection'])->nullable();
            $table->enum('domain', ['general', 'technical', 'legal', 'medical', 'financial', 'IT', 'marketing', 'scientific', 'education', 'engineering'])->nullable();
            $table->text('context')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
