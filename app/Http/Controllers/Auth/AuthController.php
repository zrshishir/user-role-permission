<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Helper\HelperController;

class AuthController extends Controller
{
    private $helping = "";

    public function __construct(){
        $this->helping = new HelperController();
    }

    public function shishir(){
        return response()->json('shishir');
    }
    public function login(Request $request){ 

        return response()->json($request->all());
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            
            $user = Auth::user(); 
           
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $user['api_token'] = $success['token'];
            $user['token_type'] = "Bearer";

            $responseData = $this->helping->responseProcess(0, 200, "Your are logged in", [
                'users' => $user, 
            ]);

            return response()->json($responseData); 
        } 
        else{ 
            $responseData = $this->helping->responseProcess(1, 401, "You have entered an incorrect email No/Password combination.", "");
            return response()->json($responseData); 
        } 
    }

    public function signup(Request $request)
    {
        $responseData = $this->helping->responseProcess(1, 422, "No registration for admin", "");
            return response()->json($responseData);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        
        if($validator->fails()){
            $errors = $validator->errors();
            $errorMsg = "";
            
            foreach ($errors->all() as $msg) {
                $errorMsg .= $msg;
            }

            $responseData = $this->helping->responseProcess(1, 422, $errorMsg, "");

            return response()->json($responseData);
        }
       
       
        
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type_id' => 5
        ]);

        $user->save();

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $user['api_token'] = $success['token'];
            $user['token_type'] = "Bearer";

            $basicInfo = InvestorBasicInfo::create([
                'user_id' => $user->id,
                'user_name' => $request->name
            ]);
            
            if($request->photo){
                $fileName = $this->imageProcess->processSignupImage($request->photo, $user->id);
                $document = InvestorDocument::create([
                    'user_id' => $user->id,
                    'photo' => $fileName
                ]);    

                $userImage = User::where('id', $user->id)->update(['photo' => $fileName]);
            }

            $basicInfos = InvestorBasicInfo::where('user_id', $user->id)->first();
            $documents = InvestorDocument::where('user_id', $user->id)->first();

            // if(! $documents){
            //     $documents = "";
            // }
            if(! $basicInfos){
                $basicInfos = (object)[];
            }
           
            $responseData = $this->helping->responseProcess(0, $this->successStatus, "Your are logged in", ['users' => $user, 'basicInfos' =>$basicInfos, 'documents' => $documents]);
            return response()->json($responseData); 
        } 
        else{ 
            $responseData = $this->helping->responseProcess(1, 401, "You have entered an incorrect email No/Password combination.", "");
            return response()->json($responseData); 
        } 
    }
}
