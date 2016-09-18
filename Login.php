<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model(array('user_model'));
		$_POST = json_decode(file_get_contents('php://input'), true);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
    }
	
    public function get_list() {
        $data = $this->user_model->getAll();
        $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data));
    }
	
	public function post_user() {
		if($_SERVER['REQUEST_METHOD'] == "POST"){
		
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this -> form_validation -> set_rules('pass', 'Password', 'required|max_length[15]|min_length[6]');

			if ($this->form_validation->run() == FALSE)
			{
				$data = array(
					'email' => form_error('email'),
					'pass' => form_error('pass')
				);
				
				$json = array("status" => 400, "errormessage" => $data);
				$this->output->set_content_type('application/json')->set_output(json_encode($json));
			
			}else{
				$insert = $this->input->post();
				$postinsert = $this->user_model->adduser($insert);
				$this->output->set_content_type('application/json')->set_output(json_encode($postinsert));
			}
			
		}else{
			$json = array("status" => 400, "msg" => "Request method not accepted");
			$this->output->set_content_type('application/json')->set_output(json_encode($json));
		}
    }
	
	public function update_user() {
		if($_SERVER['REQUEST_METHOD'] == "POST"){
		
			$this->form_validation->set_rules('id', 'Id', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this -> form_validation -> set_rules('pass', 'Password', 'required|max_length[15]|min_length[6]');

			if ($this->form_validation->run() == FALSE)
			{
				$data = array(
					'id' => form_error('id'),
					'email' => form_error('email'),
					'pass' => form_error('pass')
				);
				
				$json = array("status" => 400, "errormessage" => $data);
				$this->output->set_content_type('application/json')->set_output(json_encode($json));
			
			}else{
				$insert = $this->input->post();
				$postinsert = $this->user_model->updateuser($insert);
				$this->output->set_content_type('application/json')->set_output(json_encode($postinsert));
			}
			
		}else{
			$json = array("status" => 400, "msg" => "Request method not accepted");
			$this->output->set_content_type('application/json')->set_output(json_encode($json));
		}
    }
	
	
	public function DeleteUser($id){
		if($_SERVER['REQUEST_METHOD'] == "DELETE"){
			$deleteUSer = $this->user_model->Deleteuser($id); 
			$this->output->set_content_type('application/json')->set_output(json_encode($deleteUSer));
		}else{
			$json = array("status" => 400, "msg" => "Request method not accepted");
			$this->output->set_content_type('application/json')->set_output(json_encode($json));
		}
	}	 
	
	public function update_list($id) {
        $data = $this->user_model->getsingleuser($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}
