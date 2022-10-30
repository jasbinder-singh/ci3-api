<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Token
{

    public function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }


    function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        // print_r($headers);
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                // return $matches[1];
                // $my_product_details = $CI->common_model->get_row_data('ub_tokens', '*', array('isactive' => 1));
                //  $CheckToken = $CI->Dbconnection->get_row_data('ub_tokens', '*');

                // if ($CheckToken->token == $matches[1]) {
                //     return true;
                // } else {
                //     return false;
                // }

                return $matches[1];
            }
        }
        return null;
    }



    function Check_Token($user_type = "", $status = '', $type = '', $step = 0, $user_step = 0, $check_incomplete_step = 1, $redirect = 1, $popup = false)
    {

        $Token = $this->getBearerToken();
        switch ($user_type) {
            case "normal":
                $CI = &get_instance();
                $CI->load->model('Dbconnection');
                $CheckToken = $CI->Dbconnection->get_row_data('api_keys', '*');
                if ($CheckToken->my_key == $Token) {
                    return true;
                    echo "hello";
                } else {
                    $response = array(
                        'Message' => 'invalid token',
                        'status' => 0,
                    );
                    $response_ = json_encode($response);
                    print_r($response_);

                    die();
                }
        }
    }
}
