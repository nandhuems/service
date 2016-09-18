<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User_model extends CI_Model {
    
    protected $table_name;
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_name = 'tbl_users';
    }
    
    public function getAll() {
        $query = $this->db->query("SELECT * FROM tbl_users");
		return $query->result();
    }
	
	public function adduser($data) {
		
		$email = $data['email'];
		$this->db->where('email',$email);
		$query = $this->db->get('tbl_users');
		if ($query->num_rows() > 0){
			$json = array("status" => 204, "msg" => "Already user is exist");
			return $json;
		}
		else{
			$adduser = $this->db->insert('tbl_users',$data);
			$json = array("status" => 201, "msg" => "Successfully Registered");
			return $json;
		}
    }	
	
	
	public function updateuser($data) {
		
		$id = $data['id'];
		
		$this->db->where('id',$id);
		$this->db->update('tbl_users',$data);
		
		$json = array("status" => 200, "msg" => "Successfully Updated");
		return $json;
	
    }	
	
	
	public function Deleteuser($id){
		$this->db->where('id',$id);
		$deleteuser = $this->db->delete('tbl_users');
		
		if(!$this->db->affected_rows()) {
			$json = array("status" => 204, "msg" => "Invalid userid!");
			return $json;
		}else {
			$json = array("status" => 200, "msg" => "Successfully Deleted");
			return $json;
		}

    }

	public function getsingleuser($id){
		$query = $this->db->query("SELECT * FROM tbl_users WHERE id = $id");
		
		if(!$this->db->affected_rows()) {
			$json = array("status" => 204, "msg" => "Invalid userid!");
			return $json;
		}else {
			 return $query->result();
		}
    }
}
 
