<?php
/**
 * 
 */
class Ajax extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		if(!$this->input->is_ajax_request()){
			exit;
		}
	}
	
	function GetProvinceOption(){
		$id = $this->input->post('id');
		$this->db->where('CountryID',$id);
		$row = $this->db->get('provinces');
		?>
		<option value="">Semua Provinsi</option>
		<?php
		foreach ($row->result() as $prov) {
			?>
			<option value="<?=$prov->ProvinceID?>"><?=$prov->ProvinceName?></option>
			<?php
		}
	}
	function GetCityOption(){
		$country = $this->input->post('country');
		$province = $this->input->post('province');
		if($country > 0){
			$this->db->where('p.CountryID',$country);
		}
		if($province > 0){
			$this->db->where('p.ProvinceID',$province);
		}
		$this->db->join('provinces p', 'p.ProvinceID = c.ProvinceID','left');
		$this->db->join('countries co', 'co.CountryID = p.CountryID','left');
		$row = $this->db->get('cities c');
		
		echo '<option value="">Pilih Kota</option>';
		foreach ($row->result() as $city) {
			?>
			<option value="<?=$city->CityID?>"><?=$city->CityName?></option>
			<?php
		}
	}
	function GetCityShipment(){
		CheckLogin();
		$country = $this->input->post('country');
		$province = $this->input->post('province');
		$shipmentid = $this->input->post('shipmentid');
		if($country > 0){
			$this->db->where('p.CountryID',$country);
		}
		if($province > 0){
			$this->db->where('p.ProvinceID',$province);
		}
		$this->db->join('provinces p', 'p.ProvinceID = c.ProvinceID','left');
		$this->db->join('countries co', 'co.CountryID = p.CountryID','left');
		$row = $this->db->get('cities c');
		foreach ($row->result() as $city) {
			
			if($shipmentid){
				$this->db->where(array('CityID'=>$city->CityID,'ShipmentID'=>$shipmentid));
				$cek = $this->db->get('shipmentcost');
				if($cek->num_rows()){
					$row = $cek->row();
					$value = $row->Cost;
				}else{
					$value = 0;
				}
			}else{
				$value = 0;
			}
			?>
			<tr>
			<td><?=$city->CityName?>, <?=$city->ProvinceName?>, <?=$city->CountryName?></td>
			<td>
				<input type="hidden" name="cities[]" value="<?=$city->CityID?>" />
				<input class="angka uang" name="Tarif-<?=$city->CityID?>" value="<?=desimal($value)?>" />
			</td>
			</tr>
			<?php
		}
	}
	
	function CekCombination(){
		$this->load->model('mcombination');
		$this->load->model('mpost');
		
		$product = $this->input->post('productid');
		
		$attributes = $this->input->post('attributes');
		
		if($attributes){
			foreach ($attributes as $key => $link)
			{
			    if ($attributes[$key] == '')
			    {
			        unset($attributes[$key]);
			    }
			}
		}
		
		if($attributes){
		
			$comb = "";
			
			$attributes = join(",",$attributes);
			
			$query = $this->db->query("SELECT * FROM productcombinationdetails where AttributeDetailID IN (".$attributes.") AND ProductID = '".$product."'");
			
			$existdata = array();
			foreach ($query->result() as $que) {
				$existdata[] = $que->AttributeDetailID;
			}
			
			$querydistinct = $this->db->query("SELECT DISTINCT CombinationID FROM productcombinationdetails where AttributeDetailID IN (".$attributes.") AND ProductID = '".$product."'");
			
			if($querydistinct->num_rows() == 1){
				$row = $querydistinct->row();
				$comb = $row->CombinationID;
			}else if($querydistinct->num_rows() > 1){
				foreach ($query->result() as $rcomb) {
					$combdetailquery = $this->db->query("SELECT * FROM productcombinationdetails where CombinationID = '".$rcomb->CombinationID."'");
					$totalrow = $combdetailquery->num_rows();
					$match = 0;
					foreach ($combdetailquery->result() as $combdetail) {
						if(in_array($combdetail->AttributeDetailID, $existdata)){
							$match++;
						}
					}
					if($match == $totalrow){
						$comb = $rcomb->CombinationID;
						break;
					}
				}
			}else{
				$comb = "";
			}
		}else{
			$comb = "";
		}
		
		$qty = $this->input->post('Qty');
		
		$result = $this->mpost->GetAll(array('p.PostID'=>$product))->row();
		$oriprice = (!empty($result->DiscountPrice) && $result->DiscountUntil >= date('Y-m-d')) ? ProductPrice($result->DiscountPrice) : ProductPrice($result->Price);
		if(!empty($existdata) && $comb == ""){
			ShowJsonError(lang('no_combination'));
			return FALSE;
		}
		
		$media = "";
		$fullmedia = "";
		
		if($comb){
			$rcomb = $this->mcombination->GetWhere(array('CombinationID'=>$comb))->row();
			$price = $oriprice + $rcomb->ImpactPrice;
			$coretprice = ProductPrice($result->Price) + $rcomb->ImpactPrice;
			$weight = $result->Weight + $rcomb->ImpactWeight;
			if($rcomb->MediaID){
				$rmedia = $this->db->where('MediaID',$rcomb->MediaID)->get('media')->row();
				$media = $rmedia->MediaPath;
				$fullmedia = base_url()."assets/images/media/".$rmedia->MediaPath;
			}
		}else{
			$price = $oriprice;
			$coretprice = ProductPrice($result->Price);
			$weight = $result->Weight;
		}
		
		$response = array(
						'Price'=>rupiah($price),
						'CoretPrice'=>rupiah($coretprice),
						'Weight'=>desimal($weight,2),
						'Media'=>$media,
						'FullMedia'=>$fullmedia,
						'error'=>0
		);
		
		echo json_encode($response);
	}
	
	function cekshippingavailable(){
		$this->load->model('mshipment');
		$shipment = $this->input->post('shipment');
		$city = $this->input->post('city');
		
		$this->db->where('CityID',$city);
		$rcity = $this->db->get('cities')->row();
		
		$rshipment = $this->mshipment->GetWhere(array('ShipmentID'=>$shipment))->row();

		$cek = $this->mshipment->IsCityAvailable($shipment,$city);
		
		// if($shipment == (string)CODID){
			// $data = array(
				// 'available'=>1,
				// 'name'=>$rcity->CityName,
				// 'cost'=>0,
				// 'message'=>'Anda memilih '.$rshipment->ShipmentName
			// );
			// echo json_encode($data);
			// return;
		// }
		
		if($cek){
			$data = array(
				'available'=>1,
				'name'=>$cek->CityName,
				'cost'=>desimal($cek->Cost),
				#'message'=>"Pengiriman melalui ".$rshipment->ShipmentName." ke ".$rcity->CityName.". Biaya ".desimal($cek->Cost)." per Kg."
				'message'=>sprintf(lang('shipping_available'),$rshipment->ShipmentName,$rcity->CityName,desimal($cek->Cost))
			);
		}else{
			$data = array(
				'available'=>0,
				'name'=>$rcity->CityName,
				'message'=>sprintf(lang('shipping_not_available'),$rcity->CityName,$rshipment->ShipmentName)
			);
		}
		echo json_encode($data);
	}
	function countshipping(){
		$this->load->model('mshipment');
		$shipment = $this->input->post('shipment');
		$weight = ceil($this->session->userdata('Weight'));
		$total = $this->session->userdata('MustPay')+TotalDiscount();
		$shipmentinfo = $this->session->userdata('ShipmentInformation');
		
		$cek = $this->mshipment->IsCityAvailable($shipment,$shipmentinfo['CityID']);
		
		if($cek){
			$cost = $weight * $cek->Cost;
			?>
						<div class="subtotal">
							<span class="title"><?=lang('total_weight')?></span>
							<span class="amount"><?=desimal($weight,2)?> Kg</span>
						</div>
						<div class="subtotal">
							<span class="title">Subtotal</span>
							<span class="price" id="SubTotal"><?=desimal($total,2)?></span>
						</div>
						<div class="subtotal">
							<span class="title"><?=lang('shipping_cost')?> (<?=desimal($cost)?> - <?=desimal(ShippingDiscount())?>)</span>
							<span class="amount" id="ShipmentCost"><?=desimal($cost - ShippingDiscount(),2)?></span>
						</div>
						<div class="subtotal">
							<span class="title"><?=lang('discount')?></span>
							<span class="amount"><?=desimal(TotalDiscount(),2)?></span>
						</div>
						<div style="border-top: 1px dotted #000" class="subtotal">
							<span class="title">Total</span>
							<?php
								$grandtotal = $total + ($cost - ShippingDiscount()) - TotalDiscount();
							?>
							<span class="amount" id="TotalCost"><strong><?=desimal($grandtotal,2)?></strong></span>
						</div>
			<?php
		}else{
			?>
						<div class="subtotal">
							<span class="title"><?=lang('total_weight')?></span>
							<span class="amount"><?=desimal($weight,2)?> Kg</span>
						</div>
						<div class="subtotal">
							<span class="title">Subtotal</span>
							<span class="price" id="SubTotal"><?=desimal($total,2)?></span>
						</div>
						<div class="subtotal">
							<span class="title"><?=lang('shipping_cost')?> (<?=desimal(0)?> - <?=ShippingDiscount()?>)</span>
							<span class="amount" id="ShipmentCost"><?=desimal(0 - ShippingDiscount(),2)?></span>
						</div>
						<div class="subtotal">
							<span class="title"><?=lang('discount')?></span>
							<span class="amount"><?=desimal(TotalDiscount(),2)?></span>
						</div>
						<div style="border-top: 1px dotted #000" class="subtotal">
							<span class="title">Total</span>
							<?php
								$grandtotal = $total + (0 - ShippingDiscount()) - TotalDiscount();
							?>
							<span class="amount" id="TotalCost"><strong><?=desimal($grandtotal,2)?></strong></span>
						</div>
			<?php
		}
	}
}
