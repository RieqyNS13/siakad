<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Mapel_guru extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination"));
		$this->load->model(array("admin/MapelGuru_model","admin/SubmitRaport_model","admin/Log_model"));
	}
	function index(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_mapelguru)$perpage=$this->session->perpage_mapelguru;
			else $perpage=5;
						
			$config['base_url'] = site_url('admin/mapel_guru/index');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 4;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$getdata=$this->MapelGuru_model->cariMapelGuru($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->MapelGuru_model->jumlahcariMapelGuru($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config['total_rows']."' data dengan keyword '".htmlentities($getrequest["q"])."'</div></div>";
				$get=$getdata->result();
			}else{
				//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->MapelGuru_model->total();
				$data["caristatus"]=null;
				$get=$this->MapelGuru_model->getMapelGuru($data['page'],$perpage);
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			
			$data["idAktif"]="dataguru";
			$data["kodeGuru"]=$this->MapelGuru_model->getKodeGuru();
			$data["kodeMapel"]=$this->MapelGuru_model->getKodeMapel();
			$data["dataMapelGuru"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["hak_akses"]=$this->session->hak_akses;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/mapel_guru",$data);
			
		}
	}
	function tambahMapelGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(empty($post["kode_guru"])|| empty($post["kd_mapel"]))die(json_encode(array("error"=>"Kode guru dan kode mapel tidak boleh kosong")));
			$input=$this->MapelGuru_model->inputMapelGuru($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}
	function editMapelGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa edit mapel guru ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			$edit=$this->MapelGuru_model->editMapelGuru($post);
			if($edit["sukses"]===true)echo json_encode(array("sukses"=>$edit["msg"]));
			else echo json_encode(array("error"=>isset($edit["msg"]["message"])?$edit["msg"]["message"]:$edit["msg"]));
		}		
	}
	function hapusMapelGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa hapus mapel guru ".$this->session->userdata("hak_akses")));
		else{
			$id=$this->input->post("id_forHapus");
			$id=abs((int)$id);
			$query=$this->db->query("delete from guru_mengajar_6771 where id=$id");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function detailMapelGuru($htmlentities=null){
		$post=$this->input->post();
		if(isset($post["id"])){
			$id=abs((int)$post["id"]);
			$data=$this->db->query("select * from guru_mengajar_6771 where id=$id");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=$htmlentities!=null?htmlentities(stripslashes($ikkeh)):stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
		
	}
	function gantiPaging(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_mapelguru",abs((int)$post["perpage"]));
				redirect("admin/mapel_guru/index");
			}
			
		}
	}
	
}
?>