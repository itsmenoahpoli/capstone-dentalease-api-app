<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentData extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];

    public const CATEGORIES = [
        'clinic_information' => 'Clinic Information',
        'clinic_announcements' => 'Clinic Announcements',
        'latest_developments' => 'Latest Developments',
        'owner_information' => 'Owner Information',
        'our_team' => 'Our Team'
    ];
}
