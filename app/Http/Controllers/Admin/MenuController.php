<?php namespace App\Http\Controllers\Admin;

use Auth;

use App\Http\Controllers\AdminController;
use App\Models\Menu;
//use App\Language;
use Carbon\Carbon;
use App\Libraries\MenuManager;

class MenuController extends AdminController {

    public function postMenu () {
//        $menu = Menu::all(['label', 'url', 'icon', 'roles']);
//        $role = Auth::user()->role;
//        $roles = [];
//        foreach ($role as $value) {
//            $roles[] = $value->slug;
//        }
//
//        foreach ($menu as $key => $menuItem) {
//            $menuRoles = json_decode($menuItem->roles);
//            if (!$this->isInArray($roles, $menuRoles)) {
//                unset($menu[ $key ]);
//            }
//        }
//
//        return response()->json($menu);
        $user = Auth::user();
        $roles = is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
        $menuManager = new MenuManager($user->id);
        if(in_array('landlord', $roles)){
            $menu = $menuManager->SetUserPromos();
        }else{
            $menu = $menuManager->GetAllRoleBasedMenu();
        }
        return response()->json($menu);
    }

    public function isInArray($roles, $menuRoles){
        foreach ($roles as $role) {
            if (in_array($role, $menuRoles)) {
                return true;
            }
        }
        return false;
    }

    /*
 * makes no sense but leave it here for the moment
 */

    public function getMenu () {
        return redirect('dashboard');
    }

    public function postInsertMenu () {
    }

    public function postUpdateMenu () {
    }

    public function getEditMenu ($id) {
    }

}
