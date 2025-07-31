<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContentData;

class ContentDataSeeder extends Seeder
{
    public function run(): void
    {
        $contentData = [
            [
                'category' => 'clinic_information',
                'title' => 'Welcome to DentalEase',
                'content' => 'DentalEase is a modern dental clinic committed to providing comprehensive oral healthcare services. Our state-of-the-art facility is equipped with the latest dental technology to ensure comfortable and effective treatments for all our patients.',
                'metadata' => [
                    'contact_email' => 'info@dentalease.com',
                    'phone' => '+1-555-0123',
                    'address' => '123 Dental Street, Healthcare City, HC 12345',
                    'hours' => 'Monday-Friday: 8AM-6PM, Saturday: 9AM-3PM'
                ],
                'is_active' => true
            ],
            [
                'category' => 'clinic_announcements',
                'title' => 'New Safety Protocols',
                'content' => 'We have implemented enhanced safety protocols to ensure the health and safety of our patients and staff. All surfaces are regularly sanitized, and we maintain strict social distancing guidelines.',
                'metadata' => [
                    'announcement_date' => '2025-07-31',
                    'priority' => 'high'
                ],
                'is_active' => true
            ],
            [
                'category' => 'latest_developments',
                'title' => 'Advanced Digital Imaging System',
                'content' => 'We are excited to announce the installation of our new advanced digital imaging system. This cutting-edge technology provides clearer, more detailed images for better diagnosis and treatment planning.',
                'metadata' => [
                    'development_date' => '2025-07-15',
                    'technology_type' => 'Digital Imaging',
                    'benefits' => ['Better Diagnosis', 'Reduced Radiation', 'Faster Results']
                ],
                'is_active' => true
            ],
            [
                'category' => 'owner_information',
                'title' => 'Dr. Sarah Johnson - Clinic Owner',
                'content' => 'Dr. Sarah Johnson is a board-certified dentist with over 15 years of experience in comprehensive dental care. She graduated from the University of Dental Medicine and has been serving the community with dedication and expertise.',
                'metadata' => [
                    'education' => 'University of Dental Medicine',
            'experience_years' => 15,
            'specializations' => ['General Dentistry', 'Cosmetic Dentistry', 'Preventive Care'],
            'certifications' => ['Board Certified', 'Advanced Life Support']
                ],
                'is_active' => true
            ],
            [
                'category' => 'our_team',
                'title' => 'Meet Our Expert Team',
                'content' => 'Our team consists of experienced dental professionals dedicated to providing exceptional care. From our skilled dentists to our friendly support staff, everyone at DentalEase is committed to your oral health and comfort.',
                'metadata' => [
                    'team_members' => [
                        ['name' => 'Dr. Sarah Johnson', 'position' => 'Lead Dentist'],
                        ['name' => 'Dr. Michael Chen', 'position' => 'Associate Dentist'],
                        ['name' => 'Emily Rodriguez', 'position' => 'Dental Hygienist'],
                        ['name' => 'David Thompson', 'position' => 'Dental Assistant']
                    ],
                    'total_experience' => 45
                ],
                'is_active' => true
            ]
        ];

        foreach ($contentData as $data) {
            ContentData::create($data);
        }
    }
}
