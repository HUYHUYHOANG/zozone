<?php
defined("LPCTSTR_TOKEN") or die(":-((");

$sort = $this->model->searchData;
if(!isset($sort['sortby']) || !isset($sort['sortdir'])){
    $sort['sortby'] = 'v.issued_date';
    $sort['sortdir'] = 'asc';
}
$sort = (object)$sort;
?>
<div class="text-info" style="margin:15px;font-weight:bold;"><?php echo $lang['TOTAL_RECORD'] . ': ' . $this->model->items ?></div>
    <table id="tblVouchers" class="table table-stripped" style="width:100%;">
        <thead>
            <th data-sort="v.code" <?php echo $sort->sortby=="v.code" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo $lang['VOUCHER'] ?></th>
            <th data-sort="v.value" <?php echo $sort->sortby=="v.value" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo $lang['VALUE'] ?></th>
            <th data-sort="name" <?php echo $sort->sortby=="name" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo $lang['CUSTOMER'] ?></th>
            <th data-sort='v.issued_date' <?php echo $sort->sortby=="v.issued_date" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo $lang['ISSUED_DATE'] ?></th>
            <th data-sort="v.expired_date" <?php echo $sort->sortby=="v.expired_date" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo $lang['EXPIRED_DATE'] ?></th>
            <th data-sort="v.status" <?php echo $sort->sortby=="v.status" ? "class='sort {$sort->sortdir}'" : "" ; ?>><?php echo $lang['STATUS'] ?></th>
            <th></th>
        </thead>
        <tbody>
    <?php
    foreach($this->model->data as $r){        
        $status = str_replace('-','_', strtoupper($r['status']));
        $status = isset($lang[$status]) ? $lang[$status] : $status;
        
        ?>
        <tr class="<?php echo $r['status'] ?>">
            <td><i class="icon-feather-book"></i> <?php echo $r['code'] ?></td>
            <td style="white-space:nowrap">
                <?php
                    echo ($r['sale_type'] == 'percent' ? " {$r['value']} %" : $this->model->formatPrice($r['value']));
                ?>
            </td>
            <td><?php echo $r['name']?></td>
            <td><?php echo date('m-d-Y', strtotime($r['issued_date'])) ?></td>
            <td><?php echo date('m-d-Y', strtotime($r['expired_date'])) ?></td>
            <td class="voucher-status"><?php echo $status ?></td>
            <td class="text-right" style="white-space:nowrap">
                <?php
                if($r['status'] =='ready' || ($r['status'] =='expired' && $r['cust_id']==-1)){ ?>
                    <a class="button btn-sm" href="./vouchers?d0=edit-voucher&id=<?php echo $r['id'] ?>"><i class="icon-feather-edit"></i></a>
                    <a class="button btn-sm delete-voucher" href="javascript:void(0);" data-id="<?php echo $r['id'] ?>"><i class="icon-feather-trash-2"></i></a>
                <?php }?>
                <!-- <a class="button btn-sm qr-code" href="#" data-id="<?php //echo $r['id']?>" data-code="<?php //echo $r['code']?>" title="QR Code"><i class="fa fa-qrcode"></i></a> -->
            </td>
        </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" bgcolor="#00f">
                    <?php $this->model->pager->renderBootstrapStyle('pagination') ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>