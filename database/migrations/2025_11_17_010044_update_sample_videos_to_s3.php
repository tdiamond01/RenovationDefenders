<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update sample videos to use S3 storage
        \DB::table('VIDEOS')
            ->whereIn('ID', [1, 2, 3, 4])
            ->update([
                'STORAGE_DRIVER' => 's3',
                'FILE_PATH' => \DB::raw("REPLACE(FILE_PATH, 'sample-videos/', 'videos/')"),
                'UPDATED_AT' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert sample videos back to local storage
        \DB::table('VIDEOS')
            ->whereIn('ID', [1, 2, 3, 4])
            ->update([
                'STORAGE_DRIVER' => 'local',
                'FILE_PATH' => \DB::raw("REPLACE(FILE_PATH, 'videos/', 'sample-videos/')"),
                'UPDATED_AT' => now(),
            ]);
    }
};
