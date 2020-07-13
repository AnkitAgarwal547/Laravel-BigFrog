<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Stores;
use App\Http\Controllers\Controller;
use App\Libraries\Slug;
use App\StoreGallery;
use App\StoreReviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StoresController extends Controller
{
    //
    public function index(){
        $stores = Stores::orderByDesc('created_at')->with(['storeReview'])->get();
        return view('admin.store.show', compact('stores'));
    }

    public function add(){
        return view('admin.store.add');
    }

    // Save Store
    public function save(Request $request){

//        dd($request);
        $rules = [
            'name'              => 'required',
            'description'       => 'required',
            'image'             => 'required|max:2048',
            'url'               => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('admin/store/add')
                ->withErrors($validator)
                ->withInput();
        }

        $name           = $request->input('name');
        $description    = $request->input('description');
        $video          = $request->input('video');
        $url            = $request->input('url');
        $page_title     = $request->input('page_title');
        if(empty($page_title)){
            $page_title     = $request->input('name'). ' Coupons And Promo Codes – ' .env('APP_NAME');
        }
        $page_desc      = $request->input('page_description');
        if(!empty($page_desc)){
            $page_desc      = words($page_desc,20, '');
            $page_desc      = preg_replace( "/\r|\n/", "", $page_desc );
        }
        else{
            $page_desc      = 'Find the latest '. $name .' coupons and discount codes. Don\'t forget to bookmark ' .env('APP_NAME'). ' for all your savings and free shipping needs.';
        }
        $page_keyword   = $request->input('page_keyword');
        $featured_store	= $request->input('featured_store');

        $slugClass = new Slug();
        $storeSlug = $slugClass->make($name, 'stores', 'slug');

        $store = new Stores();

        $store->name                =   $name;
        $store->slug                =   $storeSlug;
        $store->description         =   $description;
        $store->url                 =   $url;
        $store->page_title          =   $page_title;
        $store->page_keyword        =   $page_keyword;
        $store->page_description    =   $page_desc;
        $store->video               =   $video;
        $store->featured_store      =   ($featured_store == 1) ? 1 : 0;

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');

            $filename  = $storeSlug.'-'.rand(11111,99999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/uploads/store/'), $filename);

            $path = "assets/uploads/store/";
            dean_image_compression($filename, $path);

            $store->image = 'assets/uploads/store/'.$filename;
        }


        $store->created_at 	= date('Y-m-d H:i:s');
        $store->updated_at 	= date('Y-m-d H:i:s');

        if($store->save()){
            $gallary_images = $request->file('gallery');

            if(!empty($gallary_images)){
                foreach($gallary_images as $ikey=>$index) {
                    $image = $index;

                    $filename  = $storeSlug.'-'.$ikey.'-'.time(). '.'. $image->getClientOriginalExtension();
                    $image->move(public_path('assets/uploads/stores/'), $filename);

                    $path = "assets/uploads/stores/";
                    dean_image_compression($filename, $path);

                    $storeGallery  = new StoreGallery();
                    $storeGallery->gallery_images 	    = 'assets/uploads/stores/'.$filename;
                    $storeGallery->store_id 		    =  $store->id;
                    $storeGallery->save();
                }
            }

            Session::flash('message', "Store added successfully.");
            return redirect('admin/stores');
        }else{
            Session::flash('error', "Store creation failed. Please try again after some time.");
            return redirect('admin/stores');
        }

    }

    // Edit Store
    public function edit($id){
        $store = Stores::findorfail($id);
        $storeGallery = StoreGallery::where('store_id', $id)->get();
        return view('admin.store.edit', compact('store', 'storeGallery'));
    }

    // Update Store
    public function update(Request $request, $id){
        $updateStore = Stores::findorfail($id);

        if(!empty($updateStore)){
            $rules = [
                'name'              => 'required',
                'description'       => 'required',
                'url'               => 'required',
                'image'             => 'max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect('admin/store/edit/'.$id)
                    ->withErrors($validator)
                    ->withInput();
            }

            $name           = $request->input('name');
            $description    = $request->input('description');
            $url            = $request->input('url');
            $video          = $request->input('video');
            $page_title     = $request->input('page_title');
            if(empty($page_title)){
                $page_title     = $request->input('name'). ' Coupons And Promo Codes – ' .env('APP_NAME');
            }
            $page_desc      = $request->input('page_description');
            if(!empty($page_desc)){
                $page_desc      = words($page_desc,20, '');
                $page_desc      = preg_replace( "/\r|\n/", "", $page_desc );
            }
            else{
                $page_desc      = 'Find the latest '. $name .' coupons and discount codes. Don\'t forget to bookmark ' .env('APP_NAME'). ' for all your savings and free shipping needs.';
            }
            $page_keyword   = $request->input('page_keyword');
            $featured_store	= $request->input('featured_store');

            $updateStore->name                =   $name;
            $updateStore->description         =   $description;
            $updateStore->url                 =   $url;
            $updateStore->video               =   $video;
            $updateStore->page_title          =   $page_title;
            $updateStore->page_keyword        =   $page_keyword;
            $updateStore->page_description    =   $page_desc;
            $updateStore->featured_store	  =   ($featured_store == 1) ? 1 : 0;

            if ($request->hasFile('image'))
            {
                $image = $request->file('image');

                $filename  = $updateStore->slug.'-'.rand(11111,99999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/uploads/store/'), $filename);
                $path = "assets/uploads/store/";
                dean_image_compression($filename, $path);
                $updateStore->image = 'assets/uploads/store/'.$filename;
            }
            $updateStore->updated_at 	= date('Y-m-d H:i:s');

            if($updateStore->save()){
                $gallary_images = $request->file('gallery');
                if(!empty($gallary_images)){
                    foreach($gallary_images as $ikey=>$index) {
                        $image = $index;
                        $filename  = $updateStore->slug.'-'.$ikey.'-'.time(). '.'. $image->getClientOriginalExtension();
                        $image->move(public_path('assets/uploads/stores/'), $filename);

                        // File Compression Starts

                        $path = "assets/uploads/stores/";
                        dean_image_compression($filename, $path);

                        // File compression Ends
                        $storeGallery  = new StoreGallery();
                        $storeGallery->gallery_images 	    = 'assets/uploads/stores/'.$filename;
                        $storeGallery->store_id 		    =  $updateStore->id;
                        $storeGallery->save();
                    }
                }
                Session::flash('message', "Store updated successfully.");
                return redirect('admin/stores');
            }else{
                Session::flash('error', "Store updation fails. Please try again after some time.");
                return redirect('admin/stores');
            }
        }else{
            return redirect('admin/stores');
        }
    }

    // Delete Store Gallery Images
    public function deleteStoreGallery($id){
        $deleteGallery  = StoreGallery::find($id);
        if(!empty($deleteGallery)){
            @unlink(public_path($deleteGallery->gallery_images));
            $deleteGallery->delete();
            echo "success";
        }else{
            echo "failed";
        }
    }

    // Delete Store
    public function delete($id){
        $deleteStore   = Stores::find($id);

        if(!empty($deleteStore)){
            $deleteStore->delete();
            $deleteGallery  = StoreGallery::where('store_id', $id)->get();
            if(!empty($deleteGallery)) {
                foreach ($deleteGallery as $d){
                    @unlink(public_path($d->gallery_images));
                    $d->delete();
                }
            }
            Session::flash('message', "Store deleted successfully.");
            return redirect('admin/stores');
        }else{
            Session::flash('message', "Store deletion fails. Please try after some time !");
            return redirect('admin/stores');
        }
    }

    /**
     * Reviews Functions starts from here
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    //------------------------------------------ Reviews -------------------------------------------
    public function showReview(){
        $reviews = StoreReviews::all();
        $storeDetail = Stores::where('store_reviewed', '=', 1)->get();
        return view('admin.storeReview.showReview', compact('reviews', 'storeDetail'));
    }

    public function saveReview(Request $request){

        $validator = Validator::make($request->all(),[
            'review_star'        => 'required|numeric|max:5',
        ]);

        $valid['data'] = json_encode($validator->errors());

        if ($validator->fails()) {
            $valid['status'] = 'failed';
            return response()->json($valid);
        }
        $review = new StoreReviews();

        $store_id           = $request->input('store_id');

        $store_slug = Stores::where('id', $store_id)->first();
        $store_slug = $store_slug->slug.$store_id;

        $review->store_id   = $store_id;
        $review->stars      = $request->input('review_star');
        $review->name       = $request->input('reviewer_name');
        $review->review     = $request->input('review');

        if(session()->get($store_slug) == ''){
            if($review->save()){
                Stores::where('id', $store_id)->update(['store_reviewed' => 1]);

                session()->put($store_slug, 1);

                $valid['status'] = 'success';
                return response()->json($valid);
            }
        }
        else{
            $valid['status'] = 'duplicate';
            $valid['data']   = "You've already Rated this Store.";
            return response()->json($valid);
        }
    }

    public function editReview($id){
        $reviewData = StoreReviews::where('id', $id)->first();
        return view('admin.storeReview.editReview',compact('reviewData'));
    }

    public function updateReview($id, Request $request){
        $updateReview = StoreReviews::findorfail($id);
        $updateReview->status = $request->input('status');
        if($updateReview->save()){
            Session::flash('message', "Review updated successfully.");
            return back();
        }
        else{
            Session::flash('message', "Something went wrong !!!");
            return back();
        }
    }
    public function deleteReview($id){
        $deleteReview = StoreReviews::findorfail($id);
        if(!empty($deleteReview)){
            $deleteReview->delete($id);
            Session::flash('message', "Review deleted successfully.");
            return redirect('admin/stores/reviews');
        }else{
            Session::flash('message', "Review deletion fails. Please try after some time !");
            return redirect('admin/stores/reviews');
        }
    }
}
