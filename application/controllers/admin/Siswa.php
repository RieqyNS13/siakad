<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Siswa extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination","form_validation","Excel"));
		$this->load->model(array("admin/Siswa_model","admin/SubmitRaport_model","admin/Log_model"));
	}
	function index(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_siswa)$perpage=$this->session->perpage_siswa;
			else $perpage=5;
			
			$tampil=$this->session->userdata("tampil");
			
			$config['base_url'] = site_url('admin/siswa/index');
		
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
				$get=$this->Siswa_model->cariSiswa($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Siswa_model->jumlahcariSiswa($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config['total_rows']."' data dengan keyword '".htmlentities($getrequest["q"])."'</div></div>";
				$data["agama"]=null;
			}else{
			//$config["num_links"]=$config['total_rows']/$perpage;

				$config['total_rows'] = $this->Siswa_model->total($tampil);
				$data["caristatus"]=null;
				$get=$this->Siswa_model->getSiswa($data['page'],$perpage,$tampil);
				
				
			}
			$jurusan='';
			$query=$this->db->query("select * from jurusan_6771")->result();
			foreach($query as $mbuh){
				$jurusan.="<option value=\"".$mbuh->id_jurusan."\">".$mbuh->nama_jurusan." | ".$mbuh->nama_full."</option>";
			}
			$agama='';
			$query=$this->db->query("select * from agama_6771")->result();
			foreach($query as $mbuh){
				$agama.="<option value=\"".$mbuh->id_agama."\">".$mbuh->agama."</option>";
			}
			$data["agama"]=$agama;
			$data["idAktif"]="datasiswa";
			$data["jurusan"]=$jurusan;
			//print_r($this->Siswa_model->getKelasurut());die;
			$data["tampil"]=$tampil!=null?$tampil:0;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=(stripslashes($mbuh));
			}
			$data["dataSiswa"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["hak_akses"]=$this->session->hak_akses;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/siswa",$data);
			
		}	
		
	}
	function gantiPaging(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				if(isset($post["tampil"]))$this->session->set_userdata("tampil",$post["tampil"]);
				$this->session->set_userdata("perpage_siswa",abs((int)$post["perpage"]));
				redirect("admin/siswa/index");
			}
			
		}
	}
	function detailSiswa($htmlentities=null){
		$post=$this->input->post();
		if(isset($post["nis"])){
			$nis=$this->db->escape_str($post["nis"]);
			$data=$this->db->query("select * from siswa_6771 a inner join jurusan_6771 b inner join kelas_6771 c inner join agama_6771 d on a.kd_jurusan=b.id_jurusan and a.kd_kelas=c.id_kelas and a.kd_agama=d.id_agama where a.nis='".$nis."' ");
			if($data->num_rows()>=1){
				$row=$data->row();
				$data2=$this->db->query("select a.id_kelas,a.prefix_kelas,b.nama_jurusan,a.nomor_kelas from kelas_6771 a inner join jurusan_6771 b on a.kd_jurusan=b.id_jurusan where a.kd_jurusan=".$row->kd_jurusan." order by a.prefix_kelas,a.nomor_kelas")->result();
				foreach($row as $key=>$ikkeh)$row->$key=$htmlentities!=null?htmlentities(stripslashes($ikkeh)):stripslashes($ikkeh);
				$row->pilih_kelas=$data2;
				echo json_encode($row);
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	function tambahSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$this->form_validation->set_rules('nis', 'NIS', 'trim|required|integer');
			$this->form_validation->set_rules('nisn', 'NISN', 'trim|required|integer');
			$this->form_validation->set_rules('nama', 'Nama Siswa', 'trim|required');
			$this->form_validation->set_rules('jen_kel', 'Jenis Kelamin', 'trim|required');
			$this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'trim|required|integer');
			if($this->form_validation->run()==false){
				echo json_encode(array("error"=>validation_errors()));die;
			}
			$post=$this->input->post();
			if(isset($post["photo"]))unset($post["photo"]);
			if(isset($_FILES["photo"])){
				$config["upload_path"]="./assets/images/siswa/";
				$config["allowed_types"]= 'gif|png|jpg|jpeg|bmp';
				$config["overwrite"]=TRUE;
				$config["file_name"]=md5($_FILES["photo"]["name"].time());
				$this->load->library('upload', $config);
				if($this->upload->do_upload("photo")){
					$dataupload=$this->upload->data();
					$post["photo"]=$config["upload_path"].$dataupload["file_name"];
				}else{
					echo json_encode(array("error"=>$this->upload->display_errors()));
					die;
				}
			}
			if(empty($post["nis"]) || empty($post["nisn"]))die(json_encode(array("error"=>"NIS dan NISN tidak boleh kosong")));
			if(empty($post["kd_jurusan"]) || $post["kd_jurusan"]=='0')die(json_encode(array("error"=>"Pilih jurusan dulu")));
			if(empty($post["kd_kelas"]) || $post["kd_kelas"]=='0')die(json_encode(array("error"=>"Pilih kelas dulu")));
			$input=$this->Siswa_model->inputSiswa($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}
	function editSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa edit orang siswa ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			if(isset($post["photo"]))unset($post["photo"]);
			if(isset($_FILES["photo"])){
				$config["upload_path"]="./assets/images/siswa/";
				$config["allowed_types"]= 'gif|png|jpg|jpeg|bmp';
				$config["overwrite"]=TRUE;
				$config["file_name"]=md5($_FILES["photo"]["name"].time());
				$this->load->library('upload', $config);
				if($this->upload->do_upload("photo")){
					$dataupload=$this->upload->data();
					$post["photo"]=$config["upload_path"].$dataupload["file_name"];
					$query=$this->db->query("select * from siswa_6771 where nis='".$this->db->escape_str($post["nis_forEdit"])."'")->row();
					if(!empty($query->photo))unlink($query->photo);
				}else{
					echo json_encode(array("error"=>$this->upload->display_errors()));
					die;
				}
			}
			if(empty($post["nis"]) || empty($post["nisn"]))die(json_encode(array("error"=>"NIS dan NISN tidak boleh kosong")));
			if(empty($post["kd_jurusan"]) || $post["kd_jurusan"]=='0')die(json_encode(array("error"=>"Pilih jurusan dulu")));
			if(empty($post["kd_kelas"]) || $post["kd_kelas"]=='0')die(json_encode(array("error"=>"Pilih kelas dulu")));
			
			$input=$this->Siswa_model->editSiswa($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
		
		
	}
	function hapusSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$nis=$this->input->post("nis_forEdit");
			$nis=$this->db->escape_str($nis);
			$data=$this->db->query("select * from siswa_6771 where nis='".$nis."'")->row();
			if(!empty($data->photo))unlink($data->photo);
			$query=$this->db->query("delete from siswa_6771 where nis='".$nis."'");
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
	function importFile(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input ".$this->session->userdata("hak_akses")));
		else{
			if(isset($_FILES["filexls"])){
				$name=$_FILES["filexls"]["name"];
				$file=$_FILES["filexls"]["tmp_name"];
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
				if(count($a)==10){
					$field=array("NIS","NISN","NAMA","JEN. KEL","TELEPON","KELAS","TANGGAL LAHIR","TEMPAT LAHIR","AGAMA","ALAMAT");
					$field2=array("nis","nisn","nama","jen_kel","no_telp","kelas","tgl_lahir","tempat_lahir","agama","alamat");
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
					$input_xls=$this->Siswa_model->inputSiswa_xls($data_db);
					if($input_xls["sukses"])array_push($sukses,$data_db);
					else array_push($gagal,$data_db);
					$i++;
				}
				
				echo json_encode(array("sukses"=>"S:".count($sukses)."<br>F:".count($gagal)));
				//echo file_get_contents($file);
			}
		}

	}
	
}