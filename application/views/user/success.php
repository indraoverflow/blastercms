<?php $this -> load -> view('header') ?>

<?php if($success){ ?>
    <h2>Registrasi</h2>

    <?php if(GetSetting('AutoApprove')==AUTOAPPROVE){ ?>        
        <div class="info">
            Register anda berhasil
        </div>
    <?php }else{ ?>
        <div class="info">
            Link aktivasi telah dikirimkan. Silahkan cek email anda <strong><?=$this->session->userdata('TempEmail')?></strong>
            kemudian klik link aktivasi yang kami berikan untuk mengaktifkan akun anda. Terima kasih.
        </div>  
    <?php }?>
    
<?php } ?>

<?php $this -> load -> view('footer') ?>
