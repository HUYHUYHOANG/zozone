<?php

defined("LPCTSTR_TOKEN") or die(":-((");

class TheBookingC2rt{    
    private static $cartName = "_THE_SHOP_BOOKING_ITEMS_";
    private $cart = array();

    public function __construct($shopId){
        self::$cartName .= md5(self::$cartName.$shopId);
        $this->_getData();
    }

    public function __get($name){
        if($name==='items') return $this->cart;
        elseif($name==='count') return count($this->cart);
        else return false;
    }

    public function add($itemId, &$itemData){
        $this->cart[$itemId] = $itemData;
        $this->_save();
    }

    public function remove($itemId){
        if(isset($this->cart[$itemId])) {
            $this->cart[$itemId] = null; unset($this->cart[$itemId]); $this->_save();
        }
    }

    public function count(){
        return count($this->cart);
    }

    private function _save(){
        $_SESSION[self::$cartName] = $this->cart;
    }

    public function clear(){
        if(isset($_SESSION[self::$cartName]))
            $_SESSION[self::$cartName] = null;
        $this->cart = array();
    }

    public static function clearCart($shopId = 0){
        if(isset($_SESSION[self::$cartName]))
            $_SESSION[self::$cartName] = null;
        else{
            if($shopId>0){
                self::$cartName .= md5('_THE_SHOP_BOOKING_ITEMS_'.$shopId);
                if(isset($_SESSION[self::$cartName])) $_SESSION[self::$cartName] = null;
            }
        }
    }

    private function _getData(){
        if(isset($_SESSION[self::$cartName])){
            $this->cart = $_SESSION[self::$cartName];            
        }
        if(!is_array($this->cart)) $this->cart = array();
    }
}
?>