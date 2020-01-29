<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'html', 'form'));
		
    }

	public function login(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method != 'POST') {
           $response = json_encode(array('status' =>400, 'message' => 'Bad request.'));
        } else {
			$response = $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == true){
                $params = json_decode(file_get_contents('php://input'), TRUE);
                $response = $this->api_model->login($params);
            }else{
				$response = json_encode(array('status' => 401, 'message' => 'Unauthorizes data.'));
			}
		}
		echo $response;
	}
	
	
	
	public function signup(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
           $response = json_encode(['status' => 400, 'message' => 'Bad request.']);
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == true) {
                $data = json_decode(file_get_contents('php://input'), TRUE);
                $response = $this->api_model->signup($data);
            }else{
				$response = json_encode(array('status' => 401, 'message' => 'Unauthorizes data.'));
			}
        }
		echo $response;
    }
}
