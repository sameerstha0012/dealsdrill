<?php

namespace App\Http\Controllers\Admin\Auth;

use File;
use Auth;
use Image;
use App\Admin;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout', 'edit', 'update');
    }

    public function showLoginForm() 
    {
        return view('admin.auth.admin-login');
    }

    public function login(Request $request)
    {
        //validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //Attempt to log the admin in
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
            {
                //check admin's status
                if(Auth::guard('admin')->user()->status == 'Banned') {
                    Auth::guard('admin')->logout();
                    return redirect()->back()->withErrors([
                    'message' => 'Your account is banned, Please contact the administration.'
                    ])->withInput($request->only('email', 'remember'));
                }
                //check admin's email verification
                if(Auth::guard('admin')->user()->verified == 0) {
                    Auth::guard('admin')->logout();
                    return redirect()->back()->withErrors([
                    'message' => 'Your email is not verified.'
                    ])->withInput($request->only('email', 'remember'));
                }
                //redirect to dashboard
                return redirect()->intended(route('admin.dashboard'));
            }

        return redirect()->back()->withErrors([
                    'message' => 'Invalid credentials, Please check your credentials and try again.'
                    ])->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('admin/login');
    }


    /**
     * Admin Email verification.
     */
    public function verification($token)
    {
        //fetch admin by token
        $admin = Admin::whereToken($token)->first();
        //dd($admin);

        if(!is_null($admin)) {
            $admin->confirmEmail();
            Auth()->guard('admin')->login($admin);
            return redirect()->intended(route('admin.dashboard'))->with('success','Your email is verified.');
        } else {
            return redirect('admin/login')->with('error','Email could not be verified, Please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //edit logged in admin's profile
        return view('admin.pages.profile');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //loggedin Admin
        $admin = auth()->guard('admin')->user();
        $id = $admin->id;
        
        //validate the form
        $this->validate(request(), [

            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'confirmed',
            'pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);


        //validate if there is password
        if (request('password') != null) {
            $pass = (['password' => request('password')]);
            $data = (['password' => bcrypt(request('password'))]);
            Admin::where('id', $id)->update($data);
        } else {
            $pass = ([]);
        }

        $v = Validator::make($pass, [
            'password' => 'min:8'
        ]);

        if ($v->fails()) {
            return redirect('admin/profile')->withErrors($v);
        }
        //validate if there is password

        $data = ([
            'name' => request('name'),
            'email' => request('email'),

            ]);

        $file = request()->file('pic');

        if($file != null) {

            //deleting previous image
            @unlink('uploads/'.'admins/'.$admin->pic);

            $image_name = request('name')."-".time()."-".$file->getClientOriginalName();

            // open an image file
            $img = Image::make($file);

            // prevent possible upsizing
            $img->resize(null, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if(!File::exists('uploads/'.'admins/')) {
                File::makeDirectory('uploads/'.'admins/');
            }
            
            // save image in desired format
            $img->save('uploads/'.'admins/'.$image_name);
            //$img->save(storage_path().'/admins/'.$image_name);

            $data = (['pic' => $image_name]);
            Admin::where('id', $id)->update($data);
        }

        Admin::where('id', $id)->update($data);

        //redirect to dashboard
        return redirect('admin/profile')->with('success','Profile updated.');

    }
}
