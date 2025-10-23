<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();

            // Basic group info
            $table->string('name');
            $table->string('slug')->unique(); // for URLs or channel naming
            $table->string('avatar')->nullable(); // optional group image

            // Group type (e.g., private / public)
            $table->enum('type', ['public', 'private'])->default('private');

            // Admin / creator reference
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
