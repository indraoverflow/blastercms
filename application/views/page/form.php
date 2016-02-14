<?=$this->load->view('admin/header')?>

<link rel="stylesheet" href="<?=base_url()?>assets/codemirror/lib/codemirror.css">
<script src="<?=base_url()?>assets/codemirror/lib/codemirror.js"></script>
<script src="<?=base_url()?>assets/codemirror/mode/xml/xml.js"></script>
<script src="<?=base_url()?>assets/codemirror/mode/javascript/javascript.js"></script>
<script src="<?=base_url()?>assets/codemirror/mode/css/css.js"></script>
<script src="<?=base_url()?>assets/codemirror/mode/htmlmixed/htmlmixed.js"></script>

<h2><?=$title?></h2>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3)">

<?php if(validation_errors()){?>
    <div class="error alert alert-danger">
        <?=validation_errors('')?>
    </div>    
<?php }?>

<?php if($this->input->get('success')) { ?>
    <div class="success alert alert-success">
        Data berhasil di simpan
    </div>
<?php }?>

<div style="padding: 5px 10px">

<?=form_open(current_url(),array('id' => 'validate'))?>

<label for="PageName"><h3>Judul Halaman</h3></label>
<input required="" autofocus="" type="text" class="required form-control" id="PageName" name="PageName" value="<?=$edit ? $page->PageName : set_value('PageName')?>" />
<!-- <h3>Tampil Judul</h3> -->
<input type="checkbox" <?=$edit? $page->ShowTitle?'checked=""':'' : ''?>  name="ShowTitle" id="ShowTitle" value="1" /> 
<label for="ShowTitle">Tampilkan Judul Halaman</label>

<h3>Pilihan Editor</h3>
<div id="selectEditor">
    <input type="radio" <?=!$edit?'checked=""':''?> name="selectedEditor" <?=($edit && $page->EditorType == FORMBASICID) ? 'checked=""' : ''?> value="<?=FORMBASICID?>" id="basicEditor" class="editorselect" /> <label for="basicEditor">Basic Editor</label>
    <input type="radio" name="selectedEditor" <?=($edit && $page->EditorType == FORMSCRIPTID) ? 'checked=""' : ''?> value="<?=FORMSCRIPTID?>" id="scriptEditor" class="editorselect" /> <label for="scriptEditor">Script Editor</label>
</div>

<div id="Basic">
    <textarea class="form-control" name="editorz" id="editorz"><?=$edit?$page->HTML:set_value('HTML')?></textarea>
    <br />
</div>

<div id="Advanced">
    <h3>Kode HTML</h3>
    <textarea name="HTML" id="HTML"><?=$edit?$page->HTML:set_value('HTML')?></textarea><br />
    
    <h3>Kode CSS</h3>
    <textarea name="CSS" id="CSS"><?=$edit?$page->CSS:set_value('CSS')?></textarea><br />
    
    <h3>Kode JavaScript</h3>
    <textarea name="Javascript" id="JavaScript"><?=$edit?$page->Javascript:set_value('Javascript')?></textarea><br />
</div>

<!-- <div style="float: left;width: 472px"> -->
<div class="col-sm-6">        
<label for="SEOKeyword"><h3>SEO Keyword</h3></label>
<textarea class="form-control" name="SEOKeyword" id="SEOKeyword"><?=$edit ? $page->SEOKeyword : set_value('SEOKeyword')?></textarea>
</div>

<!-- <div style="float: left;width: 472px"> -->
<div class="col-sm-6">
<label for="SEODescription"><h3>SEO Description</h3></label>
<textarea class="form-control" name="SEODescription" id="SEODescription"><?=$edit ? $page->SEODescription : set_value('SEODescription')?></textarea>
</div>

<div class="clear"></div>
<div class="clearfix"></div>
<?php if($edit){?>

<div class="col-sm-10">
<h3>URL</h3>
<div style="background: #ccc;padding: 5px 10px;">
<?=base_url()?> page/view/<input type="text" name="PageURL" value="<?=$page->PageURL?>" />.html
<input class="form-control" style="width: 97%" type="text" readonly="" value="<?=base_url().'page/view/'.$page->PageURL.'.html'?>" />
</div>
</div>

<?php }?>


<div class="clear"></div>
<div class="clearfix"></div>
<br />

<div>
<button type="submit" class="ui btn btn-primary"><b class="glyphicon glyphicon-save"></b> Simpan</button>
</div>
<div class="clearfix"></div>


