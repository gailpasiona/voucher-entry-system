<?php

class GroupController extends BaseController{
    
    public function create(){
        return View::make('groups.create');
    }
    
    public function save(){
        $group = new Role();
        
        $group->name = Input::get( 'group_name' );
        
        $group->save();
        
    }
    
    public function add_permission(){
        $group = Role::where('name','Superuser')->first();
        $perm1 = Permission::where('name' ,'manage_users')->first();
        $perm2 = Permission::where('name', 'manage_vouchers')->first();
        
        $group->perms()->sync(array($perm1->id, $perm2->id));
    }
    
    public function attach_user(){
        $user = User::where('username','gailpasiona')->first();
        $group = Role::where('name','Superuser')->first();
        $user->attachRole($group);
    }
    
}
