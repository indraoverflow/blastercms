		</div>
		<div class="clearfix"></div>
  </section>
  <div class="clearfix"></div>
</div>
<div id="GeneralDialog"></div>
<div id="GeneralDialogIcon"></div>
<div id="alertDialog"></div>
<div id="confirmDialog"></div>

<script type="text/javascript">
    $(document).ready(function() {
        jQuery(document).ready(function() {
            jQuery('.sf-menu').superfish({
                animation : {
                    height : 'show'
                        }, // slide-down effect without fade-in
                        delay : 1200 // 1.2 second delay on mouseout
                    });
        });

        if ($('.editor').length) {
            $('.editor').ckeditor({
                fullPage : true,
                extraPlugins : 'docprops'
            });
        }
    });

    $(document).ready(function(){
        $('#validate').validate();
        $('.ckeditor').ckeditor();
        $('.datatable').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        });
        $('.sf-menu a[href="<?=current_url()?>"]').parent().addClass('current');
        if($('.cekboxaction').length){
            $('.cekboxaction').click(function(){
                if($('.cekbox:checked').length < 1){
                    $('#alertDialog').empty();
                    $('#alertDialog').html("Tidak ada satupun data yang dipilih");
                    $('#alertDialog').dialog({
                        width: "auto",
                        height: "auto",
                        modal: true,
                        title: "Peringatan",
                        resizable:false,
                        buttons: [{
                            text: "OK",
                            click: function() {
                                $( this ).dialog( "close" );
                            }
                        }]
                    });
                    return false;
                }

                var a = $(this);
                $('#confirmDialog').empty();
                $('#confirmDialog').html(a.attr('confirm'));
                $('#confirmDialog').dialog({
                    modal : true,
                    width : "auto",
                    height: "auto",
                    title:"Konfirmasi",
                    resizable:false,
                    buttons : {
                        "Lanjutkan" : function(){
                            $('#dataform').ajaxSubmit({
                                dataType: 'json',
                                url : a.attr('href'),
                                success : function(data){
                                    if(data.error==0){
                                        $('#alertDialog').empty();
                                        $('#alertDialog').html(data.success);
                                        $('#alertDialog').dialog({
                                            width: "auto",
                                            height: "auto",
                                            modal: true,
                                            title: "Berhasil",
                                            resizable:false,
                                            buttons : {
                                                "OK" : function(){
                                                    $('#confirmDialog').dialog('close');
                                                    $(this).dialog('close');
                                                    window.location.reload();
                                                }
                                            }
                                        });
                                    }else{
                                        $('#alertDialog').empty();
                                        $('#alertDialog').html(data.error);
                                        $('#alertDialog').dialog({
                                            width: "auto",
                                            height: "auto",
                                            modal: true,
                                            title: "Peringatan",
                                            resizable:false,
                                            buttons : {
                                                "OK" : function(){
                                                    $('#confirmDialog').dialog('close');
                                                    $(this).dialog('close');
                                                }
                                            }
                                        });
                                    }
                                }
                            });
    },
    "Batal" : function(){
        $(this).dialog('close');
    }
}
});
        return false;
    });
    }

    $('#dataform').submit(function(){
        return false;
    });

    if($('#cekbox').length){
        $('#cekbox').click(function(){
            if($(this).attr('checked')){
                $('.cekbox').attr('checked',true);
            }else{
                $('.cekbox').attr('checked',false);
            }
        });
    }

    if($('.datepicker').length){
        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            yearRange: "1900:2100",
            changeYear : true,
            changeMonth: true,
            showOn: "button",
            buttonImage: "<?=base_url()?>assets/images/calendar.gif",
            buttonImageOnly: true
        });
    }

    var icons = {
        header: "ui-icon-circle-arrow-e",
        activeHeader: "ui-icon-circle-arrow-s"
    };
    $('.menu-h').accordion({
        icons: icons
    });
    $('a[href="<?=current_url()?>"].ui').addClass('ui-state-disabled');
    $('.sf-menu a[href="<?=current_url()?>"]').parent().addClass('current');
    $('#accor').accordion({
        heightStyle:"content",
        collapsible:true,
        clearStyle:true,
        create: function(event, ui) {
                //get index in cookie on accordion create event
                if($.cookie('saved_index') != null){
                    act =  parseInt($.cookie('saved_index'));
                }
            },
            activate: function(event, ui) {
                      //set cookie for current index on change event
                      $.cookie('saved_index', null);
                      var idx = $('.ui-accordion-header').index(ui.newHeader);
                      //alert(idx);
                      $.cookie('saved_index', idx);
                  },
                  active:parseInt($.cookie('saved_index'))
              });

    $('.angka').live('keypress',function(e){
        if((e.which <= 57 && e.which >= 48) || (e.keyCode >= 37 && e.keyCode <= 40) || e.keyCode==9 || e.which==43 || e.which==44 || e.which==45 || e.which==46 || e.keyCode==8){
            return true;
        }else{
            return false;
        }
    });
});

        $.widget("ui.dialog", $.ui.dialog, {
            _allowInteraction: function(event) {
                return !!$(event.target).closest(".cke").length || this._super(event);
            }
        });
    </script>

</body>
</html>