<?php

class Particular extends Eloquent {
    
    protected $table = 'voucher_items';
    
    public function voucher(){
        return $this->belongsTo('Voucher', 'voucher_number');
    }
}