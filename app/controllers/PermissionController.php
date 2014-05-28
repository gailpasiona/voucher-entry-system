<?php

class PermissionController extends BaseController{
    
    public function create(){
        return View::make('groups.create_permission');
    }
    
    public function save(){
        $permission = new Permission();
        
        $permission->name = Input::get( 'perm_name' );
        
        $permission->display_name = Input::get( 'perm_dispname' );
        
        $permission->save();
    }
    
}
