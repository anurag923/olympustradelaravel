<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\SuperAdmin;
use App\Models\Usertransactionwallet;
use App\Models\Useractivebet;
use App\Models\Userfinalbet;
use App\Models\Betcategory;
use App\Models\Betcategoryprice;
use App\Models\Timer;
use App\Models\Userfinalwallet;
use App\Models\market;
use App\Models\Master;
use App\Models\Mastertransactionwallet;
use App\Models\Masterfinalwallet;
use App\Models\masterfinalbet;
use App\Models\MasterUsertransactionwallet;
use App\Models\Masteruserfinalwallet;
use App\Models\MasterMarket;
use App\Models\Mastertimer;
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
        
    }
    public function master_register(Request $request){
        $count = Master::where('email',$request->email)->count();
        switch($count){
            case 0:
                $validatedData = $request->validate([
                    'email'=>'required|email|unique:users',
                    'password'=>'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
                ]);
                switch($validatedData){
                    case true:
                        $insert = new Master();
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
        
    }

    public function admin_login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $find = Admin::where('email', $email)->where('password', $password)->count();
        switch($find){
            case 1:
                $user = Admin::where('email', $email)->first();
                $token =  $user->createToken('adminuser_token')->accessToken;
                return response()->json(['response' => 'You have Logged in Successfully', 'token' => $token], 200);
                break;
            default:
                return response()->json(['message'=>'please enter correct credentials'],400);
                break;
        }
    }

    public function master_login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $find = Master::where('email', $email)->where('password', $password)->count();
        switch($find){
            case 1:
                $user = Master::where('email', $email)->first();
                $token =  $user->createToken('adminuser_token')->accessToken;
                return response()->json(['response' => 'You have Logged in Successfully', 'token' => $token], 200);
                break;
            default:
                return response()->json(['message'=>'please enter correct credentials'],400);
                break;
        }
    }
    public function addmoneytowallet(Request $request){
        $count_user = Master::where('id',$request->master_id)->count();
        switch($count_user){
            case 1:
                $data = new Mastertransactionwallet();
                $data->master_id = $request->master_id;
                $data->amount = $request->amount;
                // $data->added_by = auth()->user()->id;
                $res = $data->save();
                
                switch($res){
                    case true:
                    $count = Masterfinalwallet::where('master_id',$request->master_id)->count();
                    switch($count){
                        case 0:
                            $insertdata = new Masterfinalwallet();
                            $insertdata->master_id = $request->master_id;
                            $insertdata->amount = $request->amount;
                            $insertdata->save();
                            break;
                        default:
                        $amount = Masterfinalwallet::where('master_id',$request->master_id)->get()[0]->amount;
                        Masterfinalwallet::where('master_id',$request->master_id)->update(['amount'=>$amount+$request->amount]);
                        break;
                    }
                    return response()->json(['response'=>'you have successfully added the amount to master wallet'],200);
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

        
    }

    public function view_wallet(){
        $user = Usertransactionwallet::where('user_id',auth()->user()->id)->with(['user'=>function($q){
            $q->distinct()->select(['id','name','email']);
        }])->distinct()->select(['user_id','amount'])->get();
        return response()->json(['response'=>$user],200);
    }

    public function view_final_wallet(){
        $user = Masterfinalwallet::where('master_id',auth()->user()->id)->with(['master'=>function($q){
            $q->distinct()->select(['id','email']);
        }])->distinct()->select(['master_id','amount'])->get();
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
            break;

            default:
            return response()->json(['message'=>'your wallet has not been initiated yet'],400);
        }

    }

    public function finalbet(Request $request){
        $id = $request->bet_id;
        $profitloss = $request->profitloss;
        $res = Userfinalbet::where('id',$id)->update(['end_date'=>date("Y-m-d"),'end_time'=>date("H:i:s"),'profitloss'=>$profitloss,'exposure'=>0.00]);
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
    }

    public function master_placebet(Request $request){
        $walletdata_count = Masterfinalwallet::where('master_id',auth()->user()->id)->count();
        switch($walletdata_count){
            case 1;
            $amount = Masterfinalwallet::where('master_id',auth()->user()->id)->get()[0]->amount;
            switch($amount){
                case($amount<$request->betamount);
                return response()->json(['message'=>'insufficient funds'],400);
                break;

                case($amount>=$request->betamount);
                $data = new masterfinalbet();
                $data->master_id = auth()->user()->id;
                $data->market = $request->market;
                $data->betamount = $request->betamount;
                $data->uid = $request->uid;
                $data->start_date = date("Y-m-d");
                $data->start_time = date("H:i:s");
                $data->timer_id = $request->duration;
                $data->exposure = -($request->betamount);

                $res = $data->save();
                switch($res){
                    case true:
                        $amount = Masterfinalwallet::where('master_id',auth()->user()->id)->get()[0]->amount;
                        Masterfinalwallet::where('master_id',auth()->user()->id)->update(['amount'=>$amount-($request->betamount)]);
                        $val = masterfinalbet::orderBy('id','desc')->first();
                        return response()->json(['response'=>$val],200);
                        break;
                        
                    default:
                        return response()->json(['message'=>'something went wrong'],400);
                }
                break;

                default;
                return "default";
            }
            break;

            default:
            return response()->json(['message'=>'your wallet has not been initiated yet'],400);
        }

    }

    public function master_finalbet(Request $request){
        $id = $request->bet_id;
        $profitloss = $request->profitloss;
        $res = masterfinalbet::where('id',$id)->update(['end_date'=>date("Y-m-d"),'end_time'=>date("H:i:s"),'profitloss'=>$profitloss,'exposure'=>0.00]);
        switch($res){
            case true:
                $amount = Masterfinalwallet::where('master_id',auth()->user()->id)->get()[0]->amount; 
                switch($profitloss){
                    case($profitloss>0):
                        Masterfinalwallet::where('master_id',auth()->user()->id)->update(['amount'=>$amount+$request->betamount+$request->profitloss]);
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

    public function addtimer(Request $request,$id){
        $data = $request->all();
                for($i=0;$i<count($data);$i++){
                    $count = Timer::where('market_id',$id)->where('timer',$data[$i]['timer'])->count();
                    if($count==0){
                        $timer = new Timer();
                        $timer->timer = $data[$i]['timer'];
                        $timer->payout = $data[$i]['payout'];
                        $timer->market_id = $id;
                        $res = $timer->save();
                        if($res){
                            market::where('id',$id)->update(['payoutset'=>1]);
                        }
                    }
                    else{
                        $res = false;
                    }
                }
                switch($res){
                        case true:
                            return response()->json(['response'=>'data is stored successfully'],200);
                            break;
                        default:
                            return response()->json(['message'=>'something went wrong'],400);
                    }

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

    }

    public function viewtimers_admin($id){
        $data = Timer::where('market_id',$id)->with(['markets'=>function($q){
            $q->distinct()->select(['id','market','type']);
        }])->distinct()->select(['id','market_id','timer','payout'])->get();
        return response()->json(['response'=>$data],200);
    }

    public function viewtimers($id){
        $data = market::where('id',$id)->with(['payouts'=>function($q){
            $q->distinct()->select(['id','market_id','timer','payout']);
        }])->distinct()->select(['id','market','type'])->get();
        // $data = Timer::where('market_id',$id)->with(['markets'=>function($q){
        //     $q->distinct()->select(['id','market','type']);
        // }])->distinct()->select(['id','market_id','timer','payout'])->get();
        return response()->json(['response'=>$data],200);
    }
    // public function singlepayout(Request $request){
    //     $masterid = auth()->user()->id;
    //     $marketid = $request->marketid;
    //     $timer = $request->timer;
    //     $data = Mastertimer::where('master_id',$masterid)->where('mastermarket_id',$marketid)->where('timer',$timer)->get();
    //     return response()->json(['response'=>$data],200);
    // }
    public function singlepayout($id){
        $data = Timer::where('timer',$id)->distinct()->select(['id','payout','timer'])->get();
        return response()->json(['response'=>$data],200);
    }
    public static function liverate(){
        $current_date = date("Y-m-d");
        $response = Http::get('https://api.polygon.io/v1/open-close/crypto/BTC/USD/'.$current_date.'?adjusted=true&apiKey=6sEFcNe2upitHW5lt9dp7EfkIuxoR58k');
        $val = $response->json();
        $close = $val['close'];
        return response()->json(['response'=>$close],200);
    }

    public function getcryptomarkets(){
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/market-pairs/latest';
        $parameters = [
        'start' => '1',
        'limit' => '5000',
        'convert' => 'USD'
        ];

        $headers = [
        'Accepts: application/json',
        'X-CMC_PRO_API_KEY: 1aff8485-ac77-4bb0-8c3a-a9bfdf096410'
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
        CURLOPT_URL => $request,            // set the request URL
        CURLOPT_HTTPHEADER => $headers,     // set the headers 
        CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        //print_r(json_decode($response)); // print json decoded response
        return json_decode($response,TRUE);
        curl_close($curl); // Close request
            }
    public function markets_crypto(){
        $response_crypto = Http::get('https://api.polygon.io/v3/reference/tickers?market=crypto&active=true&sort=ticker&order=asc&apiKey=6sEFcNe2upitHW5lt9dp7EfkIuxoR58k');
        $response_stocks = Http::get('https://api.polygon.io/v3/reference/tickers?market=stocks&active=true&sort=ticker&order=asc&apiKey=6sEFcNe2upitHW5lt9dp7EfkIuxoR58k');
        $val_crypto = $response_crypto->json();
        $data_crypto = $val_crypto['results'];
        return $val_crypto;
        $val_stocks = $response_stocks->json();
        $data_stocks = $val_stocks['results'];
        
    }

    public function markets_stocks(Request $request){
        $data = $request->all();
        //return $data;
        for($i=0;$i<count($data);$i++){
            $count = market::where('market',$data[$i]['market'])->count();
            if($count==0){
                $save = new market();
                $save->market = $data[$i]['market'];
                $save->type = $data[$i]['type'];
                $save->abbv = $data[$i]['abbv'];
                $res = $save->save();
                if($res){
                    $val = market::all();
                    {
                        for($k=0;$k<5;$k++){
                            $time = $k+1;
                            $timer = new Timer();
                            $timer->market_id = $val[$i]->id;
                            $timer->timer =(string)$time;// (string)$time;
                            $timer->payout = 1.75;
                            $res_timer = $timer->save();
                        }
                        
                        // $res_timer = $timer->save();
                    }
                }
            }
            else{
                $res = false;
            }
        }
        //$res = market::firstOrCreate(array_values($data));
        
        if($res){
            return response()->json(['response'=>'data has been saved successfully'],200);
        }
        else{
            return response()->json(['message'=>'something went wrong'],400);
        }
    }

    public function selectedmarkets(){
        $data = market::distinct()->select(['id','market','type','abbv'])->with(['payouts'=>function($q){
            $q->distinct()->select(['id','market_id','timer','payout']);
        }])->get();
        return response()->json(['response'=>$data],200);
    }

    public function getmarketbytype(Request $request){
        $data = market::where('type',$request->type)->with(['payouts'=>function($q){
            $q->distinct()->select(['id','market_id','timer','payout']);
        }])->distinct()->select(['id','market','type','abbv'])->where('status',1)->get();
        return response()->json(['response'=>$data],200);
    }

    public function searchmarket(Request $request){
        $val = $request->market;
        $data = market::where('market','like',"{$val}%")->distinct()->select(['id','market','type','abbv'])->get();
        return response()->json(['response'=>$data],200);
    }

    public function get_user_timer(Request $request){
        $market_id = $request->market_id;
        $data = timer::where('market_id',$market_id)->with('markets')->get();
    }

    public function javascript(){
        echo "<script>";
        echo "alert('hello');";
        echo "</script>";
    }

    public function test(){
        return "hello";
    }

    public function master_addtouserwallet(){
        $count_user = Master::where('id',auth()->user()->id)->count();
        switch($count_user){
            case 1:
                $data = new MasterUsertransactionwallet();
                $data->master_id = auth()->user()->id;
                $data->user_id = $request->user_id;
                $data->amount = $request->amount;
                // $data->added_by = auth()->user()->id;
                $res = $data->save();
                
                switch($res){
                    case true:
                    $count = Masteruserfinalwallet::where('master_id',auth()->user()->id)->count();
                    switch($count){
                        case 0:
                            $insertdata = new Masteruserfinalwallet();
                            $insertdata->master_id = auth()->user()->id;
                            $insertdata->user_id = $request->user_id;
                            $insertdata->amount = $request->amount;
                            $insertdata->save();
                            break;
                        default:
                        $amount = Masteruserfinalwallet::where('master_id',auth()->user()->id)->get()[0]->amount;
                        Masteruserfinalwallet::where('master_id',$request->master_id)->update(['amount'=>$amount+$request->amount]);
                        break;
                    }
                    return response()->json(['response'=>'you have successfully added the amount to master wallet'],200);
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
        
    }

    public function getmarkets(Request $request)
    {
        $data = market::where('type',$request->type)->with(['payouts'=>function($q){
            $q->distinct()->select(['id','market_id','timer','payout']);
        }])->distinct()->select(['id','market','type','abbv'])->get();
        return response()->json(['response'=>$data],200);
    }
    
    public function addmarket(Request $request){
        $data = $request->all();
        $count = count($data);
        for($i=0;$i<$count;$i++){
            $addmarket = new MasterMarket();
            $addmarket->master_id = auth()->user()->id;
            $addmarket->market_id = $data[$i]['market_id'];
            $res = $addmarket->save();
        }

        if($res){
            return response()->json(['response'=>'you have successfully added the selected markets']);
        }
    }

    public function master_selectedmarkets(Request $request){
        $type = $request->type;
        $val = [];
        $data = MasterMarket::where('master_id',auth()->user()->id)->with(['master'=>function($q){
            $q->distinct()->select(['id','email']);
        }])->with(['market'=>function($q)use($type){
            $q->where('type',$type)->distinct()->select(['id','market','type','abbv']);
        }])->distinct()->select(['id','master_id','market_id'])->get();
        for($i=0;$i<count($data);$i++){
            if($data[$i]->market!=null){
                array_push($val,$data[$i]);
            }
        }
        return response()->json(['response'=>$val],200);
    }

    public function setpayout(Request $request,$id)
    {
        $data = $request->all();
        return $data;
                for($i=0;$i<count($data);$i++){
                    $count = Mastertimer::where('mastermarket_id',$id)->where('timer',$data[$i]['timer'])->count();
                    if($count==0){
                        $timer = new Mastertimer();
                        $timer->master_id = auth()->user()->id;
                        $timer->mastermarket_id = $id;
                        $timer->timer = $data[$i]['timer'];
                        $timer->payout = $data[$i]['payout'];
                        $res = $timer->save();
                    }
                    else{
                        $res = false;
                    }
                }
                switch($res){
                        case true:
                            return response()->json(['response'=>'data is stored successfully'],200);
                            break;
                        default:
                            return response()->json(['message'=>'something went wrong'],400);
                    }
    }
    
    public function timers($id){
        $data = Timer::where('market_id',$id)->distinct()->select(['id','timer'])->get();
        return response()->json(['response'=>$data],200);
    }

    public function singlepayout_master(Request $request)
    {
        $marketid = $request->marketid;
        $timer = $request->timer;
        $newpayout = $request->newpayout;
        $masterid = auth()->user()->id;
        $status = $request->status;
        $data = Timer::where('market_id',$marketid)->where('timer',$timer)->distinct()->select(['id','timer','payout'])->get();
        if($newpayout<=$data[0]->payout){
            $count = Mastertimer::where('master_id',$masterid)->where('mastermarket_id',$marketid)->where('timer',$timer)->count();
            if($count==0){
                $masterpayout = new Mastertimer;
                $masterpayout->mastermarket_id = $request->marketid;
                $masterpayout->master_id = $masterid;
                $masterpayout->timer = $timer;
                $masterpayout->payout = $newpayout;
                $masterpayout->status = $status;
                $res = $masterpayout->save();
                if($res){
                    return response()->json(['response'=>'success'],200);
                }
                else{
                    return response()->json(['error'=>'something went wrong'],400);
                }
            }
            else{
                $res = Mastertimer::where('master_id',$masterid)->where('mastermarket_id',$marketid)->where('timer',$timer)->update(['payout'=>$newpayout,'status'=>$status]);
                if($res){
                    return response()->json(['response'=>'success'],200);
                }
                else{
                    return response()->json(['error'=>'something went wrong'],400);
                }
            }
        }
        else{
            return response()->json(['error'=>'the new payout cannot exceed the current payout'],400);
        }
        //return response()->json(['response'=>$data],200);
    }

    public function viewtimers_master(Request $request){
        $masterid = auth()->user()->id;
        $marketid = $request->marketid;

        $data = Mastertimer::where('master_id',$masterid)->where('mastermarket_id',$marketid)->with(['mastermarket.market'=>function($q){
            $q->distinct()->select(['id','market','type','abbv']);
        }])
        ->distinct()->select(['id','mastermarket_id','master_id','timer','payout','status'])->get();
        return response()->json(['response'=>$data],200);
    }
    public function viewtimers_master_iframe(Request $request){
        $masterid = auth()->user()->id;
        $marketid = $request->marketid;

        $data = Mastertimer::where('master_id',$masterid)->where('mastermarket_id',$marketid)->where('status',1)->with(['mastermarket.market'=>function($q){
            $q->distinct()->select(['id','market','type','abbv']);
        }])
        ->distinct()->select(['id','mastermarket_id','master_id','timer','payout','status'])->get();
        return response()->json(['response'=>$data],200);
    }
    public function updatestatus(Request $request){
        $id = $request->id;
        $status = $request->status;
        $update = Mastertimer::where('id',$id)->update(['status'=>$status]);

        if($update){
            return response()->json(['response'=>'data updated successfully'],200);
        }
        else{
            return response()->json(['error'=>'something went wrong'],400);
        }
    }

    public function checkmaxpayout(Request $request){
        $marketid = $request->marketid;
        $timer = $request->timer;
        $newpayout = $request->newpayout;
        $masterid = auth()->user()->id;
        $status = $request->status;
        $data = Timer::where('market_id',$marketid)->where('timer',$timer)->distinct()->select(['id','timer','payout'])->get();
        if($newpayout>$data[0]->payout){
            return response()->json(['error'=>'payout is exceeding the max value'],400);
        }
        else{
            return response()->json(['response'=>'ok to proceed'],200);
        }
    }

    public function userbethistory(Request $request){
        $uid = $request->uid;
        $data = masterfinalbet::where('uid',$uid)->get();
        return response()->json(['response'=>$data],200);
    }

    public function masterbethistory(){
        $data = masterfinalbet::where('master_id',auth()->user()->id)->get();
        return response()->json(['response'=>$data],200);
    }

    public function adminbethistory(){
        $data = masterfinalbet::with('master')->with('mastertimer.mastermarket')->get();
        return response()->json(['response'=>$data],200);
    }
}
