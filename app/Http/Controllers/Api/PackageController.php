<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ResponseController;
use App\Models\Package;

class PackageController extends ResponseController
{


    public function getPackageIdByName($name){
        $package = Package::where("package",$name)->first();
        return $package->id;
    }
    public function tehereExistsPackageByName(Request $request){
        $name = $request->get("name");
        $package = Package::where("package",$name)->first();
        if($package!=null){
            // return true;
            return $this->sendResponse(true, "Létezik"); 

        }

        // return false;
        return $this->sendResponse(false, "Nem létezik"); 

    }


    public function getPackages(){
        $package=  Package::all();
        if (is_null($package)) {
            return $this->sendError("Hiba a lekérdezésben");
        }
        return $this->sendResponse($package, "Betöltve");
    }
    
    public function addPackage(Request $request){
        $input = $request->all();
        
        $package = new Package;
        $package->package=$input["package"];
        if (is_null($package)) {
            return $this->sendError("hiba a bejövő paraméterekben");
        }
        $package->save();
        return $this->sendResponse($package, "Mentve");
    }
    
    
    public function modifyPackage(Request $request){
        $id = $request->get("id");
        $package = Package::find($id);
        $package->package = $request->get("package");
        $package->save();
        if (is_null($package)) {
            return $this->sendError("hiba a bejövő paraméterekben","Nincs ilyen Package");
        }
        return $this->sendResponse($package, "Módosítva");
    }
    
    public function destroyPackage(Request $request){
        
        $package = Package::find($request->get("id"));
        if (is_null($package)) {
            return $this->sendError("hiba a bejövő paraméterekben","Nincs ilyen Package");
        }else {
            Package::destroy($package->id);
            return $this->sendResponse($package, "Törölve");
        }
    }



}
