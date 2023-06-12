<?php
defined("LPCTSTR_TOKEN") or die(":-((");
////*********************************************************************************************************************** */
/// VIEW
////*********************************************************************************************************************** */

class CStaffsView extends CBoHtmlView{
    
    public function __construct(&$model){
        parent::__construct($model);
    }

    public function defaultView(){
        $this->model->loadStaffs();        
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
                <th><?php echo $lang['BO_MENU_STAFFS'] ?></th>
                <th><?php echo $lang['INFORMATION'] ?></th>                
                <th width="10%"><?php echo $lang['USERTYPE'] ?></th>
                <th><?php echo 'UID /' . $lang['ACTIVE'] ?></th>                
                <th></th>
            </thead>
            <tbody>
        <?php
        $user = CBoCtrl::getUser();
        foreach($rows as $r){
            $name = $r['name'];
            ?>
            <tr>
                <td><i class="icon-feather-user"></i> <?php echo $name ?></td>
                <td>
                    <?php 
                        if($r['phone']) echo sprintf('<div class="cust-info"><i class="icon-feather-phone"></i> %s</div>', $r['phone']);
                        if($r['email']) echo sprintf('<div class="cust-info"><i class="icon-feather-mail"></i> %s</div>', $r['email']);
                        if($r['city']) echo sprintf('<div class="cust-info"><i class="icon-feather-map-pin"></i> %s</div>', $r['city']?$r['city']:'n/a');
                    ?>
                </td>                
                <td style="text-transform:capitalize;"><?php echo $r['user_type'] ?></td>
                <td>
                    <?php
                        echo "<i class='icon-feather-unlock'></i> {$r['username']}<br/>";
                        if($r['lastactive']) echo "<i class='icon-feather-clock'></i>{$r['lastactive']}";
                    ?>                    
                </td>                
                <td class="text-right" style="white-space:nowrap;">
                    <a class="button btn-sm" href="./staffs?d0=view-staff&id=<?php echo $r['id'] ?>"><i class="icon-feather-eye"></i></a>
                    <a class="button btn-sm" href="./staffs?d0=edit-staff&id=<?php echo $r['id'] ?>"><i class="icon-feather-edit"></i></a>
                    <?php
                    if($user->id != $r['id']){?>
                    <a class="button btn-sm cust-delete" href="javascript:void(0);" data-id="<?php echo $r['id'] ?>"><i class="icon-feather-trash-2"></i></a>
                    <?php 
                    }?>
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

    public function staffGroups(){
        $this->model->loadstaffGroups();
        global $lang;
        require_once('./templates/staff-group.dialog.php');
    }//staffGroups()

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

    public function printablestaffsList(){
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
                        <td><?php echo $r['group_name'] ?></td>
                        <td><?php echo $r['last_activity'] ?></td>                        
                    </tr>
                    <?php
                }
            ?>  
            </tbody>
        </table>
        <?php
    }//printable

    public function editStaffForm($id){
        global $lang;        
        $form =  './templates/edit-staff.form.php';
        $this->model->loadStaffGroups();  
        $this->model->loadServiceGroups();
        $this->model->loadStaff($id);        
        $data = 0;
        if(isset($this->model->data['name'])){
            $data = (object)$this->model->data;
        }
        $formAction = "edit-staff-data&id={$id}";
        $data = $this->model->data ? (object)$this->model->data : 0;
        $viewOnly = CRequest::getStr("viewonly")== "true" ? 1 : 0;        
        require_once($form);
    }//staffDetails

    public function addStaffForm(){
        global $lang;
        $viewOnly = 0;
        $this->model->loadStaffGroups();  
        //$this->model->loadServiceGroups();
        $id = 0; $data = 0;
        $form =  './templates/edit-staff.form.php';        
        require_once($form);
    }

    public function staffReservations($id){
        global $lang;
        $type = CRequest::getStr('t');        
        if(!$this->model->loadstaffReservations($id, $type)){
            echo "<p class='text-danger' style='padding:32px;'>" . $lang['RECD_NOT_FOUND'] ."...</p>";
            return;
        }

        $form =  './templates/staff-reservations.table.php';
        require_once($form);
    }    

    public function editstaffReservation($id){
        if(!$this->model->loadstaffReservation($id)){
            echo "<p class='text-danger' style='padding:32px;'>{RESERVATION(S) NOT FOUND}...</p>";
            return;
        }
        global $lang;
        $form =  './templates/staff-reservation.dialog.php';
        require_once($form);
    }

    private function reservationStatus($status){
        global $lang;
        $colors = array('info', 'success','danger');
        $labels = array( $lang['BO_CONFIRMED'], $lang['BO_DONE'],$lang['BO_CANCELLED']);
        if($status > 2) $status = $status % 2;
        return sprintf('<button type="button" class="resv-status not-click btn btn-sm btn-%s" style="min-width:100px;cursor:default;">%s</button>', $colors[$status], $labels[$status]);
    }
}//
?>