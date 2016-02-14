<section id="main">
	<script type="text/javascript" src="<?=base_url()?>assets/basic/offcanvas.js"></script>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/basic/offcanvas.css" />

	<!-- <div class="row row-offcanvas row-offcanvas-right"> -->
	<div class="mainmain">
	<?php if(!empty($catname)){ ?>
		<div class="viewType">	
		<h2 style="font-size: 18px;" class="viewtype-title page-header"><?= $catname ?></h2>
		<div class="clear"></div>
	<?php } ?>	
		
   	<table width="100%" class="tableMain">
   		<tr>
            
            <td id="SidebarLeft" class="col-sm-3">
                <?php echo Do_Shortcode("[ai:widget id=1]"); ?>
            </td>
            
            <td class="col-xs-12 col-sm-9" id="main_postcontent">
            	<?php if($modal->num_rows()>0){
            		foreach ($modal->result() as $m) {
            			$ss = $this -> db -> where('StatusServiceID',$m->StatusServiceID) -> get('statusservice') -> row();
				?>
				
				<div class="list-group">
					<a class="list-group-item" href="#">
						<p class="list-group-item-text">
						<div>
							<div class="col-xs-4 col-sm-4 text-success"><b>Kode Service</b></div>
							<div class="col-xs-8 col-sm-8 text-success">: <b><?=$m->KodeService?></b></div>
							
							<div class="col-xs-4 col-sm-4"><b>Tgl Service</b></div>
							<div class="col-xs-8 col-sm-8">: <?=konversi_tanggal(date('D, d M Y',strtotime($m->TanggalService)))?></div>
							
							<?php if($m->SudahDiambil){ ?>
							<div class="col-xs-4 col-sm-4 text-success"><b>Status Pengambilan</b></div>
							<div class="col-xs-8 col-sm-8 text-success">: <b>Barang Sudah Diambil</b></div>
							
							<div class="col-xs-4 col-sm-4 text-info"><b>Tgl Pengambilan</b></div>
							<div class="col-xs-8 col-sm-8 text-info">: <?=konversi_tanggal(date('D, d M Y',strtotime($m->TanggalAmbil)))?></div>
							<?php } if($m->Dibatalkan){ ?>
							<div class="col-xs-4 col-sm-4 text-danger"><b>Status Pembatalan</b></div>
							<div class="col-xs-8 col-sm-8 text-danger">: <b>Service Dibatalkan</b></div>
							
							<div class="col-xs-4 col-sm-4 text-warning"><b>Tgl Pengambilan</b></div>
							<div class="col-xs-8 col-sm-8 text-warning">: <?=konversi_tanggal(date('D, d M Y',strtotime($m->TanggalBatal)))?></div>	
							<?php } ?>
							
							<div class="col-xs-4 col-sm-4"><b>Nama</b></div>
							<div class="col-xs-8 col-sm-8">: <b><?=$m->Nama?></b></div>
							
							<div class="col-xs-4 col-sm-4"><b>Alamat</b></div>
							<div class="col-xs-8 col-sm-8">: <?=$m->Alamat?></div>
							
							<div class="col-xs-4 col-sm-4"><b>HP</b></div>
							<div class="col-xs-8 col-sm-8">: <?=$m->HP?></div>
						
							
							<div class="col-xs-4 col-sm-4"><b>Barang Service</b></div>
							<div class="col-xs-8 col-sm-8">: <?=$m->BarangServis?></div>
							
							<div class="col-xs-4 col-sm-4"><b>Perlengkapan</b></div>
							<div class="col-xs-8 col-sm-8">: <?=$m->Perlengkapan?></div>
							
							<div class="col-xs-4 col-sm-4"><b>Kerusakan</b></div>
							<div class="col-xs-8 col-sm-8">: <?=$m->Kerusakan?></div>
							
							<div class="col-xs-4 col-sm-4"><b>Kondisi Barang</b></div>
							<div class="col-xs-8 col-sm-8">: <?=$m->KondisiBarang?></div>
							
							<div class="col-xs-4 col-sm-4"><b>Estimasi Biaya</b></div>
							<div class="col-xs-8 col-sm-8 text-info">: <?=empty($m->EstimasiBiaya)?'-':rupiah($m->EstimasiBiaya,2)?></div>
							
							<div class="col-xs-4 col-sm-4"><b>Biaya</b></div>
							<div class="col-xs-8 col-sm-8 text-info">: <?=empty($m->Biaya)?'-':rupiah($m->Biaya,2)?></div>
							
							<div class="col-xs-4 col-sm-4"><b>Status Service</b></div>
							<div class="col-xs-8 col-sm-8">: <?=$ss->StatusServiceName?></div>
							
							<div class="clearfix clear"></div>
						</div>
						</p>
						
					</a>
				</div>

				<?php }?>
            		
            	<?php }else{ ?>
            	<div class="alert alert-warning alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    Data yang anda cari tidak ada.
                </div>
            	<?php }?>
            </td>
            
        </tr>
    </table>

	</div>
</section>


