<?php 
class NilaiRaport_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function total($arr=null){
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
		$this->db->select("nilai_tugas_6771.nis,siswa_6771.nama,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,
		mapel_6771.nama_mapel,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester,nilai_tugas_6771.tahun_ajaran,
		,round(avg(nilai_tugas_6771.nilai),2) as nilaitugas,nilai_uts_6771.nilai as nilaiuts,nilai_uas_6771.nilai as nilaiuas,
		group_concat(nilai_tugas_6771.nilai) as jancok,
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
		$this->db->where($where);
		$this->db->group_by(array("nilai_tugas_6771.kd_mapel","nilai_tugas_6771.nis","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_praktek_6771.kd_mapel","nilai_praktek_6771.nis","nilai_praktek_6771.semester","nilai_praktek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_proyek_6771.kd_mapel","nilai_proyek_6771.nis","nilai_proyek_6771.semester","nilai_proyek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_portofolio_6771.kd_mapel","nilai_portofolio_6771.nis","nilai_portofolio_6771.semester","nilai_portofolio_6771.tahun_ajaran"));
		//$this->db->where($where);
		//$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$get=$this->db->get();
		return $get->num_rows();
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
		$this->db->select("nilai_tugas_6771.nis,siswa_6771.nama,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,
		mapel_6771.nama_mapel,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester,nilai_tugas_6771.tahun_ajaran,
		,round(avg(nilai_tugas_6771.nilai),2) as nilaitugas,nilai_uts_6771.nilai as nilaiuts,nilai_uas_6771.nilai as nilaiuas,
		group_concat(nilai_tugas_6771.nilai) as jancok,
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
		$this->db->where($where);
		$this->db->group_by(array("nilai_tugas_6771.kd_mapel","nilai_tugas_6771.nis","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_praktek_6771.kd_mapel","nilai_praktek_6771.nis","nilai_praktek_6771.semester","nilai_praktek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_proyek_6771.kd_mapel","nilai_proyek_6771.nis","nilai_proyek_6771.semester","nilai_proyek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_portofolio_6771.kd_mapel","nilai_portofolio_6771.nis","nilai_portofolio_6771.semester","nilai_portofolio_6771.tahun_ajaran"));
		//$this->db->where($where);
		//$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		
		$this->db->limit($limit,$start);
		return $this->db->get()->result();
		
	}
	function cariData($q,$start,$limit){
		$q2=$this->db->escape_like_str($q);
		$this->db->select("nilai_tugas_6771.nis,siswa_6771.nama,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,
		mapel_6771.nama_mapel,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester,nilai_tugas_6771.tahun_ajaran,
		,round(avg(nilai_tugas_6771.nilai),2) as nilaitugas,nilai_uts_6771.nilai as nilaiuts,nilai_uas_6771.nilai as nilaiuas,
		group_concat(nilai_tugas_6771.nilai) as jancok,
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
		$this->db->having("kelas like '%".$q2."%'"); 
		$this->db->or_having("semester like '%".$q2."%'"); 
		$this->db->or_having("nilai_tugas_6771.nis like '%".$q2."%'"); 
		$this->db->or_having("siswa_6771.nama like '%".$q2."%'"); 
		$this->db->or_having("nilai_tugas_6771.tahun_ajaran like '%".$q2."%'"); 
		$this->db->or_having("nilaitugas like '%".$q2."%'"); 
		$this->db->or_having("nilaiuts like '%".$q2."%'"); 
		$this->db->or_having("nilaiuas like '%".$q2."%'"); 
		$this->db->or_having("nilaipraktek like '%".$q2."%'"); 
		$this->db->or_having("nilaiproyek like '%".$q2."%'"); 
		$this->db->or_having("nama_mapel like '%".$q2."%'"); 
		$this->db->or_having("nilaiportofolio like '%".$q2."%'"); 
		$this->db->or_having("nilai_sikap_6771.nilai_observasi like '%".$q2."%'"); 
		$this->db->or_having("nilai_sikap_6771.nilai_diri like '%".$q2."%'"); 
		$this->db->or_having("nilai_sikap_6771.nilai_antarteman like '%".$q2."%'"); 
		$this->db->or_having("nilai_sikap_6771.nilai_jurnal like '%".$q2."%'"); 
		$this->db->group_by(array("nilai_tugas_6771.kd_mapel","nilai_tugas_6771.nis","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
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
		$this->db->select("nilai_tugas_6771.nis,siswa_6771.nama,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas,
		mapel_6771.nama_mapel,concat(nilai_tugas_6771.semester,' (',IF(nilai_tugas_6771.semester=1,'Ganjil','Genap'),')') as semester,nilai_tugas_6771.tahun_ajaran,
		,round(avg(nilai_tugas_6771.nilai),2) as nilaitugas,nilai_uts_6771.nilai as nilaiuts,nilai_uas_6771.nilai as nilaiuas,
		group_concat(nilai_tugas_6771.nilai) as jancok,
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
		$this->db->having("kelas like '%".$q2."%'"); 
		$this->db->or_having("semester like '%".$q2."%'"); 
		$this->db->or_having("nilai_tugas_6771.nis like '%".$q2."%'"); 
		$this->db->or_having("siswa_6771.nama like '%".$q2."%'"); 
		$this->db->or_having("nilai_tugas_6771.tahun_ajaran like '%".$q2."%'"); 
		$this->db->or_having("nilaitugas like '%".$q2."%'"); 
		$this->db->or_having("nilaiuts like '%".$q2."%'"); 
		$this->db->or_having("nilaiuas like '%".$q2."%'"); 
		$this->db->or_having("nilaipraktek like '%".$q2."%'"); 
		$this->db->or_having("nilaiproyek like '%".$q2."%'"); 
		$this->db->or_having("nama_mapel like '%".$q2."%'"); 
		$this->db->or_having("nilaiportofolio like '%".$q2."%'"); 
		$this->db->or_having("nilai_sikap_6771.nilai_observasi like '%".$q2."%'"); 
		$this->db->or_having("nilai_sikap_6771.nilai_diri like '%".$q2."%'"); 
		$this->db->or_having("nilai_sikap_6771.nilai_antarteman like '%".$q2."%'"); 
		$this->db->or_having("nilai_sikap_6771.nilai_jurnal like '%".$q2."%'"); 
		$this->db->group_by(array("nilai_tugas_6771.kd_mapel","nilai_tugas_6771.nis","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_praktek_6771.kd_mapel","nilai_praktek_6771.nis","nilai_praktek_6771.semester","nilai_praktek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_proyek_6771.kd_mapel","nilai_proyek_6771.nis","nilai_proyek_6771.semester","nilai_proyek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_portofolio_6771.kd_mapel","nilai_portofolio_6771.nis","nilai_portofolio_6771.semester","nilai_portofolio_6771.tahun_ajaran"));
		//$this->db->where($where);
		//$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		return $this->db->get()->num_rows();
	}
	function cekNilaiUas($arr){
		$get=$this->db->get_where("nilai_uas_6771",$arr);
		if($get->num_rows()>0)return false;
		else return true;
	}
	function getNilai(){
		$id=$this->input->get("id");
		if(empty($id))return array("error"=>"Parameter id kosong");
		$this->db->select("nilai_uas_6771.*,siswa_6771.*,mapel_6771.*,guru_6771.nama as namaguru,concat(nilai_uas_6771.semester,' (',IF(nilai_uas_6771.semester=1,'Ganjil','Genap'),')') as semester2");
		$this->db->from("nilai_uas_6771");
		$this->db->join("siswa_6771","siswa_6771.nis=nilai_uas_6771.nis");
		$this->db->join("mapel_6771","mapel_6771.kode_mapel=nilai_uas_6771.kd_mapel");
		$this->db->join("guru_6771","guru_6771.kode_guru=nilai_uas_6771.kd_guru_penilai");
		$this->db->where("nilai_uas_6771.id",$id);
		$get=$this->db->get();
		if($get->num_rows()>0)return $get->row();
		else return array("error"=>"Tidak ada nilai uas");
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
	function inputData(){
		$post=$this->input->post();
		unset($post["kd_kelas"]);
		foreach($post as $mbuh)if(empty($mbuh))return array("error"=>"Masih ada data yang kosong");
		$nilai=$post["nilai"];
		$this->db->select("kode_guru");
		$this->db->from("guru_6771");
		$this->db->where("kode_guru",$this->session->user);
		$this->db->or_where("nip",$this->session->user);
		$get=$this->db->get();
		if($get->num_rows()==0)return array("error"=>"Tidak bisa menemukan kode guru, pastikan Anda login hanya sebagai guru mapel");
		$post["kd_guru_penilai"]=$get->row()->kode_guru;
		
		$cek=$this->cekNilaiUas(array("nis"=>$post["nis"],"kd_mapel"=>$post["kd_mapel"],"semester"=>$post["semester"],"tahun_ajaran"=>$post["tahun_ajaran"]));
		if(!$cek)return array("error"=>"Sudah ada nilai UAS dengan data tersebut");		
		
		if(!is_numeric($nilai))return array("error"=>"Nilai harus numeric");
		$nilai2=(int)$nilai;
		if($nilai2<0 || $nilai2>100)return array("error"=>"Nilai harus di antara 0-100");
		$this->db->insert("nilai_uas_6771", $post);
		
		return array("sukses"=>"Sukses input nilai");
	}
}
?>