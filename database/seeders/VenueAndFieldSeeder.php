<?php

namespace Database\Seeders;

use App\Models\Fields;
use App\Models\User;
use App\Models\Venues;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VenueAndFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::create([
            'name' => 'Owner GOR Sentosa',
            'email' => 'owner@sentosa.com',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'phone' => '087830614484'
        ]);

        $venue = Venues::create([
            'owner_id' => $owner->id,
            'name' => 'GOR Futsal & Badminton Sentosa',
            'address' => 'JL. Merdeka No. 123, Jakarta',
            'description' => 'Tempat olahraga terbaik dengan fasilitas lengkap dan kantin.',
        ]);

        // 3. Buat Lapangan
        Fields::create([
            'venue_id' => $venue->id,
            'name' => 'Lapangan Futsal Vinyl A',
            'type' => 'futsal',
            'price_per_hour' => 150000,
        ]);

        Fields::create([
            'venue_id' => $venue->id,
            'name' => 'Lapapngan Badminton Karpet 1',
            'type' => 'badminton',
            'price_per_hour' => 60000,
        ]);
    }
}
