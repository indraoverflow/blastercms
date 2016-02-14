<?php $this->load->view(ADMINHEADERVIEW) ?>

<h2>Crop</h2>


<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.Jcrop.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.Jcrop.min.js"></script>

<div style="background-color: #FFF;border-radius: 6px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);padding: 8px 10px">

        <table>
			<tr>
				<td>
					<?=$images?>
				</td>
			</tr>
		</table>

		<form action="<?=current_url()?>" method="post">
				<div class="cinfo">
					<input type="hidden" id="file_name" name="file_name" value="./assets/images/media/<?=$result->MediaPath?>" />
					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
				</div>
				<div class="col-md-4">
				    Width : <input class="form-control" type="text" id="w" name="w" readonly="" />
				</div> 
				<div class="col-md-4">
				    Height : <input class="form-control" readonly="" type="text" id="h" name="h" />
				</div>
                <div class="clearfix"></div>
				<p>
				    <input type="checkbox" checked="" name="KeepOldImage" value="1" id="Keepz" /> <label for="Keepz">Jaga Data Lama</label> 
				</p>
				<p>
				    <button class="ui btn btn-primary" type="submit" name="Submit" value="Submit"><b class="glyphicon glyphicon-save"></b> Simpan</button>
				</p>
		</form>
		
		<script type="text/javascript">
			$(function(){
				$('#cropbox').Jcrop({
					setSelect: [10,10,<?= floor($orig_w*50/100) ?>,<?= floor($orig_h*50/100) ?>],
					onSelect: updateCoords,
					onChange: updateCoords
				});
			});
	
			function updateCoords(c)
			{
				$("#x").val(c.x);
				$("#y").val(c.y);
				$("#w").val(c.w);
				$("#h").val(c.h);
			}
		</script>

</div>

<?php $this->load->view(ADMINFOOTERVIEW) ?>
