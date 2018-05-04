<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;

class GuestController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index () {
        $title = "Rentling Guest Dashboard";

        return view('admin.dashboard.index', compact('title'));
    }

}