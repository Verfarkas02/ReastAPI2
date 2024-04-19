<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ResponseController;

use App\Models\Type;


class TypeController extends ResponseController
{
    
    public function getTypeIdByName($name){
        $type = Type::where("type",$name)->first();
        return $type->id;
    }
    public function tehereExistsTypeByName(Request $request){
        $name = $request->get("name");
        $type = Type::where("type",$name)->first();
        if($type!=null){
            // return true;
            return $this->sendResponse(true, "Létezik"); 
        }

        // return false;
        return $this->sendResponse(false, "Nem létezik"); 
    }


    public function getTypes(){
        $type=  Type::all();
        if (is_null($type)) {
            return $this->sendError("Hiba a lekérdezésben");
        }
        return $this->sendResponse($type, "Betöltve");
    }
    
    public function addType(Request $request){
        $input = $request->all();
        
        $type = new Type;
        $type->type=$input["type"];
        if (is_null($type)) {
            return $this->sendError("hiba a bejövő paraméterekben");
        }
        $type->save();
        return $this->sendResponse($type, "Mentve");
    }
    
    
    public function modifyType(Request $request){
        $id = $request->get("id");
        $type = Type::find($id);
        $type->type = $request->get("type");
        $type->save();
        if (is_null($type)) {
            return $this->sendError("hiba a bejövő paraméterekben","Nincs ilyen Type");
        }
        return $this->sendResponse($type, "Módosítva");
    }
    
    public function destroyType(Request $request){
        
        $type = Type::find($request->get("id"));
        if (is_null($type)) {
            return $this->sendError("hiba a bejövő paraméterekben","Nincs ilyen Type");
        }else {
            Type::destroy($type->id);
            return $this->sendResponse($type, "Törölve");
        }
    }

}
