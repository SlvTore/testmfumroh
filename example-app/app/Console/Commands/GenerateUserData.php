<?php

namespace App\Console\Commands;

use Faker\Factory as Faker;
use Illuminate\Console\Command;

class GenerateUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:users {count=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate user data and save to CSV with Indonesian locale';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int)$this->argument('count');

        // Initialize Faker with Indonesian locale
        $faker = Faker::create('id_ID');

        // Create file path in storage/app/
        $filePath = storage_path('app/users_' . date('Y-m-d_H-i-s') . '.csv');

        // Open file for writing
        $file = fopen($filePath, 'w');

        // Write CSV header
        fputcsv($file, ['Nama', 'Email', 'Nomor Telepon']);

        // Generate and write data
        for ($i = 0; $i < $count; $i++) {
            $nama = $faker->name();
            $email = $faker->unique()->safeEmail();
            $nomorTelepon = $faker->phoneNumber();

            fputcsv($file, [$nama, $email, $nomorTelepon]);
        }

        // Close file
        fclose($file);

        // Display success message
        $this->info("✓ File generated successfully at: {$filePath}");
        $this->info("✓ Total records: {$count}");
    }
}
