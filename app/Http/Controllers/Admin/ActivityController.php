<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

//use App\Language;

class ActivityController extends AdminController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index () {
		// Show the page
		return view('admin.activity.index');
	}

}
