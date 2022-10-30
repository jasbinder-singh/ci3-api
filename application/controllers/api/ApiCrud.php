<?php
require APPPATH . 'libraries/REST_Controller.php';
class ApiCrud extends REST_Controller
{

    public  function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Authorization", "Content-Type");
        header("Content-Type: application/json");
        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("Dbconnection"));
        $this->load->library("Token");

        // $this->load->model(array("delivery_model"));
        // $this->load->library(array("form_validation"));
        // $this->load->helper("security");
        // $this->load->helper("common");
    }

    public function index_get($id = 0)
    {
        (!$this->token->Check_Token("normal", false));
        header("Content-Type: application/json");
        $input = json_decode(file_get_contents('php://input'), true);



        if (!empty($id)) {
            $data = $this->Dbconnection->select('items', '*', $id);
        } else {
            $data = $this->Dbconnection->select('items', '*');
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        (!$this->token->Check_Token("normal", false));
        header("Content-Type: application/json");

        $input = json_decode(file_get_contents('php://input'), true);
        $title = $this->input->post('title');
        $description = $this->input->post('description');

        $data = array(
            'title' => $title,
            'description' => $description
        );

        $res = $this->Dbconnection->insert('items', $data);
        if ($res) {
            $this->response(array(
                "status" => 1,
                "message" => "item inserted"
            ), REST_Controller::HTTP_OK);
        }
    }
    public function index_put($id = 0)
    {
        (!$this->token->Check_Token("normal", false));
        header("Content-Type: application/json");

        $input = json_decode(file_get_contents('php://input'), true);
        $title = $this->put('title');
        $description = $this->put('description');
        $data = array(
            'title' => $title,
            'description' => $description
        );


        $res = $this->Dbconnection->update_post($id, $data);
        if ($res) {
            $this->response(array(
                "status" => 1,
                "message" => "item updated"
            ), REST_Controller::HTTP_OK);
        }
    }

    public function index_delete($id = 0)
    {
        (!$this->token->Check_Token("normal", false));
        header("Content-Type: application/json");

        $input = json_decode(file_get_contents('php://input'), true);


        $res = $this->Dbconnection->delete($id);
        if ($res) {
            $this->response(array(
                "status" => 1,
                "message" => "item updated"
            ), REST_Controller::HTTP_OK);
        }
    }
    // function dashboard_post()
    // {

    //     $input = json_decode(file_get_contents('php://input'), true);
    //     $company_id = $input['company_id'];

    //     $total_lpdc_pickup = $this->delivery_model->count_lpdc_pickup($company_id);
    //     $total_deliverables = $this->delivery_model->count_deliverables($company_id);
    //     $total_customerpickup = $this->delivery_model->count_customerpickup($company_id);
    //     if (empty($total_lpdc_pickup)) {
    //         $total_lpdc_pickup = 0;
    //     }
    //     if (empty($total_deliverables)) {
    //         $total_deliverables = 0;
    //     }
    //     if (empty($total_customerpickup)) {
    //         $total_customerpickup = 0;
    //     }

    //     $this->response(array(
    //         "status" => 1,
    //         "message" => "LPDC PickUp ",
    //         "lpdc_pickup" => $total_lpdc_pickup,
    //         "deliverables" => $total_deliverables,
    //         "customerpickup" => $total_customerpickup,
    //     ), REST_Controller::HTTP_OK);
    // }

    // function lpdc_pickupcount_get()
    // {
    //     $input = json_decode(file_get_contents('php://input'), true);

    //     //  $org_type = $input['org_type'];
    //     $company_id =  $input['company_id'];
    //     $org_type = 11;
    //     //  $company_id = 4929;
    //     if (11 == $org_type) {
    //         $list_order_count = $this->delivery_model->list_order_details(array('p.dm_company_id' => $company_id, 'oi.order_status_id' => 7), $org_type);
    //     }
    //     // if(count($list_order_count) > 0){ 
    //     //     $this->response(array(
    //     //         "status" => 1,
    //     //         "message" => "Data found",
    //     //         "data" => $list_order_count
    //     //     ), REST_Controller::HTTP_OK);
    //     //     }else{

    //     //     $this->response(array(
    //     //         "status" => 0,
    //     //         "message" => "No Data found",
    //     //         "data" => $list_order_count
    //     //     ), REST_Controller::HTTP_NOT_FOUND);
    //     //     }
    // }

    // public function item_receive_post()
    // {
    //     header("Content-Type: application/json");
    //     $input = json_decode(file_get_contents('php://input'), true);
    //     $order_item_id_replace = $this->security->xss_clean($input['itemCode']);
    //     $dm_company_id = $this->security->xss_clean($input['dm_company_id']);
    //     // $status = $this->security->xss_clean($input['status']);   

    //     $order_item_id = str_replace("P", "", $order_item_id_replace);

    //     if ($order_item_id == '') {
    //         $this->response(array(
    //             "status" => 0,
    //             "message" => "Please enter item code"
    //         ), REST_Controller::HTTP_OK);
    //     } else {
    //         $where = array(
    //             "oi.id" => $order_item_id,
    //             "dm_company_id" => $dm_company_id
    //         );
    //         // already
    //         // $order_itemdetails = $this->dbconnection->select('order_items','*',$data);
    //         $order_itemdetails =  $this->delivery_model->check_item($where);
    //         // print_r($order_itemdetails[0]->order_status_id);
    //         if (empty($order_itemdetails)) {
    //             $this->response(array(
    //                 "status" => 0,
    //                 "message" => "Item code doesn't exists",
    //                 "order_status" => '',        //order status = 20 item received            
    //             ), REST_Controller::HTTP_OK);
    //         } else if (in_array($order_itemdetails[0]->order_status_id, array(19, 3, 9, 10))) {
    //             $this->response(array(
    //                 "status" => 0,
    //                 "message" => "Item code already exists",
    //                 "order_status" => '',        //order status = 20 item received            
    //             ), REST_Controller::HTTP_OK);
    //         } else if ($order_itemdetails[0]->order_status_id == 18) {

    //             $order_id = $order_itemdetails[0]->order_id;
    //             $item_name = $order_itemdetails[0]->item_name;
    //             $order_status_id = $order_itemdetails[0]->order_status_id;

    //             $order_item_data = array(
    //                 'order_item_id' => $order_item_id,
    //                 'order_id' => $order_id,
    //                 'dm_company_id' => $dm_company_id,
    //                 'order_status_id' => $order_status_id
    //             );

    //             $order_item_tracking = $this->dbconnection->select('order_tracking', '*', $order_item_data);

    //             if (empty($order_item_tracking)) {
    //                 $this->response(array(
    //                     "status" => 0,
    //                     "message" => "Please enter valid item code",
    //                     "order_status" => '',        //order status = 20 item received            
    //                 ), REST_Controller::HTTP_OK);
    //             } else {
    //                 $item_details = array(
    //                     'purchase_id'       => $order_item_tracking[0]->purchase_id,
    //                     'order_id'          => $order_item_tracking[0]->order_id,
    //                     'order_item_id'     => $order_item_id,
    //                     'wsc_company_id'    => $order_item_tracking[0]->wsc_company_id,
    //                     'dtc_company_id'    => $order_item_tracking[0]->dtc_company_id,
    //                     'lpdc_company_id'   => $order_item_tracking[0]->lpdc_company_id,
    //                     'dm_company_id'     => $order_item_tracking[0]->dm_company_id,
    //                     'buyer_company_id'  => $order_item_tracking[0]->buyer_company_id,
    //                     'market_region_id'  => $order_item_tracking[0]->market_region_id,
    //                     'seller_company_id' => $order_item_tracking[0]->seller_company_id,
    //                     'created'           => date('Y-m-d h:i:s', time()),
    //                     'order_status_id'  => 19,
    //                 );

    //                 // print_r($item_details);

    //                 $tbl_order_tracking = $this->dbconnection->insert('order_tracking', $item_details);
    //                 // $tbl_purchase=$this->dbconnection->update('purchase',array('order_status_id' =>$status),array('id'=>$purchase_id));  

    //                 // $this->dbconnection->update('order_items', array('order_status_id' => 19),array('order_id'=>$order_id,'id'=>$order_item_id));    
    //                 if ($tbl_order_tracking) {
    //                     $item_details_cu = array(
    //                         'purchase_id'       => $order_item_tracking[0]->purchase_id,
    //                         'order_id'          => $order_item_tracking[0]->order_id,
    //                         'order_item_id'     => $order_item_id,
    //                         'wsc_company_id'    => $order_item_tracking[0]->wsc_company_id,
    //                         'dtc_company_id'    => $order_item_tracking[0]->dtc_company_id,
    //                         'lpdc_company_id'   => $order_item_tracking[0]->lpdc_company_id,
    //                         'dm_company_id'     => $order_item_tracking[0]->dm_company_id,
    //                         'buyer_company_id'  => $order_item_tracking[0]->buyer_company_id,
    //                         'market_region_id'  => $order_item_tracking[0]->market_region_id,
    //                         'seller_company_id' => $order_item_tracking[0]->seller_company_id,
    //                         'created'           => date('Y-m-d h:i:s', time()),
    //                         'order_status_id'  => 9,
    //                     );
    //                     $check_id = $this->dbconnection->insert('order_tracking', $item_details_cu);
    //                     $this->dbconnection->update('order_items', array('order_status_id' => 9), array('order_id' => $order_id, 'id' => $order_item_id));
    //                     $this->dbconnection->update('order', array('order_status_id' => 9), array('purchase_id' => $order_item_tracking[0]->purchase_id));
    //                     $this->response(array(
    //                         "status" => 1,
    //                         "message" => "Item Received",
    //                         "order_status" => 9,        //order status = 20 item received            
    //                     ), REST_Controller::HTTP_OK);
    //                 } else {
    //                     $this->response(array(
    //                         "status" => 0,
    //                         "message" => "Not Receievd",
    //                         "order_status" => '',
    //                     ), REST_Controller::HTTP_OK);
    //                 }
    //             }
    //         } else {
    //             $this->response(array(
    //                 "status" => 0,
    //                 "message" => "Item code doesn't exists",
    //                 "order_status" => '',        //order status = 20 item received            
    //             ), REST_Controller::HTTP_OK);
    //         }
    //     }
    // }

    // function item_validation()
    // {
    // }


    // public function order_list_post()
    // {
    //     header("Content-Type: application/json");
    //     $input = json_decode(file_get_contents('php://input'), true);
    //     $company_id = $this->security->xss_clean($input['company_id']);
    //     $org_type = 11;
    //     $order_det = $this->delivery_model->getMyOrders($company_id, $org_type);
    //     $list_order_det_ = $this->delivery_model->list_order_details(array('p.dm_company_id' => $company_id), array('19', '9'), $org_type);
    //     foreach ($list_order_det_ as $list_order_dett) {
    //         $list_order_det[] = array(
    //             'order_id' => $list_order_dett->order_id,
    //             'purchase_id' => $list_order_dett->purchase_id,
    //             'item_quantity' => $list_order_dett->item_quantity,
    //             'first_name' => $list_order_dett->first_name,
    //             'last_name' => $list_order_dett->last_name,
    //             'item_price' => trim(($list_order_dett->order_total) + ($list_order_dett->tip + $list_order_dett->delivery_charge)),
    //             'order_status_id' => $list_order_dett->order_status_id,
    //             'contact_no' => $list_order_dett->contact_no,
    //             'status_name' => $list_order_dett->status_name,
    //             'city' => $list_order_dett->city,
    //             'state' => $list_order_dett->state,
    //             'address1' => $list_order_dett->address1,
    //             'latitude' => $list_order_dett->latitude,
    //             'longitude' => $list_order_dett->longitude,
    //             'order_date' => $list_order_dett->order_date,
    //             'item_name' => $list_order_dett->item_name,
    //             'market_region_id' => $list_order_dett->market_region_id,
    //             'order_item_id' => $list_order_dett->order_item_id,
    //             'wsc_company_id' => $list_order_dett->wsc_company_id,
    //             'dtc_company_id' => $list_order_dett->dtc_company_id,
    //             'lpdc_company_id' => $list_order_dett->lpdc_company_id,
    //             'buyer_company_id' => $list_order_dett->buyer_company_id,
    //             'dm_company_id' => $list_order_dett->dm_company_id,
    //         );
    //     };
    //     $this->response(array(
    //         'list_order_det' =>   $list_order_det
    //     ), REST_Controller::HTTP_OK);
    // }

    // public function order_details_post()
    // {
    //     header("Content-Type: application/json");
    //     $input = json_decode(file_get_contents('php://input'), true);
    //     $company_id = $this->security->xss_clean($input['company_id']);
    //     $purchase_id = $this->security->xss_clean($input['purchase_id']);
    //     $order_item_id = $this->security->xss_clean($input['order_item_id']);

    //     $org_type = 11;
    //     $order_details = $this->delivery_model->getMyOrderDetails($company_id, $purchase_id, $org_type, $order_item_id);

    //     $this->response(array(
    //         'order_details' => $order_details
    //     ), REST_Controller::HTTP_OK);
    // }


    // public function item_received_customer_post()
    // {
    //     // recived by customer order status id 12 and failed order status id 3
    //     header("Content-Type: application/json");
    //     $input = json_decode(file_get_contents('php://input'), true);
    //     $img = $this->security->xss_clean($input['img']);
    //     $dm_company_id = $this->security->xss_clean($input['company_id']);
    //     $purchase_id = $this->security->xss_clean($input['purchase_id']);
    //     $reason = $this->security->xss_clean($input['reason']);
    //     $comments = $this->security->xss_clean($input['comments']);
    //     $order_item_id = $this->security->xss_clean($input['order_item_id']);
    //     $order_status_id_ = $this->security->xss_clean($input['order_status_id']);
    //     if ($order_item_id == '') {
    //         $this->response(array(
    //             "status" => 0,
    //             "message" => "Please enter item code"
    //         ), REST_Controller::HTTP_OK);
    //     } else {
    //         // In Transit to customer order status id 9 check condition
    //         $data = array(
    //             "id"     => $order_item_id,
    //             "return_status"   => "1",
    //         );
    //         $order_itemdetails = $this->dbconnection->select('order_items', '*', $data);
    //         $order_id = $order_itemdetails[0]->order_id;
    //         $item_name = $order_itemdetails[0]->item_name;
    //         $order_status_id = $order_itemdetails[0]->order_status_id;
    //         $order_item_data = array(
    //             'order_item_id' => $order_item_id,
    //             'order_id' => $order_id,
    //             'dm_company_id' => $dm_company_id,
    //             'order_status_id' => $order_status_id
    //         );
    //         $order_item_tracking = $this->dbconnection->select('order_tracking', '*', $order_item_data);


    //         if ($order_itemdetails[0]->order_status_id == 19) {

    //             if (empty($order_item_tracking)) {
    //                 $this->response(array(
    //                     "status" => 0,
    //                     "message" => "Please enter valid item code",
    //                     "order_status" => '',        //order status = 20 item received            
    //                 ), REST_Controller::HTTP_OK);
    //             } else {
    //                 $item_details = array(
    //                     'purchase_id'       => $order_item_tracking[0]->purchase_id,
    //                     'order_id'          => $order_item_tracking[0]->order_id,
    //                     'order_item_id'     => $order_item_id,
    //                     'wsc_company_id'    => $order_item_tracking[0]->wsc_company_id,
    //                     'dtc_company_id'    => $order_item_tracking[0]->dtc_company_id,
    //                     'lpdc_company_id'   => $order_item_tracking[0]->lpdc_company_id,
    //                     'dm_company_id'     => $order_item_tracking[0]->dm_company_id,
    //                     'reason'            => $order_status_id == 3 ? $reason : null,
    //                     'comments'          => $order_status_id == 3 ? $comments : null,
    //                     'buyer_company_id'  => $order_item_tracking[0]->buyer_company_id,
    //                     'market_region_id'  => $order_item_tracking[0]->market_region_id,
    //                     'seller_company_id' => $order_item_tracking[0]->seller_company_id,
    //                     'created'           => date('Y-m-d h:i:s', time()),
    //                     'order_status_id'  => 9,
    //                 );


    //                 $check = $this->dbconnection->insert('order_tracking', $item_details);

    //                 if ($check) {
    //                     $item_details = array(
    //                         'purchase_id'       => $order_item_tracking[0]->purchase_id,
    //                         'order_id'          => $order_item_tracking[0]->order_id,
    //                         'order_item_id'     => $order_item_id,
    //                         'wsc_company_id'    => $order_item_tracking[0]->wsc_company_id,
    //                         'dtc_company_id'    => $order_item_tracking[0]->dtc_company_id,
    //                         'lpdc_company_id'   => $order_item_tracking[0]->lpdc_company_id,
    //                         'dm_company_id'     => $order_item_tracking[0]->dm_company_id,
    //                         'reason'            => $order_status_id == 3 ? $reason : null,
    //                         'comments'          => $order_status_id == 3 ? $comments : null,
    //                         'buyer_company_id'  => $order_item_tracking[0]->buyer_company_id,
    //                         'market_region_id'  => $order_item_tracking[0]->market_region_id,
    //                         'seller_company_id' => $order_item_tracking[0]->seller_company_id,
    //                         'created'           => date('Y-m-d h:i:s', time()),
    //                         'order_status_id'  => $order_status_id_,
    //                     );


    //                     $tbl_order_tracking = $this->dbconnection->insert('order_tracking', $item_details);
    //                 }
    //             }
    //         } else if ($order_itemdetails[0]->order_status_id == 9) {

    //             if (empty($order_item_tracking)) {
    //                 $this->response(array(
    //                     "status" => 0,
    //                     "message" => "Please enter valid item code",
    //                     "order_status" => '',        //order status = 20 item received            
    //                 ), REST_Controller::HTTP_OK);
    //             } else {
    //                 $item_details = array(
    //                     'purchase_id'       => $order_item_tracking[0]->purchase_id,
    //                     'order_id'          => $order_item_tracking[0]->order_id,
    //                     'order_item_id'     => $order_item_id,
    //                     'wsc_company_id'    => $order_item_tracking[0]->wsc_company_id,
    //                     'dtc_company_id'    => $order_item_tracking[0]->dtc_company_id,
    //                     'lpdc_company_id'   => $order_item_tracking[0]->lpdc_company_id,
    //                     'dm_company_id'     => $order_item_tracking[0]->dm_company_id,
    //                     'reason'            => $order_status_id == 3 ? $reason : null,
    //                     'comments'          => $order_status_id == 3 ? $comments : null,
    //                     'buyer_company_id'  => $order_item_tracking[0]->buyer_company_id,
    //                     'market_region_id'  => $order_item_tracking[0]->market_region_id,
    //                     'seller_company_id' => $order_item_tracking[0]->seller_company_id,
    //                     'created'           => date('Y-m-d h:i:s', time()),
    //                     'order_status_id'  => $order_status_id_,
    //                 );


    //                 $tbl_order_tracking = $this->dbconnection->insert('order_tracking', $item_details);
    //             }
    //         }

    //         if ($tbl_order_tracking) {
    //             $return_status = ($order_status_id_ == 3) ? '1' : '2';
    //             $this->dbconnection->update('order_items', array('order_status_id' => $order_status_id_, 'return_status' => $return_status), array('order_id' => $order_id, 'id' => $order_item_id));
    //             $this->dbconnection->update('order', array('order_status_id' => $order_status_id_), array('purchase_id' => $order_item_tracking[0]->purchase_id));
    //             $this->dbconnection->update('purchase', array('order_status_id' => $order_status_id_), array('id' => $order_item_tracking[0]->purchase_id));

    //             // recived by customer order status id 12 and failed order status id 3
    //             if ($order_status_id_ == 10) {
    //                 $this->dbconnection->insert('dm_took_picture', array('item_id' => $order_item_id, 'img' => $img, 'created' => date('Y-m-d h:i:s', time())));
    //             }
    //             $this->response(array(
    //                 "status" => 1,
    //                 "message" => "Item Received",
    //                 "order_status" => $order_status_id_,
    //             ), REST_Controller::HTTP_OK);
    //         } else {
    //             $this->response(array(
    //                 "status" => 0,
    //                 "message" => "Not Receievd",
    //                 "order_status" => '',
    //             ), REST_Controller::HTTP_OK);
    //         }
    //     }
    // }

    // function list_history_post()
    // {
    //     header("Content-Type: application/json");
    //     $input = json_decode(file_get_contents('php://input'), true);
    //     $company_id = $this->security->xss_clean($input['company_id']);
    //     $status = $this->security->xss_clean($input['status']);
    //     $org_type = 11;
    //     if ($status == 1) {
    //         $list_order_det = $this->delivery_model->list_order_history_details(array('p.dm_company_id' => $company_id), array('10', '3'), $org_type);
    //     }
    //     if ($status == 2) {
    //         $list_order_det = $this->delivery_model->list_order_history_details(array('p.dm_company_id' => $company_id), array('20', '22'), $org_type);
    //     }
    //     $this->response(array(
    //         'list_order_det' =>   $list_order_det
    //     ), REST_Controller::HTTP_OK);
    // }

    // function order_tracking_status_post()
    // {
    //     header("Content-Type: application/json");
    //     $input = json_decode(file_get_contents('php://input'), true);
    //     $company_id = $this->security->xss_clean($input['company_id']);
    //     $purchase_id = $this->security->xss_clean($input['purchase_id']);
    //     $order_id = $this->security->xss_clean($input['order_id']);
    //     $order_item_id = $this->security->xss_clean($input['order_item_id']);
    //     $org_type = 11;


    //     $order_item_tracking = $this->delivery_model->get_order_item_tracking($purchase_id, $order_id, $order_item_id);

    //     $dsp_wsc_receive_time = '';
    //     $dsp_wsc_ship_time = '';
    //     $dsp_dtc_receive_time = '';
    //     $dsp_dtc_ship_time = '';
    //     $dsp_lpdc_receive_time = '';
    //     $dsp_lpdc_ship_time = '';
    //     if (!empty($order_item_tracking)) {
    //         foreach ($order_item_tracking as $key => $value) {
    //             if ($key == 1) {
    //                 $dsp_wsc_receive_time = "Received: " . get_common_date_format($value->created, 'with_time');
    //             }
    //             if ($key == 5) {
    //                 $dsp_wsc_ship_time = "Shipped: " . get_common_date_format($value->created, 'with_time');
    //             }
    //             if ($key == 6) {
    //                 $dsp_dtc_receive_time = "Received: " . get_common_date_format($value->created, 'with_time');
    //             }
    //             if ($key == 7) {
    //                 $dsp_dtc_ship_time = "Shipped: " . get_common_date_format($value->created, 'with_time');
    //             }
    //             if ($key == 8) {
    //                 $dsp_lpdc_receive_time = "Received: " . get_common_date_format($value->created, 'with_time');
    //             }
    //             if ($key == 18) {
    //                 $dsp_lpdc_ship_time = "Shipped: " . get_common_date_format($value->created, 'with_time');
    //             }
    //             if ($key == 19) {
    //                 $dsp_dm_receive_time = "Received: " . get_common_date_format($value->created, 'with_time');
    //             }
    //             if ($key == 10) {
    //                 $dsp_dm_ship_time = "Delivered: " . get_common_date_format($value->created, 'with_time');
    //             }
    //         }

    //         $order_tracking_date = array(
    //             'dsp_wsc_receive_time' => $dsp_wsc_receive_time,
    //             'dsp_wsc_ship_time' => $dsp_wsc_ship_time,
    //             'dsp_dtc_receive_time' => $dsp_dtc_receive_time,
    //             'dsp_dtc_ship_time' => $dsp_dtc_ship_time,
    //             'dsp_lpdc_ship_time' => $dsp_lpdc_ship_time,
    //         );
    //     }

    //     $this->response(array(
    //         'order_tracking_date' => $order_tracking_date,
    //         'order_tracking' =>   $order_item_tracking
    //     ), REST_Controller::HTTP_OK);
    // }


    // function return_pick_up_list_post()
    // {
    //     header("Content-Type: application/json");
    //     $input = json_decode(file_get_contents('php://input'), true);
    //     $company_id = $this->security->xss_clean($input['company_id']);
    //     $org_type = 11;
    //     $order_det = $this->delivery_model->getMyOrders($company_id, $org_type);
    //     $list_order_det = $this->delivery_model->list_order_details(array('ot.dm_company_id' => $company_id), array('11'), $org_type);
    //     $this->response(array(
    //         'list_order_det' =>   $list_order_det
    //     ), REST_Controller::HTTP_OK);
    // }


    // public function return_item_pickup_dm_post()
    // {
    //     // recived by customer order status id 12 and failed order status id 3
    //     header("Content-Type: application/json");
    //     $input = json_decode(file_get_contents('php://input'), true);
    //     $img = $this->security->xss_clean($input['img']);
    //     $dm_company_id = $this->security->xss_clean($input['company_id']);
    //     $purchase_id = $this->security->xss_clean($input['purchase_id']);
    //     $reason = $this->security->xss_clean($input['reason']);
    //     $comments = $this->security->xss_clean($input['comments']);
    //     $order_item_id = $this->security->xss_clean($input['order_item_id']);
    //     $order_status_id_ = $this->security->xss_clean($input['order_status_id']);
    //     if ($order_item_id == '') {
    //         $this->response(array(
    //             "status" => 0,
    //             "message" => "Please enter item code"
    //         ), REST_Controller::HTTP_OK);
    //     } else {
    //         // In Transit to customer order status id 9 check condition
    //         $data = array(
    //             "id"     => $order_item_id,
    //             "order_status_id"   => 11,
    //         );
    //         $order_itemdetails = $this->dbconnection->select('order_items', '*', $data);

    //         if (empty($order_itemdetails)) {
    //             $this->response(array(
    //                 "status" => 0,
    //                 "message" => "Item code already exists",
    //                 "order_status" => '',
    //             ), REST_Controller::HTTP_OK);
    //         } else {
    //             $order_id = $order_itemdetails[0]->order_id;
    //             $item_name = $order_itemdetails[0]->item_name;
    //             $order_status_id = $order_itemdetails[0]->order_status_id;

    //             $order_item_data = array(
    //                 'order_item_id' => $order_item_id,
    //                 'order_id' => $order_id,
    //                 'dm_company_id' => $dm_company_id,
    //                 'order_status_id' => $order_status_id
    //             );

    //             $order_item_tracking = $this->dbconnection->select('order_tracking', '*', $order_item_data);
    //             if (empty($order_item_tracking)) {
    //                 $this->response(array(
    //                     "status" => 0,
    //                     "message" => "Please enter valid item code",
    //                     "order_status" => '',        //order status = 20 item received            
    //                 ), REST_Controller::HTTP_OK);
    //             } else {
    //                 if ($order_status_id_ == 21) {
    //                     $item_details = array(
    //                         'purchase_id'       => $order_item_tracking[0]->purchase_id,
    //                         'order_id'          => $order_item_tracking[0]->order_id,
    //                         'order_item_id'     => $order_item_id,
    //                         'wsc_company_id'    => $order_item_tracking[0]->wsc_company_id,
    //                         'dtc_company_id'    => $order_item_tracking[0]->dtc_company_id,
    //                         'lpdc_company_id'   => $order_item_tracking[0]->lpdc_company_id,
    //                         'dm_company_id'     => $order_item_tracking[0]->dm_company_id,
    //                         'reason'            => $order_status_id == 3 ? $reason : null,
    //                         'comments'          => $order_status_id == 3 ? $comments : null,
    //                         'buyer_company_id'  => $order_item_tracking[0]->buyer_company_id,
    //                         'market_region_id'  => $order_item_tracking[0]->market_region_id,
    //                         'seller_company_id' => $order_item_tracking[0]->seller_company_id,
    //                         'created'           => date('Y-m-d h:i:s', time()),
    //                         'order_status_id'  => 20,
    //                     );


    //                     $check = $this->dbconnection->insert('order_tracking', $item_details);

    //                     if ($check) {
    //                         $item_details = array(
    //                             'purchase_id'       => $order_item_tracking[0]->purchase_id,
    //                             'order_id'          => $order_item_tracking[0]->order_id,
    //                             'order_item_id'     => $order_item_id,
    //                             'wsc_company_id'    => $order_item_tracking[0]->wsc_company_id,
    //                             'dtc_company_id'    => $order_item_tracking[0]->dtc_company_id,
    //                             'lpdc_company_id'   => $order_item_tracking[0]->lpdc_company_id,
    //                             'dm_company_id'     => $order_item_tracking[0]->dm_company_id,
    //                             'reason'            => $order_status_id == 3 ? $reason : null,
    //                             'comments'          => $order_status_id == 3 ? $comments : null,
    //                             'buyer_company_id'  => $order_item_tracking[0]->buyer_company_id,
    //                             'market_region_id'  => $order_item_tracking[0]->market_region_id,
    //                             'seller_company_id' => $order_item_tracking[0]->seller_company_id,
    //                             'created'           => date('Y-m-d h:i:s', time()),
    //                             'order_status_id'  => $order_status_id_,
    //                         );


    //                         $tbl_order_tracking = $this->dbconnection->insert('order_tracking', $item_details);
    //                     }
    //                 } else {
    //                     $item_details = array(
    //                         'purchase_id'       => $order_item_tracking[0]->purchase_id,
    //                         'order_id'          => $order_item_tracking[0]->order_id,
    //                         'order_item_id'     => $order_item_id,
    //                         'wsc_company_id'    => $order_item_tracking[0]->wsc_company_id,
    //                         'dtc_company_id'    => $order_item_tracking[0]->dtc_company_id,
    //                         'lpdc_company_id'   => $order_item_tracking[0]->lpdc_company_id,
    //                         'dm_company_id'     => $order_item_tracking[0]->dm_company_id,
    //                         'reason'            => $order_status_id == 3 ? $reason : null,
    //                         'comments'          => $order_status_id == 3 ? $comments : null,
    //                         'buyer_company_id'  => $order_item_tracking[0]->buyer_company_id,
    //                         'market_region_id'  => $order_item_tracking[0]->market_region_id,
    //                         'seller_company_id' => $order_item_tracking[0]->seller_company_id,
    //                         'created'           => date('Y-m-d h:i:s', time()),
    //                         'order_status_id'  => $order_status_id_,
    //                     );


    //                     $tbl_order_tracking = $this->dbconnection->insert('order_tracking', $item_details);
    //                 }
    //                 if ($tbl_order_tracking) {
    //                     $this->dbconnection->update('order_items', array('order_status_id' => $order_status_id_), array('order_id' => $order_id, 'id' => $order_item_id));
    //                     $this->dbconnection->update('order', array('order_status_id' => $order_status_id_), array('purchase_id' => $order_item_tracking[0]->purchase_id));
    //                     $this->dbconnection->update('purchase', array('order_status_id' => $order_status_id_), array('id' => $order_item_tracking[0]->purchase_id));

    //                     // recived by customer order status id 12 and failed order status id 3
    //                     if ($order_status_id_ == 12) {
    //                         $this->dbconnection->insert('dm_took_picture', array('item_id' => $order_item_id, 'img' => $img, 'created' => date('Y-m-d h:i:s', time())));
    //                     }
    //                     $this->response(array(
    //                         "status" => 1,
    //                         "message" => "Item Received",
    //                         "order_status" => $order_status_id_,
    //                     ), REST_Controller::HTTP_OK);
    //                 } else {
    //                     $this->response(array(
    //                         "status" => 0,
    //                         "message" => "Not Receievd",
    //                         "order_status" => '',
    //                     ), REST_Controller::HTTP_OK);
    //                 }
    //             }
    //         }
    //     }
    // }
}
