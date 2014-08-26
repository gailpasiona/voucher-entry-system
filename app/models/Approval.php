<?php

class Approval extends Eloquent {
    
    protected $table = 'voucher_Approval';
    
    public function voucher(){
        return $this->belongsTo('Voucher', 'voucher_number');
    }
}
