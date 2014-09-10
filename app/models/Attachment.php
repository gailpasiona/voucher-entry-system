<?php

class Attachment extends Eloquent {
    
    protected $table = 'attachments';
    
    //protected $primaryKey = 'voucher_number';
    
    public static $rules = array(
       // 'voucher_number' => 'required',
        'voucher_number'  => 'required',
        'url' => 'required|url',
        'description'  =>  'alpha_spaces_letteronly',
    );

    public function voucher(){
        return $this->belongsTo('Voucher', 'voucher_number');
    }
    
   
    
}