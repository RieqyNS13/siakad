<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Guru extends CI_Controller{
	function __construct(){
		date_default_timezone_set("Asia/Jakarta");
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination","Proses_data","Excel"));
		$this->load->model(array("admin/Guru_model","admin/SubmitRaport_model","admin/Log_model"));

	}
	function test(){
		print_r($_FILES);
	}
	function index(){
		//if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || $this->session->userdata("hak_akses")!="admin")redirect("admin/login");
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_guru)$perpage=$this->session->perpage_guru;
			else $perpage=5;
			
			$config['base_url'] = site_url('admin/guru/index');
		
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
				$getdata=$this->Guru_model->cariGuru($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Guru_model->jumlahcariGuru($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				$get=$getdata->result();
				
			}else{
			//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->Guru_model->total();
				$data["caristatus"]=null;
				$get=$this->Guru_model->getGuru($data['page'],$perpage);
			}
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			$data["idAktif"]="dataguru";
			$data["dataGuru"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["hak_akses"]=$this->session->hak_akses;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/guru",$data);
			
		}
	}
	function gantiPagingGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_guru",abs((int)$post["perpage"]));
				redirect("admin/guru/index");
			}
			
		}
	}
	function hapusGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$kode_guru=$this->input->post("kode_guruforHapus");
			$kode_guru=$this->db->escape_str($kode_guru);
			$data=$this->db->query("select * from guru_6771 where kode_guru='".$kode_guru."'")->row();
			if(!empty($data->photo))unlink($data->photo);
			$query=$this->db->query("delete from guru_6771 where kode_guru='".$kode_guru."'");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function editGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$post2=$this->input->post();
			if(count($post2)==0)die("silent");
			foreach($post2 as $key=>$data){
				$post[str_replace("2","",$key)]=$data;
			}
			if(isset($post["photo"]))unset($post["photo"]);
			$data=array();
			if(isset($_FILES["photo2"])){
				$config["upload_path"]="./assets/images/guru/";
				$config["allowed_types"]= 'gif|png|jpg|jpeg|bmp';
				$config["overwrite"]=TRUE;
				$config["file_name"]=md5($_FILES["photo2"]["name"].time());
				$this->load->library('upload', $config);
				if($this->upload->do_upload("photo2")){
					$dataupload=$this->upload->data();
					$data["photo"]=$config["upload_path"].$dataupload["file_name"];
					$query=$this->db->query("select * from guru_6771 where kode_guru='".$this->db->escape_str($post["kode_guruforEdit"])."'")->row();
					if(!empty($query->photo))unlink($query->photo);
				}else{
					echo json_encode(array("error"=>$this->upload->display_errors()));
					die;
				}
			}
			if($post["options"]==2 && strlen(trim($post["nip"]))==0)die(json_encode(array("error"=>"NIP Tidak boleh kosong"))); 
			else if($post["options"]==1){
				$post["nip"]=null;
			}
			//print_r(array_merge($_FILES,$post));die;
			if(isset($post["options"]))unset($post["options"]);
			foreach($post as $key=>$line){
				$data[$key]=$line;
				if(strlen(trim($line))==0 && $key!="nip")die(json_encode(array("error"=>"Masih ada data yang kosong")));
				
			}
			$data["tgl_lahir"]=date("Y-m-d",strtotime($data["tgl_lahir"]));
			$input=$this->Guru_model->editGuru($data);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}	
	function importFile(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input ".$this->session->userdata("hak_akses")));
		else{
			if(isset($_FILES["filecsv"])){
				$name=$_FILES["filecsv"]["name"];
				$file=$_FILES["filecsv"]["tmp_name"];
				$exp=explode(".",$name);
				$format=strtolower(end($exp));
				//die(json_encode(array("error"=>file_get_contents($file))));
				if($format!="xls")die(json_encode(array("error"=>"Format file salah. Silahkan upload file .XLS")));
				$obj_excel=PHPExcel_IOFactory::load($file);
				$data_arr=$obj_excel->getActiveSheet()->toArray(null,true,true,true);
				if(!isset($data_arr[4]))die(json_encode(array("error"=>"Rows tidak sesuai")));
				$tmp=$data_arr[4];
				$a=array();
				foreach($tmp as $mbuh)array_push($a,$mbuh);
				$field_db=array();
				if(count($a)==7){
					$field=array("KODE GURU","NIP","NAMA","TELEPON","TEMPAT LAHIR","TANGGAL LAHIR","ALAMAT");
					$field2=array("kode_guru","nip","nama","telepon","tempat_lahir","tgl_lahir","alamat");
					foreach($a as $key=>$mbuh){
						$name=strtoupper($mbuh);
						if(in_array($name,$field)){
							$index=array_search($name,$field);
							array_push($field_db,$field2[$index]);
							unset($field[$index]);
						}else die(json_encode(array("error"=>"Field tidak sesuai : {$name}")));
					}
				}else die(json_encode(array("error"=>"Jumlah field tidak sesuai")));
				$sukses=array();
				$gagal=array();
				
				$i=5;$jumlah_data=count($data_arr);
				while ($i<=$jumlah_data){
					$data=array();
					foreach($data_arr[$i] as $tmp)array_push($data,$tmp);
					foreach($field_db as $key=>$key_db){
						$data_db[$key_db]=$data[$key];
						if($key_db=="tgl_lahir" && !empty($data[$key]))$data_db[$key_db]=date("Y-m-d",strtotime($data[$key]));
					}
					//print_r($data_db);die;
					if($this->proses_data->isKosongSemua($data_db))continue;
					$input_xls=$this->Guru_model->inputGuru_csv($data_db);
					if($input_xls["sukses"])array_push($sukses,$data_db);
					else array_push($gagal,$data_db);
					$i++;
				}
				echo json_encode(array("sukses"=>"S:".count($sukses)."<br>F:".count($gagal)));
				//echo file_get_contents($file);
			}
		}

	}
	function submitGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(isset($post["photo"]))unset($post["photo"]);
			if(isset($_FILES["photo"])){
				$config["upload_path"]="./assets/images/guru/";
				$config["allowed_types"]= 'gif|png|jpg|jpeg|bmp';
				$config["overwrite"]=TRUE;
				$config["file_name"]=md5($_FILES["photo"]["name"].time());
				$this->load->library('upload', $config);
				if($this->upload->do_upload("photo")){
					$dataupload=$this->upload->data();
					$data["photo"]=$config["upload_path"].$dataupload["file_name"];
				}else{
					echo json_encode(array("error"=>$this->upload->display_errors()));
					die;
				}
				
			}
			if($post["options"]==2 && strlen(trim($post["nip"]))==0)die(json_encode(array("error"=>"NIP Tidak boleh kosong"))); 
			if(isset($post["options"]))unset($post["options"]);
			foreach($post as $key=>$line){
				if(strlen(trim($line))==0)die(json_encode(array("error"=>"Masih ada data yang kosong")));
				$data[$key]=$line;
			}
			$data["tgl_lahir"]=date("Y-m-d",strtotime($data["tgl_lahir"]));
			$input=$this->Guru_model->inputGuru($data);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
				
		}
	}
	function lihatDetailGuru(){
		$post=$this->input->post();
		if(isset($post["kode_guru"])){
			$data=$this->db->query("select * from guru_6771 where kode_guru='".$this->db->escape_str($post["kode_guru"])."'");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	
}
?>