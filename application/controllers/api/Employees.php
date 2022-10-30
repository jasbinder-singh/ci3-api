<?php
require APPPATH . 'libraries/REST_Controller.php';
class Employees extends REST_Controller
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Authorization", "Content-Type");
        header("Content-Type: application/json");
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("Emp_model"));
        $this->load->library("Token");
    }

    public function employees_get($id)

    {
        (!$this->token->Check_Token("normal", false));
        header("Content-Type: application/json");
        $input = json_decode(file_get_contents('php://input'), true);


        // $id = $this->input->get('id');
        // $id = 0;

        if (!empty($id)) {
            $data = $this->Emp_model->get_emp_by_id($id);

            if ($data) {
                $this->response($data, REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    "status" => false,
                    "message" => "Could not get the data"
                ), REST_Controller::HTTP_OK);
            }
        } else {
            $data = $this->Emp_model->get_employees();

            if ($data) {
                $this->response($data, REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    "status" => false,
                    "message" => "Could not get the data"
                ), REST_Controller::HTTP_OK);
            }
        }

        // $this->response($res, 200);
    }
    public function add_post()
    {
        (!$this->token->Check_Token("normal", false));
        header("Content-Type: application/json");
        $input = json_decode(file_get_contents('php://input'), true);

        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');

        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
        );
        $res = $this->Emp_model->add($data);
        if (!$res) {
            $this->response(array(
                "status" => false,
                "message" => "unable to add employee"
            ), REST_Controller::HTTP_OK);
        }
        $this->response(array(
            "status" => true,
            "message" => "employee added"
        ), REST_Controller::HTTP_OK);
    }
    public function edit_put($id)
    {
        (!$this->token->Check_Token("normal", false));
        header("Content-Type: application/json");
        $input = json_decode(file_get_contents('php://input'), true);


        $firstname = $this->put('firstname');
        $lastname = $this->put('lastname');
        $email = $this->put('email');
        $phone = $this->put('phone');

        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
        );

        if (!empty($id)) {
            $res = $this->Emp_model->update_emp($id, $data);

            $this->response(array(
                "status" => true,
                "message" => "employee updated"
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                "status" => false,
                "message" => "unable to update employee"
            ), REST_Controller::HTTP_OK);
        }
    }
    public function delete_delete($id)
    {
        (!$this->token->Check_Token("normal", false));
        header("Content-Type: application/json");
        $input = json_decode(file_get_contents('php://input'), true);

        if (!empty($id)) {
            $res = $this->Emp_model->delete($id);

            $this->response(array(
                "status" => true,
                "message" => "employee deleted"
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                "status" => false,
                "message" => "unable to remove employee"
            ), REST_Controller::HTTP_OK);
        }
    }
}
