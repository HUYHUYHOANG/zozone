<?php
defined("EMPLOYER") or die('access denied...');
   
?>
<div class="table-responsive" style="margin-left:15px;">
    <table class="table table-striped vouchers-table">
        <thead>
            <th width="15%"><?php echo $lang['BOOKING'] . ' ' . $lang['DATE']?></th>
            <th width="20%"><?php echo $lang['STAFF']?></th>
            <th width="5%" class="text-center">#</th>
            <th><?php echo $lang['SERVICE']?></th>
            <th width="15%"><?php echo $lang['BOOKING'] . ' ' .$lang['TIME']?></th>
            <!--class="d-none d-sm-block"-->
        </thead>
        <tbody>
        <?php
            $prevDate = "";
            foreach($this->model->data as $r){
                $bkDate = $r['bk_date'];
                echo "<tr><td style='white-space:nowrap'>{$bkDate}</td>";

                $rows = $this->model->getBookingsByDate($bkDate);
                $idx = 0; $prevStaff = -1;  $staffBkIdx = 0;
                foreach($rows as $r){
                    $r = (object)$r;
                    
                    $name = $r->name ? $r->name : '';//sprintf("<i>(%s)</i>", $lang["DELETED"])
                    if($idx){ echo "<tr><td style='border-top:0;'></td>"; }
                    
                    $timeSlots = date('H:i', strtotime($r->arr_time)) . ' - ' . date('H:i', strtotime($r->dep_time)) ;

                    if($prevStaff != $r->staff_id){
                        $staffBkIdx = 0;
                        echo "<td>{$name}</td>";
                        echo "<td class='text-center'>".++$staffBkIdx."</td>";
                        $prevStaff = $r->staff_id;
                    }else{
                        echo "<td style='border-top:0;'></td>";
                        echo "<td  class='text-center'>".(++$staffBkIdx)."</td>";
                    }
                    
                    $services = CBoLogicData::getServiceNames($r->service_ids);
                    echo "<td>{$services}</td>";
                    echo "<td><span class='time-item' style='white-space:nowrap'>{$timeSlots}</span></td>";

                    if($idx) echo "</tr>";
                    ++$idx;
                }
                echo "</tr>";
                continue;

                echo "<tr>";
                if($bkDate != $prevDate){
                    echo "<td style='white-space:nowrap'>{$bkDate}</td>";
                    $prevDate = $bkDate;
                }else echo "<td class='no-border'></td>";
                echo "<td>{$r['staff_name']}</td><td class='text-center'>{$r['items']}</td>";
                $row = $this->model->getBookingNameAndTime($r['staff_id'], $r['bk_date']);
                if($row){
                    echo "<td>{$row[0]}</td>";
                    echo "<td class='d-none d-sm-block'>{$row[1]}</td>";
                }else{
                    echo "<td></td>";
                }
                echo "</tr>";
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
</div>