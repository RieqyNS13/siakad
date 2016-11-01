<?php
class Walikelas_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function total(){
		return $this->db->get("walikelas_6771")->num_rows();
	}
	function getWaliKelas($start,$limit){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from walikelas_6771 a inner join guru_6771 b inner join kelas_6771 c inner join jurusan_6771 d on a.kode_guru=b.kode_guru and a.id_kelas=c.id_kelas and c.kd_jurusan=d.id_jurusan limit $start,$limit");
		return $query->result();
	}
	function cekwaliKelasBelumAda($data,$type=1){
		if($type==1){
			$query=$this->db->query("select * from walikelas_6771 a inner join kelas_6771 b inner join jurusan_6771 c on a.id_kelas=b.id_kelas and b.kd_jurusan=c.id_jurusan where a.id_kelas=".$data["id_kelas"]."");
			if($query->num_rows()>=1){
				$result=$query->row();
				return array("status"=>false,"msg"=>"Sudah ada guru yang mengajar kelas '".$result->prefix_kelas." ".$result->nama_jurusan." ".$result->nomor_kelas."'");
			}else return array("status"=>true,"msg"=>null);
		}else{
			$query=$this->db->query("select * from walikelas_6771 a inner join kelas_6771 b inner join jurusan_6771 c on a.id_kelas=b.id_kelas and b.kd_jurusan=c.id_jurusan where a.id_kelas=".$data["id_kelas"]." or a.kode_guru='".$data["kode_guru"]."'");
			if($query->num_rows()>=1){
				$result=$query->row();
				return array("status"=>false,"msg"=>"Guru dengan kode '".$result->kode_guru."' sudah menjadi wali kelas '".$result->prefix_kelas." ".$result->nama_jurusan." ".$result->nomor_kelas."'");
			}else return array("status"=>true,"msg"=>null);
		}
	}
	function cariWaliKelas($q,$start,$limit){
		$q=$this->db->escape_str($q);
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select a.kode_guru,d.nama,b.prefix_kelas,c.nama_jurusan,b.nomor_kelas,concat(b.prefix_kelas,' ',c.nama_jurusan,' ',b.nomor_kelas) as kelas from walikelas_6771 a INNER join kelas_6771 b INNER join jurusan_6771 c inner join guru_6771 d on 
		a.kode_guru=d.kode_guru and a.id_kelas=b.id_kelas and b.kd_jurusan=c.id_jurusan having a.kode_guru like '%$q%' or d.nama like '%$q%' or kelas like '%$q%' limit $start,$limit");
		if($query)return $query;
		return false;
	}
	function editWaliKelas($data){
		$data2["kode_guru"]=$this->db->escape_str($data["kode_guru"]);
		$data2["id_kelas"]=$this->db->escape_str($data["id_kelas"]);
		if($data["kode_guru"]===$data["kode_guru_forEdit"]){
			$cek=$this->cekwaliKelasBelumAda($data2,1);
			if($cek["status"]==false)return array("sukses"=>false,"msg"=>$cek["msg"]);
		}else{
			$cek=$this->cekwaliKelasBelumAda($data2,2);
			if($cek["status"]==false)return array("sukses"=>false,"msg"=>$cek["msg"]);
		}
		$this->db->where("kode_guru",$data["kode_guru_forEdit"]);
		unset($data["kode_guru_forEdit"]);
		$update=$this->db->update("walikelas_6771",$data);
		if($update)return array("sukses"=>true,"msg"=>"Sukses edit data");
		else return array("sukses"=>false,"msg"=>$this->db->error());	
	}
	function jumlahCariWaliKelas($q){
		$q=$this->db->escape_str($q);
		$query=$this->db->query("select a.kode_guru,d.nama,concat(b.prefix_kelas,' ',c.nama_jurusan,' ',b.nomor_kelas) as kelas from walikelas_6771 a INNER join kelas_6771 b INNER join jurusan_6771 c inner join guru_6771 d on 
		a.kode_guru=d.kode_guru and a.id_kelas=b.id_kelas and b.kd_jurusan=c.id_jurusan having a.kode_guru like '%$q%' or d.nama like '%$q%' or kelas like '%$q%'");
		return $query->num_rows();
	}
	function inputWaliKelas($data){
		$data2["id_kelas"]=$this->db->escape_str($data["id_kelas"]);
		$data2["kode_guru"]=$this->db->escape_str($data["kode_guru"]);
		$cek=$this->cekwaliKelasBelumAda($data2,2);
		if($cek["status"]==false){
			return array("sukses"=>false,"msg"=>$cek["msg"]);
		}
		$query=$this->db->insert("walikelas_6771", $data);
		if($query)return array("sukses"=>true,"msg"=>"Sukses menambahkan sebagai wali kelas");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function getSiswa($start,$limit,$tampil){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		if($tampil!=null && $tampil>0){
			$tampil=abs((int)$tampil);
			$where="where a.kd_kelas=$tampil";
		}else $where=null;
		$query=$this->db->query("select *,b.nama_jurusan from siswa_6771 a inner join jurusan_6771 b inner join kelas_6771 c inner join agama_6771 d on a.kd_jurusan=b.id_jurusan and a.kd_kelas=c.id_kelas and a.kd_agama=d.id_agama ".$where." limit $start,$limit");
		return $query->result();
	}
}