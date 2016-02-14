<?php $this->load->view('header') ?>

<h2>Aktivasi</h2>

<div class="info">
	Terima kasih <?=$row->FirstName?>, akun anda telah diverifikasi dan diaktifkan. Silahkan login dengan username <strong><?=$row->UserName?></strong>. 
</div>

<?php $this->load->view('footer') ?>
