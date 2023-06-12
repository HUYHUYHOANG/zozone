<?php
defined("LPCTSTR_TOKEN") or die(":-((");
////*********************************************************************************************************************** */
/// VIEW
////*********************************************************************************************************************** */

use Dompdf\Dompdf;

class CVouchersView extends CBoHtmlView{
    
    public function __construct(&$model){
        parent::__construct($model);
    }

    public function loadVouchers(){  
        global $lang;
        if(!$this->model->getVouchers()){
            echo "<div class='text-danger' style='margin:20px 15px;font-weight:bold;'>{$lang['RECD_NOT_FOUND']}</div>";
            return false;
        }        
        require_once('./templates/vouchers.table.php');
        return true;
    }

    public function loadVoucher($id){
        if($id<=0) return;
        if(!$this->model->getVoucher($id)) return;
        global $lang;
        $data = &$this->model->data;
        include('./templates/voucher-edit.form.php');
    }

    public function addVouchersDialog(){        
        global $lang;
        include(__DIR__.DIRECTORY_SEPARATOR.'/../templates/vouchers-add.dialog.php');
    }

    public function downloadPDFWithQRCode($downloadPDF = true){
        global $lang;
        if(!$this->model->getVouchers(array('page'=>1), 0)){            
            return false;
        }        
        
        require_once(__DIR__. DIRECTORY_SEPARATOR .'/../../phpqrcode/qrlib.php');        
        require_once(__DIR__. DIRECTORY_SEPARATOR .'/../../dompdf/autoload.inc.php');

        
        //html content
        ob_start();
        require_once(__DIR__.DIRECTORY_SEPARATOR.'/../templates/vouchers.qr.download.php');
        $html = ob_get_clean();

        //build qr code
        foreach($this->model->data as $r){
            ob_start();
            QRcode::png($r['code']);
            $png = ob_get_clean();
            $image = '<img width="150" src="data:image/png;base64,'.base64_encode($png).'"/>';
            $html = str_replace(sprintf("{%s}", $r['code']), $image, $html);
        }
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // landscape , portrait
        $dompdf->render();
        $output = $dompdf->output();

        if(!$downloadPDF){
            header("Content-type:application/pdf");
            echo ($output);            
        }else{
            $now = gmdate("D, d M Y H:i:s");
            $filename = 'qrcodes-'.date('ymdhi').".pdf";
            header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
            header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
            header("Last-Modified: {$now} GMT");
            header("Content-Type:application/force-download");
            header("Content-Disposition: attachment; filename=\"".$filename."\"");
            echo $output;            
        }
        return true;
    }
}
?>