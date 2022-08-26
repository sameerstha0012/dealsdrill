<?php

namespace App\Http\Controllers\Admin;

use File;
use Image;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
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
        $settings = Setting::orderBy('id', 'desc')->get();

        if(count($settings) > 0) {
            return redirect('/admin/setting/1/edit');
        }
        ///add new setting
        return view('admin.form.setting', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Setting::orderBy('id', 'desc')->get();

        if(count($settings) > 0) {
            return redirect('/admin/setting/1/edit');
        }
        ///add new setting
        return view('admin.form.setting');
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
                'title' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
            ]);

        //create and save setting
        $setting = new Setting;
        
        $setting->title       = request('title');
        $setting->email       = request('email');
        $setting->phone       = request('phone');
        $setting->address     = request('address');
        $setting->seo_keyword = request('seo_keyword');
        $setting->seo_title   = request('seo_title');
        $setting->seo_desc    = request('seo_desc');
        $setting->created_at  = date('Y-m-d H:m:s');
        
        $file = request()->file('pic');

        if($file != null) {

            $image_name = request('title')."-".time()."-".$file->getClientOriginalName();

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
            
            if(!File::exists('uploads/'.'settings/')) {
                File::makeDirectory('uploads/'.'settings/');
            }

            // save image in desired format
            $img->save('uploads/'.'settings/'.$image_name);
 
            $setting->pic = $image_name;        
        }

        $setting->save();

        //redirect to dashboard
        return redirect('/admin/setting/1/edit')->with('success','Setting created.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {   
        // edit trekkings
        return view('admin.form.setting', compact('setting'));
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
        $setting = Setting::find($id);
        
        //validate the form
        $this->validate(request(), [

            'title' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',

            ]);

        $data = ([
                'title'       => request('title'),
                'email'       => request('email'),
                'phone'       => request('phone'),
                'address'     => request('address'),
                'seo_keyword' => request('seo_keyword'),
                'seo_title'   => request('seo_title'),
                'seo_desc'    => request('seo_desc'),
                'updated_at'  => date('Y-m-d H:m:s'),
            ]);

        $file = request()->file('pic');

        if($file != null) {

            //deleting previous image
            $this->deleteImage($id, 'No');

            $image_name = request('title')."-".time()."-".$file->getClientOriginalName();

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

            if(!File::exists('uploads/'.'settings/')) {
                File::makeDirectory('uploads/'.'settings/');
            }

            $img->save('uploads/'.'settings/'.$image_name);

            $data1 = (['pic' => $image_name]);
            Setting::where('id', $id)->update($data1);
        }

        //dd($data);
        Setting::where('id', $id)->update($data);

        //redirect to dashboard
        return redirect('/admin/setting/'.$id.'/edit')->with('success','Setting updated.');
    }

    public function deleteImage($id, $flash = 'Yes')
    {
        $post = Setting::find($id);
        if(isset($post))
        {
            $pic = $post->pic;
            @unlink('uploads/'.'settings/'.$post->pic);
            
            $data = (['pic' => Null]);
            Setting::where('id', $id)->update($data);

            if($flash == 'Yes') {
                return redirect('/admin/setting/'.$id. 'edit')->with('success','Image deleted!');
            }
        }
    }
}
