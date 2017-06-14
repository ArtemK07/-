<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $redirectAfterLogout = '/login';


    public function redirectProvider($provider)
    {
        return Socialite::driver($provider)->redirect();

    }

    public function callback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreate($user,$provider);
        Auth::guard($this->getGuard())->login($authUser,true);
        return redirect($this->redirectTo);
    }


    public function findOrCreate($user,$provider){
        $authUser = User::where('provider_id',$user->id)->first();
        if($authUser){
           return $authUser;
        }

        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }


    public function stepOne(Request $request)
    {
        $email = $request->input('email');
        if (!empty($email)) {
            $request->flashOnly(['email']);

            $validator = Validator::make(['email' => $email],
                ['email' => 'required|email|max:255',
                ]);
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            } else
                return view('auth/step2');
        } else {
            return view('auth/step1');
        }
    }


    public function stepTwo(Request $request)
    {
        $this->middleware('emailvalidated');
        $request['email'] = $request->old('email');
        $this->register($request);
    }


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'email',
            'password' => 'required|min:6',

        ]);
    }


    public function exitUser()
    {
        return 'x';
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),

        ]);
    }
}
