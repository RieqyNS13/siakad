<?php 
class SubmitRaport_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function isWalikelas(){
		$kode_guru=$this->session->userdata("kode_guru");
		if(is_null($kode_guru))return false;
		$this->db->select("*,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,count(siswa_6771.nis) as jumlahmurid");
		$this->db->from("walikelas_6771");
		$this->db->join("kelas_6771","walikelas_6771.id_kelas=kelas_6771.id_kelas");
		$this->db->join("siswa_6771","siswa_6771.kd_kelas=kelas_6771.id_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->where("walikelas_6771.kode_guru",$kode_guru);
		$this->db->group_by("kelas_6771.id_kelas");
		$get=$this->db->get();
		if($get->num_rows()>=1)return $get->row();
		else return false;
		
	}
	function total($arr=null,$kelas=null){
		$where=array();
		if($arr!=null){
			//print_r($arr);die;
			foreach($arr as $key=>$mbuh){
				if(!is_null($mbuh) && $mbuh!=="0"){
					if($key=="submitraport_6771.submit")$where[$key]=((int)$mbuh)-1;
					else $where[$key]=$mbuh;
				}
			}
			$this->db->where($where);
		}
		
		//print_r($where);die;
		$walikelas=$this->isWalikelas();
		//print_r($walikelas);die;
		$this->db->select("kelas_6771.id_kelas,nilai_tugas_6771.nis,nilai_tugas_6771.semester,siswa_6771.nama,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,
		mapel_6771.nama_mapel,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester2,nilai_tugas_6771.semester as semester, nilai_tugas_6771.tahun_ajaran");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("nilai_uas_6771","nilai_uas_6771.nis=nilai_tugas_6771.nis and nilai_uas_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_uas_6771.semester=nilai_tugas_6771.semester and nilai_uas_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_uts_6771","nilai_uts_6771.nis=nilai_tugas_6771.nis and nilai_uts_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_uts_6771.semester=nilai_tugas_6771.semester and nilai_uts_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_praktek_6771","nilai_praktek_6771.nis=nilai_tugas_6771.nis and nilai_praktek_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_praktek_6771.semester=nilai_tugas_6771.semester and nilai_praktek_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_proyek_6771","nilai_proyek_6771.nis=nilai_tugas_6771.nis and nilai_proyek_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_proyek_6771.semester=nilai_tugas_6771.semester and nilai_proyek_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_portofolio_6771","nilai_portofolio_6771.nis=nilai_tugas_6771.nis and nilai_portofolio_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_portofolio_6771.semester=nilai_tugas_6771.semester and nilai_portofolio_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_sikap_6771","nilai_sikap_6771.nis=nilai_tugas_6771.nis and nilai_sikap_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_sikap_6771.semester=nilai_tugas_6771.semester and nilai_sikap_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_tugas_6771.kd_mapel");
		$this->db->join("submitraport_6771","submitraport_6771.nis=siswa_6771.nis and submitraport_6771.id_kelas=kelas_6771.id_kelas and nilai_tugas_6771.semester=submitraport_6771.semester and nilai_tugas_6771.tahun_ajaran=submitraport_6771.tahun_ajaran");
		
		if($this->session->userdata("hak_akses")=="admin"){
			if($kelas!=null)$this->db->where("kelas_6771.id_kelas",$kelas);
		}
		else $this->db->where("kelas_6771.id_kelas", $walikelas->kd_kelas);
		//if($kelas!=null)
		$this->db->group_by(array("nilai_tugas_6771.nis","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		return $this->db->get()->num_rows();
	}
	function getData($start,$limit,$arr=null,$kelas=null){
		
		$where=array();
		if($arr!=null){
			//print_r($arr);die;
			foreach($arr as $key=>$mbuh){
				if(!is_null($mbuh) && $mbuh!=="0"){
					if($key=="submitraport_6771.submit")$where[$key]=((int)$mbuh)-1;
					else $where[$key]=$mbuh;
				}
			}
			$this->db->where($where);
		}
		
		//print_r($where);die;
		$walikelas=$this->isWalikelas();
		//print_r($walikelas);die;
		$this->db->select("kelas_6771.id_kelas,nilai_tugas_6771.nis,nilai_tugas_6771.semester,siswa_6771.nama,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,
		mapel_6771.nama_mapel,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester2,nilai_tugas_6771.semester as semester, nilai_tugas_6771.tahun_ajaran");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("nilai_uas_6771","nilai_uas_6771.nis=nilai_tugas_6771.nis and nilai_uas_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_uas_6771.semester=nilai_tugas_6771.semester and nilai_uas_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_uts_6771","nilai_uts_6771.nis=nilai_tugas_6771.nis and nilai_uts_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_uts_6771.semester=nilai_tugas_6771.semester and nilai_uts_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_praktek_6771","nilai_praktek_6771.nis=nilai_tugas_6771.nis and nilai_praktek_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_praktek_6771.semester=nilai_tugas_6771.semester and nilai_praktek_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_proyek_6771","nilai_proyek_6771.nis=nilai_tugas_6771.nis and nilai_proyek_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_proyek_6771.semester=nilai_tugas_6771.semester and nilai_proyek_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_portofolio_6771","nilai_portofolio_6771.nis=nilai_tugas_6771.nis and nilai_portofolio_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_portofolio_6771.semester=nilai_tugas_6771.semester and nilai_portofolio_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_sikap_6771","nilai_sikap_6771.nis=nilai_tugas_6771.nis and nilai_sikap_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_sikap_6771.semester=nilai_tugas_6771.semester and nilai_sikap_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_tugas_6771.kd_mapel");
		$this->db->join("submitraport_6771","submitraport_6771.nis=siswa_6771.nis and submitraport_6771.id_kelas=kelas_6771.id_kelas and nilai_tugas_6771.semester=submitraport_6771.semester and nilai_tugas_6771.tahun_ajaran=submitraport_6771.tahun_ajaran");
		
		if($this->session->userdata("hak_akses")=="admin"){
			if($kelas!=null)$this->db->where("kelas_6771.id_kelas",$kelas);
		}
		else $this->db->where("kelas_6771.id_kelas", $walikelas->kd_kelas);
		//if($kelas!=null)
		$this->db->group_by(array("nilai_tugas_6771.nis","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_praktek_6771.kd_mapel","nilai_praktek_6771.nis","nilai_praktek_6771.semester","nilai_praktek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_proyek_6771.kd_mapel","nilai_proyek_6771.nis","nilai_proyek_6771.semester","nilai_proyek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_portofolio_6771.kd_mapel","nilai_portofolio_6771.nis","nilai_portofolio_6771.semester","nilai_portofolio_6771.tahun_ajaran"));
		//$this->db->where($where);
		//$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		
		$this->db->limit($limit,$start);
		return $this->db->get()->result();
		
	}
	function cariData($q,$start,$limit){
		$q2=$this->db->escape_str($q);
		
		//print_r($walikelas);die;
		$walikelas=$this->isWalikelas();
		if($walikelas)$this->db->where(array("kelas_6771.id_kelas"=>$walikelas->id_kelas));
		//if($kelas!=null)$this->db->having("kelas", $kelas);
		$this->db->select("jurusan_6771.nama_jurusan,jurusan_6771.nama_full, kelas_6771.id_kelas,nilai_tugas_6771.nis,nilai_tugas_6771.semester,siswa_6771.nama,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,
		mapel_6771.nama_mapel,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester2, nilai_tugas_6771.tahun_ajaran");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("nilai_uas_6771","nilai_uas_6771.nis=nilai_tugas_6771.nis and nilai_uas_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_uas_6771.semester=nilai_tugas_6771.semester and nilai_uas_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_uts_6771","nilai_uts_6771.nis=nilai_tugas_6771.nis and nilai_uts_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_uts_6771.semester=nilai_tugas_6771.semester and nilai_uts_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_praktek_6771","nilai_praktek_6771.nis=nilai_tugas_6771.nis and nilai_praktek_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_praktek_6771.semester=nilai_tugas_6771.semester and nilai_praktek_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_proyek_6771","nilai_proyek_6771.nis=nilai_tugas_6771.nis and nilai_proyek_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_proyek_6771.semester=nilai_tugas_6771.semester and nilai_proyek_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_portofolio_6771","nilai_portofolio_6771.nis=nilai_tugas_6771.nis and nilai_portofolio_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_portofolio_6771.semester=nilai_tugas_6771.semester and nilai_portofolio_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_sikap_6771","nilai_sikap_6771.nis=nilai_tugas_6771.nis and nilai_sikap_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_sikap_6771.semester=nilai_tugas_6771.semester and nilai_sikap_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_tugas_6771.kd_mapel");
		
		//if($kelas!=null)
		$this->db->group_by(array("nilai_tugas_6771.nis","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		$this->db->having("nis like '%".$q2."%'");
		$this->db->or_having("semester2 like '%".$q2."%'");
		$this->db->or_having("nama like '%".$q2."%'");
		if($this->session->userdata("hak_akses")=="admin")$this->db->or_having("kelas like '%".$q2."%'");
		$this->db->or_having("tahun_ajaran like '%".$q2."%'");
		$this->db->or_having("nama_jurusan like '%".$q2."%'");
		$this->db->or_having("nama_full like '%".$q2."%'");
		//$this->db->group_by(array("nilai_praktek_6771.kd_mapel","nilai_praktek_6771.nis","nilai_praktek_6771.semester","nilai_praktek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_proyek_6771.kd_mapel","nilai_proyek_6771.nis","nilai_proyek_6771.semester","nilai_proyek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_portofolio_6771.kd_mapel","nilai_portofolio_6771.nis","nilai_portofolio_6771.semester","nilai_portofolio_6771.tahun_ajaran"));
		//$this->db->where($where);
		//$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		
		$this->db->limit($limit,$start);
		return $this->db->get()->result();
	}
	function jumlahcariData($q){
		
		$q2=$this->db->escape_like_str($q);
		
		$walikelas=$this->isWalikelas();
		if($walikelas)$this->db->where(array("kelas_6771.id_kelas"=>$walikelas->id_kelas));
		//if($kelas!=null)$this->db->having("kelas", $kelas);
		$this->db->select("jurusan_6771.nama_jurusan,jurusan_6771.nama_full, kelas_6771.id_kelas,nilai_tugas_6771.nis,nilai_tugas_6771.semester,siswa_6771.nama,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,
		mapel_6771.nama_mapel,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester2, nilai_tugas_6771.tahun_ajaran");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("nilai_uas_6771","nilai_uas_6771.nis=nilai_tugas_6771.nis and nilai_uas_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_uas_6771.semester=nilai_tugas_6771.semester and nilai_uas_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_uts_6771","nilai_uts_6771.nis=nilai_tugas_6771.nis and nilai_uts_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_uts_6771.semester=nilai_tugas_6771.semester and nilai_uts_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_praktek_6771","nilai_praktek_6771.nis=nilai_tugas_6771.nis and nilai_praktek_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_praktek_6771.semester=nilai_tugas_6771.semester and nilai_praktek_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_proyek_6771","nilai_proyek_6771.nis=nilai_tugas_6771.nis and nilai_proyek_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_proyek_6771.semester=nilai_tugas_6771.semester and nilai_proyek_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_portofolio_6771","nilai_portofolio_6771.nis=nilai_tugas_6771.nis and nilai_portofolio_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_portofolio_6771.semester=nilai_tugas_6771.semester and nilai_portofolio_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_sikap_6771","nilai_sikap_6771.nis=nilai_tugas_6771.nis and nilai_sikap_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_sikap_6771.semester=nilai_tugas_6771.semester and nilai_sikap_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_tugas_6771.kd_mapel");
		
		//if($kelas!=null)
		$this->db->group_by(array("nilai_tugas_6771.nis","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		$this->db->having("nis like '%".$q2."%'");
		$this->db->or_having("semester2 like '%".$q2."%'");
		$this->db->or_having("nama like '%".$q2."%'");
		if($this->session->userdata("hak_akses")=="admin")$this->db->or_having("kelas like '%".$q2."%'");
		$this->db->or_having("tahun_ajaran like '%".$q2."%'");
		$this->db->or_having("nama_jurusan like '%".$q2."%'");
		$this->db->or_having("nama_full like '%".$q2."%'");
		//$this->db->group_by(array("nilai_praktek_6771.kd_mapel","nilai_praktek_6771.nis","nilai_praktek_6771.semester","nilai_praktek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_proyek_6771.kd_mapel","nilai_proyek_6771.nis","nilai_proyek_6771.semester","nilai_proyek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_portofolio_6771.kd_mapel","nilai_portofolio_6771.nis","nilai_portofolio_6771.semester","nilai_portofolio_6771.tahun_ajaran"));
		//$this->db->where($where);
		//$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		return $this->db->get()->num_rows();
	}
	function getNilai($nis,$semester,$tahun_ajaran){
		$this->db->select("nilai_tugas_6771.nis,siswa_6771.nama,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_full,' ',kelas_6771.nomor_kelas) as kelas,
		mapel_6771.kode_mapel, mapel_6771.nama_mapel,guru_6771.nama as namaguru, nilai_tugas_6771.semester,nilai_tugas_6771.tahun_ajaran,jurusan_6771.id_jurusan,
		,round(avg(nilai_tugas_6771.nilai),2) as nilaitugas,nilai_uts_6771.nilai as nilaiuts,nilai_uas_6771.nilai as nilaiuas,
		group_concat(nilai_tugas_6771.nilai) as jancok,kelas_6771.prefix_kelas,
		,round(avg(nilai_praktek_6771.nilai),2) as nilaipraktek,
		,round(avg(nilai_proyek_6771.nilai),2) as nilaiproyek,
		,round(avg(nilai_portofolio_6771.nilai),2) as nilaiportofolio,nilai_sikap_6771.nilai_observasi,nilai_sikap_6771.nilai_diri,nilai_sikap_6771.nilai_antarteman,nilai_sikap_6771.nilai_jurnal");
		$this->db->from("nilai_tugas_6771");
		$this->db->join("nilai_uas_6771","nilai_uas_6771.nis=nilai_tugas_6771.nis and nilai_uas_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_uas_6771.semester=nilai_tugas_6771.semester and nilai_uas_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_uts_6771","nilai_uts_6771.nis=nilai_tugas_6771.nis and nilai_uts_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_uts_6771.semester=nilai_tugas_6771.semester and nilai_uts_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_praktek_6771","nilai_praktek_6771.nis=nilai_tugas_6771.nis and nilai_praktek_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_praktek_6771.semester=nilai_tugas_6771.semester and nilai_praktek_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_proyek_6771","nilai_proyek_6771.nis=nilai_tugas_6771.nis and nilai_proyek_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_proyek_6771.semester=nilai_tugas_6771.semester and nilai_proyek_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_portofolio_6771","nilai_portofolio_6771.nis=nilai_tugas_6771.nis and nilai_portofolio_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_portofolio_6771.semester=nilai_tugas_6771.semester and nilai_portofolio_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("nilai_sikap_6771","nilai_sikap_6771.nis=nilai_tugas_6771.nis and nilai_sikap_6771.kd_mapel=nilai_tugas_6771.kd_mapel and nilai_sikap_6771.semester=nilai_tugas_6771.semester and nilai_sikap_6771.tahun_ajaran=nilai_tugas_6771.tahun_ajaran","left");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_tugas_6771.nis");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_tugas_6771.kd_mapel");
		$this->db->join("guru_6771","guru_6771.kode_guru=nilai_tugas_6771.kd_guru_penilai");
		$this->db->where("siswa_6771.nis",$nis);
		$this->db->where("nilai_tugas_6771.semester",$semester);
		$this->db->where("nilai_tugas_6771.tahun_ajaran",$tahun_ajaran);
		//$this->db->where($where);
		$this->db->group_by(array("nilai_tugas_6771.kd_mapel","nilai_tugas_6771.nis","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_praktek_6771.kd_mapel","nilai_praktek_6771.nis","nilai_praktek_6771.semester","nilai_praktek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_proyek_6771.kd_mapel","nilai_proyek_6771.nis","nilai_proyek_6771.semester","nilai_proyek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_portofolio_6771.kd_mapel","nilai_portofolio_6771.nis","nilai_portofolio_6771.semester","nilai_portofolio_6771.tahun_ajaran"));
		//$this->db->where($where);
		//$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$get=$this->db->get();
		if($get->num_rows()>0)return array("jumlah"=>$get->num_rows(),"data"=>$get->result());
		else{
			$error=$this->db->error();
			return array("error"=>empty($error["message"])?"Data tidak ada":$error["message"]);
		}
	}
	function hapusData(){
		$id=$this->input->post("id");
		if(empty($id))return array("error"=>"Parameter id kosong");
		$hapus=$this->db->delete("nilai_uas_6771",array("id"=>$id));
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
		if(!is_numeric($post["nilai"]))return array("error"=>"Nilai harus numeric");
		$nilai=(int)$post["nilai"];
		if($nilai<0 || $nilai>100)return array("error"=>"Nilai harus di antara 0-100");
		$update=$this->db->update("nilai_uas_6771",$post);
		if($update)return array("sukses"=>"Sukses edit nilai UAS");
		else{
			$dberror=$this->db->error();
			return array("error"=>empty($dberror["message"])?"Error tidak diketahui":$dberror["message"]);
		}
	}
	function listSudahAda(){
		return $this->db->get("submitraport_6771")->result();
	}
	function isAda($arr){
		$get=$this->db->get_where("submitraport_6771",$arr);
		if($get->num_rows()>0)return true;
		else return false;
	}
	function inputData(){
		$post=$this->input->post();
		if($this->session->userdata("hak_akses")!="admin" && $this->isWalikelas()==false)return array("error"=>"Hanya Admin dan guru wali kelas saja yang bisa");
		if(count($post)==0)return array("error"=>"Parameter kosong");
		$id=json_decode($post["id"]);
		$nis=json_decode($post["nis"]);
		$id_kelas=json_decode($post["id_kelas"]);
		$semester=json_decode($post["semester"]);
		$tahun_ajaran=json_decode($post["tahun_ajaran"]);
		$submit=json_decode($post["submit"]);
		//print_r($sudahAda);d
		foreach($semester as $key=>$mbuh){
			$this->db->replace("submitraport_6771",array("id"=>$id[$key],"nis"=>$nis[$key],"id_kelas"=>$id_kelas[$key],"semester"=>$mbuh,"tahun_ajaran"=>$tahun_ajaran[$key],"submit"=>$submit[$key]));
		}
		$dberror=$this->db->error();
		if(empty($dberror["message"]))return array("sukses"=>"Sukses Submit Raport");
		else return array("error"=>$dberror["message"]);
	}
}
?>