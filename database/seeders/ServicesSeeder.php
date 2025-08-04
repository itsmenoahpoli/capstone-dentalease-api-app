<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $services = [
            [
                'category' => 'Preventive Care',
                'name' => 'Dental Cleaning',
                'price' => 150.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Preventive Care',
                'name' => 'Dental Examination',
                'price' => 100.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Preventive Care',
                'name' => 'X-Ray (Single Tooth)',
                'price' => 50.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Preventive Care',
                'name' => 'Full Mouth X-Ray',
                'price' => 200.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Restorative Dentistry',
                'name' => 'Dental Filling',
                'price' => 200.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Restorative Dentistry',
                'name' => 'Root Canal Treatment',
                'price' => 800.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Restorative Dentistry',
                'name' => 'Dental Crown',
                'price' => 1200.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Restorative Dentistry',
                'name' => 'Dental Bridge',
                'price' => 2500.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Cosmetic Dentistry',
                'name' => 'Teeth Whitening',
                'price' => 300.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Cosmetic Dentistry',
                'name' => 'Dental Veneers',
                'price' => 1500.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Cosmetic Dentistry',
                'name' => 'Invisible Braces',
                'price' => 3500.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Oral Surgery',
                'name' => 'Tooth Extraction',
                'price' => 250.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Oral Surgery',
                'name' => 'Wisdom Tooth Removal',
                'price' => 400.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Oral Surgery',
                'name' => 'Dental Implant',
                'price' => 3000.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Emergency Care',
                'name' => 'Emergency Dental Visit',
                'price' => 200.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Emergency Care',
                'name' => 'Toothache Treatment',
                'price' => 150.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Pediatric Dentistry',
                'name' => 'Child Dental Cleaning',
                'price' => 120.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Pediatric Dentistry',
                'name' => 'Child Dental Examination',
                'price' => 80.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Orthodontics',
                'name' => 'Traditional Braces',
                'price' => 5000.00,
                'status' => 'offered'
            ],
            [
                'category' => 'Orthodontics',
                'name' => 'Retainer',
                'price' => 300.00,
                'status' => 'offered'
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
