<?php

namespace App\Http\Controllers\Admin;

use File;
use Image;
use App\SubCategory;
use App\OtherCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OtherCategoryController extends Controller{


    public function __construct(){

        $this->middleware('auth:admin');

    }

    
    public function index(){

        //all categories
        $categories = OtherCategory::join('sub_categories', 'sub_categories.id', '=', 'other_categories.sub_category_id')
            ->select('other_categories.*', 'sub_categories.name AS subcategoryName')
            ->orderBy('order', 'asc')
            ->paginate(10);

        return view('admin.list.othercategory', compact('categories'));

    }

    
    public function create(){

        $categories = SubCategory::where([['status', '=', 'Active']])->get();

        return view('admin.form.othercategory', compact('categories'));

    }

    
    public function store(Request $request){

        //validate the form
        $this->validate(request(), [
                'name' => 'required|unique:sub_categories,name',
                'sub_category_id' => 'numeric',
                'order' => 'required|numeric',
                'status' => 'required',
                'pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

        //create and save r
        $category = new OtherCategory;
        
        $category->sub_category_id = request('sub_category_id');
        $category->name = request('name');
        $category->slug = $category->sluggable(request('name')).'-'.$category->generateToken(5);
        $category->description = request('description');
        $category->order = request('order');
        $category->status = request('status');
        $category->seo_keyword = request('seo_keyword');
        $category->seo_title   = request('seo_title');
        $category->seo_desc    = request('seo_desc');
        $category->created_at = date('Y-m-d H:m:s');
        
        $file = request()->file('pic');

        if($file != null) {

            $image_name = request('name')."-".time()."-".$file->getClientOriginalName();

            // open an image file
            $img = Image::make($file);

            // prevent possible upsizing
            $img->resize(null, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            if(!File::exists('uploads/'.'categories/')) {
                File::makeDirectory('uploads/'.'categories/');
            }

            // save image in desired format
            $img->save('uploads/'.'categories/'.$image_name);
 
            $category->pic = $image_name;        
        }

        $category->save();

        return redirect('/admin/othercategories')->with('success','Other Category created successfully.');

    }


    public function show($id){}

    
    public function edit(OtherCategory $othercategory){   

        $categories = SubCategory::where([['status', '=', 'Active']])->get();

        return view('admin.form.othercategory', compact('othercategory', 'categories'));

    }

    
    public function update(Request $request, $id){

        $category = OtherCategory::find($id);
        
        //validate the form
        $this->validate(request(), [
                'name'            => 'required|unique:sub_categories,name,'.$id,
                'sub_category_id' => 'numeric',
                'order'           => 'required|numeric',
                'status'          => 'required',
                'pic'             => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        
        $data = ([
            'name'        => request('name'),
            'sub_category_id' => request('sub_category_id'),
            'description' => request('description'),
            'order'       => request('order'),
            'status'      => request('status'),
            'seo_keyword' => request('seo_keyword'),
            'seo_title'   => request('seo_title'),
            'seo_desc'    => request('seo_desc'),
            'updated_at'  => date('Y-m-d H:m:s'),
            ]);

        $file = request()->file('pic');

        if($file != null) {

            //deleting previous image
            $this->deleteImage($id, 'No');

            $image_name = request('name')."-".time()."-".$file->getClientOriginalName();

            // open an image file
            $img = Image::make($file);

            // prevent possible upsizing
            $img->resize(null, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if(!File::exists('uploads/'.'categories/')) {
                File::makeDirectory('uploads/'.'categories/');
            }

            $img->save('uploads/'.'categories/'.$image_name);

            $data1 = (['pic' => $image_name]);
            OtherCategory::where('id', $id)->update($data1);
        }

        OtherCategory::where('id', $id)->update($data);

        //redirect to dashboard
        return redirect('/admin/othercategories')->with('success','Other Category updated successfully.');

    }


    public function destroy($id){

        $category = OtherCategory::where('id', $id)->first();

        if(isset($category)){
            $this->deleteImage($category->id, 'No');
            //deleting admin
            $affected = OtherCategory::where('id', $id)->delete();
            return redirect('/admin/othercategories')->with('success','Sub Category deleted successfully.');

        }


        return redirect('/admin/othercategories')->with('error','Sub Category deletion failed.');

    }


    public function deleteImage($id, $flash = 'Yes'){

        $post = OtherCategory::find($id);

        if(isset($post)){

            $pic = $post->pic;
            @unlink('uploads/'.'categories/'.$post->pic);
            
            $data = (['pic' => Null]);
            OtherCategory::where('id', $id)->update($data);

            if($flash == 'Yes'){

                return redirect('/admin/othercategories/'.$post->slug.'/edit')->with('success','Image deletion successful!');

            }

        }

    }
    
}

