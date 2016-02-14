<?=$this->load->view('admin/header')?>
<?php
$post       = count($posts -> result());
$page       = count($pages -> result());
$category   = count($categories -> result());
$comment    = count($comments -> result());
$approved    = count($approveds -> result());
$pending    = count($pendings -> result());
?>

<div class="admin-dashboar">
	<h2><?=$title?></h2>
	<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 10px">
		<div class="postbox " id="dashboard_right_now">
			<h3 class="hndle alert alert-info" style="margin-top: 5px">Welcome to Blaster!</h3>
			<div class="inside">
				<div class="table_content col-sm-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="sub panel-title">
								Konten
							</h3>
						</div>
						<div class="panel-body">
							<table class="table table-striped">
								<tbody>
									<tr class="first">
										<td style="width: 50px"  class="first b b-posts"><strong>(<?=$post?>)</strong></td><td class="t posts"> <?=anchor('post','<b class="glyphicon glyphicon-pencil"></b> Post')?></td>
									</tr>
									<tr>
										<td class="first b b_pages"><strong>(<?=$page?>)</strong></td><td class="t pages"> <?=anchor('page','<b class="glyphicon glyphicon-home"></b> Halaman')?></td>
									</tr>
									<tr>
										<td class="first b b-cats"><strong>(<?=$category?>)</strong></td><td class="t cats"> <?=anchor('category','<b class="glyphicon glyphicon-pencil"></b> Kategori')?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class=" table_discussion col-sm-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="sub panel-title">
								Diskusi
							</h3>
						</div>
						<div class="panel-body">
							<table class="table table-striped">
								<tbody>
									<tr class="first">
										<td style="width: 50px" class="b b-comments"><strong>(<?=$comment?>)</strong></td><td class="last t comments"><?=anchor('comment','<b class="glyphicon glyphicon-comment"></b> Komentar')?></td>
									</tr>
									<tr>
									<td class="b b_approved"><a><span><strong>(<?=$approved?>)</strong></span></a></td><td class="last t"><?=anchor(site_url('comment/').'?approved=1','<b class="glyphicon glyphicon-comment"></b> Disetujui')?></td>
									</tr>
									<tr>
										<td class="b b-waiting"><strong>(<?=$pending?>)</strong></td><td class="last t"><?=anchor(site_url('comment/').'?approved=0','<b class="glyphicon glyphicon-comment"></b> Tertunda')?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="clear"></div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>

	<?=$this->load->view('admin/footer')?>
