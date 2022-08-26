<?php

namespace App\Http\Controllers\Admin;

use File;
use Image;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller{

    
    public function __construct(){

        $this->middleware('auth:admin');

    }

    
    public function index(){

        //all categories
        $categories = Category::orderBy('order', 'asc')->paginate(10);

        return view('admin.list.category', compact('categories'));

    }

    
    public function create(){

        ///add new category
        return view('admin.form.category');

    }


    public function store(Request $request){

        //validate the form
        $this->validate(request(), [

            'name' => 'required|unique:categories,name',
            'order' => 'required|numeric',
            'status' => 'required',
            'pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        //create and save r
        $category = new Category;
        
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
            
            
            if(!File::exists('uploads/'.'categories/')) {
                File::makeDirectory('uploads/'.'categories/');
            }

            // save image in desired format
            $img->save('uploads/'.'categories/'.$image_name);
 
            $category->pic = $image_name;        
        }

        $category->save();

        //redirect to dashboard
        return redirect('/admin/categories')->with('success','Category created successfully.');

    }


    public function show($id){}

    

    public function edit(Category $category){   

        // edit category
        return view('admin.form.category', compact('category'));

    }

    

    public function update(Request $request, $id){

        $category = Category::find($id);
        
        //validate the form
        $this->validate(request(), [

            'name' => 'required|unique:categories,name,'.$id,
            'order' => 'required|numeric',
            'status' => 'required',
            'pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ]);
        
        $data = ([
                'name'        => request('name'),
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
            Category::where('id', $id)->update($data1);
        }

        //dd($data);
        Category::where('id', $id)->update($data);

        //redirect to dashboard
        return redirect('/admin/categories/')->with('success','Category updated successfully.');
    }


    public function destroy($id){

        $category = Category::where('id', $id)->first();

        // dd($page->id);
        if(isset($category)){

            $this->deleteImage($category->id, 'No');
            //deleting admin
            $affected = Category::where('id', $id)->delete();
            return redirect('/admin/categories/')->with('success','Category deleted successfully.');

        }

        return redirect('/admin/categories/')->with('error','Category deletion failed.');

    }


    public function deleteImage($id, $flash = 'Yes'){

        $post = Category::find($id);

        if(isset($post)){

            $pic = $post->pic;
            @unlink('uploads/'.'categories/'.$post->pic);
            
            $data = (['pic' => Null]);
            Category::where('id', $id)->update($data);

            if($flash == 'Yes') {
                return redirect('/admin/category/edit/'.$post->slug)->with('success','Image deletion successful!');
            }

        }

    }


}
