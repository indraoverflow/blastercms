<?php
$data = array();
$i = 0;
foreach ($r->result() as $d) {
    
    $data[$i] = array(
                    '<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d->SliderID.'" /> <input type="hidden" name="sliders[]" value="'.$d->SliderID.'" />',
                    $d->SliderID,
                    (empty($d->MediaName)) ? '-' : '<img class="img-rounded" height="100" src="'.media_url().$d->MediaPath.'" />',
                    anchor('slider/edit/'.$d->SliderID, $d->SliderName)
                );
    $i++;
}
$data = json_encode($data);
?>
<?php $this->load->view('admin/header') ?>

<h2><?php echo $title ?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 10px">

<p>
    <?=anchor('slider/delete','<b class="glyphicon glyphicon-trash"></b> Hapus',array('class'=>'cekboxaction ui btn btn-warning','confirm'=>'Apa anda yakin?'))?>
</p>
<form id="dataform" method="post" action="#">
<table id="dataslidera" cellpadding="0" cellspacing="0" border="0" class="display">
    
</table>
</form>

</div>

<div class="clear"></div>
<script type="text/javascript">
        var pelangganTable = $('#dataslidera').dataTable( {
            "aaData": <?=$data?>,
            "bJQueryUI": true,
            "bSort" : true,
            "sPaginationType": "full_numbers",
            "iDisplayLength": 100,
            "aLengthMenu": [[100, 1000, 5000, -1], [100, 1000, 5000, "Semua"]],
            "aoColumns": [
                {"sTitle": "<input type=\"checkbox\" id=\"cekbox\" class=\"cekbox\" />","sWidth":15,bSortable:false},
                {"sTitle": "ID"},
                {"sTitle": "Gambar"},
                {"sTitle": "Nama"}
            ]
        });
        $("input[aria-controls=dataslidera]").unbind().bind('keyup',function(e){
            if (e.keyCode == 13) {
                pelangganTable.fnFilter(this.value);
            }
        });
</script>

<?php $this->load->view('admin/footer') ?>