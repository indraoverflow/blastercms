<?php
$data = array();
$i = 0;
foreach ($r->result() as $d){
    
    $data[$i] = array(
                    '<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d->RoleID.'" />',
                    $d -> RoleID,
                    anchor('role/edit/'.$d->RoleID,$d->RoleName),
                );
    $i++;
}
$data = json_encode($data);
?>
<?php $this->load->view('admin/header') ?>

<h2><?php echo $title?></h2>

<div style="background-color: #EEFFEE;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 10px">

<p>
    <?=anchor('role/delete','<b class="glyphicon glyphicon-trash"></b> Hapus',array('class'=>'cekboxaction ui btn btn-warning','confirm'=>'Apa anda yakin?'))?>
</p>

<form id="dataform" method="post" action="#">
<table id="databerita" cellpadding="0" cellspacing="0" border="0" class="display">
    
</table>
</form>
</div>

<div class="clear"></div>
<script type="text/javascript">
        var pelangganTable = $('#databerita').dataTable({
            "aaData": <?=$data?>,
            "bJQueryUI": true,
            "aaSorting" : [[1,'desc']],
            "sPaginationType": "full_numbers",
            "iDisplayLength": 100,
            "aLengthMenu": [[100, 1000, 5000, -1], [100, 1000, 5000, "Semua"]],
            "aoColumns": [
                {"sTitle": "<input type=\"checkbox\" id=\"cekbox\" class=\"cekbox\" />","sWidth":15,bSortable:false},
                {"sTitle": "ID"},
                {"sTitle": "Nama Role" }
            ]
        });
        $("input[aria-controls=databerita]").unbind().bind('keyup',function(e){
            if (e.keyCode == 13) {
                pelangganTable.fnFilter(this.value);
            }
        });
</script>

<?php $this->load->view('admin/footer') ?>