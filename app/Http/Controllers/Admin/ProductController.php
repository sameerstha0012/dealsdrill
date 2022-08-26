<?php

namespace App\Http\Controllers\Admin;

use File;
use Image;
use App\User;
use App\Product;
use App\Category;
use App\SubCategory;
use App\OtherCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller{

    public function __construct(){

        $this->middleware('auth:admin');

    }


    public function index(){

        $products = Product::join('categories', 'categories.id', '=', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->join('other_categories', 'other_categories.id', '=', 'products.other_category_id', 'left')
            ->select('products.*', 'categories.name As categoryName', 'sub_categories.name As subCategory', 
                'other_categories.name As otherCategory')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.list.product', compact('products'));

    }

    
    public function create(){

        $categories = Category::where([['status', '=', 'Active']])->get();
        $sellers = User::where([['status', '=', 'Active']])->get();

        return view('admin.form.product', compact('categories', 'sellers'));

    }


    public function store(Request $request){
        
        $this->validate(request(), [

            'category_id'     => 'required',
            'sub_category_id' => 'required',
            'user_id'         => 'required',
            'name'            => 'required',
            'price'           => '',
            'status'          => 'required',
            'pic'             => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        //create and save vehicle
        $product = new Product;
        
        $product->category_id       = request('category_id');
        $product->sub_category_id   = request('sub_category_id');
        $product->other_category_id = request('other_category_id');
        $product->user_id           = request('user_id');
        $product->ads_id            = $product->generateToken(5);
        $product->name              = request('name');
        $product->slug              = $product->sluggable($product->name).'-'.$product->generateToken(3);
        $product->features          = request('features');
        $product->price             = request('price');
        $product->price_negotiable  = request('price_negotiable');
        $product->condition         = request('condition');
        $product->user_for          = request('user_for');
        $product->delivery          = request('delivery');
        $product->delivery_area     = request('delivery_area');
        $product->status            = request('status');
        $product->featured          = request('featured');
        $product->expiry_date       = date('Y-m-d', strtotime('1 months'));
        $product->seo_keyword      = request('seo_keyword');
        $product->seo_title        = request('name');
        $product->seo_desc         = request('seo_desc');
        $product->created_at        = date('Y-m-d H:m:s');

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
            
            if(!File::exists('uploads/'.'products/')) {
                File::makeDirectory('uploads/'.'products/');
            }

            // save image in desired format
            $img->save('uploads/'.'products/'.$image_name);
 
            $product->pic = $image_name;        
        }

        $product->save();

        //redirect to dashboard
        return redirect('/admin/products')->with('success','Product added successfully.');

    }


    public function show($id){}

    
    public function edit(Product $product){

        $categories = Category::where([['status', '=', 'Active']])->get();
        $sellers = User::where([['status', '=', 'Active']])->get();
        $subcategory = SubCategory::where([['category_id', '=', $product->category_id]])->get();
        $othercategory = OtherCategory::where([['sub_category_id', '=', $product->sub_category_id]])->get();

        return view('admin.form.product', compact('product', 'categories', 'subcategory', 'othercategory', 'sellers'));

    }

    
    public function update(Request $request, $id){

        $product = Product::find($id);
        
        $this->validate(request(), [

        'category_id'     => 'required',
        'sub_category_id' => 'required',
        'user_id'         => 'required',
        'name'            => 'required',
        'price'           => '',
        'status'          => 'required',
        'pic'             => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        $data = ([
            'category_id'       => request('category_id'),
            'sub_category_id'   => request('sub_category_id'),
            'other_category_id' => request('other_category_id'),
            'user_id'           => request('user_id'),
            'name'              => request('name'),
            'features'          => request('features'),
            'price'             => request('price'),
            'price_negotiable'  => request('price_negotiable'),
            'condition'         => request('condition'),
            'user_for'          => request('user_for'),
            'delivery'          => request('delivery'),
            'delivery_area'     => request('delivery_area'),
            'status'            => request('status'),
            'featured'          => request('featured'),
            'seo_keyword'       => request('seo_keyword'),
            'seo_title'         => request('name'),
            'seo_desc'          => request('seo_desc'),
            'updated_at'        => date('Y-m-d H:m:s'),
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
            
            if(!File::exists('uploads/'.'products/')) {
                File::makeDirectory('uploads/'.'products/');
            }

            $img->save('uploads/'.'products/'.$image_name);

            $data1 = (['pic' => $image_name]);
            Product::where('id', $id)->update($data1);
        }

        Product::where('id', $id)->update($data);

        return redirect('/admin/products/')->with('success','Product updated successfully.');
    }

    
    public function destroy($id){

        $product = Product::where('id', $id)->first();

        if(isset($product)) {

            $this->deleteImage($product->id, 'No');
            $affected = Product::where('id', $id)->delete();
            return redirect('/admin/products/')->with('success','Product deleted successfully.');

        }

        return redirect('/admin/products/')->with('error','Product deletion failed.');

    }


    public function deleteImage($id, $flash = 'Yes'){

        $post = Product::find($id);

        if(isset($post)){

            $pic = $post->pic;
            @unlink('uploads/'.'products/'.$post->pic);

            $data = (['pic' => Null]);
            Product::where('id', $id)->update($data);

            if($flash == 'Yes') {
                return redirect('/admin/product/'.$post->id.'/edit')->with('success','Image deletion successful!');
            }

        }
    }


    public function subcategory(Request $request){

        $category = request('category');
        $subcategory = SubCategory::select('id', 'name')->where([['category_id', '=', $category]])->get();

        if($category > 0 && ($subcategory != null)){

            $arr = array('success' => $subcategory);
            echo json_encode($arr);

        }else{

            $mgs = 'No sub category found.';
            $arr = array('error' => $mgs);
            echo json_encode($arr);

        }
    }


    public function othercategory(Request $request){

        $category = request('category');
        $othercategory = OtherCategory::select('id', 'name')->where([['sub_category_id', '=', $category]])->get();

        if($category > 0 && ($othercategory != null)){

            $arr = array('success' => $othercategory);
            echo json_encode($arr);

        }else{

            $mgs = 'No other category found.';
            $arr = array('error' => $mgs);
            echo json_encode($arr);
        }

    }


    public function addGallery(){

        $image = $request->file('file');
        $imageName = time().$image->getClientOriginalName();
        $upload_success = $image->move(public_path('images'),$imageName);
        
        if ($upload_success){

            return response()->json($upload_success, 200);

        }else{

            return response()->json('error', 400);

        }

    }


    public function changeProductFeatured(Request $request){

        $id = trim($request->id);
		$value = trim($request->value);

		try{

           	$value = ($value == 'true')?'Yes':'No';

            $product = Product::where('id', $id)->update(['featured' => $value]);

            return response()->json([
                "success" => true,
                "message" => "Product Featured Changed Successfully ! ! !"
            ]);

        }catch(\Exception $e){

            return response()->json([
                "success" => false,
                "message" => "Something Went Wrong, Try Again ! ! !"
            ]);

        }

    }


}
