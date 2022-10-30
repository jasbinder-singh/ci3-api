<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Handles common functions.
 *
 * @package	CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */
// ------------------------------------------------------------------------

class Common_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* common function to select data as array */
    function get_data($table, $fields = '*', $where = array(), $order_by = '', $limit = '')
    {
        if ((is_array($where) && count($where) > 0) or (!is_array($where) && trim($where) != ''))
            $this->db->where($where);
        if ($order_by)
            $this->db->order_by($order_by);
        if ($limit)
            $this->db->limit($limit);
        $this->db->select($fields);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    /* common function to select data as row */
    function get_row_data($table, $fields = '*', $where = array(), $order_by = '')
    {
        if ((is_array($where) && count($where) > 0) or (!is_array($where) && trim($where) != ''))
            $this->db->where($where);
        if ($order_by)
            $this->db->order_by($order_by);
        $this->db->select($fields);
        $query = $this->db->get($table);
        return $query->row();
    }

    /* common insert function */
    function save($table, $data)
    {
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        return $id;
    }

    /* common update function */
    function update($table, $data, $where)
    {
        if (!empty($data)) {
            if ($where != '')
                $this->db->where($where);
            $this->db->set($data);
            if ($this->db->update($table)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    /* common delete function */
    function delete($table, $where = array())
    {
        if (!empty($table)) {
            if ($this->db->delete($table, $where)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function getCountryName($countryid)
    {
        $this->db->select('country');
        $this->db->from('country');
        $this->db->where('id', $countryid);
        $query = $this->db->get();
        if ($query->row()) {
            $result = $query->row();
            return $result->country;
        } else {
            return false;
        }
    }
    function get_site_config($config)
    {
        $this->db->select('value');
        $this->db->from('site_config');
        $this->db->where('config', $config);
        $this->db->where('status', 'A');
        $query = $this->db->get();
        if ($query->row()) {
            $result = $query->row();
            return $result->value;
        } else {
            return false;
        }
    }

    /* function to get the latitude and longitude from address */
    public function getLL_from_addr($addr)
    {

        $this->load->library('curl');
        $points = array();

        $api_base_url = "http://dev.virtualearth.net/REST/v1/Locations?";
        $qstring = "";
        if (!empty($addr)) {
            $qstring .= "&query=" . urlencode($addr);
        }
        $qstring .= "&key=" . c('bing_map_api_key');
        $api_url = $api_base_url . $qstring;

        $ll_data = json_decode($this->curl->simple_get($api_url));
        if ($ll_data) {
            foreach ($ll_data->resourceSets as $lld) {
                foreach ($lld->resources as $llr) {
                    $points['lat'] = $llr->point->coordinates[0];
                    $points['long'] = $llr->point->coordinates[1];
                }
            }
        }
        return $points;
    }
    /*-------- Get all countries---------*/
    function getcountries()
    {
        return $this->db->get('ub_countries')->result_array();
    }

    /*-------- Get all states---------*/
    function getstates()
    {
        return $this->db->get('ub_state')->result_array();
    }

    function getProfileHeader($user_id = 0)
    {
        $this->db->select('company_name, type_description,company_logo_url, company_type_id, s.store_logo, s.default_store, c.warehouse_status, c.id as company_id');
        $this->db->from('user u');
        $this->db->join('company c', 'c.id = u.company_id', 'left');
        $this->db->join('user_type ut', 'ut.id = u.user_type_id', 'left');
        $this->db->join('subdomains s', 's.store_admin_company_id = c.id', 'left');
        $this->db->where('u.id', $user_id);
        $query = $this->db->get();
        if ($query->row()) {
            $result = $query->row();
            return $result;
        } else {
            return false;
        }
    }
    // ..........start naresh changes.......... 20/12/2019
    function totalSize_insert($data)
    {
        $this->db->insert('ub_warehouse_storage', $data);
    }
    // ..........end naresh changes.......... 20/12/2019

    //  26-03-2021 abhinay
    function count($table, $where = '', $likearr = array(), $or_likearr = array())
    {
        if ($where != '') {
            $this->db->where($where);
        }

        if (is_array($likearr) && count($likearr) > 0) {
            $this->db->group_start();
            foreach ($likearr as $like) {
                $this->db->like($like['col'], $or_like['val']);
            }
            $this->db->group_end();
        }

        if (is_array($or_likearr) && count($or_likearr) > 0) {
            $this->db->group_start();
            foreach ($or_likearr as $or_like) {
                $this->db->or_like($or_like['col'], $or_like['val']);
            }
            $this->db->group_end();
        }

        $this->db->from($table);

        return $this->db->count_all_results();
    }



    //  26-03-2021 abhinay 
}
