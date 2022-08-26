<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Image;
use App\User;
use Validator;
use App\Gallery;
use App\Setting;
use App\Product;
use App\Category;
use App\SubCategory;
use App\OtherCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller{
    
    
    public function __construct(){
        $this->middleware('auth:web');
    }


    public function index(){
        
        $setting = Setting::first();
        $seller = Auth::guard('web')->user();

        $total = $seller->products()
            ->join('users', 'products.user_id', '=', 'users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->select('products.id')
            ->orderBy('products.created_at', 'DESC')->count();

        $onsale = $seller->products()
            ->join('users', 'products.user_id', '=', 'users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->select('products.id')
            ->where([['products.status', '=', 'Available']])
            ->where([['products.expiry_date', '>=', date('Y-m-d')]])
            ->orderBy('products.created_at', 'DESC')->count();

        $sold = $seller->products()
            ->join('users', 'products.user_id', '=', 'users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->select('products.id')
            ->where([['products.status', '=', 'Sold']])
            ->orderBy('products.created_at', 'DESC')->count();

        $expired = $seller->products()
                ->join('users', 'products.user_id', '=', 'users.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                ->select('products.id')
                ->where([['products.status', '=', 'Available']])
                ->where([['products.expiry_date', '<', date('Y-m-d')]])
                ->orderBy('products.created_at', 'DESC')->count();

        $latest = $seller->products()
            ->join('users', 'products.user_id', '=', 'users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'categories.name AS categoryName', 'categories.slug AS catSlug', 'sub_categories.name AS subcategoryName', 'sub_categories.slug AS subcatSlug')
            ->where([['products.status', '=', 'Available']])
            ->where([['products.expiry_date', '>=', date('Y-m-d')]])
            ->orderBy('products.created_at', 'DESC')
            ->limit(5)
            ->get();

        return view('dashboard.home', compact('setting', 'total', 'onsale', 'sold', 'expired', 'latest'));
        
    }
    

    public function profile(){
        
        $setting = Setting::first();

        return view('dashboard.profile', compact('setting'));
        
    }


    public function update(Request $request){
        
        $user = Auth::guard('web')->user();
        
        //validate the form
        $this->validate(request(), [
            'name'    => 'required',
            'phone'   => 'required',
            'address' => 'required',
            'email'   => 'required|email|unique:users,email,'.$user->id,
            'pic'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        
        $data = ([
                    'name'    => request('name'),
                    'phone'   => request('phone'),
                    'address' => request('address'),
                    'email'   => request('email')
                ]);

        $file = request()->file('pic');

        if($file != null) {

            //deleting previous image
            @unlink('uploads/'.'users/'.$user->pic);

            $image_name = request('name')."-".time()."-".$file->getClientOriginalName();

            $img = Image::make($file);
            $img->resize(null, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $img->save('uploads/'.'users/'.$image_name);

            $data = (['pic' => $image_name]);
            User::where('id', $user->id)->update($data);
        }

        User::where('id', $user->id)->update($data);

        //redirect to profile
        return redirect('profile')->with('success','Profile updated.');
    }

    public function password(){
        
        $setting = Setting::first();
        
        return view('dashboard.password', compact('setting'));
        
    }
    

    public function updatePassword(Request $request){
        
        $user =  Auth::guard('web')->user();
        
        //validate the form
        $this->validate(request(), [
            'password' => 'required|min:8|confirmed',
            ]);

        $data = (['password' => bcrypt(request('password'))]);

        User::where('id', $user->id)->update($data);

        //redirect to dashboard
        return redirect('/password-change')->with('success','Password updated.');
        
    }
    

    public function items(){
        
        $setting = Setting::first();
        $seller = Auth::guard('web')->user();

        $title = 'All Items';

        $products = $seller->products()
                        ->join('users', 'products.user_id', '=', 'users.id')
                        ->join('categories', 'products.category_id', '=', 'categories.id')
                        ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                        ->join('other_categories', 'other_categories.id', '=', 'products.other_category_id', 'left')
                        ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'categories.name AS categoryName', 'categories.slug AS catSlug', 'sub_categories.name AS subcategoryName', 'sub_categories.slug AS subcatSlug', 'other_categories.name As otherCategory')
                        ->orderBy('products.created_at', 'DESC')
                        ->limit(5)
                        ->paginate(10);

        return view('dashboard.item', compact('setting', 'title', 'products'));
        
    }


    public function list(){
        
        $setting = Setting::first();
        $seller = Auth::guard('web')->user();

        $title = 'On Sale Items';

        $products = $seller->products()
                        ->join('users', 'products.user_id', '=', 'users.id')
                        ->join('categories', 'products.category_id', '=', 'categories.id')
                        ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                        ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'categories.name AS categoryName', 'categories.slug AS catSlug', 'sub_categories.name AS subcategoryName', 'sub_categories.slug AS subcatSlug')
                        ->where([['products.status', '=', 'Available']])
                        ->orderBy('products.created_at', 'DESC')
                        ->limit(5)
                        ->paginate(10);

        return view('dashboard.item', compact('setting', 'title', 'products'));
        
    }


    public function sold(){
        
        
        $setting = Setting::first();
        $seller = Auth::guard('web')->user();

        $title = 'Sold Items';

        $products = $seller->products()
                        ->join('users', 'products.user_id', '=', 'users.id')
                        ->join('categories', 'products.category_id', '=', 'categories.id')
                        ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                        ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'categories.name AS categoryName', 'categories.slug AS catSlug', 'sub_categories.name AS subcategoryName', 'sub_categories.slug AS subcatSlug')
                        ->where([['products.status', '=', 'Sold']])
                        ->orderBy('products.created_at', 'DESC')
                        ->limit(5)
                        ->paginate(10);

        return view('dashboard.item', compact('setting', 'title', 'products'));
        
    }
    

    public function detail($slug){
        
        $setting = Setting::first();
        $product = Product::join('users', 'products.user_id', '=', 'users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->join('other_categories', 'products.other_category_id', '=', 'other_categories.id', 'left')
            ->select('products.*', 'categories.name AS category', 'sub_categories.name AS subcategory', 'other_categories.name AS othercategory')
            ->where([['products.slug', '=', $slug]])->first();


        if(!isset($product)){        
            return abort(404);
        }
        
        Product::where([['id', '=', $product->id]])->increment('views', 1);

        $gallery = $product->galleries;
        
        return view('dashboard.detail', compact('setting', 'category', 'subcategory', 'product', 'gallery', 'similar_products', 'seller'));
        
    }
    

    public function status(Request $request){
        
        $id = request('id');
        $product = Product::where([['id', '=', $id]])->first();

        if($product->status == 'Available'){
            $product->status = 'Sold';
        }else{
            $product->status = 'Available';
        }

        $affected = $product->update();

        if($affected){
            $mgs = 'Status updated.';
            $arr = array('success' => $mgs);
            echo json_encode($arr);
        }else{
            $mgs = 'Status not updated.';
            $arr = array('error' => $mgs);
            echo json_encode($arr);
        }

    }
    

    public function renew(Request $request){
        
        $id = request('id');
        $product = Product::where([['id', '=', $id]])->first();

        if(isset($product)){

            $product->expiry_date = date('Y-m-d', strtotime('+1 month'));
            $product->updated_at = date('Y-m-d H:m:s');

            $affected = $product->update();

            if($affected){
                $mgs = 'Expiry Date updated.';
                $arr = array('success' => $mgs);
                echo json_encode($arr);
            }else{
                $mgs = 'Expiry Date not updated.';
                $arr = array('error' => $mgs);
                echo json_encode($arr);
            }

        }else{
            $mgs = 'Product not found.';
            $arr = array('error' => $mgs);
            echo json_encode($arr);
        }
        
    }
    

    public function sell(){
        
        if(!auth()->guard('web')->user()->verified){
            return redirect('dashboard');
        }
        
        $setting = Setting::first();
        $category = Category::where([['status', '=', 'Active']])->get();
        
        return view('sell', compact('setting', 'category'));
        
    }


    public function getSubCategory(Request $request){
        
        $category = request('category');
        $subcategory = SubCategory::select('id', 'name', 'pic')->where([['category_id', '=', $category]])->get();

        if($category > 0 && ($subcategory != null)){
            $arr = array('success' => $subcategory);
            echo json_encode($arr);
        }else{
            $mgs = 'No sub category found.';
            $arr = array('error' => $mgs);
            echo json_encode($arr);
        }
        
    }
    

    public function getOtherCategory(Request $request){
        
        $category = request('category');
        $othercategory = OtherCategory::select('id', 'name', 'pic')->where([['sub_category_id', '=', $category]])->get();

        if($category > 0 && ($othercategory != null)){
            $arr = array('success' => $othercategory);
            echo json_encode($arr);
        }else{
            $mgs = 'No other category found.';
            $arr = array('error' => $mgs);
            echo json_encode($arr);
        }
        
    }
    

    public function post(Request $request){
        
        $catId = trim($request->category_id);
        
        if($catId == 16 || $catId == 17 || $catId == 20){
            
            //validate the form
            $this->validate(request(), [
    
                'name'             => 'required',
                'category_id'      => 'required|numeric',
                'sub_category_id'  => 'required|numeric',
                'price'            => 'required|numeric',
                'price_negotiable' => 'required',
                'condition'        => '',
                'delivery'         => '',
                'pic'              => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                'expiry_date'      => 'required|date'

            ]);
            
        }else{
            
            //validate the form
            $this->validate(request(), [
    
                'name'             => 'required',
                'category_id'      => 'required|numeric',
                'sub_category_id'  => 'required|numeric',
                'price'            => 'required|numeric',
                'price_negotiable' => 'required',
                'condition'        => 'required',
                'delivery'         => 'required',
                'pic'              => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                'expiry_date'      => 'required|date'

            ]);
            
        }

        //create and save product
        $product = new Product;

        //validate if there is other category
        $othercategory = OtherCategory::where([
                                                ['sub_category_id', '=', request('sub_category_id')],
                                                ['status', '=', 'Active']
                                            ])->count();

        if($othercategory > 0){
            $other_category = (['other_category_id' => request('other_category_id')]);
            $product->other_category_id = request('other_category_id');
        }else{
            $other_category = ([]);
        }
        
        $messages = [
            'numeric' => 'The Other Category field is required.',
        ];

        $v = Validator::make($other_category, [
            'other_category_id' => 'numeric'
            ], $messages);

        if ($v->fails()) {
            return redirect('sell')->withErrors($v)->withInput();
        }
        //validate if there is other category
        
        $product->category_id      = request('category_id');
        $product->sub_category_id  = request('sub_category_id');
        $product->user_id          = auth()->guard('web')->user()->id;
        $product->ads_id           = $product->generateToken(5);
        $product->name             = request('name');
        $product->slug             = $product->sluggable($product->name).'-'.$product->generateToken(3);
        $product->features         = request('features');
        $product->price            = request('price');
        $product->price_negotiable = request('price_negotiable');
        $product->condition        = request('condition');
        $product->user_for         = request('user_for');
        $product->delivery         = request('delivery');
        $product->delivery_area    = request('delivery_area');
        $product->expiry_date      = request('expiry_date');
        $product->created_at       = date('Y-m-d H:m:s');

        $file = request()->file('pic');

        if($file != null) {

            $image_name = request('name')."-".time()."-".$file->getClientOriginalName();

            $img = Image::make($file);
            $img->resize(null, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            if(!File::exists('uploads/'.'products/')){ File::makeDirectory('uploads/'.'products/'); }
            $img->save('uploads/'.'products/'.$image_name);
 
            $product->pic = $image_name;        
        }

        $product->save();

        // product gallery
        $images = request()->file('gallery');

        if($images) {
            $z=0;
            foreach($images as $file) {
                if($z < 4){

                    $v = Validator::make(['gallery' => request()->file('gallery')[$z]], [
                        'gallery' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                    ]);
                    if ($v->fails()) {

                        @unlink('uploads/'.'products/'.$product->pic);
                        $product->delete();
                        return redirect('/sell')->withErrors($v)->withInput();
                    }

                    $image_name = $product->slug.time()."-".$file->getClientOriginalName();

                    $img = Image::make($file);
                    $img->resize(null, 800, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    
                    //$watermark = Image::make('administrator/img/logow.png');
                    //$watermark->opacity(50);
                    // insert a watermark
                    //$img->insert($watermark , 'center', 40, 40);
                    
                    if(!File::exists('uploads/'.'gallery/')){ File::makeDirectory('uploads/'.'gallery/'); }

                    // save image in desired format
                    $img->save('uploads/'.'gallery/'.$image_name);
        
                    $gallery = new Gallery;
                    $gallery->product_id = $product->id;
                    $gallery->pic = $image_name;
                    $gallery->save();
                }
            $z++;
            }
        }

        //redirect to dashboard
        return redirect('sell/success/'.$product->slug);

    }
    

    public function success($slug){
        
        $setting = Setting::first();
        $category = Category::where([['status', '=', 'Active']])->get();
        $product = Product::where([['slug', '=', $slug]])->first();

        if(isset($product)){        
            return view('success', compact('setting', 'product'));
        } else {
            return abort(404);
        }
        
    }
    

}
