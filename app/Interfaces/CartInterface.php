<?php

namespace App\Interfaces;

interface CartInterface 
{
    public function couponCheck($coupon_code);
    public function couponRemove();
    public function addToCart(array $data);
    public function viewByIp();
    public function delete($id);
    public function empty();
    public function qtyUpdate($id, $type);
}