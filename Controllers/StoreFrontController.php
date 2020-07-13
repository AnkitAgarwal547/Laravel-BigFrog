<?php

namespace App\Http\Controllers;

use App\Admin\Stores;
use App\Coupons;
use App\CouponsGuide;
use App\Pages;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreFrontController extends Controller
{

    protected $no_of_rows = 12;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeBySlug($storeSlug)
    {
        //
        //dd($storeSlug);
        $featured = Stores::where('featured_store', 1)->with(['storeReview'])->orderByDesc('created_at')->limit(6)->get();
        $store_detail = Stores::with(['coupon','storeReview', 'storeGallery'])->where('slug',$storeSlug)->first();
        $page = Stores::where('slug', $storeSlug)->first();
        if(!empty($store_detail)){
            return view('coupons.store-details', compact('store_detail', 'page', 'featured'));
        }
        else{
            return redirect('home');
        }
    }

    /**
     * Search Method Functionality
     */
    public function search(Request $request){

        $q = $request->input('search');
        $q = strtolower($q);
        if(!empty($q)){
            $guide    = CouponsGuide::all();
            $page     = Pages::where('slug', 'home')->first();
            $coupons['store']  = Stores::where('name','LIKE','%'.$q.'%')->orWhere('description','LIKE','%'.$q.'%')
                ->with(['couponActiveSearch'])->get();

            //$coupons['coupon'] = Coupons::where('name','LIKE','%'.$q.'%')->orWhere('coupon_code','LIKE','%'.$q.'%')->with(['store'])->get();

            /*$coupons['coupon'] = Coupons::where(function ($result) use($q){
                $result->where('name','LIKE','%'.$q.'%')->orWhere('coupon_code','LIKE','%'.$q.'%');
            })->where('status', 1)->with(['store'])->get();*/

            $coupons['coupon'] = Coupons::where(function ($result) use($q){
                $result->where('name','LIKE','%'.$q.'%')->orWhere('coupon_code','LIKE','%'.$q.'%');
                })->orWhereHas('store', function($qu) use ($q) {
                    $qu->where('name', 'LIKE', '%'.$q.'%');
                })->where('status', 1)->with(['store'])->get();

            $relatedCoupon = Coupons::where('related', 1)->where('status', 1)->with(['store'])->limit(10)->get();

            return view('coupons.coupon-search', compact('page', 'coupons', 'guide','q', 'relatedCoupon'));
        }
        else{
            return redirect('/');
        }
    }

    /**
     * Count on coupon click copy button
     */
    public function couponCount($id){
        $count = Coupons::findorfail($id);

        if(session()->get($count->slug) == ''){
            $count->clicks = $count->clicks + 1;
            $count->save();
        }
        session()->put($count->slug, 1);
    }
}