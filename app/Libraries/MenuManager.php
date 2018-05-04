<?php

namespace App\Libraries;

use App\Models\UserPromo;
use App\Models\Promo;
use App\User;
use Carbon\Carbon as Carbon;
use DB;
use App\Models\Menu;
class MenuManager {
    function __construct($user_id) {
        $this->user_id = $user_id;
    }

    function SetUserPromos(){
        $user_id = $this->user_id;
        $user = User::where('id', $user_id)->first();
        $promosApplied = UserPromo::where('user_id', $user_id)->pluck('promo_id')->toArray();
        $promosToApplyQuery =  "select id from promos where code is null and (valid_from is null or valid_from <= now()) and (valid_to is null or valid_to >=now())";
        $promosToApply = DB::select($promosToApplyQuery);
        foreach($promosToApply as $promo){
            if(!in_array($promo->id, $promosApplied)) {
                $userPromo = new UserPromo();
                $userPromo->user_id = $user->id;
                $userPromo->promo_id = $promo->id;
                $userPromo->start_date = Carbon::today()->toDateString();
                $userPromo->save();
            }
        }
        return $this->TrialPeriodMenuAssembler();
    }
    function hasPayed(){
        $user_id = $this->user_id;
        return 0;
    }
    public function TrialPeriodMenuAssembler(){
        $user_id = $this->user_id;
        $menus = [];
        if($this->hasPayed()){
            $menus = GetAllRoleBasedMenu();
        }else{
            $dashboardMenu = Menu::where('url', '#/dashboard')->first();
            if(count($dashboardMenu) >0) {
                $menus[] = $dashboardMenu;
            }
            $freeMenus = [];
            $userPromosQuery = "select *, DATE_ADD(user_promos.start_date, interval promos.free_days day) as end_date from user_promos left join promos on (user_promos.promo_id = promos.id) where user_id = ".$user_id." and start_date <= now() and DATE_ADD(user_promos.start_date, interval promos.free_days day) >= now()";
            $userPromos = DB::select($userPromosQuery);
            if(count($userPromos) >0) {
                $freeMenuQuery = "SELECT menu_item_id FROM `free_functions` 
                                    where now() >= Date( CONCAT_WS ('-', YEAR(CURDATE()), start_month, start_day))
                                    and Now()<= Date( CONCAT_WS ('-', YEAR(CURDATE()), end_month, end_day))
                                    and (valid_from is null or valid_from <=now()) and (valid_to is null or valid_to >= now())";
                $freeMenusResults = DB::select($freeMenuQuery);
                foreach($freeMenusResults as $key => $freeMenusResult){
                    $findMenu = Menu::where('url', $freeMenusResult->menu_item_id)->first();
                    if(count($findMenu) >0){
                        $menus[] = $findMenu;
                    }

                }
                if(count($freeMenusResults)>0){
                    $propertiesMenu = Menu::where('url', '#/properties')->first();
                    if(count($propertiesMenu) >0) {
                        $menus[]= $propertiesMenu;
                    }
                    $tenantMenu = Menu::where('url', '#/tenants')->first();
                    if(count($tenantMenu) >0) {
                        $menus[]= $tenantMenu;
                    }
                }
            }
            $settingMenu = Menu::where('url', '#/settings')->first();
            if(count($settingMenu) >0) {
                $menus[] = $settingMenu;
            }
        }
        return $menus;
    }
    function GetAllRoleBasedMenu(){
        $user = User::where('id', $this->user_id)->first();
        $menu = Menu::all(['label', 'url', 'icon', 'roles']);
        $role = $user->role;
        $roles = [];
        foreach ($role as $value) {
            $roles[] = $value->slug;
        }

        foreach ($menu as $key => $menuItem) {
            $menuRoles = json_decode($menuItem->roles);
            if (!$this->isInArray($roles, $menuRoles)) {
                unset($menu[ $key ]);
            }
        }
        return $menu;
    }

    public function isInArray($roles, $menuRoles){
        foreach ($roles as $role) {
            if (in_array($role, $menuRoles)) {
                return true;
            }
        }
        return false;
    }

    function codeEnteredInSettings($code){
        $user_id = $this->user_id;
        $promo = Promo::where('code',$code)->first();
        if(count($promo) >0) {
            $userPromo = new UserPromo();
            $userPromo->user_id = $user_id;
            $userPromo->promo_id = $promo->id;
            $userPromo->start_date = Carbon::today()->toDateString();
            $userPromo->save();
        }
        return true;
    }
}