<?php
defined("LPCTSTR_TOKEN") or die(":-((");
////*********************************************************************************************************************** */
/// DATA
////*********************************************************************************************************************** */
class CVouchersData extends CBoLogicData{
    public $items = 0;
    public $groups = 0;

    public function __construct(&$config, $shopID){        
        parent::__construct($config, $shopID);
        $this->tableName = 'qr_vouchers';
    }
    
    public function getVouchers($searchData=0, $showPagination=1){
        
        $itemCount = 0;
        $rowsPerPage = 2*PAGINATION_ROWS_PER_PAGE;

        $cond = " v.shop_id={$this->shopID} " . $this->_buildSqlCondition($searchData);
        $sqlCount = 'SELECT COUNT(*) AS items FROM ' . $this->tableName . ' v LEFT JOIN qr_customers c ON c.id=v.cust_id WHERE v.deleted=0 AND ' . $cond;
        
        $rows = ORM::for_table($this->tableName)->raw_query($sqlCount)->find_one();        
        if($rows) $itemCount = $rows['items'];        
        
        $this->pager = new CPager($itemCount, $searchData['page'], $rowsPerPage, 5);
        
        $sql = 'SELECT v.*, if(v.cust_id=-1, "One-time customer", c.name) as name FROM qr_vouchers v LEFT JOIN qr_customers c ON v.cust_id=c.id 
                WHERE v.deleted=0 AND ' . $cond;
        
        if($searchData['sortby'] && $searchData['sortdir']){
            $sql .= " ORDER BY {$searchData['sortby']} {$searchData['sortdir']}";
        }else $sql .= ' ORDER BY v.issued_date ASC';

        if($showPagination) $sql .= ' LIMIT ' . $this->pager->begin() . ', ' . $rowsPerPage;        

        $this->data = ORM::for_table($this->config['db']['pre'] . 'customers')->raw_query($sql)->find_many();        
        return ($this->items = $itemCount);
    }    

    private function _buildSqlCondition(&$searchData){        
        $cond = '';        
        $offset = CRequest::getNbr('page', -1);
        if(!$searchData){            
            $searchData = array(
                'search' => '',
                'issued' => '',
                'expired' => '',
                'status' => '',
                'page'   => -1,
                'sortby' => 'v.expired_date',
                'sortdir' => 'asc'
            );
        }else{
            $offset = $searchData['page'];
        }
        
        if($offset < 0){
            //set new search data            
            $searchData['search'] = CRequest::getStr('qry');
            $searchData['status'] = CRequest::getStr('status');
            $searchData['issued'] = CRequest::getStr('isd');
            $searchData['expired'] = CRequest::getStr('exd');            
        }else{
            $sortby = CRequest::getStr('sort');
            $sortdir = CRequest::getStr('dir');
            //get old search data, change the page index
            $searchData = $_SESSION['SEARCH_VOUCHER_DATA'];
            $searchData['page'] = $offset;
            if($sortby && $sortdir){
                $searchData['sortby'] = $sortby;
                $searchData['sortdir'] = $sortdir;
            }
        }
        
        //save
        $_SESSION['SEARCH_VOUCHER_DATA'] = $searchData;
        $this->searchData = $searchData;
        $data = (object)$searchData;
        if(isset($data->search) && $data->search){
            $text = $data->search;
            $s = sprintf(' AND ( v.code LIKE "#%s#" OR c.name LIKE "#%s#")', $text, $text);
            $cond .= str_replace('#', '%', $s);
        }
        if(isset($data->status) && $data->status){
            $cond .= " AND v.status='$data->status'";
        }
        if(isset($data->issued) && $data->issued){
            $count = 0;
            $dates = parent::extractDateFromString($data->issued, $count);            
            $date1 = DateTime::createFromFormat('m/d/Y', $dates[0])->format('Y-m-d');
            $date2 = DateTime::createFromFormat('m/d/Y', $dates[1])->format('Y-m-d');
            if($date1<$date2) $s = " AND (v.issued_date>='{$date1}' AND v.issued_date<='{$date2}')";
            else $s = " AND v.issued_date='{$date1}'";
            $cond .= $s;
        }
        if(isset($data->expired) && $data->expired){
            $count = 0;
            $dates = parent::extractDateFromString($data->expired, $count);            
            $date1 = DateTime::createFromFormat('m/d/Y', $dates[0])->format('Y-m-d');
            $date2 = DateTime::createFromFormat('m/d/Y', $dates[1])->format('Y-m-d');
            $s = " AND (v.expired_date>='{$date1}' AND v.expired_date<='{$date2}')";
            $cond .= $s;
        }
        return $cond;
    }

