<?php 
class NilaiSikap_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function total($arr=null){
		$where=array();
		$mapelajar=array();
		if($arr!=null){
			//print_r($arr);die;
			foreach($arr as $key=>$mbuh){
				if(!is_null($mbuh)){
					if($key=="nilai_sikap_6771.kd_mapel" && $mbuh==="00"){
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
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_sikap_6771.nis");
		return $this->db->get("nilai_sikap_6771")->num_rows();
	}
	function getData($start,$limit,$arr=null){
		$mapelajar=array();
		$where=array();
		if($arr!=null){
			//print_r($arr);die;
			foreach($arr as $key=>$mbuh){
				if(!is_null($mbuh)){
					if($key=="nilai_sikap_6771.kd_mapel" && $mbuh==="00"){
						if(!$this->session->has_userdata("kode_guru"))continue;
						$this->db->select("kd_mapel");
						$get=$this->db->get_where("guru_mengajar_6771",array("kode_guru"=>$this->session->userdata("kode_guru")))->result();
						foreach($get as $cok)array_push($mapelajar,$cok->kd_mapel);
						$this->db->where_in("kd_mapel",$mapelajar);//die;
					}else if($mbuh!=="0")$where[$key]=$mbuh;
				}
			}
		}
		$this->db->select("*,concat(nilai_sikap_6771.semester,' (',IF(nilai_sikap_6771.semester=1,'Ganjil','Genap'),')') as semester2,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas");
		$this->db->from("nilai_sikap_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_sikap_6771.nis");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_sikap_6771.kd_mapel");
		$this->db->where($where);
		//$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		
		$this->db->limit($limit,$start);
		return $this->db->get()->result();
		
	}
	function cariData($q,$start,$limit){
		$this->db->select("*,concat(nilai_sikap_6771.semester,' (',IF(nilai_sikap_6771.semester=1,'Ganjil','Genap'),')') as semester2,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas");
		$this->db->from("nilai_sikap_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_sikap_6771.nis");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_sikap_6771.kd_mapel");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("guru_6771","guru_6771.kode_guru=nilai_sikap_6771.kd_guru_penilai");
		$q2=$this->db->escape_like_str($q);
		$this->db->having("kelas like '%".$q2."%'");
		$this->db->or_having("siswa_6771.nis like '%".$q2."%'");
		$this->db->or_having("siswa_6771.nama like '%".$q2."%'");
		$this->db->or_having("mapel_6771.nama_mapel like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.semester like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.tahun_ajaran like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.nilai_observasi like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.nilai_diri like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.nilai_antarteman like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.nilai_jurnal like '%".$q2."%'");
		$this->db->or_having("guru_6771.nama like '%".$q2."%'");
		$this->db->or_having("semester2 like '%".$q2."%'");
		$this->db->limit($limit,$start);
		return $this->db->get()->result();
	}
	function jumlahcariData($q){
		$this->db->select("*,concat(nilai_sikap_6771.semester,' (',IF(nilai_sikap_6771.semester=1,'Ganjil','Genap'),')') as semester2,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas");
		$this->db->from("nilai_sikap_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_sikap_6771.nis");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_sikap_6771.kd_mapel");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("guru_6771","guru_6771.kode_guru=nilai_sikap_6771.kd_guru_penilai");
		$q2=$this->db->escape_like_str($q);
		$this->db->having("kelas like '%".$q2."%'");
		$this->db->or_having("siswa_6771.nis like '%".$q2."%'");
		$this->db->or_having("siswa_6771.nama like '%".$q2."%'");
		$this->db->or_having("mapel_6771.nama_mapel like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.semester like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.tahun_ajaran like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.semester like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.tahun_ajaran like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.nilai_observasi like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.nilai_diri like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.nilai_antarteman like '%".$q2."%'");
		$this->db->or_having("nilai_sikap_6771.nilai_jurnal like '%".$q2."%'");
		$this->db->or_having("guru_6771.nama like '%".$q2."%'");
		$this->db->or_having("semester2 like '%".$q2."%'");
		return $this->db->get()->num_rows();
	}
	function cekNilaiSikap($arr){
		$get=$this->db->get_where("nilai_sikap_6771",$arr);
		if($get->num_rows()>0)return false;
		else return true;
	}
	function getNilai(){
		$id=$this->input->get("id");
		if(empty($id))return array("error"=>"Parameter id kosong");
		$this->db->select("nilai_sikap_6771.*,siswa_6771.*,mapel_6771.*,guru_6771.nama as namaguru,concat(nilai_sikap_6771.semester,' (',IF(nilai_sikap_6771.semester=1,'Ganjil','Genap'),')') as semester2,round((nilai_sikap_6771.nilai_observasi+nilai_sikap_6771.nilai_diri+nilai_sikap_6771.nilai_antarteman+nilai_sikap_6771.nilai_jurnal)/4) as rata2");
		$this->db->from("nilai_sikap_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_sikap_6771.nis");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_sikap_6771.kd_mapel");
		$this->db->join("guru_6771","guru_6771.kode_guru=nilai_sikap_6771.kd_guru_penilai");
		$this->db->where("nilai_sikap_6771.id",$id);
		$get=$this->db->get();
		if($get->num_rows()>0)return $get->row();
		else return array("error"=>"Tidak ada nilai sikap");
	}
	function hapusData(){
		$id=$this->input->post("id");
		if(empty($id))return array("error"=>"Parameter id kosong");
		$hapus=$this->db->delete("nilai_sikap_6771",array("id"=>$id));
		if($hapus)return array("sukses"=>"Sukses hapus nilai UAS");
		else{
			$dberror=$this->db->error();
			return array("error"=>empty($dberror["message"])?"Error tidak diketahui":$dberror["message"]);
		}
	}
	function editData(){
		$post=$this->input->post();
		if(count($post)==0)return array("error"=>"Parameter tidak ada");
		unset($post["nis"]);
		unset($post["kd_mapel"]);
		$this->db->where("id",$post["idEdit"]);
		unset($post["idEdit"]);
		$nilaiKey=array("nilai_observasi","nilai_diri","nilai_antarteman","nilai_jurnal");
		foreach($post as $key=>$mbuh){
			if(in_array($key,$nilaiKey)){
				if(empty(trim($post[$key])))$post[$key]=0;
				else{
					if(!is_numeric($post[$key]))return array("error"=>"Nilai harus numeric");
					$nilai=(int)$post[$key];
					if($nilai<0 || $nilai>4)return array("error"=>"Nilai harus di antara 1-4");
				}
			}
		}
		$update=$this->db->update("nilai_sikap_6771",$post);
		if($update)return array("sukses"=>"Sukses edit nilai sikap");
		else{
			$dberror=$this->db->error();
			return array("error"=>empty($dberror["message"])?"Error tidak diketahui":$dberror["message"]);
		}
	}
	function inputData(){
		$post=$this->input->post();
		unset($post["kd_kelas"]);
		$nilaiKey=array("nilai_observasi","nilai_diri","nilai_antarteman","nilai_jurnal");
		foreach($post as $key=>$mbuh){
			if(in_array($key,$nilaiKey)){
				if(empty(trim($post[$key])))$post[$key]=0;
				else{
					if(!is_numeric($post[$key]))return array("error"=>"Nilai harus numeric");
					$nilai=(int)$post[$key];
					if($nilai<0 || $nilai>4)return array("error"=>"Nilai harus di antara 1-4");
				}
			}
		}
		$this->db->select("kode_guru");
		$this->db->from("guru_6771");
		$this->db->where("kode_guru",$this->session->user);
		$this->db->or_where("nip",$this->session->user);
		$get=$this->db->get();
		if($get->num_rows()==0)return array("error"=>"Tidak bisa menemukan kode guru, pastikan Anda login hanya sebagai guru mapel");
		$post["kd_guru_penilai"]=$get->row()->kode_guru;
		
		$cek=$this->cekNilaiSikap(array("nis"=>$post["nis"],"kd_mapel"=>$post["kd_mapel"],"semester"=>$post["semester"],"tahun_ajaran"=>$post["tahun_ajaran"]));
		if(!$cek)return array("error"=>"Sudah ada nilai sikap dengan data tersebut");		
	
		$this->db->insert("nilai_sikap_6771", $post);
		
		return array("sukses"=>"Sukses input nilai");
	}
	function getNisData(){
		$get=$this->db->query("select * from siswa_6771")->result();
		$asu="";
		foreach($get as $key=>$data){
			$asu.="<option value=\"".$data->nis."\">".$data->nis." | ".$data->nama."</option>";
		}
		return $asu;
	}
}
?>