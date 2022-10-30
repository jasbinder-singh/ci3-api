<?php
class Emp_model extends CI_Model
{
    public function get_employees()
    {
        $this->db->select('*');
        $this->db->from('emp');
        $query = $this->db->get()->result();
        return $query;
    }



    public function get_emp_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('emp');
        $this->db->where('id', $id);

        $query = $this->db->get()->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }


    // public function postsByUser($user_id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('post');
    //     $this->db->where('user_id', $user_id);

    //     $query = $this->db->get()->result();

    //     return $query;
    // }



    // public function single_user_post($post_id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('post');
    //     $this->db->where('post_id', $post_id);

    //     $query = $this->db->get()->result();
    //     return $query;
    // }


    public function delete($id)
    {
        $query =  $this->db->where('id', $id)->delete('emp');
        if ($query) {
            return true;
        } else {
            return false;
        }
    }



    public function add($data)
    {
        $query = $this->db->insert('emp', $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }



    public function update_emp($id, $data)
    {
        $query = $this->db->where('id', $id)->update('emp', $data);
        if ($query) {
            return true;
        } else {
            // return false;
            echo 'kahdja';
        }
    }
}
