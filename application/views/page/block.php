<?php $this->load->view('header') ?>

<?=Do_Shortcode(parse_form(GetSetting("BlockedHTML")))?>

<?php $this->load->view('footer') ?>