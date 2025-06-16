<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Locale;
use App\Models\Tag;
use App\Models\Translation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate tables to avoid unique constraint issues
        \DB::table('users')->truncate();
        \DB::table('locales')->truncate();
        \DB::table('tags')->truncate();
        \DB::table('translations')->truncate();

        // Remove existing admin user if present
        User::where('email', 'admin@example.com')->delete();

        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create 10 locales
        $locales = Locale::factory()->count(10)->create();

        // Create 20 tags
        $tags = Tag::factory()->count(20)->create();

        // Create 100k+ translations
        // We'll create them in chunks to avoid memory issues
        $chunkSize = 1000;
        $totalTranslations = 100000;

        for ($i = 0; $i < $totalTranslations; $i += $chunkSize) {
            $currentChunkSize = min($chunkSize, $totalTranslations - $i);
            
            Translation::factory()
                ->count($currentChunkSize)
                ->create([
                    'locale_id' => fn() => $locales->random()->id,
                ]);
        }
    }
}
