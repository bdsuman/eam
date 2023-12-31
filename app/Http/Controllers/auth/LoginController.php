<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallBack(){
        $user = Socialite::driver('google')->user();
 
        // $user->token
        $this->_registerOrLoginUser($user);
        if('admin'==Auth::user()->user_type){
            return redirect()->route('home.admin');
        }else if('employee'==Auth::user()->user_type){
            return redirect()->route('home.employee');
        }else{
            return redirect()->route('blank');
        }
       
    }

    protected function _registerOrLoginUser($data){
        $user = User::Where('email','=',$data->email)->first();
        if(!$user){
            $user= new User();
            $user->name= $data->name;
            $user->email= $data->email;
            $user->provider_id= $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }
        Auth::login($user);
        
    }
}
