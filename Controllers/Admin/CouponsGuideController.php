<?php

namespace App\Http\Controllers\Admin;

use App\CouponsGuide;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CouponsGuideController extends Controller
{
    /**
     * Show All guide to Admin
     */
    public function index(){
        $guides = CouponsGuide::all();
        return view('admin.guide.show', compact('guides'));
    }

    /**
     * Add Coupon Guide
     */
    public function addGuide(){
        return view('admin.guide.add');
    }

    /**
     * Save Guide to Database
     */
    public function saveGuide(Request $request){

        $rules = [
            'name'          => 'required',
            'description'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('admin/guide/add')
                ->withErrors($validator)
                ->withInput();
        }
        $name           = $request->input('name');
        $description    = $request->input('description');

        $addGuide = new CouponsGuide();

        $addGuide->name           =   $name;
        $addGuide->description    =   $description;

        if($addGuide->save()){
            Session::flash('message', "Guide added successfully.");
            return redirect('admin/guide');
        }else{
            Session::flash('error', "Guide creation fails. Please try again after some time.");
            return redirect('admin/guide');
        }
    }

    /**
     * Edit Guide
     */
    public function editGuide($id){
        $editGuide = CouponsGuide::findorfail($id);
        return view('admin.guide.edit', compact('editGuide'));
    }

    /**
     * Update Guide to Database
     */

    public function updateGuide(Request $request, $id){
        $updateGuide = CouponsGuide::findorfail($id);
        if(!empty($updateGuide)){
            $rules = [
                'name'          => 'required',
                'description'   => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect('admin/guide/add')
                    ->withErrors($validator)
                    ->withInput();
            }
            $name           = $request->input('name');
            $description    = $request->input('description');

            $updateGuide->name           =   $name;
            $updateGuide->description    =   $description;

            if($updateGuide->save()){
                Session::flash('message', "Guide updated successfully.");
                return redirect('admin/guide');
            }else{
                Session::flash('error', "Guide updation fails. Please try again after some time.");
                return redirect('admin/guide');
            }
        }
        else{
            return view('admin.guide.show');
        }
    }

    /**
     * Delete Guide from Database
     */

    public function deleteGuide($id){
        $deleteStore   = CouponsGuide::find($id);
        if(!empty($deleteStore)){
            $deleteStore->delete();
            Session::flash('message', "Guide deleted successfully.");
            return redirect('admin/guide');
        }else{
            return redirect('admin/guide');
        }
    }
}
