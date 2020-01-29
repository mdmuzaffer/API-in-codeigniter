<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Clients extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('upload');
    }
	
	// post create
    public function createBlog(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
        $response = json_encode(array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                $params = json_decode(file_get_contents('php://input'), TRUE);
                $response = $this->api_model->createBlog($params);
				$response = json_encode(['status' => $response]);
                }
            }
        }
		echo $response;
    }

// post update
    public function updatePost()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
             $response = json_encode(array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->api_model->auth();
                if($response['status'] == 200){
                $params = json_decode(file_get_contents('php://input'), TRUE);
                $response = $this->api_model->updatePost($params);
                $response = json_encode(['status' => $response]);
                }
            }
        }
		echo $response;
    }
	
// post delete
	public function deletePost(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
             $response = json_encode(array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->api_model->auth();
				$responseStatus = json_decode($response);
                if($responseStatus->status == 200){
                $params = json_decode(file_get_contents('php://input'), TRUE);
                $response = $this->api_model->deletePost($params);
                $response = json_encode(['status' => $response]);
                }
            }
        }
		echo $response;
    }

// Image upload
	public function imagePost(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
             $response = json_encode(array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->api_model->auth();
				$responseStatus = json_decode($response);
                if($responseStatus->status == 200){
				$title = $this->input->post('title');
		
					if($_FILES['image']['name']){
					$config['upload_path']   = './api/demo/upload/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']      = 2000;
					$config['max_width']     = 1500;
					$config['max_height']    = 1000;
					$config['overwrite']     = TRUE;
					$config['file_name']     = time().$_FILES['image']['name'];
					$file_size = $_FILES['image']['size'];
					$file_tmp = $_FILES['image']['tmp_name'];

					$file_ext_var = explode('.',$_FILES['image']['name']);
					$file_ext = strtolower(end($file_ext_var));
					$extensions = array("jpeg","jpg","png");
						if(in_array($file_ext,$extensions)){
							if($file_size < 2097101){
								$this->upload->initialize($config);
								$imge=$_SERVER['DOCUMENT_ROOT'].'/api/demo/upload/'. time().$_FILES['image']['name'];
								move_uploaded_file($file_tmp,$imge);
								$postData = $this->input->post();
								$postDatasave = array(
								'post_title'=> $postData['title'],
								'post_content'=> $postData['content'],
								'user_id'=> $postData['post-id'],
								'image'=>  time().$_FILES['image']['name']
								);
								$response = $this->api_model->postImage($postDatasave);
								$response = json_encode(['status' => $response]);
								//$response = json_encode(array('status' => 200, 'success' =>'true', 'message' =>'Your file successfully upload.'));
							}else{
								$response = json_encode(array('status' => 200, 'success' =>'true', 'message' =>'File size must be excately 2 MB.'));
							}
						}else{
							$response = json_encode(array('status' => 200, 'success' =>'true', 'message' =>'extension not allowed, please choose a JPEG or PNG file.'));
						}
					}
                }
            }
        }
		echo $response;
		
    }



}
