<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;
use File;
use Image;


class BlogController extends Controller{

    public function __construct(){
        $this->middleware("auth:admin");
    }


    public function blogList(){
        
        $data['blogs'] = Blog::latest()->paginate(10);
        
        return view("admin.list.blog", compact(['data']));

    }


    public function addBlog(){
        return view("admin.form.blog");
    }


    public function addBlogProcess(Request $request){

        $this->validate($request, [
            "name" => "required|unique:blogs|max:191",
            "pics" => "required|image|mimes:jpg,jpeg,png,gif|max:10240",
            "desc" => "required",
            "status" => "required|max:191"
        ]);

        try{

            $data = array(
                "name"        => $request->name,
                "permalink"   => $this->sluggable($request->name),
                "description" => $request->desc,
                "status"      => $request->status,
                "seo_title"   => $request->seo_title,
                "seo_keywords"    => $request->seo_keywords,
                "seo_description" => $request->seo_desc,
                "created_at"      => date('Y-m-d H:i:s')
            );

            $file = $request->file('pics');

			if($file != NULL):

				$ext  = $file->extension();
				$pics = Image::make($file);
				$pics->widen(800);

				if(!File::exists('uploads/blog')){ File::makeDirectory('uploads/blog'); }

				$data['pics'] = 'blog_pics_'.md5(time()).'_'.md5(time()+1).'.'.$ext;
	            $pics->save('uploads/blog/'.$data['pics']);

			endif;

	        Blog::insert($data);

			$request->session()->flash('success', 'Blog Created Successfully ! ! ! !');
			return redirect()->route('admin.blogList');

        }catch(\Exception $e){

            $request->session()->flash("error", "Something Went Wrong, Try Again ! ! !");

            return redirect()->back()->withInput($request->all());

        }

    }


    public function editBlog(Blog $id){

        $data['blog'] = $id;

        return view("admin.form.blog", compact(['data']));

    }


    public function editBlogProcess(Request $request, Blog $id){

        $this->validate($request, [
			"name"    => "required|max:191|unique:blogs,name,".$id->id,
			"pics"    => "image|mimes:jpg,jpeg,png,gif|max:10240",
			"desc"    => "",
			"status"  => "required|max:191"
        ]);

        try{

            $id->name        = $request->name;
            $id->permalink   = $this->sluggable($request->name);
			$id->description = $request->desc;
			$id->status      = $request->status;
			$id->seo_title   = $request->seo_title;
			$id->seo_keywords    = $request->seo_keywords;
			$id->seo_description = $request->seo_desc;
			$id->updated_at      = date('Y-m-d H:i:s');

			$file = $request->file('pics');

			if($file != NULL):

				if(!File::exists('uploads/blog')){ File::makeDirectory('uploads/blog'); }
				$path = "uploads/blog/".$id->pics;

				$ext  = $file->extension();
				$pics = Image::make($file);
				$pics->widen(800);

				$id->pics = 'blog_pics_'.md5(time()).'_'.md5(time()+1).'.'.$ext;
	            $pics->save('uploads/blog/'.$id->pics);

	            @unlink($path);

			endif;

	        $id->update();

			$request->session()->flash('success', 'Blog Updated Successfully ! ! !');
			return redirect()->route('admin.blogList');

		}catch(\Exception $e){

			$request->session()->flash('error', 'Something Went Wrong, Try Again ! ! !');
			return redirect()->back()->withInput($request->all());

		}
        
    }


    public function deleteBlog(Request $request){

        $id = trim($request->id);

        try{

            $blog = Blog::find($id);
            $path = "uploads/blog/".$blog->pics;
            $blog->delete();

            @unlink($path);

            $request->session()->flash('success', 'Blog Deleted Successfully ! ! !');
			return redirect()->route('admin.blogList');

        }catch(\Exception $e){

            $request->session()->flash('error', 'Something Went Wrong, Try Again ! ! !');
			return redirect()->route('admin.blogList');

        }

    }

    
}