    public function deleteVoucher($id){
        return ORM::get_db()->prepare("UPDATE {$this->tableName} SET deleted=1 WHERE id={$id}")->execute();
    }

    public function getVoucher($id){
        $sql = 'SELECT v.*, c.name AS cname FROM qr_vouchers v LEFT JOIN qr_customers c ON c.id=v.cust_id WHERE v.shop_id='.$this->shopID.' AND v.id='.$id;
        $this->data = ORM::for_table($this->tableName)->raw_query($sql)->find_one();
        return !empty($this->data) && isset($this->data['code']);
    }

    public function saveVoucher(&$errorObj){
        $renew = CRequest::getStr('renew');        
        $data = &$_POST;        
        unset($_POST[$_SESSION['user']['login_string']]);
        unset($_POST['cust_name']);        
        $newStatus = 'ready';
        
        if($data['status']=='exprired') $newStatus = 'ready';
        //elseif($data['status']=='ready' && $data['cust_id']>0) $newStatus = 'in-use';  <-- upadated at 10-18-2022 17:40 PM, DO NOT SET status when assign a voucher to a customer
        $data['status'] = $newStatus;

        $exp = DateTime::createFromFormat('m-d-Y', $data['expired_date'])->format('Y-m-d');
        $isd = DateTime::createFromFormat('m-d-Y', $data['issued_date'])->format('Y-m-d');
        $data['expired_date'] = $exp;
        $data['issued_date'] = $isd;

        $sql = $this->prepareSQL($data, 'update');
        $pdo = ORM::get_db();
        $stmt = $pdo->prepare($sql);

        $id = $data['id']; unset($data['id']);

        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $ret = $stmt->execute($data);

        if($ret){
            //create history log
            $this->_addVoucherHistoryRecord($id, $data);
            $errorObj->voucherStatus = $newStatus;
        }else{
            $errorInfo = $stmt->errorInfo();
            $errorObj->text = $errorInfo[0];
        }
        return $ret ? $id : 0;
    }

    private function _addVoucherHistoryRecord($id, &$data){
        $row = ORM::for_table("{$this->config['db']['pre']}vouchers_history")->where(array("voucher_id"=>$id, "action"=>"update", "changed_value"=>$data["value"], "changed_status"=>$data["status"]))->find_one();
        if(!empty($row) && isset($row["id"])){
            $row->changed_by = $_SESSION['user']['username'];
            $row->save(); 
        }        
    }

    public function generateVouchers(&$errorObj){        
        $number = CRequest::postNbr('vouchers_nbr');
        $period = CRequest::postNbr('period');
        $this->_randomVouchers2DB($number, $period);
        return 1;
    }

    private function _randomVouchers2DB($number = 10, $period=30){
        $pdo = ORM::get_db();        
        $data = new stdClass;
        $data->shop_id = $this->shopID;
        $data->cust_id = -1;
        $data->code = '';
        $data->sale_type = 'price';
        $data->value = 0;
        $data->issued_date = date('Y-m-d');
        $data->expired_date = date('Y-m-d H:i:s', strtotime($data->issued_date . ' + ' . $period . ' days'));        
        $data->status = 'ready';        
        $data->note = '';

        for($i = 1; $i<=$number; ++$i){
            $data->code = $this->generateToken();            
            if($this->_checkVoucherExists($data->code)){                
                ++$number; continue;
            }

            $sql = 'INSERT INTO qr_vouchers(shop_id, cust_id, code, sale_type, value, issued_date, expired_date, status, note)
                    VALUES(:shop_id, :cust_id, :code, :sale_type, :value, :issued_date, :expired_date, :status, :note)';

            $pdo->prepare($sql)->execute((array)$data);
            if($id = $pdo->lastInsertId()){
                $pdo->prepare("update qr_vouchers set expired_date='{$data->expired_date}' WHERE id={$id}")->execute();
            }else{

            }
        }
        //check duplicated row: SELECT code, COUNT(*) c FROM qr_vouchers GROUP BY code HAVING c > 1
    }

    private function _checkVoucherExists($code){
        $item = ORM::for_table($this->tableName)->where('code', $code)->findOne();        
        return !empty($item['code']);
    }

    private static function cryptoRandSecure($min, $max){
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    private static function generateToken($length=8){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet);
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[self::cryptoRandSecure(0, $max-1)];
        }
        return strtoupper($token);
    }
}//DATA class
?>