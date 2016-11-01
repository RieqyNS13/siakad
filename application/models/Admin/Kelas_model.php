<?php 
class Kelas_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function cariKelas($q,$start,$limit){
		$q=$this->db->escape_str($q);
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select a.id_kelas,concat(a.prefix_kelas,' ',b.nama_jurusan,' ',a.nomor_kelas) as kelas,a.prefix_kelas,b.nama_jurusan,a.nomor_kelas,b.nama_full from kelas_6771 a 
		INNER JOIN jurusan_6771 b on a.kd_jurusan=b.id_jurusan HAVING kelas like '%$q%' or b.nama_jurusan like '%$q%' limit $start,$limit");
		if($query)return $query;
		return false;
	}
	function jumlahcariKelas($q){
		$q=$this->db->escape_str($q);
		$query=$this->db->query("select concat(a.prefix_kelas,' ',b.nama_jurusan,' ',a.nomor_kelas) as kelas,b.nama_jurusan from kelas_6771 a 
		INNER JOIN jurusan_6771 b on a.kd_jurusan=b.id_jurusan HAVING kelas like '%$q%' or b.nama_jurusan like '%$q%'");
		return $query->num_rows();
	}
	function total(){
		return $this->db->query("select * from kelas_6771")->num_rows();
	}
	function cekKelasbelumada($data,$type=1){
		if($type==1){
			$query=$this->db->query("select * from kelas_6771 where prefix_kelas='".$data["prefix_kelas"]."' and kd_jurusan=".$data["kd_jurusan"]." and nomor_kelas=".$data["nomor_kelas"]."");
			if($query->num_rows()>=1)return array("status"=>false,"msg"=>"Kelas sudah ada");
			else return array("status"=>true,"msg"=>null);
		}else if($type==2){
			
		}
	}
	function getJurusan(){
		$jurusan='';
		$query=$this->db->query("select * from jurusan_6771")->result();
		foreach($query as $mbuh){
			$jurusan.="<option value=\"".$mbuh->id_jurusan."\">".$mbuh->nama_jurusan." | ".$mbuh->nama_full."</option>";
		}
		return $jurusan;
	}
	function editKelas($post){
		$data["prefix_kelas"]=$this->db->escape_str($post["prefix_kelas"]);
		$data["kd_jurusan"]=$this->db->escape_str($post["kd_jurusan"]);
		$data["nomor_kelas"]=$this->db->escape_str($post["nomor_kelas"]);
		$cek=$this->cekKelasbelumada($data);
		if($cek["status"]==false){
			return array("sukses"=>false,"msg"=>$cek["msg"]);
		}
		$this->db->where("id_kelas",$post["id_kelas_forEdit"]);
		unset($post["id_kelas_forEdit"]);
		$update=$this->db->update("kelas_6771",$data);
		if($update)return array("sukses"=>true,"msg"=>"Sukses edit data");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function getKelas($start,$limit){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("SELECT *,concat(a.prefix_kelas,' ',b.nama_jurusan,' ',a.nomor_kelas) as mbuh from kelas_6771 a inner join jurusan_6771 b on a.kd_jurusan=b.id_jurusan order by a.kd_jurusan,a.prefix_kelas,a.nomor_kelas limit $start,$limit");
		return $query->result();
	}
	function inputKelas($post){
		$data["prefix_kelas"]=$this->db->escape_str($post["prefix_kelas"]);
		$data["kd_jurusan"]=$this->db->escape_str($post["kd_jurusan"]);
		$data["nomor_kelas"]=$this->db->escape_str($post["nomor_kelas"]);
		$cek=$this->cekKelasbelumada($data);
		if($cek["status"]==false){
			return array("sukses"=>false,"msg"=>$cek["msg"]);
		}
		$query=$this->db->insert("kelas_6771", $post);
		if($query)return array("sukses"=>true,"msg"=>"Sukses menambahkan kelas");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
}
?>