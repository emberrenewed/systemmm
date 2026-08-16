<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->nullable()->default(null)->change();
            $table->enum('priority', ['low', 'medium', 'high'])->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open')->change();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->change();
        });
    }
};
