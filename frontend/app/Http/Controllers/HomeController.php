<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function PHPUnit\Framework\returnValue;

class HomeController extends Controller
{
    //Home index Files//
    public function index()
    {
        return view('include.home.index');
    }
    public function index2()
    {
        return view('include.home.index2');
    }
    public function index3()
    {
        return view('include.home.index3');
    }
    public function index4()
    {
        return view('include.home.index4');
    }
    //pages //

    public function shopGridLeftSidebar()
    {
        return view('include.pages.shop-grid-left-sidebar');
    }

    public function shopGridRightSidebar()
    {
        return view('include.pages.shop-grid-right-sidebar');
    }

    public function shopGridFull3Column()
    {
        return view('include.pages.shop-grid-full-3-column');
    }

    public function shopGridFull4Column()
    {
        return view('include.pages.shop-grid-full-4-column');
    }

    public function productDetails()
    {
        return view('include.pages.product-details');
    }

    public function productDetailsAffiliate()
    {
        return view('include.pages.product-details-affiliate');
    }

    public function productDetailsVariable()
    {
        return view('include.pages.product-details-variable');
    }

    public function productDetailsGroup()
    {
        return view('include.pages.product-details-group');
    }

    public function cart()
    {
        return view('include.pages.cart');
    }

    public function checkout()
    {
        return view('include.pages.checkout');
    }

    public function compare()
    {
        return view('include.pages.compare');
    }

    public function wishlist()
    {
        return view('include.pages.wishlist');
    }

    public function myAccount()
    {
        return view('include.pages.my-account');
    }

    public function loginRegister()
    {
        return view('include.pages.login-register');
    }

    public function aboutUs()
    {
        return view('include.pages.about-us');
    }

    public function contactUs()
    {
        return view('include.pages.contact-us');
    }
    public function shopGridLeftSidebar3Col()
    {
        return view('include.pages.shop-grid-left-sidebar-3-col');
    }
    public function shopGridRightSidebar3Col()
    {
        return view('include.pages.shop-grid-right-sidebar-3-col');
    }
    //Shop Controller//
    public function shopListLeftSidebar()
    {
        return view('include.shop.shop-list-left-sidebar');
    }

    public function shopListRightSidebar()
    {
        return view('include.shop.shop-list-right-sidebar');
    }

    public function shopListFullWidth()
    {
        return view('include.shop.shop-list-full-width');
    }
    //Blog Controller//

    public function blogLeftSidebar()
    {
        return view('include.blog.blog-left-sidebar');
    }

    public function blogLeftSidebar2Col()
    {
        return view('include.blog.blog-left-sidebar-2col');
    }

    public function blogRightSidebar()
    {
        return view('include.blog.blog-right-sidebar');
    }

    public function blogFull2Col()
    {
        return view('include.blog.blog-full-2col');
    }

    public function blogFull3Col()
    {
        return view('include.blog.blog-full-3col');
    }

    public function blogDetails()
    {
        return view('include.blog.blog-details');
    }

    public function blogDetailsAudio()
    {
        return view('include.blog.blog-details-audio');
    }

    public function blogDetailsVideo()
    {
        return view('include.blog.blog-details-video');
    }

    public function blogDetailsImage()
    {
        return view('include.blog.blog-details-image');
    }

}
