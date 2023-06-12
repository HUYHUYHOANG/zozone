<?php
defined("LPCTSTR_TOKEN") or die(":-((");

////*********************************************************************************************************************** */
/// DATA
////*********************************************************************************************************************** */
class CSystemDataModel extends CBoLogicData{
    private static $countries;

    public function __construct(&$config, $shopID){
        parent::__construct($config, $shopID);    
    }

    public static function getCountriesList(){
        global $config;        
        return ORM::for_table($config['db']['pre'].'countries')->select_many('id', 'code', 'asciiname')->order_by_asc('asciiname')->find_many();
    }
}
?>