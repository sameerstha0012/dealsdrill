<?php

namespace App\Http\Controllers\Admin;

use File;
use Image;
use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
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
        //all pages
        $pages = Page::join('pages As menu', 'pages.parent', '=', 'menu.id', 'left')
            ->select('pages.*', 'menu.name AS parentMenu')
            ->orderBy('order', 'asc')
            ->paginate(10);

        return view('admin.list.page', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Page::where([['parent', '=', 0],])->get();

        return view('admin.form.page', compact('menus'));
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

            'name' => 'required',
            'template' => 'required',
            'parent' => 'numeric',
            'order' => 'required|numeric',
            'status' => 'required',
            'pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ]);

        //create and save vehicle
        $page = new Page;
        
        $page->parent = request('parent');
        $page->name = request('name');
        $page->slug = $page->sluggable($page->name);
        $page->template = request('template');
        $page->description = request('description');
        $page->order = request('order');
        $page->status = request('status');
        $page->seo_keyword = request('seo_keyword');
        $page->seo_title   = request('seo_title');
        $page->seo_desc    = request('seo_desc');
        $page->created_at = date('Y-m-d H:m:s');
        
        $file = request()->file('pic');

        if($file != null) {

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
            
            if(!File::exists('uploads/'.'pages/')) {
                File::makeDirectory('uploads/'.'pages/');
            }

            // save image in desired format
            $img->save('uploads/'.'pages/'.$image_name);
 
            $page->pic = $image_name;        
        }

        $page->save();

        //redirect to dashboard
        return redirect('/admin/pages')->with('success','Page created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {   
        $menus = Page::where('id', '=', 0)->orWhere('id', '<>', $page->id)->get();

        // edit state
        return view('admin.form.page', compact('page', 'menus'));
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
        $page = Page::find($id);
        
        //validate the form
        $this->validate(request(), [

            'name' => 'required',
            'template' => 'required',
            'parent' => 'numeric',
            'order' => 'required|numeric',
            'status' => 'required',
            'pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ]);
        
        $data = ([
            'name' => request('name'),
            'slug' => $page->sluggable(request('name')),
            'template' => request('template'),
            'parent' => request('parent'),
            'description' => request('description'),
            'order' => request('order'),
            'status' => request('status'),
            'seo_keyword' => request('seo_keyword'),
            'seo_title'   => request('seo_title'),
            'seo_desc'    => request('seo_desc'),
            'updated_at' => date('Y-m-d H:m:s'),
            ]);

        $file = request()->file('pic');

        if($file != null) {

            //deleting previous image
            $this->deleteImage($id, 'No');

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

            if(!File::exists('uploads/'.'pages/')) {
                File::makeDirectory('uploads/'.'pages/');
            }

            $img->save('uploads/'.'pages/'.$image_name);

            $data1 = (['pic' => $image_name]);
            Page::where('id', $id)->update($data1);
        }

        //dd($data);
        Page::where('id', $id)->update($data);

        //redirect to dashboard
        return redirect('/admin/pages/')->with('success','Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::where('id', $id)->first();

        // dd($page->id);
        if(isset($page)) 
            {
                $this->deleteImage($page->id, 'No');
                //deleting admin
                $affected = Page::where('id', $id)->delete();
                return redirect('/admin/pages/')->with('success','Page deleted successfully.');

            }

        return redirect('/admin/pages/')->with('error','Page deletion failed.');
    }

    public function deleteImage($id, $flash = 'Yes')
    {
        $post = Page::find($id);
        if(isset($post))
        {
            $pic = $post->pic;
            @unlink('uploads/'.'pages/'.$post->pic);
            
            $data = (['pic' => Null]);
            Page::where('id', $id)->update($data);

            if($flash == 'Yes') {
                return redirect('/admin/page/edit/'.$post->slug)->with('success','Image deletion successful!');
            }
        }
    }
}
