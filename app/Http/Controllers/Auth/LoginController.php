<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Setting;
use Illuminate\Http\Request;
use App\Mail\UserVerifyEmail;
use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout', 'verification');
    }

    public function showLoginForm() 
    {
        $setting = Setting::first();
        return view('auth.login', compact('setting'));
    }

    public function login(Request $request)
    {
        //validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //Attempt to log the user in
        if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
            {
                //check user's status
                if(Auth::guard('web')->user()->status == 'Banned') {
                    Auth::guard('web')->logout();
                    return redirect()->back()->withErrors([
                    'message' => 'Your account is banned, Please contact the administration.'
                    ])->withInput($request->only('email', 'remember'));
                }
                //check admin's email verification
                if(Auth::guard('web')->user()->verified == 0) {
                    Auth::guard('web')->logout();
                    return redirect()->back()->withErrors([
                    'message' => 'Your email is not verified.'
                    ])->withInput($request->only('email', 'remember'));
                }
                //redirect to dashboard
                return redirect()->intended(route('dashboard'));
            }

        return redirect()->back()->withErrors([
                    'message' => 'Invalid credentials, Please check your credentials and try again.'
                    ])->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('login');
    }

    public function showRegisterForm() 
    {
        $setting = Setting::first();
        return view('register', compact('setting'));
    }

    public function register(Request $request)
    {
        //validate the form
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required|confirmed|min:8',
            ]);

        //create and save user
        $user = new User;

        $user->name = request('name');
        $user->slug = $user->sluggable(request('name')).'-'.$user->generateToken(5);
        $user->phone = request('phone');
        $user->address = request('address');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->status = 'Active';      

        $user->save();

        //send mail to activate account.
        \Mail::to($user)->send(new UserVerifyEmail($user));
        
        //sign them in
        auth()->login($user);
        
        //redirect to dashboard
        return redirect()->intended(route('dashboard'))->with('success', 'Account registered.');
    }

    /**
     * User Email verification.
     */
    public function verification($token)
    {
        // Auth::guard('web')->logout();
        //fetch user by token
        $user = User::whereToken($token)->first();

        if(!is_null($user)) {
            $user->confirmEmail();
            Auth()->guard('web')->login($user);
            return redirect()->intended(route('dashboard'))->with('success','Your email is verified.');
        } else {
            return redirect('login')->with('error','Email could not be verified, Please try again.');
        }
    }

}
