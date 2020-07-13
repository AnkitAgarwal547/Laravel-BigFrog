<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pages;
use App\Faqs;

class PagesController extends Controller
{
    public function index($page_slug){
		$page = Pages::where('slug', $page_slug)->first();
		if(!empty($page)){
			return view('pages',compact('page'));
		}
		else{
			return redirect('/');
		}
	}

	public function faq(){
		
		$page = Pages::where('slug', 'faq')->first();
		if(!empty($page)){
			$faqs = Faqs::where('visibility',1)->get();
			return view('faq',compact('page','faqs'));
		}else{
			return redirect('/');
		}
	}
}