<div class="col-sm-8 alert alert-info" style="margin-top: 8px;font-size: 12px">
    <?php
         $icon = '<b class="glyphicon glyphicon-arrow-right"></b>';
    ?>
    <strong>Cara Penggunaan :</strong>
    <ol>
        <li><strong>Slider</strong></li>
        [ai:slider ids=id_slider|viewtype=tipe_slider|height=tinggi_slider|width=lebar_slider]
        <ul>
            <li>ex : <strong>Default</strong> <?=$icon?> [ai:slider ids=1 2 3]</li>
            <li>ex : <strong>View</strong> <?=$icon?> [ai:slider ids=1 2 3|viewtype=2]</li>
            <li>ex : <strong>Tinggi</strong> <?=$icon?> [ai:slider ids=1 2 3|height=200]</li>
            <li>ex : <strong>Lebar</strong> <?=$icon?> [ai:slider ids=1 2 3|width=950]</li>
            <li>ex : <strong>Full</strong> <?=$icon?> [ai:slider ids=1 2 3|viewtype=2|height=200|width=950]</li>
        </ul>
        <li><strong>Post</strong></li>
        [ai:post cats=id_kategori|src=tipe|viewtype=tipe_tampilan|count=banyak_data]
        <ul>
            <li>ex : <strong>Default</strong> <?=$icon?> [ai:post cats=1]</li>
            <li>ex : <strong>View</strong> <?=$icon?> [ai:post cats=1|viewtype=1]</li>
            <li>ex : <strong>Count</strong> <?=$icon?> [ai:post cats=1|count=3]</li>
            <li>ex : <strong>Full</strong> <?=$icon?> [ai:post cats=1 2 3|src=post|viewtype=1|count=3]</li>
        </ul>
        <li><strong>Widget</strong></li>
        [ai:widget id=id_widget]
        <ul>
            <li>ex : <strong>Default</strong> <?=$icon?> [ai:widget id=1]</li>
        </ul>
        <li><strong>Menu</strong></li>
        [ai:menu id=id_menu]
        <ul>
            <li>ex : <strong>Default</strong> <?=$icon?> [ai:menu id=1]</li>
        </ul>
    </ol>
</div>
<div class="clearfix"></div>

<?php if($edit){ ?>
       
    <table class="meta ui-state-default" border="1">
        <tr>
            <td>
                Dibuat Oleh:
            </td>
            <td><?=$page->CreatedBy?></td>
        </tr>
        <tr>
            <td>
                Dibuat Pada:
            </td>
            <td><?=$page->CreatedOn?></td>
        </tr>
        <tr>
            <td>
                Diubah Oleh:
            </td>
            <td><?=$page->UpdateBy?></td>
        </tr>
        <tr>
            <td>
                Diubah Pada:
            </td>
            <td><?=$page->UpdateOn?></td>
        </tr>
    </table>
<?php } ?>

<?=form_close()?>

</div>

</div>
<script type="text/javascript">
    $(document).ready(function(){
        var pageurl = '<?=base_url()?>page/view/';
        
        $('.URL').on('change',function(){
            var vall = str_replace($(this).val(),'.','-');
            vall = str_replace(vall,' ','-');
            $('#FullURL').val(pageurl+vall+'.html');
        }).on('keyup',function(e){
            var vall = str_replace($(this).val(),'.','-');
            vall = str_replace(vall,' ','-');
            $('#FullURL').val(pageurl+vall+'.html');
        });
        
        $('#FullURL').on('click',function(){
            $(this).select();
        });
                
        $('form').validate();
        
        var htmleditor = CodeMirror.fromTextArea(document.getElementById("HTML"), {
            mode: "text/html",
            tabMode: "indent",
            lineNumbers: true
        });
        var csseditor = CodeMirror.fromTextArea(document.getElementById("CSS"), {
            mode: "text/html",
            tabMode: "indent",
            lineNumbers: true
        });
        var jseditor = CodeMirror.fromTextArea(document.getElementById("JavaScript"), {
            mode: "text/html",
            tabMode: "indent",
            lineNumbers: true
        });
        
        $(".cats").dropdownchecklist( { icon: { placement: 'right', toOpen: 'ui-icon-arrowthick-1-s'
                                            , toClose: 'ui-icon-arrowthick-1-n' }
                                            , maxDropHeight: 200, width: 300 } );
        
        $('#selectEditor').buttonset();
        $('#editorz').ckeditor();
        $('#Advanced').hide();
        // $('#Basic').fadeIn();
        
        $('input[name=selectedEditor]').change(function(){
            if($(this).val() == "<?=FORMBASICID?>"){
                $('#Basic').fadeIn();
                $('#Advanced').hide();
            }else if($(this).val() == "<?=FORMSCRIPTID?>"){
                $('#Basic').hide();
                $('#Advanced').fadeIn();
            }else{
                $('#Basic').fadeIn();
                $('#Advanced').hide();
            }
        });
        
        if($('.editorselect').attr('checked')){
            $('#Basic').fadeIn();
            $('#Advanced').hide();
        }else{
            $('#Basic').hide();
            $('#Advanced').fadeIn();
        }
        
        
    
        
});

</script>

<?=$this->load->view('admin/footer')?>