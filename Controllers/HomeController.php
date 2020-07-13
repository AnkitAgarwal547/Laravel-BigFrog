<?php

namespace App\Http\Controllers;

use App\Admin\Stores;
use App\AdminUser;
use App\Blogs;
use App\Coupons;
use App\CouponsVideoGuide;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Sliders;
use App\Pages;
use App\Settings;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$page = page('home');
        $author_name = AdminUser::first();
        $author_name     = $author_name->name;
		$page_detail = Pages::where('slug', 'home')->first();
		// $sliders = Sliders::where('visibility', 1)->get();
        $featured = Stores::where('featured_store', 1)->with(['storeReview'])->orderByDesc('created_at')->limit(10)->get();
        $latest_blogs = Blogs::where('visibility',1)->orderBy('created_at', 'desc')->limit(6)->get();
        $video_guide = CouponsVideoGuide::orderByDesc('created_at')->first();
        
        $featured_posts = Blogs::where('visibility',1)->where('featured_post', 1)->orderBy('created_at', 'desc')->limit(6)->get();

        $top_rated_coupon = Coupons::where('valid_till', '>=', Carbon::now())->where('status', 1)->where('featured', 1)->orderByDesc('clicks')->orderByDesc('created_at')->with(['store'])->limit(7)->get();

        return view('home',compact('page', 'page_detail', 'featured', 'video_guide','latest_blogs', 'top_rated_coupon', 'author_name', 'featured_posts'));
    }
}
