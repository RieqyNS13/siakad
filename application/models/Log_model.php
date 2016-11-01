<?php 
class Log_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getLog(){
		$this->db->order_by("waktu","desc");
		return $this->db->get("tr_log_aktivitas")->result();
	}
}