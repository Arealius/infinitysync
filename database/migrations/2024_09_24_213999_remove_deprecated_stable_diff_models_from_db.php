<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $keysToDelete = [
            'stable-diffusion-xl-1024-v0-9',
            'stable-diffusion-xl-beta-v2-2-2',
            'stable-diffusion-512-v2-1',
        ];

        DB::table('entities')
            ->whereIn('key', $keysToDelete)
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
