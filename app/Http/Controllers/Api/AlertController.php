<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Mail\AlertMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class AlertController extends Controller
{
    public function sendMail($user, $time){
        $content = [
            "title" => "Figyelmeztető levél",
            "user" => $user,
            "time" => $time
        ];
        Mail::to("morabarna@ktch.hu")->send(new AlertMail($content));
    }
}
