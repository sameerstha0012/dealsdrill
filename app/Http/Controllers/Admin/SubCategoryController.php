<?php

namespace App\Http\Controllers\Admin;

use File;
use Image;
use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller{


    public function __construct(){

        $this->middleware('auth:admin');

    }


    public function index(){

        //all categories
        $categories = SubCategory::join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->select('sub_categories.*', 'categories.name AS categoryName')
            ->orderBy('order', 'asc')
            ->paginate(10);

        return view('admin.list.subcategory', compact('categories'));

    }

    
    public function create(){

        $categories = Category::where([['status', '=', 'Active']])->get();

        return view('admin.form.subcategory', compact('categories'));

    }

   
    public function store(Request $request){

        //validate the form
        $this->validate(request(), [
                'name'        => 'required|unique:sub_categories,name',
                'category_id' => 'numeric',
                'order'       => 'required|numeric',
                'status'      => 'required',
                'pic'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

        //create and save r
        $category = new SubCategory;
        
        $category->category_id = request('category_id');
        $category->name        = request('name');
        $category->slug        = $category->sluggable(request('name')).'-'.$category->generateToken(5);
        $category->description = request('description');
        $category->order       = request('order');
        $category->status      = request('status');
        $category->seo_keyword = request('seo_keyword');
        $category->seo_title   = request('seo_title');
        $category->seo_desc    = request('seo_desc');
        $category->created_at  = date('Y-m-d H:m:s');
        
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
            
            if(!File::exists('uploads/'.'categories/')){
                File::makeDirectory('uploads/'.'categories/');
            }

            // save image in desired format
            $img->save('uploads/'.'categories/'.$image_name);
 
            $category->pic = $image_name;        
        }

        $category->save();

        return redirect('/admin/subcategories')->with('success','Sub Category created successfully.');

    }

    
    public function show($id){}

    
    public function edit(SubCategory $subcategory){ 

        $categories = Category::where([['status', '=', 'Active']])->get();

        return view('admin.form.subcategory', compact('subcategory', 'categories'));

    }

    
    public function update(Request $request, $id){

        $category = SubCategory::find($id);
        
        //validate the form
        $this->validate(request(), [
                'name' => 'required|unique:sub_categories,name,'.$id,
                'category_id' => 'numeric',
                'order' => 'required|numeric',
                'status' => 'required',
                'pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        
        $data = ([
                    'name'        => request('name'),
                    'category_id' => request('category_id'),
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
            
            if(!File::exists('uploads/'.'categories/')){
                File::makeDirectory('uploads/'.'categories/');
            }

            $img->save('uploads/'.'categories/'.$image_name);

            $data1 = (['pic' => $image_name]);
            SubCategory::where('id', $id)->update($data1);
        }

        SubCategory::where('id', $id)->update($data);

        return redirect('/admin/subcategories')->with('success','Sub Category updated successfully.');

    }

    
    public function destroy($id){

        $category = SubCategory::where('id', $id)->first();

        if(isset($category)){
            $this->deleteImage($category->id, 'No');
            //deleting admin
            $affected = SubCategory::where('id', $id)->delete();
            return redirect('/admin/subcategories')->with('success','Sub Category deleted successfully.');
        }


        return redirect('/admin/subcategories')->with('error','Sub Category deletion failed.');

    }


    public function deleteImage($id, $flash = 'Yes'){

        $post = SubCategory::find($id);

        if(isset($post)){

            $pic = $post->pic;
            @unlink('uploads/'.'categories/'.$post->pic);
            
            $data = (['pic' => Null]);
            SubCategory::where('id', $id)->update($data);

            if($flash == 'Yes'){
                return redirect('/admin/subcategories/'.$post->slug.'/edit')->with('success','Image deletion successful!');
            }

        }

    }
    
}
