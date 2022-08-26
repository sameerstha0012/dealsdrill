<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Advertise;
use Auth;
use Image;
use File;


class AdvertiseController extends Controller{

    
	public function __construct(){

		$this->middleware('auth:admin');

	}


	public function advertiseList(){

		$advertise = Advertise::orderBy('id', 'DESC')
								->orderBy('status', 'Active')->paginate(10);

		return view('admin.list.advertise', compact(['advertise']));

	}


	public function addAdvertise(){

		return view('admin.form.advertise');

	}


	public function addAdvertiseProcess(Request $request){

		$this->validate(request(), [
            'title'  => 'required',
            'pic'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link'   => 'required|max:191',
            'type'   => 'required|max:191',
            'status' => 'max:191',
            'order'  => 'numeric|min:0,max:9999999999',
        ]);
            
        $data = array(
                "title" => request('title'),
                "link"  => request('link'),
                "type"  => request('type'),
                "status" => request('status'),
                "order" => request('order'),
                "created_at" => date('Y-m-d H:m:s'),
            );


        $file = request()->file('pic');

        if($file != null) {

            $img = Image::make($file);
            $ext = $file->extension();

            $pic = time()."-".time().".".$ext;

            if(!File::exists('uploads/advertise/')):
                File::makeDirectory('uploads/advertise/');
            endif;

            // save image in desired format
            $img->save('uploads/advertise/'.$pic);
 
            $data['pic'] = $pic;        
        }

        Advertise::insert($data);

        return redirect()->route('admin.advertiseList')->with('success','Advertise Added successfully.');

	}


	public function editAdvertise(Request $request, $id){

		$advertise = Advertise::where('id', $id)->get();

		if(count($advertise) > 0):

			$advertise = Advertise::find($id);
			return view('admin.form.advertise', compact(['advertise']));

		else:

			$request->session()->flash('success', 'Invalid Advertise ! ! ! ! !');
			return redirect()->route('admin.advertiseList');

		endif;

	}


	public function editAdvertiseProcess(Request $request, $id){

		$this->validate(request(), [
            'title'  => 'required',
            'pic'    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link'   => 'required|max:191',
            'type'   => 'required|max:191',
            'status' => 'max:191',
            'order'  => 'numeric|min:0,max:9999999999',
        ]);

        $advertise = Advertise::find($id);
        
        $advertise->title      = request('title');
        $advertise->link       = request('link');
        $advertise->type       = request('type');
        $advertise->status     = request('status');
        $advertise->order      = request('order');
        $advertise->updated_at = date('Y-m-d H:m:s');
        
        $file = request()->file('pic');

        if($file != null) {

            $img = Image::make($file);
            $ext = $file->extension();

            $pic = time()."-".time().".".$ext;

            if(!File::exists('uploads/advertise/')):
                File::makeDirectory('uploads/advertise/');
            endif;

            $url = "uploads/advertise/".$advertise->pic;
			@unlink($url);

            // save image in desired format
            $img->save('uploads/advertise/'.$pic);
 
            $advertise->pic = $pic;        
        }

        $advertise->update();

        return redirect()->route('admin.advertiseList')->with('success','Advertise Updated successfully.');

	}


	public function deleteAdvertise(Request $request, $id){

		$advertise = Advertise::where('id', $id)->get();

		if(count($advertise) > 0):

			$url = "uploads/advertise/".$advertise[0]->pic;
			@unlink($url);

			Advertise::where('id', $id)->delete();

			$request->session()->flash('success', 'Successfully Deleted Advertise ! ! ! !');
			return redirect()->route('admin.advertiseList');
			
		endif;

		$request->session()->flash('success', 'Invalid Advertise ! ! ! !');
		return redirect()->route('admin.advertiseList');

	}



}
