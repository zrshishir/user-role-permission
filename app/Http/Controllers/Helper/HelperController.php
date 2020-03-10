<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ActivityLog\ActivityLog;
use App\User;
use Schema, DB, Auth;
use Carbon\Carbon;


class HelperController extends Controller
{

   
    private $helping;
    

    public function __construct(){
        $this->helping = new HelperController();
    }

    public function noContent(){
        return $this->responseProcess(0, 204, "No Content", "");
    }

    public function indexData($datas){
        return $this->responseProcess(0, 200, "Datas...", $datas);
    }

    public function validatingErrors($errorMsg){
        return $this->responseProcess(1, 422, $errorMsg, "");
    }

    public function invalidEditId(){
        return $this->responseProcess(1, 403, "Invalid id", "");
    }

    public function savingData($datas){
        return $this->responseProcess(0, 201, "Data has been saved", $datas);
    }

    public function serverError(){
        return $this->responseProcess(1, 500, "Internal Server Error.", "");
    }

    public function notNumeric(){
        return $this->responseProcess(1, 403, "The id should be a number.", "");
    }

    public function deletingData($datas){
        return $this->responseProcess(0, 200, "Data has been deleted successfully.", $datas);
    }

    public function invalidDeleteId($datas){
        return $this->responseProcess(1, 400, "Please give a valid id.", $datas);
    }

    public function responseProcess($errorCode, $statusCode, $msg, $data){
        $responseData['error'] = $errorCode; 
        $responseData['statusCode'] = $statusCode;
        $responseData['errorMsg'] = $msg;
        $responseData['data'] = $data ;
        
        // $this->activityLogStorage($errorCode, $statusCode, $msg, Auth::user());

        return $responseData;
    }
    //activity logs

    
}
