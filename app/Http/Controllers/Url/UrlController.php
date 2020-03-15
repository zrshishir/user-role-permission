<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\Url\Url;
use Validator, Auth;
use App\Http\Controllers\Helper\HelperController;

class UrlController extends Controller
{
    private $helping = "";

    public function __construct(){
        $this->helping = new HelperController();
    }

    public function index(){
        
        $urls = Url::get();

        $responseData = $this->helping->indexData(['urls'=> $urls]);
        return response()->json($responseData);

    }

    public function store(Request $request){
        $userId = Auth::user()->id;
        $infoExist = Url::find($request->id);
        
        if(! $infoExist){
            $validator = Validator::make($request->all(), [
                'title' => 'required|string'
            ]);
            
            if($validator->fails()){
                $errors = $validator->errors();
                $errorMsg = null;
                
                foreach ($errors->all() as $msg) {
                    $errorMsg .= $msg;
                }

                $responseData = $this->helping->validatingErrors($errorMsg);
                return response()->json($responseData);
            }

            $contactInfoId = Url::create([
                'title' => $title
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'title' => 'required|string'
            ]);
            
            if($validator->fails()){
                $errors = $validator->errors();
                $errorMsg = null;
                
                foreach ($errors->all() as $msg) {
                    $errorMsg .= $msg;
                }
               
                $responseData = $this->helping->validatingErrors($errorMsg);
                return response()->json($responseData);
            }
            $contactInfoId = Url::where('id', $request->id)->update([
                'title' => $request->title
            ]);
        }

        if($contactInfoId){
            $urls = Url::get();
            $responseData = $this->helping->savingData(['urls'=> $urls]);
            return response()->json($responseData);
        }else{
             $responseData = $this->helping->serverError();
            return response()->json($responseData);
        }
    }
}
