<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Stores;
use App\Coupons;
use App\CouponTypes;
use App\Libraries\Slug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $coupons = Coupons::orderByDesc('created_at')->get();
        return view('admin.coupon.show', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        //
        $couponTypes = CouponTypes::all();
        $stores = Stores::all();
        return view('admin.coupon.add', compact('couponTypes', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name'              => 'required|min:5',
            'coupon_code'       => 'required',
            'valid_till'        => 'required',
            'coupon_type'       => 'required',
            'store_id'          => 'required',
            'link_to_go'        => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('admin/coupon/add')
                ->withErrors($validator)
                ->withInput();
        }

        $name               = $request->input('name');
        $description        = $request->input('description');
        $coupon_code        = $request->input('coupon_code');
        $coupon_value       = $request->input('coupon_value');
        $amount_type        = $request->input('amount_type');


        $valid_till         = $request->input('valid_till');
        $coupon_type        = $request->input('coupon_type');
        $store_id           = $request->input('store_id');
        $link_to_go         = $request->input('link_to_go');
        $related_coupon     = $request->input('related_coupon');
        $featured_coupon     = $request->input('featured_coupon');

        $page_title         = $request->input('page_title');
        $page_keyword       = $request->input('page_keyword');
        $page_description   = $request->input('page_description');


        $slugClass = new Slug();
        $couponSlug = $slugClass->make($name, 'coupons', 'slug');

        $coupon = new Coupons();

        $coupon->name               = $name;
        $coupon->slug               = $couponSlug;
        $coupon->description        = $description;
        $coupon->coupon_code        = $coupon_code;
        $coupon->value              = $coupon_value;
        $coupon->amount_type        = $amount_type;
        $coupon->valid_till         = $valid_till;
        $coupon->coupon_types       = $coupon_type;
        $coupon->store_id           = $store_id;
        $coupon->link_to_go         = $link_to_go;
        $coupon->related            = ($related_coupon == 1) ? 1 : 2;
        $coupon->featured           = ($featured_coupon == 1) ? 1 : 0;

        $coupon->page_title         = $page_title;
        $coupon->page_description   = $page_description;
        $coupon->page_keyword       = $page_keyword;

        if ($request->hasFile('feature_image'))
        {
            $image = $request->file('feature_image');

            $filename  = $couponSlug.'-'.rand(11111,99999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/uploads/coupons/'), $filename);
            $coupon->featured_image = 'assets/uploads/coupons/'.$filename;

            $path = "assets/uploads/blog/coupons/";
            dean_image_compression($filename, $path);
        }


        if($coupon->save()){
            Session::flash('message', "Coupon added successfully.");
            return redirect('admin/coupons');
        }else{
            Session::flash('error', "Coupon creation fails. Please try again after some time.");
            return redirect('admin/coupons');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $editCoupon = Coupons::findorfail($id);
        if(!empty($editCoupon)){
            $couponTypes = CouponTypes::all();
            $stores      = Stores::all();
            $selectType  = CouponTypes::where('id', $editCoupon->coupon_types)->first();
            $selectStore = Stores::where('id', $editCoupon->store_id)->first();
            return view('admin.coupon.edit', compact('editCoupon','couponTypes', 'stores', 'selectType', 'selectStore'));
        }
        else{
            return view('admin.coupon.show');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //dd($request->all());
        $coupon = Coupons::findorfail($id);
        if(!empty($coupon)){
            $rules = [
                'name'          => 'required|min:5',
                'coupon_type'   => 'required',
                'valid_till'    => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect('admin/coupon/edit'.'/'.$id)
                    ->withErrors($validator)
                    ->withInput();
            }

            $name               = $request->input('name');
            $description        = $request->input('description');
            $coupon_code        = $request->input('coupon_code');
            $coupon_value       = $request->input('coupon_value');
            $amount_type        = $request->input('amount_type');


            $valid_till         = $request->input('valid_till');
            $coupon_type        = $request->input('coupon_type');
            $store_id           = $request->input('store_id');
            $link_to_go         = $request->input('link_to_go');
            $related_coupon     = $request->input('related_coupon');
            $featured_coupon    = $request->input('featured_coupon');

            $page_title         = $request->input('page_title');
            $page_keyword       = $request->input('page_keyword');
            $page_description   = $request->input('page_description');

            $coupon->name               = $name;
            $coupon->description        = $description;
            $coupon->coupon_code        = $coupon_code;
            $coupon->value              = $coupon_value;
            $coupon->amount_type        = $amount_type;
            $coupon->valid_till         = $valid_till;
            $coupon->coupon_types       = $coupon_type;
            $coupon->store_id           = $store_id;
            $coupon->link_to_go         = $link_to_go;
            $coupon->page_title         = $page_title;
            $coupon->page_description   = $page_description;
            $coupon->page_keyword       = $page_keyword;
            $coupon->related            = ($related_coupon == 1) ? 1 : 2;
            $coupon->featured           = ($featured_coupon == 1) ? 1 : 0;

            $status = $request->input('status');
            if($coupon->status != $status){
                $coupon->status = $status;
            }

            if ($request->hasFile('feature_image'))
            {
                $image = $request->file('feature_image');

                $filename  = $coupon->slug.'-'.rand(11111,99999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/uploads/coupons/'), $filename);
                $coupon->featured_image = 'assets/uploads/coupons/'.$filename;

                $path = "assets/uploads/blog/coupons/";
                dean_image_compression($filename, $path);
            }

            if($coupon->save()) {
                Session::flash('message', "Coupon updated successfully.");
                return redirect('admin/coupons');
            }
            else{
                Session::flash('error', "Coupon updated fails. Please try again after some time.");
                return redirect('admin/coupons');
            }
        }
        else{
            return view('admin.coupon.show');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $deleteCoupon   = Coupons::find($id);
        if(!empty($deleteCoupon)){
            $deleteCoupon->delete();
            Session::flash('message', "Coupon deleted successfully.");
            return redirect('admin/coupons');
        }else{
            Session::flash('message', "Coupon deletion fails. Please try after some time !");
            return redirect('admin/coupons');
        }
    }

    /**
     * Coupon Types starts from here
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    // ----------------------------------------------------------------------------

    //TYPES LISTING
    public function Types(){
        $types = CouponTypes::all();
        //$categories = Categories::where('parent', '=', 0)->get();
        return view('admin.coupon.addType',compact('types'));
    }


    public function saveType(Request $request){
        $validator = Validator::make($request->all(),[
            'typename' => 'required|min:3',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
        ]);

        if ($validator->fails()) {
            return redirect('admin/coupons/types')
                ->withErrors($validator)
                ->withInput();
        }

        $typename 			= $request->input('typename');
        $typeslug 			= $request->input('slug');

        $type_cat		= $request->input('categories');
        if($type_cat != '') {
            $type_cat   = implode(",", $type_cat);
        }else{
            $type_cat = '';
        }

        $typeDescription 	= $request->input('description');
        $page_title     	= $request->input('page_title');
        $page_keyword   	= $request->input('page_keyword');
        $page_description 	= $request->input('page_description');


        if($typeslug == ''){
            $typeslug = str_slug($typename, '-');
        }

        $slugClass = new Slug();
        $newslug = $slugClass->make($typeslug, 'coupon_types', 'slug');


        $type  = new CouponTypes();
        $type->title 			= $typename;
        $type->slug 			= $newslug;
        $type->categories 		= $type_cat;
        $type->description 		= $typeDescription;
        $type->page_title 		= $page_title;
        $type->page_keyword 	= $page_keyword;
        $type->page_description = $page_description;
        $type->visible_status 	= 1;


        $filename = '';

        if ($request->hasFile('thumbnail'))
        {
            $image = $request->file('thumbnail');
            $filename  = $newslug .'-'.rand(11111,99999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/uploads/coupons/types/'), $filename);
            $type->thumbnail 		= 'assets/uploads/coupons/types/'.$filename;

            $path = "assets/uploads/blog/coupons/types/";
            dean_image_compression($filename, $path);
        }

        $main_image = '';
        if ($request->hasFile('main_image'))
        {
            $image = $request->file('main_image');
            $main_image  = $newslug .'-'.rand(11111,99999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/uploads/coupons/types/'), $main_image);
            $type->main_image 		= 'assets/uploads/coupons/types/'.$main_image;

            $path = "assets/uploads/blog/coupons/types/";
            dean_image_compression($filename, $path);
        }

        $featured_image = '';
        if ($request->hasFile('featured_image'))
        {
            $image = $request->file('featured_image');
            $featured_image  = $newslug .'-'.rand(11111,99999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/uploads/coupons/types/'), $featured_image);
            $type->featured_image 		= 'assets/uploads/coupons/types/'.$featured_image;

            $path = "assets/uploads/blog/coupons/types/";
            dean_image_compression($filename, $path);
        }

        if($type->save()){
            Session::flash('message', "Coupon Type created successfully.");
            return Redirect::back();
        }else{
            Session::flash('error', "Coupon Type creation fails. Please try again after some time.");
            return Redirect::back();
        }
    }

    public function editType($id)
    {
        $editType   = CouponTypes::find($id);
        if(!empty($editType)){
//            $categories = Categories::where('parent', '=', 0)->get();
            return view('admin.coupon.editType',compact('editType'));
        }else{
            return redirect('admin/coupons/types');
        }
    }

    public function updateType($id, Request $request){
        $editType   = CouponTypes::find($id);
        if(!empty($editType)){
            $validator = Validator::make($request->all(),[
                'typename' 		=> 'required|min:3',
                'thumbnail' 		=> 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'main_image' 		=> 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'featured_image' 	=> 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'slug'				=> 'unique:coupon_types,slug,'.$id,
            ]);

            if ($validator->fails()) {
                return redirect('admin/coupons/edit-type/'.$id)
                    ->withErrors($validator)
                    ->withInput();
            }
            $typename 			= $request->input('typename');
            $typeslug 			= $request->input('slug');

            $type_cat		= $request->input('categories');
            if($type_cat != '') {
                $type_cat   = implode(",", $type_cat);
            }else{
                $type_cat = '';
            }

            $typeDescription 	= $request->input('description');
            $page_title     	= $request->input('page_title');
            $page_keyword   	= $request->input('page_keyword');
            $page_description 	= $request->input('page_description');

            if($typeslug == ''){
                $typeslug = str_slug($typename, '-');
                $slugClass = new Slug();
                $typeslug = $slugClass->make($typeslug, 'coupon_types', 'slug');
            }

            $filename = '';
            if($request->hasFile('thumbnail'))
            {
                $image = $request->file('thumbnail');
                $filename  = $typeslug .'-'.rand(11111,99999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/uploads/coupons/types/'), $filename);
                $editType->thumbnail = 'assets/uploads/coupons/types/'.$filename;

                $path = "assets/uploads/blog/coupons/types/";
                dean_image_compression($filename, $path);
            }

            $main_image = '';
            if($request->hasFile('main_image'))
            {
                $image = $request->file('main_image');
                $main_image  = $typeslug .'-'.rand(11111,99999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/uploads/coupons/types/'), $main_image);
                $editType->main_image = 'assets/uploads/coupons/types/'.$main_image;

                $path = "assets/uploads/blog/coupons/types/";
                dean_image_compression($filename, $path);
            }

            $featured_image = '';
            if($request->hasFile('featured_image'))
            {
                $image = $request->file('featured_image');
                $featured_image  = $typeslug .'-'.rand(11111,99999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/uploads/coupons/types/'), $featured_image);
                $editType->featured_image 		= 'assets/uploads/coupons/types/'.$featured_image;

                $path = "assets/uploads/blog/coupons/types/";
                dean_image_compression($filename, $path);
            }



            $editType->title 		= $typename;
            $editType->slug 		= $typeslug;
            $editType->categories 	= $type_cat;

            $editType->description = $typeDescription;
            $editType->page_title 	= $page_title;
            $editType->page_keyword = $page_keyword;
            $editType->page_description = $page_description;
            $editType->visible_status = 1;
            $editType->updated_at = date('Y-m-d H:i:s');
            if($editType->save()){
                Session::flash('message', "Coupons Type updated successfully.");
                return redirect('admin/coupons/types');
            }

        }else{
            return redirect('admin/coupons/types');
        }

    }

    public function deleteType($id)
    {
        $delType  = CouponTypes::find($id);
        if(!empty($delType)){
            if($delType->thumbnail){
                unlink(public_path($delType->thumbnail));
            }
            if($delType->main_image) {
                unlink(public_path($delType->main_image));
            }
            $delType->delete();
            Session::flash('message', "Coupons Type deleted successfully.");
            return redirect('admin/coupons/types');
        }else{
            return redirect('admin/coupons/types');
        }
    }

    /**
     * Coupon Value types start from here
     */
    // ----------------------------------------------------------------------------

}
