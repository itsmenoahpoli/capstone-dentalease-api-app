<?php

namespace App\Http\Controllers;

use App\Services\NotificationsService;

class SmsController extends Controller
{
    public function __construct(
        public NotificationsService $notificationsService
    ) {}

    public function smsSms()
    {
        $this->notificationsService->send_sms('09620636535', 'Message sent from backend application');
    }
}
