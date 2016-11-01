<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kelas extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination"));
		$this->load->model(array("admin/Kelas_model","admin/SubmitRaport_model","admin/Log_model"));
	}
	function index(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_kelas)$perpage=$this->session->perpage_kelas;
			else $perpage=5;
						
			$config['base_url'] = site_url('admin/kelas/index');
		
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
				$getdata=$this->Kelas_model->cariKelas($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Kelas_model->jumlahcariKelas($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config['total_rows']."' data dengan keyword '".htmlentities($getrequest["q"])."'</div></div>";
				$get=$getdata->result();
			}else{
				//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->Kelas_model->total();
				$data["caristatus"]=null;
				$get=$this->Kelas_model->getKelas($data['page'],$perpage);
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			$data["idAktif"]="datakurikulum";
			$data["jurusan"]=$this->Kelas_model->getJurusan();
			$data["dataKelas"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["hak_akses"]=$this->session->hak_akses;
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/kelas",$data);
			
		}
	}
	function gantiPaging(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_kelas",abs((int)$post["perpage"]));
				redirect("admin/kelas/index");
			}
			
		}
	}
	function detailKelas(){
		$post=$this->input->post();
		if(isset($post["id_kelas"])){
			$data=$this->db->query("select * from kelas_6771 where id_kelas=".$this->db->escape_str($post["id_kelas"])."");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	function tambahKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input kelas"));
		else{
			$post=$this->input->post();
			if(empty($post["prefix_kelas"])|| empty($post["kd_jurusan"]) || empty($post["nomor_kelas"]))die(json_encode(array("error"=>"Prefix kelas, Jurusan, dan Nomor kelas tidak boleh kosong")));
			$input=$this->Kelas_model->inputKelas($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}
	function editKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input kelas"));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			$edit=$this->Kelas_model->editKelas($post);
			if($edit["sukses"]===true)echo json_encode(array("sukses"=>$edit["msg"]));
			else echo json_encode(array("error"=>isset($edit["msg"]["message"])?$edit["msg"]["message"]:$edit["msg"]));
		}
	}
	function hapusKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input kelas"));
		else{
			$id=$this->input->post("id_kelas_forHapus");
			$id=$this->db->escape_str($id);
			$query=$this->db->query("delete from kelas_6771 where id_kelas='".$id."'");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function getKelas(){
		if(!empty($this->input->get("id_jurusan"))){
			$id_jurusan=$this->db->escape_str($this->input->get("id_jurusan"));
			$query=$this->db->query("select * from kelas_6771 a inner join jurusan_6771 b on a.kd_jurusan=b.id_jurusan where b.id_jurusan=$id_jurusan")->result();
			$kelas='';
			foreach($query as $mbuh)$kelas.="<option value=\"".$mbuh->id_kelas."\">".$mbuh->prefix_kelas." ".$mbuh->nama_jurusan." ".$mbuh->nomor_kelas."</option>";
			echo $kelas;
			
		}else echo "you bitches";
	}
	
}