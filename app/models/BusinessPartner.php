<?php

class BusinessPartner extends Eloquent{
    
    protected $table = 'business_partners';
    
    protected $primaryKey = 'bp_id';
    
    public function voucher(){
        return $this->hasMany('Voucher', 'payto_id');
    }
    public static function validate($input) {
        $rules = array(
                 'bp_name'  => 'required|min:4|alpha_spaces',
                 'bp_loc_building'  => 'required|min:4|alpha_spaces',
                 'bp_loc_street'    => 'required|min:4|alpha_spaces',
                 'bp_loc_city'  => 'required|min:4|alpha_spaces',
                 'bp_loc_country'   => 'required|min:4|alpha_spaces',
                 'bp_contact_fname' => 'required|min:4|alpha_spaces',
                 'bp_contact_lname' => 'required|min:4|alpha_spaces'
        );

                # validation code
        return Validator::make($input,$rules);
        
        }
        
}

