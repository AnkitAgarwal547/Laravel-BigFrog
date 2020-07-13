<?php

namespace App\Http\Controllers\Admin;

use App\CouponsVideoGuide;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CouponsVideoGuideController extends Controller
{
    //
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function videoGuide(){
        $links = CouponsVideoGuide::get();
        return view('admin.coupon.showVideoGuide', compact('links'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addVideoGuide(){
        return view('admin.coupon.videoGuide');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function saveVideoGuide(Request $request){

        $link = $request->input('video_link');

        Validator::make($request->all(), array(
            'video_link' => 'required',
        ))->validate();

        if(!empty($link)){
            $videoGuide = new CouponsVideoGuide();
            $videoGuide->video_link = $link;

            if($videoGuide->save()){
                Session::flash('message', 'Video Link Successfully saved');
                return redirect()->back();
            }
            else{
                Session::flash('error', 'Something went Wrong ! Please try again Later');
                return redirect()->back();
            }
        }
        return redirect('/admin/guide/video/show');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function editVideoGuide($id){
        $editVideoGuide = CouponsVideoGuide::findorfail($id);
        return view('admin.coupon.editVideoGuide', compact('editVideoGuide'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateVideoGuide($id, Request $request){

        Validator::make($request->all(), array(
           'video_link' => 'required',
        ))->validate();

        $updateVideoGuide = CouponsVideoGuide::findorfail($id);
        $video_link = $request->input('video_link');

        $updateVideoGuide->video_link = $video_link;
        if($updateVideoGuide->save()){
            Session::flash('message', 'Video Link Updated Successfully');
            return redirect('/admin/guide/video/show');
        }
        else{
            Session::flash('error', 'Video Link Updating Failed, please try again later !');
            return redirect('/admin/guide/video/show');
        }
    }
    public function deleteVideoGuide($id){
        $deleteVideoGuide = CouponsVideoGuide::findorfail($id);

        if($deleteVideoGuide->delete()){
            Session::flash('message', 'Video Link Deleted Successfully');
            return redirect('admin/guide/video/show');
        }
        else{
            Session::flash('error', 'Deletion Failed, Please Try again later');
            return redirect('admin/guide/video/show');
        }

    }
}
