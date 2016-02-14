<?php $this -> load -> view('header')?>

<?php if($this -> input -> get('msg')=='suspend'){ ?>
</br>
   <div class="error">
       Maaf, Akun anda di non-aktifkan
   </div> 
<? }else if($this -> input -> get('msg')=='verify'){ ?>
</br>
   <div class="error">
       Maaf, Akun anda belum diverifikasi
   </div> 
<? }else if($this -> input -> get('msg')=='expired'){ ?>
</br>
   <div class="error">
       Maaf, Akun anda sudah tidak berlaku
   </div> 
<? }?>

<section>
    <?php echo empty($error) ? "" : "</br><div class='error'>".$error."</div>"; ?>
    <div class="user_reg" >
        <h3>Tidak Punya Akun?</h3>
        <p><?=anchor('user/register', 'Daftar Sekarang',array('class' => 'ui')) ?></p>
    </div>
    <div class="user_login">
        
         
        
        <h3><?php echo $title ?></h3>
    
        <?=form_open(current_url(), array('id' => 'validate'))?>
        
        <!-- <label for="Username"><h4>Username / Email</h4></label> -->
        <input  type="text" id="UserName" name="UserName" placeholder="Username" value="<?=set_value('Username')?>" />
        <br />
        <!-- <label for="Password"><h4>Password</h4></label> -->
        <input  type="password" id="Password" name="Password" placeholder="Password" value="<?=set_value('Password') ?>" />
        
        <br />
        <input type="submit" class="ui" value="Masuk" />
        
        <?form_close()?>
        
        <br /><br />
        <p><?=anchor('user/forgetpassword', 'Lupa Password') ?></p>
    </div>
    
</section>

<script type="text/javascript">
    $(document).ready(function(){
       $('#validate').validate(); 
    });
</script>

<?php $this -> load -> view('footer')?>