<?php

namespace App\Http\Controllers\Admin;

use File;
use Image;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Mail\UserVerifyEmail;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //all users
        $users = User::paginate(10);
        return view('admin.list.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //add new user
        return view('admin.form.user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the form
        $this->validate(request(), [
            'status' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

        //create and save user
        $user = new User;

        $user->status = request('status');
        $user->name = request('name');
        $user->slug = $user->sluggable(request('name')).'-'.$user->generateToken(5);
        $user->phone = request('phone');
        $user->address = request('address');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));

        $file = request()->file('pic');

            $image_name = request('name')."-".time()."-".$file->getClientOriginalName();

            // open an image file
            $img = Image::make($file);

            // resize image instance
            //$img->resize(1920, 1080);

            // prevent possible upsizing
            $img->resize(null, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            //$watermark = Image::make('administrator/img/logow.png');
            //$watermark->opacity(50);
            
            // insert a watermark
            //$img->insert($watermark , 'center', 40, 40);

            if(!File::exists('uploads/'.'users/')) {
                File::makeDirectory('uploads/'.'users/');
            }
            
            // save image in desired format
            $img->save('uploads/'.'users/'.$image_name);
 
            $user->pic = $image_name;        

        $user->save();

        //send mail to activate account.
        \Mail::to($user)->send(new UserVerifyEmail($user));

        //sign them in
        //auth()->login($user);

        //redirect to dashboard
        return redirect('/admin/users')->with('success','User created.');
    }

    /**
     * User Email verification.
     */
    public function verification($token)
    {
        //fetch user by token
        $user = User::whereToken($token)->firstOrFail()->confirmEmail();

        if(!is_null($user)) { 
            return redirect()->intended(route('home'))->with('success','Your email is verified.');
        }
        
        return redirect('login')->with('error','Email could not be verified, Please try again.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // edit user
        return view('admin.form.user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        
        //validate the form
        $this->validate(request(), [

            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'confirmed',
            'pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);


        //validate if there is password
        if (request('password') != null) {
            $pass = (['password' => request('password')]);
            $data = (['password' => bcrypt(request('password'))]);
            User::where('id', $id)->update($data);
        } else {
            $pass = ([]);
        }

        $v = Validator::make($pass, [
            'password' => 'min:8'
        ]);

        if ($v->fails()) {
            return redirect('/admin/profile')
                        ->withErrors($v)
                        ->withInput();
        }
        //validate if there is password
        
        $data = ([
            'name' => request('name'),
            'phone' => request('phone'),
            'address' => request('address'),
            'email' => request('email'),
            'status' => request('status'),

            ]);

        $file = request()->file('pic');

        if($file != null) {

            //deleting previous image
            @unlink('uploads/'.'users/'.$user->pic);

            $image_name = request('name')."-".time()."-".$file->getClientOriginalName();

            // open an image file
            $img = Image::make($file);

            // resize image instance
            //$img->resize(1920, 1080);

            // prevent possible upsizing
            $img->resize(null, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            //$watermark = Image::make('administrator/img/logow.png');
            //$watermark->opacity(50);
            
            // insert a watermark
            //$img->insert($watermark , 'center', 40, 40);

            // save image in desired format
            $img->save('uploads/'.'users/'.$image_name);

            $data = (['pic' => $image_name]);
            User::where('id', $id)->update($data);
        }

        //dd($data);
        User::where('id', $id)->update($data);

        //redirect to dashboard
        return redirect('/admin/user/'.$id.'/edit')->with('success','User updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if(isset($user)) {

            $pic = $user->pic;
            //deleting user
            $affected = User::where('id', $id)->where('id', '=', $user->id)->delete();
            if($affected > 0) {
                //deleting profile image
                @unlink('uploads/'.'users/'.$user->pic);
            }
            return redirect('/admin/users/')->with('success','User deleted.');

        } else {
            //redirect to dashboard
            return redirect('/admin/users/')->with('error','User deletion failed.');
        }
    }
}
