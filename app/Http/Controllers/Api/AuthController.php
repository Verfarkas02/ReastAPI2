<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ResponseController;
use App\Http\Requests\UserLoginChecker;
use App\Http\Requests\UserRegisterChecker;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends ResponseController
{
    public function register(UserRegisterChecker $request){
        $request->validated();
        $input = $request->all();
        $input["password"]=bcrypt($input["password"]);
        $user = User::create($input);
        $success["name"]=$user->name;
        return $this ->sendResponse($success, "Sikeres Regisztráció");
    }
    public function login(UserLoginChecker $request){
        $bann = (new BannController);
        $request->validated();
        
        $input =$request->all();
        if(Auth::attempt(["email"=>$input["email"], "password"=>$input["password"]])){
            $bannTime=$bann->getBannedTime($input["email"]);
            if($bannTime>Carbon::now()){
                return $this->sendError("Túl sok Próbálkozás",["nextLogin"=>$bannTime],401);
            }
            $bann->resetLoginAttempts($input["email"]);
            $authUser = Auth::user();
            $success["token"] = $authUser->createToken($authUser->name."token")->plainTextToken;
            $success["name"] = $authUser->name;
            return $this->sendResponse($success, "Sikeres Bejelentkezés");
        } else {
            if ($bann->getLoginAttempts($request->email)<3) {
                $bann->incrementLoginAttempts($request->email);
                return $this->sendError("Sikertelen bejelentkezés",["Hibás felhasználónév/email vagy jelszó"],401);
            } else{
                $time = $bann->setBannedTime($input["email"]);
                (new AlertController)->sendMail($input['email'],$time);
                return $this->sendError("Túl sok Próbálkozás",["nextLogin"=>$time],401);
                // return $this->sendError("Sikertelen azonosítás",["error"=>"Túl sok próbálkozás"],401);
            }
        }

    }
    public function logout(){
        auth("sanctum")->user()->currentAccessToken()->delete();
        // Auth::logout();
        return $this->sendResponse([],"Sikeres kijelentkezés");
    }
}
