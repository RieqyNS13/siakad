<?php 
class Home extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library("pagination");
		//$this->load->library("url");
		$this->load->database();
		$this->load->model(array("Raport_model","Home_m"));
	}
	function index(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			$header=$this->load->view("header",null,true);
			$konten=$this->Home_m->getPengumuman();
			$data=array("nama_user"=>$this->session->userdata("nama_user"),"hak_akses"=>$this->session->userdata("hak_akses"),
			"user"=>$this->session->userdata("user"), "judulKonten"=>"Home - SMK N 8 Semarang","headerUtama"=>$header,"log"=>null,"konten"=>$konten);
			$data["walikelas"]=$this->session->userdata("walikelas");
			$this->template->load("home","main",$data);
		}
	}
	function cetakraport(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			if(!empty($this->input->post("pilihan"))){
				$exp=explode("_",$this->input->post("pilihan"));
				if(count($exp)!=2)return array("error"=>"Invalid");
				$tahun_ajaran=$exp[0];
				$semester=$exp[1];
				$this->session->set_userdata("semester",$semester);
				$this->session->set_userdata("tahun_ajaran",$tahun_ajaran);
			}
			if($this->session->has_userdata("semester") && $this->session->has_userdata("tahun_ajaran")){
				//$kelompok=$this->Raport_model->getKelompok();
				$kelompok=$this->Raport_model->getKelompok();
				//print_r($kelompok);die;
				if(!$kelompok)die(json_encode(array("error"=>"Raport tidak tampil karena belum ada pembagian mapel")));
				$ikkeh=$this->Raport_model->getData();
				$nilai=$ikkeh["data"];
				//print_r($nilai);die;
				$dataGay=null;
				foreach($nilai as $data){
					foreach($kelompok as $kelompokmapel){
						if($data->semester==$kelompokmapel->semester && $data->prefix_kelas==$kelompokmapel->kelas_prefix && $data->id_jurusan==$kelompokmapel->kd_jurusan && $data->kode_mapel==$kelompokmapel->kode_mapel && $data->tahun_ajaran==$kelompokmapel->tahun_ajaran){
							$dataGay[$kelompokmapel->kode_kelompok_mapel][]=$data;
						}
					}
				}
				//print_r($dataGay);die;
				$atas=$this->Raport_model->getAtas();
				$data=array("nama_user"=>$this->session->userdata("nama_user"),"hak_akses"=>$this->session->userdata("hak_akses"),
				"user"=>$this->session->userdata("user"), "judulKonten"=>"Raport - SMK N 8 Semarang","log"=>null,"konten"=>null,"headerUtama"=>null);
				$data["header"]=$atas;
				$data["dataGay"]=$dataGay;
				$data["jumlahBaris"]=$ikkeh["jumlah"];
				$data["semester"]=$this->session->userdata("semester");
				$data["tahun_ajaran"]=$this->session->userdata("tahun_ajaran");
				if(!empty($this->uri->segment(3)) && $this->uri->segment(3)=="print")$this->load->view("raportprint",$data);
				else $this->template->load("home","tampilraport",$data);
			}
	
		}
	}
	function raport(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			$konten=$this->Home_m->getPengumuman();
			$data=array("nama_user"=>$this->session->userdata("nama_user"),"hak_akses"=>$this->session->userdata("hak_akses"),
			"user"=>$this->session->userdata("user"), "judulKonten"=>"Raport - SMK N 8 Semarang","log"=>null,"konten"=>$konten,"headerUtama"=>null);
			//$data["walikelas"]=$this->session->userdata("walikelas");
			$njir=$this->Home_m->getPilihan();
			$tahun_ajaran='';
			$semester='';
			$pilih='';
			foreach($njir as $gay){
				//$huruf=$gay->semester==1?"Ganjil":"Genap";
				$pilih.="<option value=\"".$gay->tahun_ajaran."_".$gay->semester."\">Tahun Ajaran ".$gay->tahun_ajaran." Semester ".$gay->semester."</option>";
			}
			$data["pilihan"]=$pilih;
			$this->template->load("home","raport",$data);
		}
	}
	function bacaPengumuman(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			if(!empty($this->uri->segment(3))){
				$get=$this->Home_m->bacaPengumuman($this->uri->segment(3));
				if($get["sukses"]){
					$data=array("nama_user"=>$this->session->userdata("nama_user"),"user"=>$this->session->userdata("user"),"id_user"=>$this->session->userdata("nomor_user"), "judulKonten"=>$get["data"]->judul,"headerUtama"=>null,"konten"=>$get["data"],"log"=>null);
					$data["walikelas"]=$this->session->userdata("walikelas");
					$data["hak_akses"]=$this->session->userdata("hak_akses");
					$this->template->load("home","baca_pengumuman",$data);
				}else show_error($get["data"],400,"Error");
			}else redirect("home/pengumuman");
		}
	}
	function profile(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			
			
		}
	}
	function editPengumuman(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			$post=$this->input->post();
			foreach($post as $key=>$mbuh)$post[$key]=trim($mbuh);
			if(empty($post["judul"]) || empty($post["isi"])){
				die(json_encode(array("error"=>"Judul dan isi tidak boleh kosong")));
			}
			if(isset($post["gambar"]))unset($post["gambar"]);
			if(!empty($_FILES["gambar"]["name"])){
				$config["upload_path"]="./assets/images/pengumuman/";
				$config["allowed_types"]= 'gif|png|jpg|jpeg|bmp';
				$config["overwrite"]=TRUE;
				$config["file_name"]=md5($_FILES["gambar"]["name"].time());
				$this->load->library('upload', $config);
				if($this->upload->do_upload("gambar")){
					$dataupload=$this->upload->data();
					$row=$this->db->get_where("pengumuman_6771",array("id"=>$post["id_forEdit"]))->row();
					if(!empty($row->gambar))@unlink($row->gambar);
					$post["gambar"]=$config["upload_path"].$dataupload["file_name"];
				}else{
					$error=$this->upload->display_errors('<p>', '</p>');
					die(json_encode(array("error"=>$error)));
				}
			}
			$edit=$this->Home_m->editPengumuman($post);
			if($edit["sukses"]){
				echo json_encode(array("sukses"=>"Sukses edit pengumuman"));
			}else echo json_encode(array("error"=>$edit["msg"]));
		}
	}
	function hapusPengumuman(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			$id=$this->input->post("id_forHapus");
			if(empty($id))die(json_encode(array("error"=>"ID Kosong cok")));
			$get=$this->db->get_where("pengumuman_6771",array("id"=>$id));
			if($get->num_rows()>=1){
				$row=$get->row();
				if(!empty($row->gambar))@unlink($row->gambar);
			}
			$delete=$this->db->delete("pengumuman_6771",array("id"=>$id));
			if($delete)echo json_encode(array("sukses"=>"Sukses Hapus Data"));
			else{
				$dberror=$this->db->error();
				echo json_encode(array("error"=>isset($dberror["code"])?$dberror["message"]:"Error hapus data"));
			}
		}
	}
	function getdetailPengumuman(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			$id=$this->input->get("id_pengumuman");
			if(!empty($id)){
				$get=$this->db->get_where("pengumuman_6771",array("id"=>$id));
				if($get->num_rows()>=1)echo json_encode($get->row());
				else echo json_encode(array("error"=>"Data tidak ditemukan"));;
			}
		}
	}
	function pengumuman(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			if(!empty($this->input->get("q"))){
				$cari=$this->Home_m->cariPengumuman($this->input->get("q"),$page,5);
				//print_r($cari);die;
				$konten=$cari["data"];
				$config['total_rows']=$cari["jumlah"];
				$judul="Hasil Pencarian <small>Ditemukan ".$cari["jumlah"]." data</small>";
				$logatas='<div class="alert alert-info" role="alert"><strong>Ditemukan \''.$cari["jumlah"].'\' data dengan keyword \''.$this->input->get("q").'\'</strong></div>';
			}else{
				$config['total_rows']=$this->Home_m->totalPengumuman();
				$konten=$this->Home_m->getPengumuman($page,5);
				$judul="Pengumuman <small>Pemberitahuan terbaru </small>";
				$logatas=null;
			}
			
			$config['base_url'] = site_url('home/pengumuman');
			$config['per_page'] = 5;
			$config['uri_segment'] = 3;
			$config['full_tag_open']='<ul class="pager">';
			$config['full_tag_close']='</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			//$config['use_page_numbers'] = false;
			$config['display_pages'] = FALSE;
			$config['next_tag_open'] = '<li class="previous">';
			$config['next_tag_close'] = '</li>';
			$config['next_link'] = '&larr; Older';
			$config['prev_tag_open'] = '<li class="next">';
			$config['prev_tag_close'] = '</li>';
			$config['prev_link'] = 'Newer &rarr;';
			$config['reuse_query_string'] = true;
			
			$log=!is_null($this->session->flashdata("log"))?$this->session->flashdata("log"):null;
			$data=array("nama_user"=>$this->session->userdata("nama_user"),"user"=>$this->session->userdata("user"),"judulKonten"=>"Pengumuman - SMK N 8 Semarang","headerUtama"=>null,"log"=>$log,"judulAtas"=>$judul,"logAtas"=>$logatas);
			$data["konten"]=$konten;
			$data["hak_akses"]=$this->session->hak_akses;
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data["walikelas"]=$this->session->userdata("walikelas");
			$this->template->load("home","pengumuman",$data);
		}
	}
	function test(){
		show_error("Error",400,"Error");
	}
	function getProfile(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			if($this->session->hak_akses=="siswa"){
				$data=$this->Home_m->getProfil($this->session->user,1);	
			}elseif($this->session->hak_akses=="guru"){
				$data=$this->Home_m->getProfil($this->session->user,2);
				//print_r($data["msg"]);
			}
			if($data["sukses"])echo json_encode($data["msg"]);
			else echo json_encode(array("error"=>$data["msg"]));
		}
	}
	function getAkun(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			$data=$this->Home_m->getAkun($this->session->user);
			if($data["sukses"])echo json_encode($data["msg"]);
			else echo json_encode(array("error"=>$data["msg"]));
		}
		
	}
	function editAkun(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			$post=$this->input->post();
			if(isset($post["password"])){
				$pw=trim($post["password"][0]);
				$pw2=trim($post["password"][1]);
				if(strcmp($pw,$pw2)==0 && strlen($pw)>0){
					$ganti=$this->Home_m->gantiPass($this->session->user,$pw);
					if($ganti["sukses"])echo json_encode(array("sukses"=>"Sukses ganti password"));
					else echo json_encode(array("error"=>$ganti["msg"]));
				}else echo json_encode(array("error"=>"Password harus sama dan tidak boleh kosong"));
			}else{
				foreach($post as $key=>$line)$post[$key]=trim($line);
				if(empty($post["nama"]) || empty($post["email"])){
					die(json_encode(array("error"=>"Nama dan email harus diisi")));
				}
				$edit=$this->Home_m->editData($this->session->user,$post);
				if($edit["sukses"]){
					$this->session->set_userdata("nama_user",$post["nama"]);
					echo json_encode(array("sukses"=>"Sukses edit data"));
				}
				else echo json_encode(array("error"=>$edit["msg"]));
			}
		}
	}
	function submitPengumuman(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("login");
		else{
			date_default_timezone_set("Asia/Jakarta");
			$post=$this->input->post();
			if(count($post)==0)die("silent :p");
			$post["isi"]=trim($post["isi"]);
			$post["judul"]=trim($post["judul"]);
			if(empty($post["isi"]) || empty($post["judul"])){
				$data=array("nama_user"=>$this->session->userdata("nama_user"),"judulKonten"=>"Pengumuman","headerUtama"=>null,"log"=>'<div class="col-lg-12"><div class="alert alert-danger" role="alert">Judul dan isi tidak boleh kosong</div></div>');
				$this->template->load("home","pengumuman",$data);
			}else{
			if(!empty($_FILES["gambar"]["name"])){
				//print_r($_FILES);die;
				$config["upload_path"]="./assets/images/pengumuman/";
				$config["allowed_types"]= 'gif|png|jpg|jpeg|bmp';
				$config["overwrite"]=TRUE;
				$config["file_name"]=md5($_FILES["gambar"]["name"].time());
				$this->load->library('upload', $config);
				if($this->upload->do_upload("gambar")){
					$dataupload=$this->upload->data();
					$post["gambar"]=$config["upload_path"].$dataupload["file_name"];
				}else{
					$error=$this->upload->display_errors('<p>', '</p>');
					$this->session->set_flashdata("log",'<div class="col-lg-12"><div class="alert alert-danger" role="alert">'.$error.'</div></div>');
					redirect("home/pengumuman");
					return;
				}
			}else $data["gambar"]=null;
			$post["author"]=$this->session->userdata("nomor_user");
			$post["tanggal"]=date("Y-m-d H:i:s",strtotime("now"));
			$input=$this->Home_m->inputPengumuman($post);
			if($input["sukses"])redirect("home/pengumuman");
			else{
				show_error($input["msg"],400,"Gagal Upload");
			}
			}
		}
	}
	function logout(){
		$this->session->sess_destroy();
		redirect("login");
	}
	
}
?>