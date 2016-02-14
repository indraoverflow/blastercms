	
</div>
</div>

<footer>
	<div class="container">
        <ul class="footerTopLine">
            <li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>
        </ul>
    </div>
    <section class="subscribeNewsletter">

        <div class="container">
            <div class="col12 desc">
                <h3 class="">Info Service</h3>
                <h2 class=""><?=SITETITLE?></h2>
            </div><div class="col12">
            <?=form_open(site_url('service/info'),array('method'=>'get','role'=>'form','id'=>'form-subscribe-newsletter'))?>
            <input type="text" placeholder="Masukkan No.Service..." name="noService">
            <button class="subscribeButton" type="submit"><i class="fa fa-fw fa-search"></i> Search</button>
            <?=form_close()?>
        </div>
    </div>

</section>

<div class="footercol_container">
  <div class="container">
   <?php NewGetFooterColumnBoos() ?>
</div>
</div>

<div class="footermenu">
   <div class="container">
       <?php PrintFooterMenu() ?>
   </div>
   <div class="clear"></div>
</div>

<section>
    <div class="footerLinkHeader">
        <div class="container">
            <h2>Belanja <i class="ir ico-paymentBag"></i> dan Bayar dengan Mitra Pembayaran kami</h2>
            <div class="paymentList">
                <ul>
                    <li><i class="ir ico-bca">BCA (Bank Central Asia)</i></li>
                    <li><i class="ir ico-mandiri">Bank Mandiri</i></li>
                    <li><i class="ir ico-epay">Epay BRI</i></li>

                </ul>
            </div>
        </div>
    </div>            
</section>

<div class="container">
   <p class="copy">
       Copyright &copy; <?=date('Y')?> <?=SITETITLE?> - All Right Reserved. Powered by <a href="<?=base_url()?>">Indra Prasetya</a>
   </p>
</div>
</footer>

<div id="LoginDialog"></div>
<div id="RegisterDialog"></div>
</body>
<script type="text/javascript">
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $(document).ready(function(){
        $('a[href="<?=current_url()?>"]').parents('li').addClass('active');
        $('#SidebarLeft .active').parents('.collapse').addClass('in');

        $('.angka').on('keypress',function(e){
            if((e.which <= 57 && e.which >= 48) || (e.keyCode >= 37 && e.keyCode <= 40) || e.keyCode==9 || e.which==43 || e.which==44 || e.which==45 || e.which==46 || e.keyCode==8){
                return true;
            }else{
                return false;
            }
        });

        $('.imgcontainer img').each(function(){
            if($(this).width() > $(this).height()){
                var margintop = ($(this).parent().height() - $(this).height()) / 2;
                $(this).css('margin-top',margintop);
            }
        });
    });
</script>
</html>