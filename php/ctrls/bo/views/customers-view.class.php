<?php
////*********************************************************************************************************************** */
/// VIEW
////*********************************************************************************************************************** */

class CCustomersView extends CBoHtmlView{
    
    public function __construct(&$model){
        parent::__construct($model);
    }

    public function defaultView(){
        $this->model->loadCustomers();        
        $rows = $this->model->data;
        ob_start();
        global $lang;
        if(!count($rows)){
            echo '<div class="text-danger" style="margin:15px;">' . $lang['RECD_NOT_FOUND'] . '</div>';
        }else{
        ?>
        <div class="text-info" style="margin:15px;font-weight:bold;"><?php echo $lang['TOTAL_RECORD'] . ': ' . $this->model->items ?></div>
        <table id="tblReservations" class="table table-stripped" style="width:100%;">
            <thead>
                <th><?php echo $lang['CUSTOMER'] ?></th>
                <th><?php echo $lang['INFORMATION'] ?></th>
                <th><?php echo $lang['GROUP'] ?></th>
                <th><?php echo $lang['LAST_ACTIVITY'] ?></th>
                <th class="text-center"><?php echo $lang['NEWSLETTER'] ?></th>
                <th></th>
            </thead>
            <tbody>
        <?php
        foreach($rows as $r){
            ?>
            <tr>
                <td><i class="icon-feather-user"></i> <?php echo $r['name'] ?></td>
                <td>
                    <?php 
                        if($r['phone']) echo sprintf('<div class="cust-info"><i class="icon-feather-phone"></i> %s</div>', $r['phone']);
                        if($r['email']) echo sprintf('<div class="cust-info"><i class="icon-feather-mail"></i> %s</div>', $r['email']);
                        if($r['city']) echo sprintf('<div class="cust-info"><i class="icon-feather-map-pin"></i> %s</div>', $r['city']?$r['city']:'n/a');
                    ?>
                </td>
                <td><?php 
                    echo $r['group_name'];
                    if($r['description']) echo '<br/><i>' . $r['description'] . '</i>';
                ?></td>
                <td><?php echo $r['last_activity'] ?></td>
                <td class="text-center">
                <?php 
                    if($r['newsletter']) echo "<i class='fa fa-check-square-o'></i>";
                    else echo "<i class='fa fa-square-o'></i>";
                ?></td>
                <td class="text-right" style="white-space:nowrap">
                    <a class="button btn-sm" href="./customers?d0=view-customer&id=<?php echo $r['id'] ?>"><i class="icon-feather-eye"></i></a>
                    <a class="button btn-sm" href="./customers?d0=edit-customer&id=<?php echo $r['id'] ?>"><i class="icon-feather-edit"></i></a>
                    <a class="button btn-sm cust-delete" href="javascript:void(0);" data-id="<?php echo $r['id'] ?>"><i class="icon-feather-trash-2"></i></a>
                </td>
            </tr>
            <?php
        }
        ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" bgcolor="#00f">
                        <?php $this->model->pager->renderBootstrapStyle('pagination') ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php
        }
        $s = ob_get_contents();
        ob_clean();
        ob_end_flush();
        return $s;
    }//default view

    public function customerGroups(){
        $this->model->loadCustomerGroups();
        global $lang;
        require_once(__DIR__ . DIRECTORY_SEPARATOR . '/../templates' . DIRECTORY_SEPARATOR . 'customer-group.dialog.php');
    }//customerGroups()

    public function csvExport(){
        $this->model->dataForCSV();
        if(!$this->model->data){            
            return;
        } 
        
        ob_start();
        $df = fopen("php://output", 'wb');
        //c.id, c.name, c.phone, c.email, c.address, c.city, c.last_activity, g.name AS group_name, g.disc_perct
        $hdr = array('ID', 'Name', 'Phone', 'Email', 'Address', 'City', 'Group', 'Discount %', 'Last Activity');
        fputcsv($df, $hdr);
        foreach($this->model->data as $r){
            $r = (object)$r;
            $data = array($r->id, $r->name, $r->phone, $r->email, $r->address, $r->city, $r->group_name, $r->disc_perct, $r->last_activity);
            fputcsv($df, $data);
        }
        fclose($df);
        echo ob_get_clean();
    }

