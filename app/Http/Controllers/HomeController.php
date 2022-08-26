<?php

namespace App\Http\Controllers;

use App\Page;
use App\User;
use App\Setting;
use App\Product;
use App\Category;
use App\SubCategory;
use App\OtherCategory;
use App\Advertise;
use App\Blog;
use Illuminate\Http\Request;

class HomeController extends Controller{
    
    public function __construct(){}

    
    public function index(){
        
        $setting = Setting::first();
        $seo = Setting::select('seo_keyword', 'seo_title', 'seo_desc')->first();
        $category = Category::where([['status', '=', 'Active']])->orderBy('order', 'asc')->get();
        
        // Products For Featured Item
        $featured = Product::join('users', 'products.user_id', '=', 'users.id')
                            ->join('categories', 'products.category_id', '=', 'categories.id')
                            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                            ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'users.slug As sellerslug', 'categories.slug AS catSlug', 'sub_categories.slug AS subcatSlug')
                            ->where([ 
                                        ['products.status', 'Available'],
                                        // ['products.expiry_date', '>=', date('Y-m-d')],
                                        ['products.featured', 'Yes']
                                    ])
                            ->orderBy('products.created_at', 'DESC')
                            ->limit(15)
                            ->get();
        
        $products = Product::join('users', 'products.user_id', '=', 'users.id')
                            ->join('categories', 'products.category_id', '=', 'categories.id')
                            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                            ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'users.slug As sellerslug', 'categories.slug AS catSlug', 'sub_categories.slug AS subcatSlug')
                            ->where([
                                        ['products.status', 'Available'],
                                        // ['products.expiry_date', '>=', date('Y-m-d')]
                                    ])
                            ->orderBy('products.created_at', 'DESC')
                            ->limit(7)
                            ->get();
                            
        // echo "<pre>";
        // print_r($products->toArray());
        // die();
        
        $products1 = Product::join('users', 'products.user_id', '=', 'users.id')
                            ->join('categories', 'products.category_id', '=', 'categories.id')
                            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                            ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'users.slug As sellerslug', 'categories.slug AS catSlug', 'sub_categories.slug AS subcatSlug')
                            ->where([
                                        ['products.status', 'Available'],
                                        // ['products.expiry_date', '>=', date('Y-m-d')]
                                    ])
                            ->orderBy('products.created_at', 'DESC')
                            ->skip(7)
                            ->limit(8)
                            ->get();
                            
        $products2 = Product::join('users', 'products.user_id', '=', 'users.id')
                            ->join('categories', 'products.category_id', '=', 'categories.id')
                            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                            ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'users.slug As sellerslug', 'categories.slug AS catSlug', 'sub_categories.slug AS subcatSlug')
                            ->where([
                                        ['products.status', 'Available'],
                                        // ['products.expiry_date', '>=', date('Y-m-d')]
                                    ])
                            ->orderBy('products.created_at', 'DESC')
                            ->skip(15)
                            ->limit(8)
                            ->get();
        
        
        
        $data['header'] = Advertise::where([['status', 'Active'],['type', 'header']])->first();
        $data['m-left'] = Advertise::where([['status', 'Active'],['type', 'm-left']])->first();
        $data['section1'] = Advertise::where([['status', 'Active'],['type', 'section1']])->first();
        $data['section2'] = Advertise::where([['status', 'Active'],['type', 'section2']])->first();
        $data['m-right'] = Advertise::where([['status', 'Active'],['type', 'm-right']])->first();
        $data['footer'] = Advertise::where([['status', 'Active'],['type', 'footer']])->first();
        
        return view('home', compact('setting', 'category', 'products', 'products1', 'products2', 'featured', 'seo', 'data'));
        
    }


    public function page($slug){
        
        $setting = Setting::first();
        $seo = Page::select('seo_keyword', 'seo_title', 'seo_desc')
                    ->where('slug', $slug)->first();
        $category = Category::where([['status', '=', 'Active']])->orderBy('order', 'asc')->get();
        $page = Page::where([['slug', '=', $slug]])->first();
        $blogs = Blog::where('status', 'Active')->latest()->get();
        
        if(isset($page)){        
            return view($page->template, compact('setting', 'category', 'page', 'seo', 'blogs'));
        }else{
            return abort(404);
        }
        
    }
    
    
    public function blogDetails($permalink){

        $data['blog'] = Blog::wherePermalink($permalink)->first();

        if(!isset($data['blog'])){ return redirect('/'); }

        $setting = Setting::first();
        $data['other-blogs'] = Blog::where('permalink', '!=', $permalink)
                                    ->inRandomOrder()->limit(5)->get();
        
        $data['social'] = [
            "title"       => $data['blog']->name,
            "description" => mb_substr(strip_tags($data['blog']->description),0 ,120, 'utf-8'),
            "image"       => asset('uploads/blog/'.$data['blog']->pics),
            "url"         => route('site.blogDetails', $data['blog']->permalink)
        ];
        
        return view('blog-details', compact('setting', 'data'));

    }
    
    
    public function category(Request $request, $slug){
        
        $setting = Setting::first();

        $category = Category::where([['slug', '=', $slug]])->first();

        $categories = Category::where([['status', '=', 'Active']])->orderBy('order', 'asc')->get();

        if(!isset($category)){        
            return abort(404);
        }

        $subcategory = $category->subcategories()->orderBy('name', 'asc')->get();

        $x=0;
        foreach($subcategory as $row){

            $subcategory[$x]->othercategory = $othercategory = OtherCategory::where([
                                                                                        ['status', '=', 'Active'],
                                                                                        ['sub_category_id', '=', $row->id]
                                                                                    ])
                                                                            ->orderBy('name', 'asc')->get();
                                                                            
            $hasothercategory = OtherCategory::where([
                                                        ['status', '=', 'Active'],
                                                        ['sub_category_id', '=', $row->id]
                                                    ])
                                                ->count();

            if($hasothercategory > 0){
                
                $y=0;
                foreach($othercategory as $sub){
                    
                    $othercategory[$y]->product = Product::where([
                                                                    ['status', '=', 'Available'],
                                                                    // ['expiry_date', '>=', date('Y-m-d')],
                                                                    ['other_category_id', '=', $sub->id]
                                                                ])
                                                            ->count();
                    $y++;
                
                }
                
            }else{
                
                $subcategory[$x]->product = $row->products()->where([
                                                                        ['status', '=', 'Available'],
                                                                        // ['expiry_date', '>=', date('Y-m-d')]
                                                                    ])
                                                            ->count();
                
            }

            $x++;
            
        }

        $products = $category->products()
                        ->join('users', 'products.user_id', '=', 'users.id')
                        ->join('categories', 'products.category_id', '=', 'categories.id')
                        ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                        ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'users.address', 'users.slug As sellerslug')
                        ->where([
                                    ['products.status', '=', 'Available'],
                                    // ['products.expiry_date', '>=', date('Y-m-d')]
                                ])
                        ->OfLocation(session('location'))
                        ->OfCondition(session('condition'))
                        ->OfPrice(session('start'), session('end'))
                        ->OfOrder(session('sort'), session('order'))
                        ->paginate(10);

        return view('category', compact('setting', 'categories', 'category', 'subcategory', 'products'));
        
    }


    public function subcategory($category, $slug){
        
        $setting = Setting::first();

        $categories = Category::where([['status', '=', 'Active']])->orderBy('order', 'asc')->get();

        $subcategory = SubCategory::where([['slug', '=', $slug]])->first();

        $category = Category::where([['id', '=', $subcategory->category_id]])->first();

        if(!isset($subcategory)){        
            return abort(404);
        }

        $othercategory = OtherCategory::where([
                                                ['status', '=', 'Active'],
                                                ['sub_category_id', '=', $subcategory->id]
                                            ])
                                        ->orderBy('name', 'asc')->get();

        $y=0;
        foreach($othercategory as $sub){
            
            $othercategory[$y]->product = Product::where([
                                                            ['status', '=', 'Available'],
                                                            // ['expiry_date', '>=', date('Y-m-d')],
                                                            ['other_category_id', '=', $sub->id]
                                                        ])
                                                    ->count();
            
            $y++;
            
        }

        $products = $subcategory->products()
            ->join('users', 'products.user_id', '=', 'users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'users.address', 'users.slug As sellerslug')
            ->where([
                        ['products.status', '=', 'Available'],
                        // ['products.expiry_date', '>=', date('Y-m-d')]
                    ])
            ->OfLocation(session('location'))
            ->OfCondition(session('condition'))
            ->OfPrice(session('start'), session('end'))
            ->OfOrder(session('sort'), session('order'))
            ->paginate(10);

        return view('subcategory', compact('setting', 'categories', 'category', 'subcategory', 'othercategory', 'products'));
        
    }
    

    public function othercategory($category, $subcategory, $slug){
        
        $setting = Setting::first();

        $categories = Category::where([['status', '=', 'Active']])->orderBy('order', 'asc')->get();

        $othercategory = OtherCategory::where([['slug', '=', $slug]])->first();
        
        $subcategory = SubCategory::where([['id', '=', $othercategory->sub_category_id]])->first();

        $category = Category::where([['id', '=', $subcategory->category_id]])->first();

        if(!isset($othercategory)){        
            return abort(404);
        }

        $othercategory->product = Product::where([
                                                    ['status', '=', 'Available'],
                                                    // ['expiry_date', '>=', date('Y-m-d')],
                                                    ['other_category_id', '=', $othercategory->id]
                                                    ])
                                            ->count();

        $products = Product::join('users', 'products.user_id', '=', 'users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'users.address', 'users.slug As sellerslug')
            ->where([
                        ['products.other_category_id', '=', $othercategory->id],
                        ['products.status', '=', 'Available'],
                        // ['products.expiry_date', '>=', date('Y-m-d')]
                    ])
            ->OfLocation(session('location'))
            ->OfCondition(session('condition'))
            ->OfPrice(session('start'), session('end'))
            ->OfOrder(session('sort'), session('order'))
            ->paginate(10);

        return view('othercategory', compact('setting', 'categories', 'category', 'subcategory', 'othercategory', 'products'));
        
    }
    

    public function filter(Request $request){
        
        $request->session()->put('location', request('location'));
        $request->session()->put('condition', request('condition'));
        $request->session()->put('start', request('start'));
        $request->session()->put('end', request('end'));

        $sort = request('sort');
        if($sort == 'price-desc') {
            $request->session()->put('sort', 'price');
            $request->session()->put('order', 'DESC');
        } elseif($sort == 'price-asc') {
            $request->session()->put('sort', 'price');
            $request->session()->put('order', 'ASC');
        } else {
            $request->session()->forget('sort');
            $request->session()->forget('order');
        }

        $url = request('url');

        return redirect('/'.$url);
        
    }
    

    public function searchFilter(Request $request){
        
        $request->session()->put('location', request('location'));
        $request->session()->put('condition', request('condition'));
        $request->session()->put('start', request('start'));
        $request->session()->put('end', request('end'));

        if($request->has('keyword')) {
            $request->session()->put('keyword', request('keyword'));
            $request->session()->flash('search', request('keyword'));
        }

        $sort = request('sort');
        if($sort == 'price-desc') {
            $request->session()->put('sort', 'price');
            $request->session()->put('order', 'DESC');
        } elseif($sort == 'price-asc') {
            $request->session()->put('sort', 'price');
            $request->session()->put('order', 'ASC');
        } else {
            $request->session()->forget('sort');
            $request->session()->forget('order');
        }

        return redirect('search');
        
    }
    

    public function search(Request $request){
        
        $setting = Setting::first();

        $products = Product::join('users', 'products.user_id', '=', 'users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'users.address', 'users.slug As sellerslug', 'categories.slug AS catSlug', 'sub_categories.slug AS subcatSlug')
            ->where([
                        ['products.status', '=', 'Available'],
                        // ['products.expiry_date', '>=', date('Y-m-d')]
                    ])
            ->OfLocation(session('location'))
            ->OfCondition(session('condition'))
            ->OfPrice(session('start'), session('end'))
            ->OfSearch(session('keyword'))
            ->OfOrder(session('sort'), session('order'))
            ->paginate(10);

        return view('search', compact('setting', 'products'));
        
    }


    public function product($slug){
        
        $setting = Setting::first();
        $seo = Product::select('seo_keyword', 'seo_title', 'seo_desc')
                        ->where('slug', $slug)->first();
        $product = Product::join('users', 'products.user_id', '=', 'users.id')
            ->select('products.*', 'users.address')
            ->where([['products.slug', '=', $slug]])->first();

        if(!isset($product)){        
            return abort(404);
        }
        
        Product::where([['id', '=', $product->id]])->increment('views', 1);

        $gallery = $product->galleries;
        
        $similar_products = Product::join('users', 'products.user_id', '=', 'users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->join('other_categories', 'products.other_category_id', '=', 'other_categories.id', 'left')
            ->select('products.*', 'users.name AS seller', 'users.slug As sellerslug', 'users.pic AS profile', 'users.address')
            ->where([
                        ['products.id', '<>', $product->id],
                        ['products.name', 'like', '%'.$product->name.'%'],
                        ['products.status', '=', 'Available'],
                        // ['products.expiry_date', '>=', date('Y-m-d')]
                    ])
            ->orderBy('products.created_at', 'DESC')
            ->limit(4)
            ->get();

        $category = Category::where([['id', '=', $product->category_id]])->first();
        $subcategory = SubCategory::where([['id', '=', $product->sub_category_id]])->first();
        
        $othercategory = OtherCategory::where([['id', '=', $product->other_category_id]])->first();
        
        $seller = User::where([['id', '=', $product->user_id]])->first();
        
        return view('details', compact('setting', 'category', 'subcategory', 'othercategory', 'product', 'gallery', 'similar_products', 'seller', 'seo'));
        
    }
    

    public function seller($slug){
        
        $setting = Setting::first();

        $seller = User::where([['slug', '=', $slug]])->first();

        if(!isset($seller)){        
            return abort(404);
        }

        $products = $seller->products()
            ->join('users', 'products.user_id', '=', 'users.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'categories.slug AS catSlug', 'sub_categories.slug AS subcatSlug')
            ->where([
                        ['products.status', '=', 'Available'],
                        // ['products.expiry_date', '>=', date('Y-m-d')]
                    ])
            ->orderBy('products.created_at', 'DESC')->get();

        return view('seller', compact('setting', 'seller', 'products'));
        
    }
    
    
    public function loadMoreProduct(Request $request){
        
        $start = trim($request->start);
        
        $results = Product::join('users', 'products.user_id', '=', 'users.id')
                            ->join('categories', 'products.category_id', '=', 'categories.id')
                            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                            ->select('products.*', 'users.name AS seller', 'users.pic AS profile', 'users.slug As sellerslug', 'categories.slug AS catSlug', 'sub_categories.slug AS subcatSlug')
                            ->where([
                                        ['products.status', 'Available'],
                                        // ['products.expiry_date', '>=', date('Y-m-d')]
                                    ])
                            ->orderBy('products.created_at', 'DESC')
                            ->skip($start)
                            ->take(8)
                            ->get();
                            
        $hide = (count($results) < 8)?true:false;
        $data = "";           
        
        foreach($results as $row):
            
            $img = ($row->profile != '')?asset('uploads/'.'users/'.$row->profile):asset('images/icons/default.fw.png');
            
            $data .= "
                    <div class='col-md-4 col-sm-6 col-lg-3 item-column-wrap'>
                        <div class='item-column'>
                            <div class='img-container'>
                                <a href='".url('/item/'.$row->slug)."' style='display: inline'>
                                    <img src='".asset('uploads/'.'products/'.$row->pic)."' alt='".ucwords($row->name)."' class='img-fitted hvr-grow'>
                                </a>
                                <a href='".url('seller/'.$row->sellerslug)."' class='seller-info img-container' 
                                    data-toggle='tooltip' title='Seller: ".ucwords($row->seller)."' data-placement='right'>
                                    <img src='".$img."' alt='".ucwords($row->seller)."' class='img-fitted'>
                                </a>
                                <div class='item-thumbs'>
                                    <h3 class='item-price'>Rs. ".number_format($row->price, 0)."</h3>
                                </div>
                            </div>
                            <div class='column-info'>
                                <a href='".url('item/'.$row->slug)."' title='".ucwords($row->name)."'>
                                    <h4 class='item-title'>".ucwords($row->name)."</h4>
                                </a>
                                <span class='item-location'>
                                    <b>Condition:</b>".$row->condition."
                                </span>
                            </div>
                        </div>
                    </div>
                    ";
            
        endforeach;
        
        return response()->json([
                "success" => true,
                "hide"    => $hide,
                "data"    => $data 
            ]);
        
    }
    
    
}
