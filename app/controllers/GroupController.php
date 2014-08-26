<?php

class GroupController extends BaseController{
    
    public function create(){
        $permissions= Permission::select('id','display_name')->get();
       
        return View::make('groups.create')->with('permissions',$permissions);
    }
    
    public function save(){
        
        $group = new Role();
        
        $group->name = Input::get( 'group_name' );
       
        if($group->validate()){
            
            if($group->save()){
                $group->perms()->sync(Input::get('permissions'));
                
                return Redirect::action('GroupController@create')
                            ->with('notice', 'User Group Successfuly added!');
            }
            else{
                $error = $user->errors()->all(':message');

                return Redirect::action('GroupController@create')
                            ->withInput(Input::all())
                            ->with( 'error', $error );
            }
        }
        else{
            //dd($group->errors()->all(':message'));
            return Redirect::action('GroupController@create')
                            ->withInput(Input::all())
                            ->with( 'error', $group->errors()->all(':message'));
        }
    }
    
    public function add_permission(Role $group, $perms){
       // $group = Role::where('name','Superuser')->first();
       // $perm1 = Permission::where('name' ,'manage_users')->first();
       // $perm2 = Permission::where('name', 'manage_vouchers')->first();
        
        $group->perms()->sync($perms);
    }
    
    public function attach_user(){
//        $user = User::where('username','gailpasiona')->first();
//        $group = Role::where('name','Superuser')->first();
//        $user->attachRole($group);
        $group= Role::select('id','name')->get();
        $users = User::select('id','username')->get();
        return View::make('groups.assign_to_group')->with('roles',$group)
                ->with('users',$users);
    }
    
    public function update_user_role(){
        $groups = Role::select('id','name')->get();
        $users = User::select('id','username')->get();
        $message = null;
        $user = User::where('id',Input::get('user'))->first();
        $group = Role::where('id',Input::get('role'))->first();
        
        if(!$user->hasRole($group->name)){
            $user->attachRole($group);
            $message = "User's Role Updated!";
        }
        else
            $message = "User is already assigned to the role";
            
        
//        foreach( $user->roles as $role ){
//            $prev_role = $role->name;
//        }
//        
//        $user->detachRole(Role::where('name',$prev_role)->first());
//        
//        
//        
        return View::make('groups.assign_to_group')->with('roles',$groups)
                ->with('users',$users)
            ->with('notice', $message);
        
    }
    
}