    public function printableCustomersList(){
        $this->model->dataForCSV();
        if(!$this->model->data){

            return;
        }
        ?>
        <table class="table table-stripped" style="width:100%;">
            <thead>
                <th>Cust. Name</th>
                <th>Cust. Info</th>
                <th>Group</th>
                <th>Last Activity</th>
            </thead>
            <tbody>
            <?php
                foreach($this->model->data as $r){
                    ?>
                    <tr>
                        <td><i class="icon-feather-user"></i> <?php echo $r['name'] ?></td>
                        <td>
                            <?php 
                                echo sprintf('<div class="cust-info"><i class="icon-feather-phone"></i> %s</div>', $r['phone']);
                                echo sprintf('<div class="cust-info"><i class="icon-feather-mail"></i> %s</div>', $r['email']);
                                echo sprintf('<div class="cust-info"><i class="icon-feather-map-pin"></i> %s</div>', $r['city']?$r['city']:'n/a');
                            ?>
                        </td>
                        <td><?php 
                            echo $r['group_name'];
                            if($r['description']) echo '<br/><i>' . $r['description'] . '</i>';
                        ?></td>
                        <td><?php echo $r['last_activity'] ?></td>                        
                    </tr>
                    <?php
                }
            ?>  
            </tbody>
        </table>
        <?php
    }//printable

    public function editCustomerForm($id){
        global $lang;        
        $form =  'templates/edit-customer.form.php';
        $this->model->loadCustomerGroups();  
        $this->model->loadCustomer($id);
        $data = 0;
        if(isset($this->model->data['name'])){
            $data = (object)$this->model->data;
        }
        $formAction = "edit-customer-data&id={$id}";
        $data = $this->model->data ? (object)$this->model->data : 0;
        $viewOnly = CRequest::getStr("viewonly")== "true" ? 1 : 0;
        require_once($form);
    }//customerDetails

    public function viewCustomerInfo($id){        
    }

    public function addCustomerForm(){
        global $lang;
        $form =  'templates/edit-customer.form.php';
        $this->model->loadCustomerGroups();
        $formAction = 'edit-customer-data&id=0';
        $id = 0; $data = 0; $viewOnly = 0;
        require_once($form);
    }

    public function customerReservations($id){
        $type = CRequest::getStr('t'); 
        global $lang;       
        if(!$this->model->loadCustomerReservations($id, $type)){
            echo "<p class='text-danger' style='padding:32px;'>". $lang['RECD_NOT_FOUND'] ."...</p>";
            return;
        }
        $form =  __DIR__ . DIRECTORY_SEPARATOR . '/../templates' . DIRECTORY_SEPARATOR . 'customer-reservations.table.php';
        require_once($form);
    }    

    public function editCustomerReservation($id){
        if(!$this->model->loadCustomerReservation($id)){
            echo "<p class='text-danger' style='padding:32px;'>{RESERVATION(S) NOT FOUND}...</p>";
            return;
        }
        global $lang;
        $form =  __DIR__ . DIRECTORY_SEPARATOR . '/../templates' . DIRECTORY_SEPARATOR . 'customer-reservation.dialog.php';
        require_once($form);
    }

    private function reservationStatus($status){
        global $lang;
        $colors = array('warning', 'danger', 'info', 'secondary', 'primary', 'success');
        $labels = array($lang['BO_PENDING'], $lang['BO_CANCELLED'], $lang['BO_CONFIRMED'],
                        $lang['BO_NOT_COME'], $lang['BO_IN_SERVICE'], $lang['BO_DONE']);
        if($status > 5) $status = $status % 5;
        return sprintf('<button type="button" class="resv-status not-click btn btn-sm btn-%s" style="min-width:100px;cursor:default;">%s</button>', $colors[$status], $labels[$status]);
    }

    public function loadCustomerVouchers($theCustomerID){
        global $lang;
        $items = $this->model->loadCustomerVouchers($theCustomerID);
        if(!$items){
            echo "<p class='text-danger' style='padding:32px;'>{$lang['RECD_NOT_FOUND']}</p>";
            return;
        }
        $form =  __DIR__ . DIRECTORY_SEPARATOR . '/../templates' . DIRECTORY_SEPARATOR . 'customer-vouchers.table.php';
        require_once($form);
    }
}//CCustomersView
?>