<?php

class Voucher extends Eloquent {
    
    protected $table = 'vouchers';
    
    protected $primaryKey = 'voucher_number';
    
    public static $rules = array(
       // 'voucher_number' => 'required',
        'payee'  => 'required',
        'total_amount' => 'required|amount',
        'bank'  =>  'required|alpha_spaces_letteronly',
        'check_number'  =>  'required|alpha_num',
        'check_date'    =>  'required|date',
        'voucher_date'    =>  'required|date',
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
            static::$rules["ref_no.{$i}"] = 'alpha_num';
            static::$rules["particular.{$i}"] = 'required|alpha_spaces';
            static::$rules["amount.{$i}"] = 'required|amount';
            $att["ref_no.{$i}"] = "Reference for Item No. " . "{$line}";
            $att["particular.{$i}"] = "Particular Description for Item No. " . "{$line}";
            $att["amount.{$i}"] = "Amount for Item No. " . "{$line}";
        }
        }
        $validator = Validator::make($input, static::$rules);
        $validator->setAttributeNames($att);
        
        return $validator;
    }
    
}