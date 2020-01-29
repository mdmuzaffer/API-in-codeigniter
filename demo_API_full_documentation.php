A:-$data = json_decode(file_get_contents('php://input'), TRUE);
Getting all body row data

B:-$users_id = $this->input->get_request_header('User-ID', TRUE);
getting header particular field data like User-ID


C:-$postData = $this->input->post();
getting body form-data 


1. Sign up Ul=  http://localhost/api/demo/api/auth/signup
Method Type: POST

Header:-
--------------------
Content-Type:application/x-www-form-urlencoded
Client-Service:frontend-user
Auth-Key:$2y$12$61bUSAwW07ZD/Kb

body ==== raw
------------------
{ "first_name" : "shazidh", "last_name" : "khan", "email" : "skkhan@yopmail.com", "password" : "12345", "address" : "katihar", "country" : "India", "city" : "choni", "pincode" : "854326", "mobile" : "987458210", "device_token":"DUMMY622684085DACD21EBC84DUMMYF4FBE5212FDCF1E2B488gSDERHYTNLOJHGRD" , "device_type":"ios" }

Success messag:-
-------------------
{
    "status": 200,
    "success": "true",
    "message": "Sign up successfully.",
    "token": "JNTQW3KHS3@7G67CBD9H96M42",
    "user_data": {
        "id": "7",
        "first_name": "shazidh",
        "last_name": "khan",
        "email": "skkhan@yopmail.com",
        "passsword": "827ccb0eea8a706c4c34a16891f84e7b",
        "address": "katihar",
        "country": "India",
        "city": "choni",
        "pincode": "854326",
        "mobile": "987458210",
        "device_token": "DUMMY622684085DACD21EBC84DUMMYF4FBE5212FDCF1E2B488gSDERHYTNLOJHGRD",
        "device_type": "ios",
        "created_at": "2020-01-25 00:03:03"
    }
}

---------------------------------

2.Login url- http://localhost/api/demo/api/auth/login
Method Type: POST
Headers:-
-----------------------
Content-Type:application/x-www-form-urlencoded
Client-Service:frontend-user
Auth-Key:$2y$12$61bUSAwW07ZD/Kb

----------------------------
Body === row
----------------------
{"email" : "skkhan@yopmail.com", "password" : "12345", "device_token":"DUMMY622684085DACD21EBC84DUMMYF4FBE5212FDCF1E2B48825D004783DUMMY", "device_type":"ios" }
Message:-
-------------------
{
    "status": 200,
    "success": "true",
    "message": "Login successfully.",
    "token": "404YNG1L0EENHFE367JHN4IJ@",
    "user_data": [
        {
            "id": "7",
            "first_name": "shazidh",
            "last_name": "khan",
            "email": "skkhan@yopmail.com",
            "passsword": "827ccb0eea8a706c4c34a16891f84e7b",
            "address": "katihar",
            "country": "India",
            "city": "choni",
            "pincode": "854326",
            "mobile": "987458210",
            "device_token": "DUMMY622684085DACD21EBC84DUMMYF4FBE5212FDCF1E2B488gSDERHYTNLOJHGRD",
            "device_type": "ios",
            "created_at": "2020-01-25 00:03:03"
        }
    ]
}

3. Post create API Url 
http://localhost/api/demo/api/clients/createBlog
--------------------------------------------------
METHOD : POST
Headers:-
Content-Type:application/json
Client-Service:frontend-user 
Auth-Key:$2y$12$61bUSAwW07ZD/Kb 
User-ID:7
Token:1LJZLEC7QD3YIJJ3QQMT2WBIK

Body === row
-------------------
{ "post_title" : "Demo post title", "post_description":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ." }

Message
------------------
{
    "status": {
        "status": 200,
        "success": "true",
        "message": "Post Created successfully.",
        "post_data": {
            "id": "1",
            "user_id": "7",
            "post_title": "Demo post title",
            "post_description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt .",
            "created_at": "2020-01-25 01:33:37",
            "updated_at": "2020-01-25 01:33:37"
        }
    }
}


4. post update 
-------------------------------------
http://localhost/api/demo/api/clients/updatePost

Method Type: POST
Header:-
Content-Type:application/json
Client-Service:frontend-user 
Auth-Key:$2y$12$61bUSAwW07ZD/Kb 
User-ID:2
Token:85EMDOI6O#E0CG3JEWR88WB8J //here token no need

Body row
----------------------
{ "post_id" : "4", "post_title" : "Demo post update", "post_description":"Lorem ipsum dolor sit amet, consectetur adipiscing updated." }

Message
----------------------
{
    "status": {
        "status": 200,
        "success": "true",
        "message": "Post Updated Successfully!"
    }
}

5. // Post delete
http://localhost/api/demo/api/clients/deletePost

Method Type: POST

Header:-
Content-Type:application/json
Client-Service:frontend-user 
Auth-Key:$2y$12$61bUSAwW07ZD/Kb 
User-ID:7

Body row
----------------------
{ "post_id" : "2" }

Message
----------------------
{
    "status": {
        "status": 200,
        "success": "true",
        "message": "Your post deleted Successfully!"
    }
}

==============================

6. // Upload Post images
http://localhost/api/demo/api/clients/imagePost


Method Type: POST

Header:-
-----------
Content-Type:application/json
Client-Service:frontend-user 
Auth-Key:$2y$12$61bUSAwW07ZD/Kb 
User-ID:2

Body form-data
----------------------
title:demo title
content:this is the demo content
post-id:3
----------------------

Message:-
{
    "status": {
        "status": 200,
        "success": "true",
        "message": "Post Created successfully.",
        "post_data": {
            "id": "1",
            "post_title": "demo title",
            "post_content": "this is the demo content",
            "image": "1580323716pexels-photo-1661470.jpeg",
            "user_id": "3",
            "created_at": "2020-01-30 00:18:36",
            "updated_at": "2020-01-30 00:18:36"
        }
    }
}












