<?php
/**
 * 
 */
class Service extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$data['title'] = "Service";
		$this->db->join('statusservice ss','ss.StatusServiceID = s.StatusServiceID','left');
		$data['r'] = $this->db->order_by('TanggalService','desc')->get('services s');
		$this->load->view('service/data',$data);
	}
	
	function add(){
		$data['title'] = "Service Baru";
		$status = $this->db->order_by('StatusServiceName','asc')->get('statusservice');
		$data['status'] = $status;
		$data['edit'] = false;
		if(!empty($_POST)){
			$datainsert = array(
								'KodeService' => $this->input->post('KodeService'),
								'TanggalService' => $this->input->post('TanggalService'),
								'SudahDiambil' => $this->input->post('SudahDiambil'),
								'TanggalAmbil' => $this->input->post('TanggalAmbil'),
								'Dibatalkan' => $this->input->post('Dibatalkan'),
								'TanggalBatal' => $this->input->post('TanggalBatal'),
								'Nama' => $this->input->post('Nama'),
								'HP' => $this->input->post('HP'),
								'Alamat' => $this->input->post('Alamat'),
								'BarangServis' => $this->input->post('BarangServis'),
								'Perlengkapan' => $this->input->post('Perlengkapan'),
								'Kerusakan' => $this->input->post('Kerusakan'),
								'KondisiBarang' => $this->input->post('KondisiBarang'),
								'EstimasiBiaya' => toNum($this->input->post('EstimasiBiaya')),
								'Biaya' => toNum($this->input->post('Biaya')),
								'StatusServiceID' => $this->input->post('StatusServiceID'),
								'Keterangan' => $this->input->post('Keterangan')
			);
			
			$this->db->insert('services',$datainsert);
			redirect(site_url('service')."?success=1");
		}else{
			$this->load->view('service/form',$data);
		}
	}

	function edit($id){
		$data['title'] = "Service Baru";
		$status = $this->db->order_by('StatusServiceName','asc')->get('statusservice');
		$data['status'] = $status;
		$data['edit'] = true;
		$data['result'] = $this->db->where('NoService',$id)->get('services')->row();
		if(!empty($_POST)){
			$datainsert = array(
								'KodeService' => $this->input->post('KodeService'),
								'TanggalService' => $this->input->post('TanggalService'),
								'SudahDiambil' => $this->input->post('SudahDiambil'),
								'TanggalAmbil' => $this->input->post('TanggalAmbil'),
								'Dibatalkan' => $this->input->post('Dibatalkan'),
								'TanggalBatal' => $this->input->post('TanggalBatal'),
								'Nama' => $this->input->post('Nama'),
								'HP' => $this->input->post('HP'),
								'Alamat' => $this->input->post('Alamat'),
								'BarangServis' => $this->input->post('BarangServis'),
								'Perlengkapan' => $this->input->post('Perlengkapan'),
								'Kerusakan' => $this->input->post('Kerusakan'),
								'KondisiBarang' => $this->input->post('KondisiBarang'),
								'EstimasiBiaya' => toNum($this->input->post('EstimasiBiaya')),
								'Biaya' => toNum($this->input->post('Biaya')),
								'StatusServiceID' => $this->input->post('StatusServiceID'),
								'Keterangan' => $this->input->post('Keterangan')
			);
			
			$this->db->update('services',$datainsert,array('NoService' => $id));
			redirect(site_url('service')."?success=1");
		}else{
			$this->load->view('service/form',$data);
		}
	}

	function delete(){
		$datas = $this->input->post('cekbox');
		$deleted = 0;
		foreach ($datas as $data) {
			$this->db->delete('services',array('NoService'=>$data),1);
			$deleted++;
		}
		ShowJsonSuccess($deleted." data dihapus");
		#redirect(site_url('services')."?deleted=".$deleted);
	}
	
	function info(){
        $s = $this->input->post('noService');
        $sg = $this->input->get('noService');
        if(empty($s)){
            $s = $sg;
        }
        
        if(empty($s)){
            redirect();
        }else{
            $s = url_title($s);
            redirect('service/search/'.$s);
        }
    }
	
	function search($keyword){
		$keyword = str_replace("-", " ", $keyword);
		$data['kata'] = $kata = $this -> input -> post('noService');
		
		$data['modal'] = $this -> db -> where('KodeService',$keyword) -> get('services');
		$data['title'] = "Pencarian Service dengan Kode &quot;".$keyword."&quot;";
        $data['catname'] = "Pencarian Service dengan Kode &quot;".$keyword."&quot;";
        $this->load->view('header',$data);
        $this->load->view(DEFAULTSERVICESEARCH,$data);
        $this->load->view('footer',$data);
	}
}
