<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use File;
use Image;
use App\Role;
use App\Admin;
use Validator;
use Illuminate\Http\Request;
use App\Mail\AdminVerifyEmail;
use App\Http\Controllers\Controller;

class AdminController extends Controller
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
        //all admins
        $admins = Admin::paginate(10);
        return view('admin.list.admin', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //add new admin
        return view('admin.form.admin');
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

            //'role' => 'required',
            'status' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|min:8',
            'pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ]);

        //create and save admin
        $admin = new Admin;

        //$user->role = request('role');
        $admin->status = request('status');
        $admin->name = request('name');
        $admin->email = request('email');
        $admin->password = bcrypt(request('password'));
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

            if(!File::exists('uploads/'.'admins/')) {
                File::makeDirectory('uploads/'.'admins/');
            }
            
            // save image in desired format
            $img->save('uploads/'.'admins/'.$image_name);
 
            $admin->pic = $image_name;        

        $admin->save();

        //send mail to activate account.
        \Mail::to($admin)->send(new AdminVerifyEmail($admin));

        //redirect to dashboard
        return redirect('/admin/admins')->with('success','Admin created.');
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
    public function edit(Admin $admin)
    {
        // edit admin
        return view('admin.form.admin', compact('admin'));
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
        $admin = Admin::find($id);
        
        //validate the form
        $this->validate(request(), [

            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
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
            return redirect('/admin/profile')
                        ->withErrors($v)
                        ->withInput();
        }
        //validate if there is password
        
        $data = ([
            'name' => request('name'),
            'email' => request('email'),
            'status' => request('status'),

            ]);

        $file = request()->file('pic');

        if($file != null) {

            //deleting previous image
            @unlink('uploads/'.'admins/'.$admin->pic);

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
            $img->save('uploads/'.'admins/'.$image_name);

            $data = (['pic' => $image_name]);
            Admin::where('id', $id)->update($data);
        }

        //dd($data);
        Admin::where('id', $id)->update($data);

        //redirect to dashboard
        return redirect('/admin/admin/'.$id.'/edit')->with('success','Admin updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(Auth::guard('admin')->user()->id == $id) 
            {
                return redirect('/admin/admins/')->with('error','Cannot delete a Logged In admin.');
            }

        $admin = Admin::find($id);

        if(isset($admin)) 
            {
                $pic = $admin->pic;
                //deleting admin
                $affected = Admin::where('id', $id)->where('id', '=', $admin->id)->delete();
                if($affected > 0) {
                    //deleting profile image
                    @unlink('uploads/'.'admins/'.$admin->pic);
                }
                return redirect('/admin/admins/')->with('success','Admin deleted.');

            }

        return redirect('/admin/admins/')->with('error','Admin deletion failed.');
    }

    public function assign(Admin $admin)
    {
        $roles = Role::get();

        $assigned = $admin->roles;

        return view('admin.form.assign-roles', compact('admin', 'roles', 'assigned'));
    }

    public function assignRoles(Request $request, $id)
    {

        //validate the form
        $this->validate(request(), [

            'roles' => 'required'

            ]);

        $admin = Admin::findOrFail($id);

        //delete all existing roles of this admin
        DB::table('admin_role')->where('admin_id', '=', $id)->delete();

        $roles = request('roles');

        //dd($admin->roles);

        //assign roles to this admin
        foreach ($roles as $role) {
            $r = Role::whereName($role)->first();
            $admin->roles()->save($r);
        }

        return redirect('/admin/admin/'.$id.'/assign')->with('success','Role assigned.');

    }
}
