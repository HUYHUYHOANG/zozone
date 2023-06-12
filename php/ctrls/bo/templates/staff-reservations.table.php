<?php
isset($this) or die(':-)');
?>
<div class="table-responsive" style="margin-left:15px;">
<table class="table table-striped resv-table">
    <thead>
        <th class="text-center">Start time</th>
        <th class="text-center">End time</th>
        <th>Service(s)</th>
        <th>Customer</th>
        <th class="text-center">Status</th>
        <th></th>
    </thead>
    <tbody>
        <?php
        foreach($this->model->data as &$row){
            $row = (object)$row;
            $arrTime = strtotime($row->arr_time);
            $time = date('H:i', $arrTime);
            $date = date('m-d-Y', $arrTime);
            echo "<tr><td class='text-center'>{$time}<br/>{$date}</td>";
            
            $depTime = strtotime($row->dep_time);
            $time = date('H:i', $depTime);
            $date = date('m-d-Y', $depTime);

            $services = CBoLogicData::getServiceNames($row->service_ids);
            echo "<td class='text-center'>{$time}<br/>{$date}</td>";
            echo "<td>{$services}</td><td>{$row->customer}</td>
                  <td class='text-center'>";            
            echo $this->reservationStatus($row->status);
            echo "</td><td><a data-id='{$row->id}' data-action='edit' href='javascript:void(0);' class='button btn-sm btn-success btn-action edit-resv'><i class='icon-feather-edit'></i></a>
                  <a data-id='{$row->id}' data-action='delete' href='javascript:void(0);' class='button btn-sm btn-danger btn-action'><i class='icon-feather-trash-2'></i></a>";
            echo "</td></tr>";
        }
        ?>
    </tbody>
</table>
</div>