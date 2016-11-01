<?php 
class Siswa_model extends CI_Model{
	function __construct(){
		$this->load->library("Proses_data");
		parent::__construct();
	}
	function cekSiswasudahada($nis,$nisn){
		$cek=$this->db->query("select * from siswa_6771 where nis='$nis' or nisn='$nisn'");
		if($cek->num_rows()>=1)return false;
		return true;	
	}
	function cekSiswasudahada2($nis){
		$cek=$this->db->query("select * from siswa_6771 where nis='$nis'");
		if($cek->num_rows()>=1)return false;
		return true;	
	}
	function total($tampil=null){
		if($tampil!=null && $tampil>0){
			$this->db->where("kd_kelas",$tampil);
		}
		return $this->db->get("siswa_6771")->num_rows();
	}
	function getSiswa($start,$limit,$tampil){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		if($tampil!=null && $tampil>0){
			$tampil=abs((int)$tampil);
			$where="where a.kd_kelas=$tampil";
		}else $where=null;
		$query=$this->db->query("select *,b.nama_jurusan from siswa_6771 a inner join jurusan_6771 b inner join kelas_6771 c inner join agama_6771 d on a.kd_jurusan=b.id_jurusan and a.kd_kelas=c.id_kelas and a.kd_agama=d.id_agama ".$where." order by a.nis limit $start,$limit");
		return $query->result();
	}
	function editSiswa($data){
		$nis=$this->db->escape_str($data["nis"]);
		if($data["nis"]!==$data["nis_forEdit"] && !$this->cekSiswasudahada2($nis))return array("sukses"=>false,"msg"=>"Siswa dengan nis '".$data["nis"]."' sudah ada");
		$this->db->where("nis",$data["nis_forEdit"]);
		unset($data["nis_forEdit"]);
		$update=$this->db->update("siswa_6771",$data);
		if($update)return array("sukses"=>true,"msg"=>"Sukses edit data");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function inputSiswa($data){
		if(!$this->cekSiswasudahada($this->db->escape_str($data["nis"]),$this->db->escape_str($data["nisn"]))){
			return array("sukses"=>false,"msg"=>"Sudah ada siswa dengan nis/nisn tersebut");
		}
		$query=$this->db->insert("siswa_6771", $data);
		if($query)return array("sukses"=>true,"msg"=>"Sukses tambah data");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function cariSiswa($q,$start,$limit){
		$q=$this->db->escape_str($q);
		//echo $q;die;
		$this->db->select("*,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas");
		$this->db->from("siswa_6771");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=siswa_6771.kd_jurusan");
		$this->db->join("agama_6771","agama_6771.id_agama=siswa_6771.kd_agama");
		$this->db->having("nis like '%$q%'");
		$this->db->or_having("nisn like '%$q%'");
		$this->db->or_having("nama like '%$q%'");
		$this->db->or_having("no_telp like '%$q%'");
		$this->db->or_having("tgl_lahir like '%$q%'");
		$this->db->or_having("tempat_lahir like '%$q%'");
		$this->db->or_having("nama_jurusan like '%$q%'");
		$this->db->or_having("nama_full like '%$q%'");
		$this->db->or_having("prefix_kelas like '%$q%'");
		$this->db->or_having("agama like '%$q%'");
		$this->db->or_having("alamat like '%$q%'");
		$this->db->or_having("kelas like '%$q%'");
		$this->db->limit($limit,$start);
		$query=$this->db->get();
		//$query=$this->db->query("select *,concat(kelas_6771.prefix_kelas,' ',kelas_6771 from siswa_6771 a inner join jurusan_6771 b inner join kelas_6771 c inner join agama_6771 d on a.kd_jurusan=b.id_jurusan and a.kd_kelas=c.id_kelas and a.kd_agama=d.id_agama where a.nis like '%$q%' or a.nisn like '%$q%' or a.nama like '%$q%' or a.jen_kel like '%$q%' or a.no_telp
		//like '%$q%' or a.tgl_lahir like '%$q%' or a.tempat_lahir like '%$q%' or b.nama_jurusan like '%$q%' or b.nama_full like '%$q%' or c.prefix_kelas like '%$q%' or d.agama like '%$q%' or a.alamat like '%$q%' limit $start,$limit");
		if($query)return $query->result();
		return false;
	}
	function getKelasurut(){
		$query=$this->db->query("select nama_jurusan,id_jurusan from jurusan_6771")->result();
		foreach($query as $mbuh){
			$data[$mbuh->nama_jurusan]=array();
			$query2=$this->db->query("select * from kelas_6771 a inner join jurusan_6771 b on a.kd_jurusan=b.id_jurusan where a.kd_jurusan=".$mbuh->id_jurusan." order by a.prefix_kelas,a.nomor_kelas")->result();
			foreach($query2 as $mbuh2){
				$data[$mbuh->nama_jurusan][$mbuh2->id_kelas]=$mbuh2->prefix_kelas." ".$mbuh2->nama_jurusan." ".$mbuh2->nomor_kelas;
			}
		}
		return $data;
	}
	function jumlahcariSiswa($q){
		$q=$this->db->escape_like_str($q);
		$this->db->select("*,concat(kelas_6771.prefix_kelas,' ',jurusan_6771.nama_jurusan,' ',kelas_6771.nomor_kelas) as kelas");
		$this->db->from("siswa_6771");
		$this->db->join("kelas_6771","kelas_6771.id_kelas=siswa_6771.kd_kelas");
		$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=siswa_6771.kd_jurusan");
		$this->db->join("agama_6771","agama_6771.id_agama=siswa_6771.kd_agama");
		$this->db->having("nis like '%$q%'");
		$this->db->or_having("nisn like '%$q%'");
		$this->db->or_having("nama like '%$q%'");
		$this->db->or_having("no_telp like '%$q%'");
		$this->db->or_having("tgl_lahir like '%$q%'");
		$this->db->or_having("tempat_lahir like '%$q%'");
		$this->db->or_having("nama_jurusan like '%$q%'");
		$this->db->or_having("nama_full like '%$q%'");
		$this->db->or_having("prefix_kelas like '%$q%'");
		$this->db->or_having("agama like '%$q%'");
		$this->db->or_having("alamat like '%$q%'");
		$this->db->or_having("kelas like '%$q%'");
		$query=$this->db->get();
		return $query->num_rows();
	}
	function inputSiswa_xls($data){
		$cek=$this->proses_data->checkDataSudahDisi($data,array("nisn"));
		$data=$this->proses_data->trimData($data);
		if(!$cek)return array("sukses"=>false,"msg"=>"Data error");
		$kelas=preg_split("/\s+/",$data["kelas"]);
		if(count($kelas)!=3)return array("sukses"=>false);
		unset($data["kelas"]);
		$kode_jurusan=$this->db->select("id_jurusan")->from("jurusan_6771")->where(array("nama_jurusan"=>$kelas[1]))->get()->row()->id_jurusan;
		$data["kd_jurusan"]=$kode_jurusan;
		$data["kd_kelas"]=$this->db->select("id_kelas")->from("kelas_6771")->where(array("prefix_kelas"=>$kelas[0],"kd_jurusan"=>$kode_jurusan,"nomor_kelas"=>$kelas[2]))->get()->row()->id_kelas;
		$data["kd_agama"]=$this->db->select("id_agama")->from("agama_6771")->where(array("agama"=>$data["agama"]))->get()->row()->id_agama;
		unset($data["agama"]);
		$query=$this->db->insert("siswa_6771",$data);
		if($query)return array("sukses"=>true);
		else return array("sukses"=>false);
	}
}
?>