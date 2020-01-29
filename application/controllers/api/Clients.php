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

    public function getUserPartRequests()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                    if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->getUserPartRequests($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getManufacturersList()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->getManufacturersList($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getModelListByManufacturerId()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->getModelListByManufacturerId($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getUserDetails()
    {
    
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->getUserDetails($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

     public function cancelUserPartRequest()
    {
    
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->cancelUserPartRequest($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

     public function updateUserPartRequest()
    {
    
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->updateUserPartRequest($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

     public function updateUserBankDetails()
    {
    
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->updateUserBankDetails($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }


      public function getFilteredPendingPartRequests()


    {
    
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->getFilteredPendingPartRequests($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }


     public function getPendingPartRequests()


    {
    
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->getPendingPartRequests($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

     public function updateUserNotificationSettings()
    {
    
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->updateUserNotificationSettings($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }


    public function getUserBankDetails()
    {
    
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->getUserBankDetails($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getUserNotificationSettings()
    {
    
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->getUserNotificationSettings($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }


    public function makeOfferPartRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->api_model->auth();
                $respStatus = $response['status'];
                if ($response['status'] == 200) {
                    
                    $params = $_REQUEST;
                    $fileData = $_FILES;

                    if($params['partRequestId'] == "") {
                        $respStatus = 400;
                        $resp = array('status' => 400, 'message' => 'Part Request Id can\'t empty');
                    } else {
                        $resp = $this->api_model->makeOfferPartRequest($params, $fileData);
                    }
                    json_output($respStatus, $resp);
                }
            }
        }
    }


    public function getPartRequestOffers()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                    if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->getPartRequestOffers($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }


    public function acceptOfferOfPartRequest()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                    if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->acceptOfferOfPartRequest($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }


    public function rejectOfferOfPartRequest()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->api_model->check_auth_client();
            if ($check_auth_client == TRUE) {
                $response = $this->api_model->auth();
                    if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    $resp = $this->api_model->rejectOfferOfPartRequest($params);
                    json_output($response['status'], $resp);
                }
            }
        }
    }



}
