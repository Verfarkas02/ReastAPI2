<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class BannController extends Controller
{
    

    public function getLoginAttempts($email){
        $user = User::where("email",$email)->first();
        return $user->login_attempts;
    }
    
    public function incrementLoginAttempts($email){
        User::where("email",$email)->increment("login_attempts");
    }
    public function setBannedTime($email){
        $user = User::where("email",$email)->first();
        $banned = Carbon::now()->addSeconds(60);
        $user->banned_time=$banned;
        $user->save();
        return $banned;
    }
    public function getBannedTime($email){
        // $carbon = (new Carbon);
        $user = User::where("email",$email)->first();
        return $user->banned_time;
    }
    public function resetLoginAttempts($email){
        $user = User::where("email",$email)->first();
        $user->login_attempts=0;
        $user->banned_time=null;
        $user->save();
    }



















}
