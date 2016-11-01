<?php 
class NilaiTugas_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function total($arr=null){
		$mapelajar=array();
		$where=array();
		if($arr!=null){
			foreach($arr as $key=>$mbuh){
				if(!is_null($mbuh)){
					if($key=="nilai_tugas_6771.kd_mapel" && $mbuh==="00"){
						if(!$this->session->has_userdata("kode_guru"))continue;
						$this->db->select("kd_mapel");
						$get=$this->db->get_where("guru_mengajar_6771",array("kode_guru"=>$this->session->userdata("kode_guru")))->result();
						foreach($get as $cok)array_push($mapelajar,$cok->kd_mapel);
						$this->db->where_in("kd_mapel",$mapelajar);//die;
					}else if($mbuh!=="0")$where[$key]=$mbuh;
				}
			}
			$this->db->where($where);
		}
		$this->db->select("*");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->group_by(array("nilai_tugas_6771.nis","nilai_tugas_6771.kd_mapel","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		return $this->db->get()->num_rows();
	}
	function cariData($q,$start,$limit,$arr=null){
			$mapelajar=array();
		$where=array();
		if($arr!=null){
			//print_r($arr);die;
			foreach($arr as $key=>$mbuh){
				if(!is_null($mbuh)){
					if($key=="nilai_tugas_6771.kd_mapel" && $mbuh==="00"){
						if(!$this->session->has_userdata("kode_guru"))continue;
						$this->db->select("kd_mapel");
						$get=$this->db->get_where("guru_mengajar_6771",array("kode_guru"=>$this->session->userdata("kode_guru")))->result();
						foreach($get as $cok)array_push($mapelajar,$cok->kd_mapel);
						$this->db->where_in("kd_mapel",$mapelajar);//die;
					}else if($mbuh!=="0")$where[$key]=$mbuh;
				}
			}
		}
		$this->db->select("siswa_6771.*,mapel_6771.*,nilai_tugas_6771.*,guru_6771.nama as nama_guru,round(avg(nilai_tugas_6771.nilai),2) as rata2,count(nilai) as jumlah,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester2");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_tugas_6771.kd_mapel");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("guru_6771","guru_6771.kode_guru=nilai_tugas_6771.kd_guru_penilai");
		$this->db->where($where);
		$q2=$this->db->escape_like_str($q);
		$this->db->group_by(array("nilai_tugas_6771.nis","nilai_tugas_6771.kd_mapel","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		$this->db->having("kelas like '%".$q2."%'");
		$this->db->or_having("siswa_6771.nis like '%".$q2."%'");
		$this->db->or_having("siswa_6771.nama like '%".$q2."%'");
		$this->db->or_having("mapel_6771.nama_mapel like '%".$q2."%'");
		$this->db->or_having("nilai_tugas_6771.semester like '%".$q2."%'");
		$this->db->or_having("nilai_tugas_6771.tahun_ajaran like '%".$q2."%'");
		$this->db->or_having("nilai_tugas_6771.nilai like '%".$q2."%'");
		$this->db->or_having("rata2 like '%".$q2."%'");
		$this->db->or_having("jumlah like '%".$q2."%'");
		$this->db->or_having("nama_guru like '%".$q2."%'");
		$this->db->or_having("semester2 like '%".$q2."%'");
		$this->db->limit($limit,$start);
		return $this->db->get()->result();
	}
	function jumlahcariData($q,$arr=null){
			$mapelajar=array();
		$where=array();
		if($arr!=null){
			//print_r($arr);die;
			foreach($arr as $key=>$mbuh){
				if(!is_null($mbuh)){
					if($key=="nilai_tugas_6771.kd_mapel" && $mbuh==="00"){
						if(!$this->session->has_userdata("kode_guru"))continue;
						$this->db->select("kd_mapel");
						$get=$this->db->get_where("guru_mengajar_6771",array("kode_guru"=>$this->session->userdata("kode_guru")))->result();
						foreach($get as $cok)array_push($mapelajar,$cok->kd_mapel);
						$this->db->where_in("kd_mapel",$mapelajar);//die;
					}else if($mbuh!=="0")$where[$key]=$mbuh;
				}
			}
		}
		$this->db->select("*,round(avg(nilai_tugas_6771.nilai),2) as rata2,count(nilai) as jumlah,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester2");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_tugas_6771.kd_mapel");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("guru_6771","guru_6771.kode_guru=nilai_tugas_6771.kd_guru_penilai");
		$this->db->where($where);
		$q2=$this->db->escape_like_str($q);
		$this->db->group_by(array("nilai_tugas_6771.nis","nilai_tugas_6771.kd_mapel","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		$this->db->having("kelas like '%".$q2."%'");
		$this->db->or_having("siswa_6771.nis like '%".$q2."%'");
		$this->db->or_having("siswa_6771.nama like '%".$q2."%'");
		$this->db->or_having("mapel_6771.nama_mapel like '%".$q2."%'");
		$this->db->or_having("nilai_tugas_6771.semester like '%".$q2."%'");
		$this->db->or_having("nilai_tugas_6771.tahun_ajaran like '%".$q2."%'");
		$this->db->or_having("nilai_tugas_6771.nilai like '%".$q2."%'");
		$this->db->or_having("rata2 like '%".$q2."%'");
		$this->db->or_having("jumlah like '%".$q2."%'");
		$this->db->or_having("guru_6771.nama like '%".$q2."%'");
		$this->db->or_having("semester2 like '%".$q2."%'");
		return $this->db->get()->num_rows();
	}
	function getData($start,$limit,$arr=null){
		$mapelajar=array();
		$where=array();
		if($arr!=null){
			//print_r($arr);die;
			foreach($arr as $key=>$mbuh){
				if(!is_null($mbuh)){
					if($key=="nilai_tugas_6771.kd_mapel" && $mbuh==="00"){
						if(!$this->session->has_userdata("kode_guru"))continue;
						$this->db->select("kd_mapel");
						$get=$this->db->get_where("guru_mengajar_6771",array("kode_guru"=>$this->session->userdata("kode_guru")))->result();
						foreach($get as $cok)array_push($mapelajar,$cok->kd_mapel);
						$this->db->where_in("kd_mapel",$mapelajar);//die;
					}else if($mbuh!=="0")$where[$key]=$mbuh;
				}
			}
		}
		$this->db->select("*,round(avg(nilai_tugas_6771.nilai),2) as rata2,count(nilai) as jumlah,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester2");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_tugas_6771.kd_mapel");
		$this->db->where($where);
		//$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		
		$this->db->group_by(array("nilai_tugas_6771.nis","nilai_tugas_6771.kd_mapel","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		$this->db->limit($limit,$start);
		return $this->db->get()->result();
	}
	function getNisData(){
		$get=$this->db->query("select * from siswa_6771")->result();
		$asu="";
		foreach($get as $key=>$data){
			$asu.="<option value=\"".$data->nis."\">".$data->nis." | ".$data->nama."</option>";
		}
		return $asu;
	}
	function getNilaiByNis(){
		$this->db->select("*");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_tugas_6771.kd_mapel");
		$this->db->where("nilai_tugas_6771.nis",$this->input->post("nis"));
		$this->db->order_by("nilai_tugas_6771.id","asc");
		$get=$this->db->get();
		if($get->num_rows()>=1)return $get->result();
		else return array("error"=>"Data nilai tidak ditemukan");
	}
	function editData(){
		$post=$this->input->post();
		if(count($post)==0)return array("error"=>"Parameter tidak ada");
		$where["nis"]=$post["nisEdit"];
		$where["kd_mapel"]=$post["kd_mapelEdit"];
		$where["semester"]=$post["semesterEdit"];
		$where["tahun_ajaran"]=$post["tahun_ajaranEdit"];
		$nilaitmp=$post["nilai"];
		$this->db->order_by("id","asc");
		$get=$this->db->get_where("nilai_tugas_6771",$where);
		$result=$get->result();
		$i=0;
		foreach($result as $key=>$mbuh){
			if(!in_array($mbuh->id,$post["id"])){
				$this->db->delete("nilai_tugas_6771",array("id"=>$mbuh->id));
			}else{
				$this->db->where("id",$mbuh->id);
				$cari=array_search($mbuh->id,$post["id"]);
				if(!is_numeric($post["nilai"][$cari]))return array("error"=>"Nilai harus numeric");
				$nilai=(int)$post["nilai"][$cari];
				if($nilai<0 || $nilai>100)return array("error"=>"Nilai harus di antara 0-100");
				$this->db->update("nilai_tugas_6771",array("nilai"=>$nilai));
				unset($nilaitmp[$cari]);
			}
		}
		foreach($nilaitmp as $cok){
			$nilai=(int)$cok;
			if($nilai<0 || $nilai>100)return array("error"=>"Nilai harus di antara 0-100");
			$this->db->insert("nilai_tugas_6771",array_merge($where,array("nilai"=>$cok,"kd_guru_penilai"=>$this->session->userdata("kode_guru"))));
		}
		$this->db->where($where);
		$edit=$this->db->update("nilai_tugas_6771",array("semester"=>$post["semester"],"tahun_ajaran"=>$post["tahun_ajaran"]));
		if($edit)return array("sukses"=>"Sukses edit nilai tugas");
		else{
			$error=$this->db->error();
			return array("error"=>!empty($error["message"])?$error["message"]:"Error tidak diketahui");
		}
		
	}
	function inputData(){
		$post=$this->input->post();
		unset($post["kd_kelas"]);
		foreach($post as $mbuh)if(empty($mbuh))return array("error"=>"Masih ada data yang kosong");
		if($post["nis"]=="pilihsiswa")return array("error"=>"Pilih siswa dulu");
		$nilais=$post["nilai"];
		$this->db->select("kode_guru");
		$this->db->from("guru_6771");
		$this->db->where("kode_guru",$this->session->user);
		$this->db->or_where("nip",$this->session->user);
		$get=$this->db->get();
		if($get->num_rows()==0)return array("error"=>"Tidak bisa menemukan kode guru, pastikan Anda login hanya sebagai guru mapel");
		$post["kd_guru_penilai"]=$get->row()->kode_guru;
		
		foreach($nilais as $key=>$nilai){
			$post["nilai"]=$nilai;
			$nilai2=(int)$nilai;
			if($nilai2<0 || $nilai2>100)return array("error"=>"Nilai harus di antara 0-100");
			if(!is_numeric($nilai))return array("error"=>"Nilai harus numeric");
			$this->db->insert("nilai_tugas_6771", $post);
		}
		return array("sukses"=>"Sukses input nilai");
		
	}
	function getSiswaByKelas($all="true"){
		$kd_kelas=$this->input->get("kd_kelas");
		$this->db->select("*");
		$this->db->from("siswa_6771");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		if($kd_kelas=='0' || $kd_kelas==null)$get=$this->db->get()->result();
		else {
			$this->db->where("kd_kelas",$kd_kelas);
			$get=$this->db->get()->result();
		}
		$asu='';
		if(count($get)>0 && $all=="true"){
			$njir='';
			if(!empty($kd_kelas) && $all=="true")$njir=$get[0]->prefix_kelas.' '.$get[0]->nama_jurusan.' '.$get[0]->nomor_kelas;
			$asu.='<option value="0">Semua Siswa '.$njir.'</option>';
		}
		foreach($get as $data){
			$asu.="<option value=\"".$data->nis."\">".$data->nis." | ".$data->nama."</option>";
		}
		return $asu;
	}
	function getNilai(){
		
		$data['nilai_tugas_6771.nis']=$this->input->get("nis");
		$data['nilai_tugas_6771.kd_mapel']=$this->input->get("kd_mapel");
		$data['nilai_tugas_6771.semester']=$this->input->get("semester");
		$data['nilai_tugas_6771.tahun_ajaran']=$this->input->get("tahun_ajaran");
		foreach($data as $mbuh)if(empty($mbuh))return array("error"=>"Parameter gak lengkap");
		$this->db->select("nilai_tugas_6771.*,siswa_6771.*,mapel_6771.*,guru_6771.nama as namaguru,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester2");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_tugas_6771.kd_mapel");
		$this->db->join("guru_6771","guru_6771.kode_guru=nilai_tugas_6771.kd_guru_penilai");
		$this->db->where($data);
		$this->db->order_by("nilai_tugas_6771.id","asc");
		$get=$this->db->get();
		$jumlah=$get->num_rows();
		if($jumlah>=1){
			return array("jumlah"=>$jumlah,"msg"=>$get->result());
		}else return array("jumlah"=>$jumlah,"msg"=>"Tidak ada record nilai. Nilai dimulai dari Tugas 1");
	}
	function hapusData(){
		$post=$this->input->post();
		if(count($post)==0)return array("error"=>"Tidak ada parameter");
		$hapus=$this->db->delete("nilai_tugas_6771",$post);
		if($hapus)return array("sukses"=>"Sukses hapus data");
		else{
			$error=$this->db->error();
			return array("error"=>empty($error["message"])?"Error tidak diketahui":$error["message"]);
		}
	}
	function getMapelData($cok=null,$type=1){
		if($cok==null){
			$asx='';
			$get=$this->db->get("mapel_6771")->result();
			foreach($get as $data){
				$asx.="<option value=\"".$data->kode_mapel."\">".$data->nama_mapel."</option>";
			}
			return $asx;
		}
		else{
			$asu="";
			$this->db->select("*");
			$this->db->from("guru_mengajar_6771");
			$this->db->join("mapel_6771","guru_mengajar_6771.kd_mapel=mapel_6771.kode_mapel");
			$this->db->where("guru_mengajar_6771.kode_guru",$cok);
			$get= $this->db->get()->result();
			if($type==1){	
				foreach($get as $key=>$data){
					$asu.="<option value=\"".$data->kode_mapel."\">".$data->nama_mapel."</option>";
				}
			}else{
				$asu.='<optgroup label="Mapel yang diajar">';
				$mapelajar=array();
				foreach($get as $data){
					array_push($mapelajar,$data->kode_mapel);
					$asu.="<option value=\"".$data->kode_mapel."\">".$data->nama_mapel."</option>";
				}
				$asu.='</optgroup>';
				
				$this->db->where_not_in("kode_mapel",$mapelajar);
				$get=$this->db->get("mapel_6771")->result();
				$asu.='<optgroup label="Mapel umum">';
				foreach($get as $data){
					$asu.='<option value="'.$data->kode_mapel.'">'.$data->nama_mapel.'</option>';
				}
				$asu.='</optgroup>';
			}
			return $asu;
		}
	}
}
?>