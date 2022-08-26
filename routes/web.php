<?php


/**************************************** Socialite Login ******************************************/
Route::get('login/{provider}', 'Social\SocialiteController@redirectToProvider')
	->name('social.login');

Route::get('callback/{provider}', 'Social\SocialiteController@handleProviderCallback')
	->name('social.callback');


/***************************************** Admin Routes ********************************************/
Route::prefix('admin')->group(function(){

	// login authentication routes
	Route::get('login', 'Admin\Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Admin\Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
	Route::get('logout', 'Admin\Auth\AdminLoginController@logout')->name('admin.logout');

	// loggedin admin profile routes
	Route::get('profile', 'Admin\Auth\AdminLoginController@edit');
	Route::post('profile', 'Admin\Auth\AdminLoginController@update');

	//email verification routes
	//Mail::to($user = App\Admin::first())->send(new App\Mail\AdminVerifyEmail($user));
	Route::get('verification/{token}', 'Admin\Auth\AdminLoginController@verification')->name('admin.email.verification');

	//admin password reset routes...
	Route::post('password/email', 'Admin\Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::get('password/reset', 'Admin\Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('password/reset', 'Admin\Auth\AdminResetPasswordController@reset');
	Route::get('password/reset/{token}', 'Admin\Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');

	//roles and permission routes
	Route::get('roles', 'Admin\Auth\RolesAndPermissionsController@index');
	Route::get('role/add', 'Admin\Auth\RolesAndPermissionsController@create');
	Route::post('role/add', 'Admin\Auth\RolesAndPermissionsController@store');
	Route::get('role/{role}/edit', 'Admin\Auth\RolesAndPermissionsController@edit');
	Route::post('role/{role}/edit', 'Admin\Auth\RolesAndPermissionsController@update');
	Route::get('role/{role}/delete', 'Admin\Auth\RolesAndPermissionsController@destroy');
	Route::get('role/{role}/assign', 'Admin\Auth\RolesAndPermissionsController@assign');
	Route::post('role/{role}/assign', 'Admin\Auth\RolesAndPermissionsController@assignPermissions');

	Route::get('permissions', 'Admin\Auth\RolesAndPermissionsController@permissions');
	Route::get('permission/add', 'Admin\Auth\RolesAndPermissionsController@createPermission');
	Route::post('permission/add', 'Admin\Auth\RolesAndPermissionsController@storePermission');
	Route::get('permission/{permission}/edit', 'Admin\Auth\RolesAndPermissionsController@editPermission');
	Route::post('permission/{permission}/edit', 'Admin\Auth\RolesAndPermissionsController@updatePermission');
	Route::get('permission/{permission}/delete', 'Admin\Auth\RolesAndPermissionsController@destroyPermission');
	Route::get('permission/{permission}/delete', 'Admin\Auth\RolesAndPermissionsController@destroyPermission');

	// admin routes
	Route::get('admins', 'Admin\AdminController@index');
	Route::get('admin/add', 'Admin\AdminController@create');
	Route::post('admin/add', 'Admin\AdminController@store');
	Route::get('admin/{admin}/edit', 'Admin\AdminController@edit');
	Route::post('admin/{admin}/edit', 'Admin\AdminController@update');
	Route::get('admin/{admin}/delete', 'Admin\AdminController@destroy');
	Route::get('admin/{admin}/assign', 'Admin\AdminController@assign');
	Route::post('admin/{admin}/assign', 'Admin\AdminController@assignRoles');

	// user routes
	Route::get('users', 'Admin\UserController@index');
	Route::get('user/add', 'Admin\UserController@create');
	Route::post('user/add', 'Admin\UserController@store');
	Route::get('user/{user}/edit', 'Admin\UserController@edit');
	Route::post('user/{user}/edit', 'Admin\UserController@update');
	Route::get('user/{user}/delete', 'Admin\UserController@destroy');

	// category routes
	Route::get('categories', 'Admin\CategoryController@index');
	Route::get('category/add', 'Admin\CategoryController@create');
	Route::post('category/add', 'Admin\CategoryController@store');
	Route::get('category/{category}/edit', 'Admin\CategoryController@edit');
	Route::post('category/{category}/edit', 'Admin\CategoryController@update');
	Route::get('category/{category}/delete', 'Admin\CategoryController@destroy');

	// category routes
	Route::get('subcategories', 'Admin\SubCategoryController@index');
	Route::get('subcategory/add', 'Admin\SubCategoryController@create');
	Route::post('subcategory/add', 'Admin\SubCategoryController@store');
	Route::get('subcategory/{subcategory}/edit', 'Admin\SubCategoryController@edit');
	Route::post('subcategory/{subcategory}/edit', 'Admin\SubCategoryController@update');
	Route::get('subcategory/{subcategory}/delete', 'Admin\SubCategoryController@destroy');

	// category routes
	Route::get('othercategories', 'Admin\OtherCategoryController@index');
	Route::get('othercategory/add', 'Admin\OtherCategoryController@create');
	Route::post('othercategory/add', 'Admin\OtherCategoryController@store');
	Route::get('othercategory/{othercategory}/edit', 'Admin\OtherCategoryController@edit');
	Route::post('othercategory/{othercategory}/edit', 'Admin\OtherCategoryController@update');
	Route::get('othercategory/{othercategory}/delete', 'Admin\OtherCategoryController@destroy');

	// product routes
	Route::get('products', 'Admin\ProductController@index');
	Route::get('product/add', 'Admin\ProductController@create');
	Route::post('product/add', 'Admin\ProductController@store');
	Route::get('product/{product}/edit', 'Admin\ProductController@edit');
	Route::post('product/{product}/edit', 'Admin\ProductController@update');
	Route::get('product/{product}/delete', 'Admin\ProductController@destroy');
	Route::post('product/subcategory', 'Admin\ProductController@subcategory');
	Route::post('product/othercategory', 'Admin\ProductController@othercategory');
	Route::get('product/{product}/gallery', 'Admin\ProductController@gallery');
	Route::post('product/{product}/gallery', 'Admin\ProductController@addGallery');
	Route::get('product/{product}/gallery/{id}/delete', 'Admin\ProductController@deleteGallery');
	Route::post('change-product-featured', 'Admin\ProductController@changeProductFeatured')
	->name('admin.changeProductFeatured');
	
	
	// Route For Advertise
	Route::get('/advertise-list', 'Admin\AdvertiseController@advertiseList')
	->name('admin.advertiseList');
	Route::get('/add-advertise', 'Admin\AdvertiseController@addAdvertise')
	->name('admin.addAdvertise');
	Route::post('/add-advertise', 'Admin\AdvertiseController@addAdvertiseProcess')
	->name('admin.addAdvertiseProcess');
	Route::get('/edit-advertise/{id}', 'Admin\AdvertiseController@editAdvertise')
	->name('admin.editAdvertise');
	Route::post('/edit-advertise/{id}', 'Admin\AdvertiseController@editAdvertiseProcess')
	->name('admin.editAdvertiseProcess');
	Route::get('/delete-advertise/{id}', 'Admin\AdvertiseController@deleteAdvertise')
	->name('admin.deleteAdvertise');

	// pages routes
	Route::get('pages', 'Admin\PageController@index');
	Route::get('page/add', 'Admin\PageController@create');
	Route::post('page/add', 'Admin\PageController@store');
	Route::get('page/{page}/edit', 'Admin\PageController@edit');
	Route::post('page/{page}/edit', 'Admin\PageController@update');
	Route::get('page/{page}/delete', 'Admin\PageController@destroy');

	Route::get('settings', 'Admin\SettingController@index');
	Route::post('setting/add', 'Admin\SettingController@store');
	Route::get('setting/{setting}/edit', 'Admin\SettingController@edit');
	Route::post('setting/{setting}/edit', 'Admin\SettingController@update');
	
	
	// Route For Blog
	Route::get('/blog-list', 'Admin\BlogController@blogList')
	->name('admin.blogList');
	Route::get('/add-blog', 'Admin\BlogController@addBlog')
	->name('admin.addBlog');
	Route::post('/add-blog', 'Admin\BlogController@addBlogProcess')
	->name('admin.addBlogProcess');
	Route::get('/edit-blog/{id}', 'Admin\BlogController@editBlog')
	->name('admin.editBlog');
	Route::post('/edit-blog/{id}', 'Admin\BlogController@editBlogProcess')
	->name('admin.editBlogProcess');
	Route::get('/delete-blog/{id}', 'Admin\BlogController@deleteBlog')
	->name('admin.deleteBlog');
	
});
// Admin Routes

Route::get('/', 'HomeController@index')->name('index');

// login authentication routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\LoginController@showRegisterForm')->name('register');
Route::post('register', 'Auth\LoginController@register')->name('register');
Route::get('verification/{token}', 'Auth\LoginController@verification')->name('email.verification');

// password reset routes
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

// user dashboard routes
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('profile', 'DashboardController@profile')->name('profile');
Route::post('profile', 'DashboardController@update')->name('profile');
Route::get('password-change', 'DashboardController@password')->name('password.change');
Route::post('password-change', 'DashboardController@updatePassword')->name('password.change');
Route::get('items', 'DashboardController@items')->name('items');
Route::get('items/list', 'DashboardController@list')->name('items.list');
Route::get('items/sold', 'DashboardController@sold')->name('items.sold');
Route::get('detail/{product}', 'DashboardController@detail')->name('item.detail');
Route::post('update/status', 'DashboardController@status')->name('update.status');
Route::post('renew', 'DashboardController@renew')->name('renew');

Route::get('dealsdrill/{page}', 'HomeController@page')->name('page');
Route::post('get/subcategory', 'DashboardController@getSubCategory')->name('getSubCategory');
Route::post('get/othercategory', 'DashboardController@getOtherCategory')->name('getOtherCategory');
Route::get('sell', 'DashboardController@sell')->name('sell');
Route::post('sell', 'DashboardController@post')->name('sell');
Route::get('sell/success/{product}', 'DashboardController@success')->name('success');

Route::get('seller/{user}', 'HomeController@seller')->name('seller');
Route::post('filter', 'HomeController@filter')->name('filter');
Route::get('search', 'HomeController@search')->name('search');
Route::post('search', 'HomeController@searchFilter')->name('search');
Route::get("blog/{permalink}", "HomeController@blogDetails")->name("site.blogDetails");

Route::get('item/{product}', 'HomeController@product')->name('product.details');
Route::get('{category}', 'HomeController@category')->name('category');
Route::get('{category}/{subcategory}', 'HomeController@subcategory')->name('subcategory');
Route::get('{category}/{subcategory}/{othercategory}', 'HomeController@othercategory')->name('othercategory');

Route::post('/load-more-product', 'HomeController@loadMoreProduct')
->name('site.loadMoreProduct');