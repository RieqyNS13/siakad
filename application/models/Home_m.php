<?php
class Home_m extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function inputPengumuman($post){
		$insert=$this->db->insert("pengumuman_6771",$post);
		if($insert){
			return array("sukses"=>true,"msg"=>null);
		}else{
			$dberror=$this->db->error();
			return array("sukses"=>false,"msg"=>isset($dberror["code"])?$dberror["message"]:"Error ketika input data");
		}
	}
	function getPilihan(){
		$get=$this->db->get_where("submitraport_6771",array("nis"=>$this->session->userdata("user"),"submit"=>1))->result();
		//foreach($
		return $get;
	}
	function editPengumuman($post){
		$id=$post["id_forEdit"];
		unset($post["id_forEdit"]);
		$this->db->where("id",$id);
		$edit=$this->db->update("pengumuman_6771",$post);
		if($edit)return array("sukses"=>true,"msg"=>null);
		else{
			$error=$this->db->error();
			return array("sukses"=>false,"msg"=>isset($error["code"])?$error["message"]:"Error edit data");
		}
	}
	function cekWaliKelas($kode_guru){
		$this->db->select("*");
		$this->db->from("walikelas_6771");
		$this->db->join("kelas_6771","walikelas_6771.id_kelas=kelas_6771.id_kelas");
		$this->db->join("jurusan_6771","kelas_6771.kd_jurusan=jurusan_6771.id_jurusan");
		$this->db->where("walikelas_6771.kode_guru",$kode_guru);
		$get=$this->db->get();
		if($get->num_rows()>=1){
			return array("walikelas"=>true,"data"=>$get->row());
		}else return array("walikelas"=>false,"data"=>null);
	}
	function gantiPass($user,$pass){
		$this->db->where("username",$user);
		$update=$this->db->update("user_6771",array("password"=>md5($pass)));
		if($update)return array("sukses"=>true,"msg"=>null);
		else{
			$dberror=$this->db->error();
			return array("sukses"=>false,"msg"=>isset($dberror["code"])?$dberror["message"]:null);
		}
	}
	function editData($user,$data){
		unset($data["username"]);
		$this->db->where("username",$user);
		$update=$this->db->update("user_6771",$data);
		if($update)return array("sukses"=>true,"msg"=>null);
		else{
			$dberror=$this->db->error();
			return array("sukses"=>false,"msg"=>isset($dberror["code"])?$dberror["message"]:null);
		}
	}
	function getAkun($user){
		$this->db->select("id_user,username,nama,email,no_telp,kd_role");
		$this->db->from("user_6771");
		$this->db->where("username",$user);
		$query=$this->db->get();
		if($query->num_rows()>=1){
			return array("sukses"=>true,"msg"=>$query->row());
		}else{
			$dberror=$this->db->error();
			return array("sukses"=>false,"msg"=>isset($dberror["code"])?$dberror["message"]:null);
		}
	}
	function getMapelYgDiajar($kd_guru){
		$this->db->select("*");
		$this->db->from("guru_mengajar_6771");
		$this->db->join("mapel_6771","guru_mengajar_6771.kd_mapel=mapel_6771.kode_mapel");
		$this->db->where("guru_mengajar_6771.kode_guru",$kd_guru);
		return $this->db->get()->result();
	}
	function getProfil($user,$type=1){
		if($type==1){
			$user=$this->db->escape_str($user);
			$query=$this->db->query("select a.*,b.*,c.*,d.*,e.nama_ayah,e.nama_ibu,e.pekerjaan_ayah,e.pekerjaan_ibu,e.alamat_ortu from siswa_6771 a join jurusan_6771 b on a.kd_jurusan=b.id_jurusan 
			join kelas_6771 c on a.kd_kelas=c.id_kelas
			join agama_6771 d on a.kd_agama=d.id_agama
			left join ortu_siswa_6771 e on e.nis=a.nis
			where a.nis='".$user."'");
		}else{
			$this->db->select("user_6771.username,user_6771.email,guru_6771.*,walikelas_6771.id_kelas,kelas_6771.*,jurusan_6771.nama_jurusan");
			$this->db->from("user_6771");
			$this->db->join("guru_6771","user_6771.username=guru_6771.kode_guru or user_6771.username=guru_6771.nip");
			$this->db->join("walikelas_6771","walikelas_6771.kode_guru=guru_6771.kode_guru","left");
			$this->db->join("kelas_6771","kelas_6771.id_kelas=walikelas_6771.id_kelas","left");
			$this->db->join("jurusan_6771","jurusan_6771.id_jurusan=kelas_6771.kd_jurusan","left");
			$this->db->where("user_6771.username",$user);
			$query=$this->db->get();
		}
		if($query->num_rows()>=1){
			return array("sukses"=>true,"msg"=>$query->row());
		}else{
			$dberror=$this->db->error();
			return array("sukses"=>false,"msg"=>!empty($dberror["code"])?$dberror["message"]:"Error tidak diketahui");
		}
	}
	function bacaPengumuman($id){
		$this->db->select("*");
		$this->db->from("pengumuman_6771");
		$this->db->join("user_6771","pengumuman_6771.author=user_6771.id_user");
		$this->db->where("pengumuman_6771.id",$id);
		$get=$this->db->get();
		if($get->num_rows()>=1)return array("sukses"=>true,"data"=>$get->row());
		else return array("sukses"=>false,"data"=>"Data Tidak Ada");
	}
	function getPengumuman($start=null,$limit=null){
		if($start!=null && $limit!=null){
			$start=abs((int)$start);
			$limit=abs((int)$limit);
			$asu="limit $start,$limit";
		}else $asu=null;
		$query=$this->db->query("select * from pengumuman_6771 a inner join user_6771 b on a.author=b.id_user order by a.tanggal desc $asu");
		return $query->result();
	}
	function totalPengumuman(){
		return $this->db->get("pengumuman_6771")->num_rows();
	}
	function cariPengumuman($q,$start,$limit){
		$this->db->select("pengumuman_6771.*,user_6771.username,user_6771.nama");
		$this->db->from("pengumuman_6771");
		$this->db->join("user_6771","pengumuman_6771.author=user_6771.id_user");
		$this->db->like("pengumuman_6771.judul",$q);
		$this->db->or_like("pengumuman_6771.isi",$q);
		$this->db->or_like("pengumuman_6771.tanggal",$q);
		$this->db->or_like("user_6771.username",$q);
		$this->db->or_like("user_6771.nama",$q);
		$this->db->limit($limit,$start);
		$get=$this->db->get();
		return array("jumlah"=>$get->num_rows(),"data"=>$get->result());
	}
}