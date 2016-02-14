<?php
$data = array();
$i = 0;
foreach ($r->result() as $d){
    $categories = "";
    $a=0;
    $cats = array();
    foreach ($this -> mpost -> GetRowPostCat($d -> PostID) -> result() as $cat) {
        if($a > 0){
            $categories .= ", <br />";
        }
        $categories .= '- <small><b>'.$cat -> CategoryName.'</b></small>';
        $a++;
    }
    
    $tags = "";
    $t = 0;
    $tag = array();
    foreach ($this -> db -> where('PostID',$d->PostID) -> get('posttags') -> result() as $tg) {
        if($t > 0){
            $tags .=", ";
        }
        $posttag = $this -> db -> where('TagID',$tg -> TagID) -> get('tags') -> row();
        $tags .= $posttag -> TagName;
        $t++;
    }
        
    $data[$i] = array(
                    '<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d->PostID.'" />',
                    $d->PostID,
                    anchor('post/edit/'.$d->PostID,$d->PostTitle),
                    $d->PostTypeID==POST?'Post':'Produk',
                    $categories,
                    $d->PostTypeID==PRODUCT? $d->DiscountPrice? $d->DiscountUntil>date('Y-m-d')? rupiah($d->DiscountPrice).'<br/><small style="text-decoration:line-through">'.rupiah($d->Price).'</small>' : rupiah($d->Price): rupiah($d->Price) :'-',
                    $d->DiscountUntil>date('Y-m-d')?$d->DiscountUntil!='0000-00-00'?date('d-M-Y',strtotime($d->DiscountUntil)):'-':'-',
                    #'<input readonly="" class="form-control" value="'.base_url().'post/view/'.$d->PostSlug.'.html'.'" />',
                    '<textarea class="form-control" readonly="">'.base_url().'post/view/'.$d->PostSlug.'.html'.'</textarea>',
                    // $tags,
                    #date('d-M-Y',strtotime($d->PostDate)).'<br /><small>'.date('H:i:s',strtotime($d->PostDate)).'</small>',
                    //$d->UpdateBy? $d->UpdateBy:$d->PostedBy
                    
                );
    $i++;
}
$data = json_encode($data);
?>
<?php $this->load->view('admin/header') ?>

<h2><?php echo $title?></h2>
<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 15px 10px">

<p>
    <?=anchor('post/delete','<b class="glyphicon glyphicon-trash"></b> Hapus',array('class'=>'cekboxaction ui btn btn-warning','confirm'=>'Apa anda yakin?'))?>
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
                {"sTitle": "Judul"},
                {"sTitle": "Tipe"},
                {"sTitle": "Kategori","sWidth":150},
                {"sTitle": "Harga"},
                {"sTitle": "Discount Sampai"},
                {"sTitle": "URL"},
                // {"sTitle": "Tag"},
                //{"sTitle": "Tanggal", "sClass": "center" },
                //{"sTitle": "Dibuat"},
                // {"sTitle": "Tanggal", "sClass": "center" }
            ]
        });
        $("input[aria-controls=databerita]").unbind().bind('keyup',function(e){
            if (e.keyCode == 13) {
                pelangganTable.fnFilter(this.value);
            }
        });
</script>

<?php $this->load->view('admin/footer') ?>