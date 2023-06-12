<?php
isset($this) or die(':-)');
$sort = new stdClass;
$sort->sortby = '';
$sort->sortdir = '';
?>
<div class="table-responsive" style="margin-left:15px;">
<table class="table table-striped vouchers-table">
    <thead>
        <th data-sort="v.code" <?php echo $sort->sortby=="v.code" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo $lang['VOUCHER'] ?></th>
        <th data-sort="v.value" <?php echo $sort->sortby=="v.value" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo 'Value' ?></th>        
        <th data-sort='v.issued_date' <?php echo $sort->sortby=="v.issued_date" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo 'Issued' ?></th>
        <th data-sort="v.expired_date" <?php echo $sort->sortby=="v.expired_date" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo 'Expired' ?></th>
        <th data-sort="v.status" <?php echo $sort->sortby=="v.status" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo $lang['STATUS'] ?></th>
        <th></th>
    </thead>
    <tbody>
    <?php
    foreach($this->model->data as $r){        
        ?>
        <tr class="<?php echo $r['status'] ?>">
            <td><i class="icon-feather-book"></i> <?php echo $r['code'] ?></td>
            <td>
                <?php
                    echo ($r['sale_type'] == 'percent' ? " {$r['value']} %" : $this->model->formatPrice($r['value']));
                ?>
            </td>            
            <td><?php echo date('m-d-Y', strtotime($r['issued_date'])) ?></td>
            <td><?php echo date('m-d-Y', strtotime($r['expired_date'])) ?></td>
            <td class="voucher-status"><?php echo $r['status']?></td>
            <td class="text-right">                
                <?php
                if($r['status'] =='ready' || $r['status'] =='expired'){ ?>
                    <a class="button btn-sm " href="./vouchers?d0=edit-voucher&id=<?php echo $r['id'] ?>"><i class="icon-feather-edit"></i></a>
                    <a class="button btn-sm delete-voucher" href="javascript:void(0);" data-id="<?php echo $r['id'] ?>"><i class="icon-feather-trash-2"></i></a>
                <?php }?>
                <a class="button btn-sm qr-code" href="#" data-id="<?php echo $r['id']?>" data-code="<?php echo $r['code']?>" title="QR Code"><i class="fa fa-qrcode"></i></a>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>
</div>
<style>
    .voucher-status{text-transform: capitalize;}
</style>