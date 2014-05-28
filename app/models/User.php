<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Entrust\HasRole;

class User extends ConfideUser {
    use HasRole;
    
    public function voucher(){
        return $this->hasMany('Voucher','created_by');
    }
}