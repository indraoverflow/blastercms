<?php $this -> load -> view('header') ?>


<section>
    <div class="forgetpassword">
        
        <h3><?php echo $title ?></h3><br />

        <?php
        if($error){
            ?>
            <div class="error">
                <?=$error?>
            </div>
            <?php
        }
        ?>
        
        <?php
            if($this->input->get('success') != ""){
                ?>
                <div class="success">
                    Kami telah mengirimkan link konfirmasi ke email anda. Silahkan cek email anda.
                </div>
                <?php
            }
        ?>
        
        <?=form_open(current_url(),array('id'=>'validate'))?>
        
        Masukkan Email anda: <br /> 
        <input class="required email title" type="text" name="Email" />
        <br />
        <button class="ui">Kirim</button>
        <?=form_close()?>
        
        <br />
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
       $('#validate').validate();
       
       
        
    });
</script>


<?php $this -> load -> view('footer') ?>
