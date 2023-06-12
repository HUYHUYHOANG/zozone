<?php
defined("LPCTSTR_TOKEN") or die(":-((");
$statusColors = array('all'=>'#333', 'ready'=>'#696969','in-use'=>'#28a745','used'=>'#6c757d','expired'=>'red');
$searchData = $_SESSION['SEARCH_VOUCHER_DATA'];
?>
<div style="background-color:#EEE;padding:12px;margin-bottom:15px;">
    <?php
        $status = $searchData['status'];
        if(empty($status)) $status = 'all';
        echo '<span style="color:'.$statusColors[$status].'">' . strtoupper($status) . '</span> ' . $lang['VOUCHERS'] . ' : ' . $this->model->items;
    ?>
</div>
<div style="border:1px dotted #333;">    
    <table width="100%" style="font-family:Tahoma;font-size:12px;" cellspacing=0 cellpadding=0>
        <tbody>
    <?php
        $cols = 0; $idx = 0; $row = 0;
        foreach($this->model->data as $r){
            $r = (object)$r;
            $value = ($r->sale_type == 'percent' ? " {$r->value} %" : $this->model->formatPrice($r->value));
            $issuedDate = date('m-d-Y', strtotime($r->issued_date));
            $expiredDate = date('m-d-Y', strtotime($r->expired_date));
            $color = $statusColors[$r->status];
            if($cols == 0){
                echo '<tr>';
            }
            ?>
            <td <?php if($row) echo 'style="border-top:1px dotted #333;"'?>>
                <table>
                    <tr>
                        <td>{<?php echo $r->code?>}</td>
                        <td style="line-height: 20px;">
                            Code: <b><?php echo $r->code;?></b>
                            <br/>
                            Customer: <b><?php echo $r->name; ?></b>
                            <br/>
                            Value: <b><?php echo self::formatPrice($r->value); ?></b>
                            <br/>
                            Issued: <b><?php echo $issuedDate ?></b>
                            <br/>
                            Expired: <b><?php echo $expiredDate ?></b>
                            <br/>
                            Status: <span style="font-weight:bold;color:<?php echo $color;?>"><?php echo strtoupper($r->status) ?></span>
                        </td>
                    </tr>
                </table>
            </td>
            <?php
            if(++$cols >= 3 || $idx++>=$this->model->items-1){
                echo '</tr>';
                $cols = 0; ++$row;
            }
        }
        ?>
        </tbody>
    </table>
</div>
