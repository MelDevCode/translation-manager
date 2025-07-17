<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('set null');
            $table->enum('type', [
                'Word', 'PDF', 'PPT', 'Excel', 'Text', 'InDesign',
                'HTML', 'JSON', 'XML', 'YAML', 'PO/MO', 'Strings', 'XLIFF',
                'Audio', 'Video', 'Subtitles',
                'Photoshop', 'Illustrator', 'Image', 'Scanned PDF',
                'CAT Package', 'MemoQ Package',
                'Other',
            ]);
            $table->string('language')->nullable();
            $table->string('file_path');
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
