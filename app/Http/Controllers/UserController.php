<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Usertransactionwallet;
use App\Models\Useractivebet;
use App\Models\Userfinalbet;
use App\Models\Betcategory;
use App\Models\Betcategoryprice;
use App\Models\Timer;
use App\Models\Userfinalwallet;
use App\Repository\UserRepositoryInterface;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function register(Request $request){
        $count = User::where('email',$request->email)->count();
        switch($count){
            case 0:
                $validatedData = $request->validate([
                    'name' => 'required|min:3',
                    'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    'email' => 'required|email|unique:users'
                ]);
                switch($validatedData){
                    case true:
                        $insert = new User();
                        $insert->name = $request->name;
                        $insert->email = $request->email;
                        $insert->password = $request->password;
                        $res = $insert->save();
                        switch($res){
                            case true:
                                $token = $insert->createToken('user_token')->accessToken;
                                return response()->json(['token' => $token], 200);
                                break;
                            default:
                                return response()->json(['message'=>'something went wrong'],400);
                                break;
                        }
                    break;
                    default:
                    return response()->json(['message'=>'validation error']);
                    break;    
                }
            break;
            default:
            return response()->json(['message'=>'nothing'],400);
            break;
        }
        // if($count==0){
        //     $validatedData = $request->validate([
        //         'name' => 'required|min:3',
        //         'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        //         'email' => 'required|email|unique:users'
        //     ]);
        // if($validatedData){
        //     $insert = new User();
        //     $insert->name = $request->name;
        //     $insert->email = $request->email;
        //     $insert->password = $request->password;
        //     $res = $insert->save();

        //     if ($res) {
        //         $token = $insert->createToken('user_token')->accessToken;
        //         return response()->json(['token' => $token], 200);
        //     } else {
        //         return response()->json(['message' => 'something is wrong'], 400);
        //     }
        // }
        // else{
        //     return "valiadation error";
        // }
        // }
        
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $find = User::where('email', $email)->where('password', $password)->count();
        switch($find){
            case 1:
                $user = User::where('email', $email)->first();
                $token =  $user->createToken('user_token')->accessToken;
                return response()->json(['response' => 'You have Logged in Successfully', 'token' => $token], 200);
                break;
            default:
                return response()->json(['message'=>'please enter correct credentials'],400);
                break;
        }
        // if ($find == 1) {
        //     $user = User::where('email', $email)->first();
        //     $token =  $user->createToken('user_token')->accessToken;
        //     return response()->json(['message' => 'You have Logged in Successfully', 'token' => $token], 200);
        // } else {
        //     return response()->json(['message' => 'please enter correct credentials'], 400);
        // }
    }

    public function admin_register(Request $request){
        $count = Admin::where('email',$request->email)->count();
        switch($count){
            case 0:
                $validatedData = $request->validate([
                    'email'=>'required|email|unique:users',
                    'password'=>'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
                ]);
                switch($validatedData){
                    case true:
                        $insert = new Admin();
                        $insert->email = $request->email;
                        $insert->password = $request->password;
                        $res = $insert->save();
                        switch($res){
                            case true:
                                $token = $insert->createToken('admin_token')->accessToken;
                                return response()->json(['token' => $token], 200);
                                break;
                            default:
                                return response()->json(['message'=>'something is wrong'],400);
                                break;
                        }
                        break;
                    default:
                        return response()->json(['message'=>'validation error'],400);
                        break;
                }
                break;
            default:
                return response()->json(['message'=>'nothing'],400);
                break;
        }
        // if($count==0){
        //     $validatedData = $request->validate([
        //         'email'=>'required|email|unique:users',
        //         'password'=>'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        //     ]);
        // if($validatedData){
        //     $insert = new Admin();
        //     $insert->email = $request->email;
        //     $insert->password = $request->password;
        //     $res = $insert->save();
            


        //     if ($res) {
        //         $token = $insert->createToken('admin_token')->accessToken;
        //         return response()->json(['token' => $token], 200);
        //     } else {
        //         return response()->json(['message' => 'something is wrong'], 400);
        //     }
        // }
        
        // }
        
    }

    public function admin_login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $find = Admin::where('email', $email)->where('password', $password)->count();
        switch($find){
            case 1:
                $user = Admin::where('email', $email)->first();
                $token =  $user->createToken('admin_token')->accessToken;
                return response()->json(['response' => 'You have Logged in Successfully', 'token' => $token], 200);
                break;
            default:
                return response()->json(['message'=>'please enter correct credentials'],400);
                break;
        }
        // if ($find == 1) {
        //     $user = Admin::where('email', $email)->first();
        //     $token =  $user->createToken('admin_token')->accessToken;
        //     return response()->json(['message' => 'You have Logged in Successfully', 'token' => $token], 200);
        // } else {
        //     return response()->json(['message' => 'please enter correct credentials'], 400);
        // }
    }

    public function addmoneytowallet(Request $request){
        $count_user = User::where('id',$request->user_id)->count();
        switch($count_user){
            case 1:
                $data = new Usertransactionwallet();
                $data->user_id = $request->user_id;
                $data->amount = $request->amount;
                $data->added_by = auth()->user()->id;
                $res = $data->save();
                
                switch($res){
                    case true:
                    $count = Userfinalwallet::where('user_id',$request->user_id)->count();
                    switch($count){
                        case 0:
                            $insertdata = new Userfinalwallet();
                            $insertdata->user_id = $request->user_id;
                            $insertdata->amount = $request->amount;
                            $insertdata->save();
                            break;
                        default:
                        $amount = Userfinalwallet::where('user_id',$request->user_id)->get()[0]->amount;
                        Userfinalwallet::where('user_id',$request->user_id)->update(['amount'=>$amount+$request->amount]);
                        break;
                    }
                    return response()->json(['response'=>'you have successfully added the amount to user wallet'],200);
                    break;
                    default:
                    return response()->json(['message'=>'the requested amount could not be added'],400);
                    break;
                }
                break;
                default:
                    return response()->json(['message'=>'no such user exists'],400);
                break;
        }

        // ifelse
        // $count_user = User::where('id',$request->user_id)->count();
        // if($count_user==1){
        //     $data = new Usertransactionwallet();
        //     $data->user_id = $request->user_id;
        //     $data->amount = $request->amount;
        //     $data->added_by = auth()->user()->id;
        //     $res = $data->save();

        //     if($res){
        //         $count = Userfinalwallet::where('user_id',$request->user_id)->count();

        //         if($count==0){
        //             $insertdata = new Userfinalwallet();
        //             $insertdata->user_id = $request->user_id;
        //             $insertdata->amount = $request->amount;
        //             $insertdata->save();
        //         }
        //         else{
        //             $amount = Userfinalwallet::where('user_id',$request->user_id)->get()[0]->amount;
        //             Userfinalwallet::where('user_id',$request->user_id)->update(['amount'=>$amount+$request->amount]);
        //         }
        //         return response()->json(['response'=>'you have successfully added the amount to user wallet'],200);
        //     }

        //     else{
        //         return response()->json(['error'=>'something went wrong'],400);
        //     }
        // }
        // else{
        //     return response()->json(['error'=>'There is no such user'],400);
        // }
    }

    public function view_wallet(){
        $user = Usertransactionwallet::where('user_id',auth()->user()->id)->with(['user'=>function($q){
            $q->distinct()->select(['id','name','email']);
        }])->distinct()->select(['user_id','amount'])->get();
        return response()->json(['response'=>$user],200);
    }

    public function view_final_wallet(){
        $user = Userfinalwallet::where('user_id',auth()->user()->id)->with(['user'=>function($q){
            $q->distinct()->select(['id','name','email']);
        }])->distinct()->select(['user_id','amount'])->get();
        return response()->json(['response'=>$user],200);
    }
    public function placebet(Request $request){
        $walletdata_count = Userfinalwallet::where('user_id',auth()->user()->id)->count();
        switch($walletdata_count){
            case 1;
            $amount = Userfinalwallet::where('user_id',auth()->user()->id)->get()[0]->amount;
            switch($amount){
                case($amount<$request->betamount);
                return response()->json(['message'=>'insufficient funds'],400);
                break;

                case($amount>=$request->betamount);
                $data = new Userfinalbet();
                $data->user_id = auth()->user()->id;
                $data->market = $request->market;
                $data->betamount = $request->betamount;
                $data->start_date = date("Y-m-d");
                $data->start_time = date("H:i:s");
                $data->timer_id = $request->duration;
                $data->exposure = -($request->betamount);

                $res = $data->save();
                switch($res){
                    case true:
                        $amount = Userfinalwallet::where('user_id',auth()->user()->id)->get()[0]->amount;
                        Userfinalwallet::where('user_id',auth()->user()->id)->update(['amount'=>$amount-($request->betamount)]);
                        $val = Userfinalbet::orderBy('id','desc')->first();
                        return response()->json(['response'=>$val],200);
                        break;
                        
                    default:
                        return response()->json(['message'=>'something went wrong'],400);
                }
                break;

                default;
                return "default";
            }
            // return response()->json(['response'=>'data is present'],200);
            break;

            default:
            return response()->json(['message'=>'your wallet has not been initiated yet'],400);
        }

        // ifelse
        // $data = new Userfinalbet();
        // $data->user_id = auth()->user()->id;
        // $data->market = $request->market;
        // $data->betamount = $request->betamount;
        // $data->start_date = date("Y-m-d");
        // $data->start_time = date("H:i:s");
        // $data->timer_id = $request->duration;
        // $data->exposure = -($request->betamount);

        // $res = $data->save();

        // if($res){
        //     $amount = Userfinalwallet::where('user_id',auth()->user()->id)->get()[0]->amount;
        //     Userfinalwallet::where('user_id',auth()->user()->id)->update(['amount'=>$amount-($request->betamount)]);
        //     $val = Useractivebet::orderBy('id','desc')->first();
        //     return response()->json(['response'=>$val],200);
        // }
        // else{
        //     return response()->json(['error'=>'something went wrong'],400);
        // }
    }

    public function finalbet(Request $request){
        $id = $request->bet_id;
        $profitloss = $request->profitloss;
        $res = Userfinalbet::where('id',$id)->update(['end_date'=>date("Y-m-d"),'end_time'=>date("H:i:s"),'profitloss'=>$profitloss,'exposure'=>0.00]);
        // $data->user_id = auth()->user()->id;
        // $data->end_date = date("Y-m-d");
        // $data->end_time = date("H:i:s");
        // $data->profitloss = $request->profitloss;
        // $res = $data->save();
        switch($res){
            case true:
                $amount = Userfinalwallet::where('user_id',auth()->user()->id)->get()[0]->amount; 
                switch($profitloss){
                    case($profitloss>0):
                        Userfinalwallet::where('user_id',auth()->user()->id)->update(['amount'=>$amount+$request->betamount+$request->profitloss]);
                        break;
                    default:
                        return response()->json(['response'=>'your bet has been completed successfully'],200);
                        break;
                }
            return response()->json(['response'=>'your bet has been completed successfully'],200);
            break;
            default:
            return response()->json(['message'=>'something went wrong'],400);  
        }
        // if($res){
        //     //Useractivebet::where('id',$request->active_bet_id)->update(['exposure'=>0.00]);
        //     $amount = Userfinalwallet::where('user_id',auth()->user()->id)->get()[0]->amount;
        //     if($request->profitloss>0){
        //     Userfinalwallet::where('user_id',auth()->user()->id)->update(['amount'=>$amount+$request->betamount+$request->profitloss]);
        //     }
        //     else{
        //         //do nothing
        //     }
        //     // Userfinalwallet::where('user_id',auth()->user()->id)->update(['amount'=>$amount+$request->betamount+$request->profitloss]);
        //     return response()->json(['response'=>'your bet has been completed successfully'],200);
        // }
        // else{
        //     return response()->json(['error'=>'something went wrong'],400);
        // }
    }

    public function betcategory(Request $request){
        $count = Betcategory::where('category_name',$request->category)->count();
        if($count==1){
            return response()->json(['error'=>'A category already exists in this name'],400);
        }
        else{
            $data = new Betcategory();
            $data->category_name = $request->category;
            $res = $data->save();

            if($res){
                return response()->json(['response'=>'you have successfully created the bet category'],200);
            }

            else{
                return response()->json(['error'=>'something went wrong'],400);
            }
        }   
    }

    public function betcategoryprices(Request $request){
        $count = Betcategory::where('id',$request->betcategory_id)->count();
        if($count==0){
            return response()->json(['error'=>'no such category exists'],400);
        }
        else{
            $data = new Betcategoryprice();
            $data->betcategory_id = $request->betcategory_id;
            $data->amount = $request->amount;
            $res = $data->save();

            if($res){
                return response()->json(['response'=>'data has been posted successfully'],200);
            }

            else{
                return response()->json(['error'=>'something went wrong'],400);
            }
        }   
    }

    public function viewbetcategories(){
        $val = Betcategoryprice::orderBy('id','DESC')->distinct()->select(['id','betcategory_id','amount'])->with('betcategory')->get();
        $data = $val->unique('betcategory_id')->values();
        return response()->json($data,200);
    }

    public function addtimer(Request $request){
        $count = Timer::where('timer',$request->timer)->count();
        switch($count){
            case 0:
                $timer = new Timer();
                $timer->timer = $request->timer;
                $timer->payout = $request->payout;
                $res = $timer->save();
                switch($res){
                    case true:
                        return response()->json(['response'=>'data is stored successfully'],200);
                        break;
                    default:
                        return response()->json(['message'=>'something went wrong'],400);
                }
            break;
            default:
                return response()->json(['message'=>'this data is already present'],400);
        }
        // if($count == 0){
        //     $timer = new Timer();
        //     $timer->timer = $request->timer;
        //     $timer->payout = $request->payout;
        //     $res = $timer->save();
        //     if($res){
        //         return response()->json(['response'=>'data is stored successfully'],200);
        //     }
        //     else{
        //         return response()->json(['error'=>'something went wrong'],400);
        //     }
        // }
        // else{
        //     return response()->json(['error'=>'this data is already present'],400);
        // }
    }
    
    public function viewallfinalbets(){
        $finalbets = Userfinalbet::distinct()->select(['id','user_id','market','betamount','start_date','start_time','timer_id','exposure','profitloss'])
        ->with(['user'=>function($q){
            $q->distinct()->select(['id','name','email']);
        }])->with(['duration'=>function($q){
            $q->distinct()->select(['id','timer','payout']);
        }])->get();
        return response()->json(['response'=>$finalbets],200);
    }

    public function viewallwallets(){
        $wallets = Usertransactionwallet::where('added_by',auth()->user()->id)->with(['user'=>function($q){
            $q->distinct()->select(['id','name','email']);
        }])->distinct()->select(['id','user_id','amount'])->get();
        return response()->json(['response'=>$wallets],200);
    }

    public function viewfinalbets(){
        $userfinalbets = Userfinalbet::where('user_id',auth()->user()->id)->with(['user'=>function($q){
            $q->distinct()->select(['id','name','email']);
        }])->with(['duration'=>function($q){
            $q->distinct()->select(['id','timer','payout']);
        }])->distinct()->select(['id','user_id','market','betamount','start_date','start_time','timer_id','end_date','end_time','profitloss'])->get();
        return response()->json(['response'=>$userfinalbets],200);
    }

    public function allusers(){
        $users = User::distinct()->select(['id','name','email'])->with(['user_finalwallet'=>function($q){
            $q->distinct()->select(['id','user_id','amount']);
        }])->get();
        return response()->json(['response'=>$users],200);
    }

    public function updatepayout(Request $request,$id){
     $update = Timer::where('id',$id)->update(['payout'=>$request->payout]);
        switch($update){
            case true:
                return response()->json(['response'=>'data has been updated successfully'],200);
                break;
            default:
                return response()->json(['message'=>'something went wrong'],400);
        }
    //  if($update){
    //      return response()->json(['response'=>'data has been updated successfully']);
    //  }
    //  else{
    //      return response()->json(['error'=>'something went wrong']);
    //  }
    }

    public function viewtimers(){
        $data = Timer::distinct()->select(['id','timer','payout'])->get();
        return response()->json(['response'=>$data],200);
    }

    public function singlepayout($id){
        $data = Timer::where('id',$id)->distinct()->select(['id','payout','timer'])->get();
        return response()->json(['response'=>$data],200);
    }

    public static function liverate(){
        $response = Http::get('https://api.polygon.io/v1/open-close/crypto/BTC/USD/2021-09-28?adjusted=true&apiKey=6sEFcNe2upitHW5lt9dp7EfkIuxoR58k');
        $val = $response->json();
        $close = $val['close'];
        return response()->json(['response'=>$close],200);
    }
}
