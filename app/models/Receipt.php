<?php

class Receipt extends Eloquent {
    
    protected $table = 'item_receipts';
    
//    public static $rules = array(
//        'gross_amt' => 'required|amount',
//        'net_vat' => 'required|amount',
//        'ewt' => 'required|amount',
//        'receipt_no'  =>  'required',
//    );
    
    public static function validate($input) {
        $att = array();
       //extra validation rules for dynamic fields
        if(isset($input['receipt_no'])){
            for($i=0;$i < count($input['receipt_no']);$i++){
                $line = $i + 1;
                //static::$rules["receipt_no.{$i}"] = 'required';
                static::$rules["gross_amt.{$i}"] = 'required|amount';
                static::$rules["net_vat.{$i}"] = 'required|amount';
                static::$rules["ewt.{$i}"] = 'required|amount';
                $att["receipt_no.{$i}"] = "Receipt Number for Item No. " . "{$line}";
                $att["gross_amt.{$i}"] = "Gross Amount for Item No. " . "{$line}";
                $att["net_vat.{$i}"] = "Vat Amount for Item No. " . "{$line}";
                $att["ewt.{$i}"] = "EWT Amount for Item No. " . "{$line}";
            }
        }
        $validator = Validator::make($input, static::$rules);
        $validator->setAttributeNames($att);
        
        return $validator;
    }
    
    public function particular(){
        return $this->belongsTo('Particular');
    }
}