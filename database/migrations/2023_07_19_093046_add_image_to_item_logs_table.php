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
        Schema::table('item_logs', function (Blueprint $table) {
            $table->double('qty')->after('type');
            $table->string('image')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_logs', function (Blueprint $table) {
            $table->dropColumn(['qty', 'image']);
        });
    }
};
