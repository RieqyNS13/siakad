<?php 
class Raport_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getAtas(){
		if(!$this->session->has_userdata("user"))return array("error"=>"Tidak Ada Nis Terdeteksi");
		$nis=$this->session->userdata("user");
		$this->db->select("siswa_6771.nama,siswa_6771.nis,siswa_6771.nisn,kelas_6771.prefix_kelas,jurusan_6771.nama_full");
		$this->db->from("siswa_6771");
		$this->db->join("kelas_6771","siswa_6771.kd_kelas=kelas_6771.id_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->where("siswa_6771.nis",$nis);
		return $this->db->get()->row();
	}
	function getKelompok(){
		if(!$this->session->has_userdata("user"))return array("error"=>"Tidak Ada Nis Terdeteksi");
		$this->db->select("kelas_6771.prefix_kelas,jurusan_6771.id_jurusan");
		$this->db->from("kelas_6771");
		$this->db->join("siswa_6771","siswa_6771.kd_kelas=kelas_6771.id_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan");
		$this->db->where("siswa_6771.nis",$this->session->userdata("user"));
		$get=$this->db->get()->row();
		$prefix_kelas=$get->prefix_kelas;
		$kd_jurusan=$get->id_jurusan;
		$this->db->select("*");
		$this->db->from("pembagian_mapel_6771");
		$this->db->where(array("kelas_prefix"=>$prefix_kelas,"semester"=>$this->session->userdata("semester"),"kd_jurusan"=>$kd_jurusan,"tahun_ajaran"=>$this->session->userdata("tahun_ajaran")));
		$get=$this->db->get();
		if($get->num_rows()==0)return false;
		return $get->result();
	}
	function getData(){
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
		$this->db->where("siswa_6771.nis",$this->session->userdata("user"));
		$this->db->where("nilai_tugas_6771.semester",$this->session->userdata("semester"));
		//$this->db->where($where);
		$this->db->group_by(array("nilai_tugas_6771.kd_mapel","nilai_tugas_6771.nis","nilai_tugas_6771.semester","nilai_tugas_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_praktek_6771.kd_mapel","nilai_praktek_6771.nis","nilai_praktek_6771.semester","nilai_praktek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_proyek_6771.kd_mapel","nilai_proyek_6771.nis","nilai_proyek_6771.semester","nilai_proyek_6771.tahun_ajaran"));
		//$this->db->group_by(array("nilai_portofolio_6771.kd_mapel","nilai_portofolio_6771.nis","nilai_portofolio_6771.semester","nilai_portofolio_6771.tahun_ajaran"));
		//$this->db->where($where);
		//$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$get=$this->db->get();
		return array("jumlah"=>$get->num_rows(),"data"=>$get->result());

	}	


}
?>