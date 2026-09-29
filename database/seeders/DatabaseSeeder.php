<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
    {
        // 1. Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@visitmate.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // 2. Categories Map (Unique Categories create karaganima)
        $nature = Category::create(['name' => 'Nature & Waterfalls']);
        $heritage = Category::create(['name' => 'Religious & Heritage']);
        $wildlife = Category::create(['name' => 'Wildlife & Conservation']);
        $beach = Category::create(['name' => 'Beaches & Coastal']);
        $cultural = Category::create(['name' => 'Cultural & Experience']);

        // 3. Real 25km Local Places Data Insertion
        $places = [
            [
                'category_id' => $nature->id,
                'name' => 'Thotas Ella',
                'description' => 'Thotas Ella is a beautiful waterfall in Walallawita surrounded by a peaceful natural environment. Visitors can enjoy the flowing water, natural scenery, and relaxing surroundings.',
                'distance_km' => 4.30,
                'image' => 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9',
                'latitude' => '6.4500',
                'longitude' => '80.1333',
                'facilities' => 'Natural Bathing, Photo Spots, Parking nearby',
                'safety_info' => 'Be cautious on slippery rocks near the waterfall during rain.',
            ],
            [
                'category_id' => $nature->id,
                'name' => 'Yagirala Rainforest',
                'description' => 'Yagirala Rainforest is a beautiful tropical rainforest with rich biodiversity and green surroundings. Visitors can experience the peaceful forest environment and enjoy its natural beauty.',
                'distance_km' => 6.00,
                'image' => 'https://images.unsplash.com/photo-1511497584788-876761c11969',
                'latitude' => '6.3683',
                'longitude' => '80.1800',
                'facilities' => 'Nature Trails, Guided Walks, Bird Watching',
                'safety_info' => 'Wear suitable footwear for trekking and leech protection.',
            ],
            [
                'category_id' => $heritage->id,
                'name' => 'Ganegoda Raja Maha Viharaya',
                'description' => 'Ganegoda Raja Maha Viharaya is a historic Buddhist temple in the Elpitiya area with religious and heritage value. Its history dates back to the Anuradhapura Kingdom period.',
                'distance_km' => 5.80,
                'image' => 'https://images.unsplash.com/photo-1566127444979-b3d2b654e3d7',
                'latitude' => '6.3000',
                'longitude' => '80.1500',
                'facilities' => 'Parking, Restrooms, Historical Information',
                'safety_info' => 'Please wear appropriate attire covering shoulders and knees.',
            ],
            [
                'category_id' => $heritage->id,
                'name' => 'Kaludiya Pokuna',
                'description' => 'Kaludiya Pokuna is an ancient Buddhist archaeological site in Pitigala surrounded by a peaceful jungle environment with monastery ruins, stone structures, and rock inscriptions.',
                'distance_km' => 9.40,
                'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5',
                'latitude' => '6.3333',
                'longitude' => '80.2167',
                'facilities' => 'Archaeological Trail, Peaceful Meditation Area',
                'safety_info' => 'Do not disturb or climb on ancient stone ruins.',
            ],
            [
                'category_id' => $heritage->id,
                'name' => 'Mahamevnawa Buddhist Monastery',
                'description' => 'Mahamevnawa Buddhist Monastery is a peaceful Buddhist religious place where visitors can learn and practice Dhamma teachings and experience a calm spiritual environment.',
                'distance_km' => 8.40,
                'image' => 'https://images.unsplash.com/photo-1508672019048-805479767385',
                'latitude' => '6.3500',
                'longitude' => '80.1200',
                'facilities' => 'Meditation Hall, Dhamma Books, Parking, Restrooms',
                'safety_info' => 'Maintain silence and respect the spiritual atmosphere.',
            ],
            [
                'category_id' => $nature->id,
                'name' => 'Andahelena Ella Waterfall',
                'description' => 'Andahelena Ella is a beautiful natural waterfall surrounded by greenery and peaceful scenery. Perfect for nature lovers to relax and enjoy the flowing water.',
                'distance_km' => 16.00,
                'image' => 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9',
                'latitude' => '6.4000',
                'longitude' => '80.2500',
                'facilities' => 'Scenic Viewpoint, Bathing Spots',
                'safety_info' => 'Avoid swimming during high water flow periods.',
            ],
            [
                'category_id' => $beach->id,
                'name' => 'Ahungalla Beach',
                'description' => 'Ahungalla Beach is a peaceful sandy beach with beautiful sea views and a relaxing coastal environment. Ideal for beach walks and sunset viewing.',
                'distance_km' => 22.00,
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e',
                'latitude' => '6.3100',
                'longitude' => '80.0300',
                'facilities' => 'Beachside Restaurants, Hotels, Parking',
                'safety_info' => 'Pay attention to local warning flags before entering the ocean.',
            ],
            [
                'category_id' => $wildlife->id,
                'name' => 'Kosgoda Sea Turtle Conservation and Research Centre',
                'description' => 'Dedicated to protecting and conserving sea turtles. Visitors can learn about different sea turtle species, conservation activities, and marine life protection.',
                'distance_km' => 22.00,
                'image' => 'https://images.unsplash.com/photo-1518467166778-b88f373ffec7',
                'latitude' => '6.3300',
                'longitude' => '80.0200',
                'facilities' => 'Guided Tours, Hatchery Tanks, Souvenir Counter',
                'safety_info' => 'Do not use flash photography near hatchlings.',
            ],
            [
                'category_id' => $heritage->id,
                'name' => 'Kothduwa Raja Maha Viharaya',
                'description' => 'A peaceful Buddhist temple located on an island in Madu Ganga. Visitors can reach the temple by boat while enjoying river mangroves and scenic views.',
                'distance_km' => 20.00,
                'image' => 'https://images.unsplash.com/photo-1519331379826-f10be5486c6f',
                'latitude' => '6.2800',
                'longitude' => '80.0500',
                'facilities' => 'Boat Access, Shrine Room, Scenic River View',
                'safety_info' => 'Wear life jackets while traveling in boats on Madu Ganga.',
            ],
            [
                'category_id' => $cultural->id,
                'name' => 'Cinnamon Island – Madu Ganga',
                'description' => 'A small island in the Madu Ganga estuary where visitors can experience traditional cinnamon peeling and processing firsthand from local artisans.',
                'distance_km' => 24.00,
                'image' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d',
                'latitude' => '6.2750',
                'longitude' => '80.0550',
                'facilities' => 'Cinnamon Demonstrations, Local Products Sales, Boat Stop',
                'safety_info' => 'Follow boat captain instructions during transport.',
            ],
        ];

        foreach ($places as $place) {
            Place::create($place);
        }
    }
}
