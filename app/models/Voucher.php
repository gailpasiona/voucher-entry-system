<?php

class Voucher extends Eloquent {
    
    protected $table = 'vouchers';
    
    protected $primaryKey = 'voucher_number';
    
    public static $rules = array(
        'payee'  => 'required',
        'total_amount' => 'required|amount',
        'bank'  =>  'required|alpha_spaces_letteronly',
        'check_number'  =>  'required|alpha_num',
        'particular' => 'required',
    );


    //one-to-many relationship 
    public function particulars(){
        return $this->hasMany('Particular', 'voucher_number');
    }
    
    public function payto(){
        return $this->belongsTo('BusinessPartner' , 'payto_id');
    }
    
    public function user(){
        return $this->belongsTo('User', 'created_by');
    }
    
    public static function validate($input) {
        $att = array();
       //extra validation rules for dynamic fields
        if(isset($input['particular'])){
            for($i=0;$i < count($input['particular']);$i++){
            $line = $i + 1;
            static::$rules["particular.{$i}"] = 'required|alpha_spaces';
            static::$rules["amount.{$i}"] = 'required|amount';
            $att["particular.{$i}"] = "Particular Description for Item No. " . "{$line}";
            $att["amount.{$i}"] = "Amount for Item No. " . "{$line}";
        }
        }
        $validator = Validator::make($input, static::$rules);
        $validator->setAttributeNames($att);
        
        return $validator;
    }
    
}