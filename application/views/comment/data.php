<?php
$data = array();
$i = 0;
foreach ($r->result() as $d){
    $post = $this -> db -> where('PostID',$d->PostID) -> get('posts') -> row();
    $data[$i] = array(
                    '<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d->CommentID.'" />',
                    #anchor('comment/view/'.$d->CommentID,$d->Name),
                    $d->Name,                    
                    date('d-M-Y',strtotime($d->CommentDate)).'<br /><small>'.date('H:i:s',strtotime($d->CommentDate)).'</small>',
                    $post->PostTitle,
                    $d->Email,
                    word_limiter(strip_tags($d->Comment),10).' '.anchor('comment/view/'.$d->CommentID,'selengkapnya'),
                    $d->IsVerified ? '<b class="glyphicon glyphicon-eye-open"></b> <b>ditampilkan</b>' : '<b class="glyphicon glyphicon-eye-close"></b> disembunyikan'
                    
                );
    $i++;
}
$data = json_encode($data);
?>
<?php $this->load->view('admin/header') ?>

<h2><?php echo $title?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 10px">

<p>
    <?=anchor('comment/delete','<b class="glyphicon glyphicon-trash"></b> Hapus',array('class'=>'cekboxaction ui btn btn-warning','confirm'=>'Apa anda yakin?'))?>
    <?=anchor('comment/show','<b class="glyphicon glyphicon-eye-open"></b> Tampilkan',array('class'=>'cekboxaction ui btn btn-info','confirm'=>'Apa anda yakin?'))?>
    <?=anchor('comment/hide','<b class="glyphicon glyphicon-eye-close"></b> Sembunyikan',array('class'=>'cekboxaction ui btn btn-info','confirm'=>'Apa anda yakin?'))?>
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
                {"sTitle": "Nama"},
                {"sTitle": "Tanggal"},
                {"sTitle": "Dari Post"},
                {"sTitle": "Email"},
                {"sTitle": "Komentar","sWidth":300},
                {"sTitle": "Status","sClass": "center" }
                
            ]
        });
        $("input[aria-controls=databerita]").unbind().bind('keyup',function(e){
            if (e.keyCode == 13) {
                pelangganTable.fnFilter(this.value);
            }
        });
</script>

<?php $this->load->view('admin/footer') ?>