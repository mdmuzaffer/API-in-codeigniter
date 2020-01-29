<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class ApiModel extends CI_Model
{
    
	var $client_service = "frontend-user";
    var $auth_key = "$2y$12$61bUSAwW07ZD/Kb";

    //var $folder_upload_path = "/demo/development/upload/";

    /**
     *
     * @return boolean
     *
     */
	private function getToken()
    {
        $token = '';
        $string = 'ABCDEFGHIJKLMNOPQRSTUQWXYZ0123456789#@';
        for($i=1;$i<=25;$i++){
            $index = rand(0,37);
            $token = $token.$string[$index];
        }
        return $token;
    }
	
	
    public function check_auth_client()
    {
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key = $this->input->get_request_header('Auth-Key', TRUE);
        if ($client_service == $this->client_service && $auth_key == $this->auth_key) {
            return true;
        } else {
            return false;
        }
    }
	
	 public function login($params){
		$table = "users";
		$email = $params['email'];
		$passsword = md5($params['password']);
		
		$this->db->select("*");
		$this->db->from($table);
		$this->db->where('email',$email);
		$this->db->where('passsword',$passsword);
		$query = $this->db->get();
		$result = $query->result();
		$userId = $result['0']->id;
		$rowcount = $query->num_rows();
		if($rowcount ==1){
			$token = $this->getToken();
			$expired_at = date("Y-m-d H:i:s", strtotime('+5 hours'));
			$tokenexist = $this->db->select('token')->from('users_authentication')->where('users_id', $userId)->get();
			if ($tokenexist->num_rows() > 0){
					$tokenUpdate = array('users_id'=>$userId,'token'=>$token,'expired_at'=>$expired_at);
					$this->db->where('users_id',$userId);
					$this->db->update('users_authentication', $tokenUpdate);
				}else{
					$this->db->insert('users_authentication', array('users_id'=>$userId,'token'=>$token,'expired_at'=>$expired_at));
				}
				return json_encode(['status' => 200, 'success' => 'true', 'message' => 'Login successfully.', 'token' => $token, 'user_data' =>$result]);
		}else{
			return json_encode(array('status' =>401, 'message' => 'User name or Email incorrect'));
		}
		
	 }
	 
	public function signup($data){
		$password = md5($data['password']);
		$table = "users";
		date_default_timezone_set('Asia/Kolkata');
		$signdata = array(
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'email' => $data['email'],
			'passsword' => $password,
			'address' => $data['address'],
			'country' => $data['country'],
			'city' => $data['city'],
			'pincode' => $data['pincode'],
			'mobile' => $data['mobile'],  
			'device_token' => $data['device_token'],
			'device_type' => $data['device_type'],
			'created_at' => date('Y-m-d H:i:s'),
		);
		$email = $data['email'];

		$this->db->select("*");
		$this->db->from($table);
		$this->db->where('email',$email);
		$query = $this->db->get();
		$email_exist = $query->result();
		$rowcount = $query->num_rows();
		
		if($rowcount < 1){
			$this->db->insert($table, $signdata);
			$lastinsertId = $this->db->insert_id();
			$insertQuery = $this->db->select('*')->from($table)->where('id', $lastinsertId)->get()->row();
			
			if(!empty($insertQuery)){
				$token = $this->getToken();
				$expired_at = date("Y-m-d H:i:s", strtotime('+5 hours'));
				$tokenexist = $this->db->select('token')->from('users_authentication')->where('users_id', $lastinsertId)->get();
				if ($tokenexist->num_rows() > 0){
					$tokenUpdate = array('users_id'=>$lastinsertId,'token'=>$token,'expired_at'=>$expired_at);
					$this->db->where('users_id',$lastinsertId);
					$this->db->update('users_authentication', $tokenUpdate);
				}else{
					$this->db->insert('users_authentication', array('users_id'=>$lastinsertId,'token'=>$token,'expired_at'=>$expired_at));
				}
				return json_encode(['status' => 200, 'success' => 'true', 'message' => 'Sign up successfully.', 'token' => $token, 'user_data' =>$insertQuery]);
			}
		}else{
			return json_encode(['status' => 200, 'success' => 'true', 'message' => 'User already exist with this email id']);
		}
	}
	
	
	    /**
     * Auth
     *
     * @return type
     */
    public function auth()
    {
        $users_id = $this->input->get_request_header('User-ID', TRUE);
        $users_id = (int) filter_var($users_id, FILTER_SANITIZE_NUMBER_INT);

        $token = $this->input->get_request_header('Token', TRUE);

        //$type = $this->input->get_request_header('Type', TRUE);

        $q = $this->db->select('expired_at')->from('users_authentication')->where('users_id', $users_id)->get()->row();
        if (empty($q)) {
            return json_encode(array('status' => 401, 'message' => 'Unauthorized'));
        } else {
            if ($q->expired_at < date('Y-m-d H:i:s')) {
                return json_encode(array('status' => 401, 'message' => 'Your session has been expired.'));
            } else {
                $updated_at = date('Y-m-d H:i:s');
                $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->where('users_id', $users_id)->update('users_authentication', array('token' => $token, 'expired_at' => $expired_at, 'updated_at' => $updated_at));
				return json_encode(array('status' => 200, 'message' => 'Authorized'));
            }
        }
    }
	
	// post insert query
	
	public function createBlog($data){

        $users_id = $this->input->get_request_header('User-ID', TRUE);
        $users_id = (int) filter_var($users_id, FILTER_SANITIZE_NUMBER_INT);
        $table = 'blog_post';
	   
		$blog_post_data = array(
			'user_id' => $users_id,
			'post_title' => $data['post_title'],
			'post_description' => $data['post_description']
		);
		
		$this->db->insert($table, $blog_post_data);
		$lastinsertId = $this->db->insert_id();
		$q = $this->db->select('*')->from($table)->where('id', $lastinsertId)->get()->row();
		if (!empty($q)) {
			return array('status' => 200, 'success' => 'true', 'message' => 'Post Created successfully.', 'post_data' => $q);
		} else {
			return array('status' => 500, 'success' => 'false', 'message' => 'Internal server error.');
		}
	}

	// post update Api
	
	 public function updatePost($data){
		$users_id = $this->input->get_request_header('User-ID', TRUE);
		//$post_id = $this->input->get_request_header('Post-ID', TRUE);
		//$post_id = (int) filter_var($post_id, FILTER_SANITIZE_NUMBER_INT);
        $users_id = (int) filter_var($users_id, FILTER_SANITIZE_NUMBER_INT);
        $table = 'blog_post';
		
		$post_update_data = array(
			'id' => $data['post_id'],
			'user_id' => $users_id,
			'post_title' => $data['post_title'],
			'post_description' => $data['post_description']
		);

		$this->db->where('id', $data['post_id']);
		$this->db->where('user_id', $users_id);
		$this->db->update( $table , $post_update_data);
		return array('status' => 200, 'success' => 'true', 'message' => 'Post Updated Successfully!');
	 }
	
	// delete post
		public function deletePost($data){
		$users_id = $this->input->get_request_header('User-ID', TRUE);
        $users_id = (int) filter_var($users_id, FILTER_SANITIZE_NUMBER_INT);
        $table = 'blog_post';
		
		$this->db->where('id', $data['post_id']);
		$this->db->where('user_id', $users_id);
		$this->db->delete($table);
		return array('status' => 200, 'success' => 'true', 'message' => 'Your post deleted Successfully!');
	 }
	 
	 	// images of the post
		public function postImage($data){
		$users_id = $this->input->get_request_header('User-ID', TRUE);
        $users_id = (int) filter_var($users_id, FILTER_SANITIZE_NUMBER_INT);
        $table = 'post_image';
		
		$this->db->insert($table, $data);
		$lastinsertId = $this->db->insert_id();
		$q = $this->db->select('*')->from($table)->where('id', $lastinsertId)->get()->row();
		if (!empty($q)) {
			return array('status' => 200, 'success' => 'true', 'message' => 'Post Created successfully.', 'post_data' => $q);
		} else {
			return array('status' => 500, 'success' => 'false', 'message' => 'Internal server error.');
		}
	 }

}	
?>