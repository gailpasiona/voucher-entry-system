<?php

class Particular extends Eloquent {
    
    protected $table = 'voucher_items';
    
    public function voucher(){
        return $this->belongsTo('Voucher', 'voucher_number');
    }
    
    public function receipt(){
        return $this->hasMany('Receipt', 'particular_id');
    }
}