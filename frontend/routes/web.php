<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
                                  //Home//
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/index-2', [HomeController::class, 'index2'])->name('home.index2');
Route::get('/index-3', [HomeController::class, 'index3'])->name('home.index3');
Route::get('/index-4', [HomeController::class, 'index4'])->name('home.index4');

                         //Pages Routes//
Route::get('/shop-grid-right-sidebar-3-col', [HomeController::class, 'shopGridRightSidebar3Col'])->name('pages.shopGridRightSidebar3Col');
Route::get('/shop-grid-left-sidebar-3-col', [HomeController::class, 'shopGridLeftSidebar3Col'])->name('pages.shopGridLeftSidebar3Col');
Route::get('/shop-grid-left-sidebar', [HomeController::class, 'shopGridLeftSidebar'])->name('pages.shopGridLeftSidebar');
Route::get('/shop-grid-right-sidebar', [HomeController::class, 'shopGridRightSidebar'])->name('pages.shopGridRightSidebar');
Route::get('/shop-grid-full-3-column', [HomeController::class, 'shopGridFull3Column'])->name('pages.shopGridFull3Column');
Route::get('/shop-grid-full-4-column', [HomeController::class, 'shopGridFull4Column'])->name('pages.shopGridFull4Column');

Route::get('/product-details', [HomeController::class, 'productDetails'])->name('pages.product.details');
Route::get('/product-details-affiliate', [HomeController::class, 'productDetailsAffiliate'])->name('pages.product.detailsAffiliate');
Route::get('/product-details-variable', [HomeController::class, 'productDetailsVariable'])->name('pages.product.detailsVariable');
Route::get('/product-details-group', [HomeController::class, 'productDetailsGroup'])->name('pages.product.detailsGroup');
Route::get('/product-details-box', [HomeController::class, 'productDetailsBox'])->name('pages.product.detailsBox');

Route::get('/cart', [HomeController::class, 'cart'])->name('pages.cart');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('pages.checkout');
Route::get('/compare', [HomeController::class, 'compare'])->name('pages.compare');
Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('pages.wishlist');

Route::get('/my-account', [HomeController::class, 'myAccount'])->name('pages.myAccount');
Route::get('/login-register', [HomeController::class, 'loginRegister'])->name('pages.loginRegister');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('pages.aboutUs');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('pages.contactUs');



                        // Shop List Layout Routes
Route::get('/shop-list-left-sidebar', [HomeController::class, 'shopListLeftSidebar'])->name('shop.listLeftSidebar');
Route::get('/shop-list-right-sidebar', [HomeController::class, 'shopListRightSidebar'])->name('shop.listRightSidebar');
Route::get('/shop-list-full-width', [HomeController::class, 'shopListFullWidth'])->name('shop.listFullWidth');


                                //Blog Routes //

Route::get('/blog-left-sidebar', [HomeController::class, 'blogLeftSidebar'])->name('blog.leftSidebar');
Route::get('/blog-left-sidebar-2col', [HomeController::class, 'blogLeftSidebar2Col'])->name('blog.leftSidebar2Col');
Route::get('/blog-right-sidebar', [HomeController::class, 'blogRightSidebar'])->name('blog.rightSidebar');
Route::get('/blog-full-2col', [HomeController::class, 'blogFull2Col'])->name('blog.full2Col');
Route::get('/blog-full-3col', [HomeController::class, 'blogFull3Col'])->name('blog.full3Col');
Route::get('/blog-details', [HomeController::class, 'blogDetails'])->name('blog.details');
Route::get('/blog-details-audio', [HomeController::class, 'blogDetailsAudio'])->name('blog.detailsAudio');
Route::get('/blog-details-video', [HomeController::class, 'blogDetailsVideo'])->name('blog.detailsVideo');
Route::get('/blog-details-image', [HomeController::class, 'blogDetailsImage'])->name('blog.detailsImage');
