<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dbconnection extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $db = $this->load->database();
    }



    function insert($table, $data)
    {
        $res = $this->db->insert($table, $data);
        if ($res) {
            return true;
        } else {
            return $this->db->_error_message();
        }
    }

    function select($table, $select, $where = '', $order = '', $order_type = 'ASC')
    {
        $this->db->select($select);
        $this->db->from($table);
        if ($where != '') {
            $this->db->where($where);
        }
        if ($order != '') {
            $this->db->order_by($order, $order_type);
        }

        $query = $this->db->get();

        return $query->result();
    }

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



    public function update_post($id, $data)
    {
        $query = $this->db->where('id', $id)->update('items', $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    function update($table, $data, $where)
    {
        $res = $this->db->update($table, $data, $where);
        if ($res) {
            return true;
        } else {
            return $this->db->_error_message();
        }
    }

    public function delete($post_id)
    {
        $query =  $this->db->where('id', $post_id)->delete('items');
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    // function delete($table, $where = array())
    // {
    //     $res = $this->db->delete($table, $where);
    //     if ($res) {
    //         return true;
    //     } else {
    //         return $this->db->_error_message();
    //     }
    // }

    // function get_last_id()
    // {
    //     return $this->db->insert_id();
    // }


    // function select_limit_query($table, $select, $where, $order, $limit, $offset = '', $likearr = array(), $or_likearr = array())
    // {
    //     $this->db->select($select);
    //     $this->db->from($table);
    //     if ($where != '') $this->db->where($where);


    //     if (is_array($likearr) && count($likearr) > 0) {
    //         $this->db->group_start();
    //         foreach ($likearr as $like) {
    //             $this->db->like($like['col'], $or_like['val']);
    //         }
    //         $this->db->group_end();
    //     }
    //     if (is_array($or_likearr) && count($or_likearr) > 0) {
    //         $this->db->group_start();
    //         foreach ($or_likearr as $or_like) {
    //             $this->db->or_like($or_like['col'], $or_like['val']);
    //         }
    //         $this->db->group_end();
    //     }

    //     $this->db->order_by($order);
    //     if ($offset != '') {
    //         $this->db->limit($limit, $offset);
    //     } else {
    //         $this->db->limit($limit);
    //     }
    //     $query = $this->db->get();

    //     return $query->result();
    // }

    // public function get_table_data($table_name, $col_to_fetch, $col_val_arr)
    // {
    //     $this->db->select($col_to_fetch);
    //     $this->db->from($table_name);
    //     $this->db->where($col_val_arr);
    //     return $this->db->get()->row()->$col_to_fetch;
    // }
    // public function Get_namme($tablename, $tbl_pk, $tbl_pk_value, $col_name)
    // {
    //     $this->db->select($col_name);
    //     $this->db->from($tablename);
    //     $this->db->where($tbl_pk, $tbl_pk_value);
    //     $query = $this->db->get();
    //     if ($query->num_rows() > 0) {
    //         $value = $query->row()->$col_name;
    //     } else {
    //         $value = '';
    //     }
    //     return $value;
    // }
    // function get_subject_name_by_id($subject_id)
    // {
    //     $query    =    $this->db->get_where('subject', array('id' => $subject_id))->row();
    //     return $query->name;
    // }
    // function get_section_name_by_id($section_id)
    // {
    //     $query    =    $this->db->get_where('section', array('id' => $section_id))->row();
    //     return $query->sec_name;
    // }
    // function get_subject($class_id, $section_id)
    // {
    //     $query = $this->db->query("SELECT t1.subject_id,t2.teacher_id,t3.name,t4.name as teacher_name,t5.class_name,t6.sec_name FROM `class_routine` as t1 left join `class_subject_teacher` as t2 on t2.subject_id = t1.subject_id AND t2.class_id=t1.class_id AND t2.section_id = t1.section_id left join `subject` as t3 on t3.id = t1.subject_id left join `employee` as t4 on t4.id = t2.teacher_id left join `class` as t5 on t5.id=t1.class_id left join section as t6 on t1.section_id = t6.id WHERE  t1.class_id=$class_id AND t1.section_id=$section_id AND t1.status= 1 GROUP BY t1.subject_id HAVING t1.subject_id>0");
    //     return $query->result();
    // }
    // function selectexam($examid)
    // {
    //     $query = $this->db->query("SELECT * FROM `exam` WHERE id=$examid");
    //     return $query->result();
    // }
    // function GetRoutine($class_id, $sect_id, $day, $date)
    // {

    //     $this->db->select('t1.*,t2.name as subjectname,t3.teacher_id,t4.name as teachername,t6.name as assignedteacher');
    //     $this->db->from('class_routine as t1');
    //     $this->db->join('subject as t2', 't2.id = t1.subject_id', 'left');
    //     $this->db->join('class_subject_teacher as t3', 't3.class_id = t1.class_id AND t3.section_id=t1.section_id AND t3.subject_id=t1.subject_id', 'left');
    //     $this->db->join('employee as t4', 't4.id = t3.teacher_id', 'left');
    //     $this->db->join('class_substitute_routine as t5', 't5.class_routine_id = t1.id AND t5.status=1 AND t5.date="' . $date . '"', 'left');
    //     $this->db->join('employee as t6', 't6.id=t5.teacher_id', 'left');

    //     $this->db->where('t1.day', $day);
    //     $this->db->where('t1.class_id', $class_id);
    //     $this->db->where('t1.section_id', $sect_id);
    //     $this->db->where('t1.status', '1');
    //     $this->db->ORDER_BY('t1.time_start');
    //     $query = $this->db->get();
    //     $row = $query->result_array();
    //     return $row;
    // }
    // function get_marks($class_id, $section_id, $student_id, $examid)
    // {
    //     $query = $this->db->query("SELECT t1.id,t1.class_id,t4.name as subjectname,t1.section_id,t2.mark_id,t2.mark_obtained,t2.mark_total,t3.pass_mark FROM `class_routine` as t1 left join `mark` as t2 on  t2.student_id=$student_id AND t2.class_id = t1.class_id AND t2.subject_id=t1.subject_id AND t2.exam_id=$examid left join `exam` as t3 on t3.id=t2.exam_id left join `subject` as t4 on t1.subject_id = t4.id WHERE t1.class_id=$class_id AND t1.section_id=$section_id AND t1.status= 1 GROUP BY t1.subject_id HAVING t1.subject_id>0");
    //     return $query->result();
    // }


    // function get_max_value($col_name, $rename, $table, $where = '')
    // {
    //     $this->db->select_max($col_name, $rename);
    //     $this->db->from($table);
    //     if ($where != '') {
    //         $this->db->where($where);
    //     }
    //     $max_value = $this->db->get()->row()->$rename;
    //     return $max_value;
    // }



    function fetch_information($table, $col_fetch_by, $col_fetch_condition, $fetch_col1 = '', $fetch_col2 = '', $fetch_col3 = '', $fetch_col4 = '', $fetch_col5 = '')
    {

        $fetched_data = $this->dbconnection->select("$table", "$fetch_col1,$fetch_col2,$fetch_col3,$fetch_col4,$fetch_col5", "$col_fetch_by=$col_fetch_condition");
        echo json_encode($fetched_data);
    }


    function GetTotalStudent($cid, $secti)
    {
        $sect = trim($secti);
        $query = $this->db->query("SELECT t2.* from `section` as t1 JOIN `student` as t2 ON t2.section_id = t1.id WHERE t1.sec_name= '$sect' AND t2.class_id= '$cid' AND t2.section_id=t1.id AND t2.status='Y' AND t1.status='Y'");
        $sql = $this->db->last_query();
        /*$row = $query->row_array(); */
        return $query->num_rows();
    }
    function GetSubjectTeacher($clsid, $secid, $subid)
    {
        $querya = $this->db->query("SELECT t2.* FROM `class_subject_teacher` as t1 join `employee` as t2 ON t2.id=t1.teacher_id WHERE t1.class_id = $clsid AND t1.section_id = $secid AND t1.subject_id = $subid AND t1.status = '1'");
        $rowa = $querya->num_rows();
        if ($rowa > 0) {
            $datas = $querya->row();
            $name = $datas->name;
        } else {
            $name = '';
        }
        return $name;
    }

    function GetSubjectName($cid, $sid, $day)
    {
        $query = $this->db->query("SELECT t2.*,t1.id as crid,t3.time_start,t3.time_start_min,t3.time_end,t3.time_end_min FROM `class_routine` as t1 join `subject` as t2 on t2.id = t1.subject_id left join `class_periods` as t3 on t3.id = t1.period_id WHERE t1.class_id =$cid AND t1.section_id =$sid AND t1.status= 1 AND t2.status = 1 AND t1.day='$day'");

        $datas = $query->result_array();
        return $datas;
    }

    function GetSubjectLists($class_id, $subject_id)
    {
        $query = $this->db->query("SELECT t2.id,t2.name FROM class_routine as t1 join subject as t2 on t2.id = t1.subject_id WHERE t1.class_id=$class_id AND t1.section_id=$subject_id GROUP BY t1.subject_id HAVING t1.subject_id>0");
        return $query->result();
    }


    function selectasteacher()
    {
        $query = $this->db->query("SELECT t1.teacher_id,t1.id as idss,t1.date,t1.remarks,t1.status,t2.name,t3.*,t4.class_name,t5.name as subject,t6.sec_name,t7.time_start as tstart,t7.time_start_min as tstart_min,t7.time_end as tend,t7.time_end_min as tend_min,t7.id as pid from `class_substitute_routine` as t1 join `employee` as t2 ON t1.teacher_id = t2.id join `class_routine` as t3 ON t3.id = t1.class_routine_id join `class` as t4 ON t4.id = t3.class_id join `subject` as t5 ON t5.id=t3.subject_id join `section` as t6 on t6.id=t3.section_id left join `class_periods` as t7 on t7.id=t3.period_id WHERE t1.status='1'");

        $datas = $query->result_array();
        return $datas;
    }

    function selectasteacherById($id)
    {
        $query = $this->db->query("SELECT t1.teacher_id,t1.id as idss,t1.date,t1.day,t1.remarks,t1.status,t2.name,t3.*,t4.class_name,t5.name as subject,t6.sec_name from `class_substitute_routine` as t1 join `employee` as t2 ON t1.teacher_id = t2.id join `class_routine` as t3 ON t3.id = t1.class_routine_id join `class` as t4 ON t4.id = t3.class_id join `subject` as t5 ON t5.id=t3.subject_id join `section` as t6 on t6.id=t3.section_id WHERE t1.status='1' AND t1.id=$id");

        $datas = $query->row();
        return $datas;
    }

    function selectStudentData($exam, $clas, $sect, $subj)
    {
        $query = $this->db->query("SELECT t1.id as sid,t2.id as cid,t3.id as secid,t1.admission_no,t1.first_name,t2.class_name,t3.sec_name,t4.mark_id,t4.mark_total,t4.mark_obtained,t4.class_id,t5.name as subjectname,t6.grand_total FROM `student` as t1 join `class` as t2 ON t1.class_id=t2.id join `section` as t3 ON t3.id=t1.section_id LEFT JOIN `mark` as t4 ON t4.class_id = $clas AND t4.subject_id = $subj AND t4.exam_id = $exam AND t4.student_id=t1.id join`subject`as t5 ON t5.id = $subj join `exam` as t6 ON t6.id=$exam WHERE t1.class_id=$clas AND t1.section_id=$sect AND t1.status='Y' ORDER BY t1.admission_no ASC");

        $datas = $query->result_array();
        return $datas;
    }

    function CountData($datacheck)
    {
        $this->db->select('count(*) as count');
        $this->db->from('mark');
        $this->db->where($datacheck);
        $query = $this->db->get();
        $row = $query->result();
        return $data = $row[0]->count;
    }

    function GetRoutinedata($pid, $day, $clsid, $sec)
    {
        $query = $this->db->query("SELECT t1.id,t1.subject_id,t2.name,t4.name as tname FROM `class_routine` as t1 join `subject` as t2 ON t2.id=t1.subject_id left join `class_subject_teacher` as t3 on t3.class_id=t1.class_id AND t3.section_id=t1.section_id AND t3.subject_id=t1.subject_id left join `employee` as t4 on t4.id=t3.teacher_id  WHERE t1.`class_id` = $clsid AND t1.`section_id` = $sec AND t1.`period_id` = $pid AND t1.`status`='1' AND t1.`day` LIKE '$day'");
        $rows = $query->result_array();
        return $rows;
    }

    function get_classteacher_name_by_id($clid, $sec)
    {
        $query = $this->db->query("SELECT t1.*, t2.name FROM `class_teachet_alloc` as t1 join `employee` as t2 on t2.id=t1.teacher_id WHERE t1.class_id=$clid AND t1.section_id=$sec");
        $rowct = $query->row();
        return $rowct;
    }


    function GetTeacherData($pid, $day, $tid)
    {
        $query = $this->db->query("SELECT t1.id,t3.class_name,t4.sec_name,t5.name FROM `class_routine` as t1 JOIN `class_subject_teacher` as t2 ON t1.class_id=t2.class_id AND t1.section_id=t2.section_id AND t1.subject_id = t2.subject_id JOIN `class` as t3 on t3.id=t2.class_id JOIN `section` as t4 on t4.id=t2.section_id JOIN `subject` as t5 on t5.id=t2.subject_id WHERE t1.period_id=$pid AND t1.day='$day' AND t2.teacher_id=$tid");
        return $data = $query->row();
    }

    function GetSubsti($todaydate, $day, $tid)
    {
        $query = $this->db->query("SELECT t2.*,t3.class_name,t4.sec_name,t5.name FROM `class_substitute_routine` as t1 JOIN class_routine as t2 ON t2.id=t1.class_routine_id JOIN `class` as t3 on t3.id=t2.class_id JOIN `section` as t4 on t4.id=t2.section_id JOIN `subject` as t5 on t5.id=t2.subject_id WHERE t1.date='$todaydate' AND t1.teacher_id = $tid");
        return $subteac = $query->row();
    }

    public function selectstudent($exam, $clas, $sect)
    {
        $query = $this->db->query("SELECT t1.id,t1.admission_no,t1.first_name,t1.middle_name,t1.last_name,t2.class_name,t3.sec_name FROM `student` as t1 JOIN `class` as t2 on t2.id=t1.class_id JOIN `section` as t3 on t3.id=t1.section_id WHERE t1.`class_id` = $clas AND t1.`section_id` = $sect");
        return $row = $query->result();
    }

    public function dbcon()
    {
        $query = $this->db->query("SELECT t1.*,t2.class_name,t3.sec_name,t4.name,t5.name as category FROM `assignment` as t1 JOIN `class` as t2 ON t2.id=t1.class_id JOIN `section` as t3 ON t3.id=t1.section_id JOIN `subject` as t4 ON t4.id=t1.subject_id JOIN `assignment_category` as t5 ON t5.id=t1.assi_category_id WHERE t1.status=1");
        return $row = $query->result();
    }

    public function selectassignment($cid, $sid)
    {
        $query = $this->db->query("SELECT t1.*,t2.name,t3.name as subject FROM `assignment` as t1 JOIN `assignment_category` as t2 ON t2.id=t1.assi_category_id JOIN `subject` as t3 ON t1.subject_id = t3.id WHERE t1.class_id=$cid AND t1.section_id=$sid AND t1.dos>CURDATE() ORDER BY t1.id");
        return $row = $query->result();
    }
    public function selectCompletassignment($cid, $sid)
    {
        $query = $this->db->query("SELECT t1.*,t2.name,t3.name as subject FROM `assignment` as t1 JOIN `assignment_category` as t2 ON t2.id=t1.assi_category_id JOIN `subject` as t3 ON t1.subject_id = t3.id WHERE t1.class_id=$cid AND t1.section_id=$sid AND t1.dos<CURDATE() ORDER BY t1.id");
        return $row = $query->result();
    }

    public function select_homework($examnam, $clas, $section, $subject, $datesub)
    {
        $query = $this->db->query("SELECT  t1.assi_category_id,t1.id,t1.dos,t3.id as stid, t1.title,t1.dos,t2.class_name,t3.section_id,t3.admission_no,t3.first_name,t4.sec_name from assignment as t1 JOIN class as t2 ON t2.id=t1.class_id JOIN student as t3 on t3.class_id=t1.class_id AND t3.section_id=t1.section_id JOIN section as t4 ON t4.id=t1.section_id WHERE t1.class_id=$clas AND t1.section_id=$section AND t1.date_created='$datesub' AND t1.assi_category_id=$examnam");
        return $row = $query->result();
    }


    function GetClassTeacher($uid)
    {
        $query = $this->db->query("SELECT t1.*,t2.teacher_id as classteacher, t2.id as ids FROM `class_subject_teacher` as t1 JOIN `class_teachet_alloc` as t2 ON t2.class_id=t1.class_id AND t2.section_id=t1.section_id  WHERE t1.teacher_id=$uid");
        $row = $query->result_array();
        return $row;
    }

    public function dbcreate($newdb, $templatedb)
    {


        $this->load->dbforge();
        $this->load->dbutil();
        $dbmsg = '';
        if (!$this->dbutil->database_exists($newdb)) {
            $this->dbforge->create_database($newdb);

            $this->db->db_select($templatedb);
            $tables = $this->db->list_tables();
            $this->db->db_select($newdb);
            $cnt_tbl = 0;
            foreach ($tables as $table) {
                if (!$this->db->table_exists($table)) {
                    $t = $this->db->query("create table $table like $templatedb.$table");
                    if ($t) {
                        $this->db->query("INSERT INTO $table SELECT * FROM $templatedb.$table");
                    }
                    $cnt_tbl++;
                }
            }
            $dbmsg = "$newdb created alongwith  $cnt_tbl tables are created";
        }
        $this->db->db_select('digikhata');
        return $dbmsg;
    }

    public function selectsupplier()
    {
        $query = $this->db->query("SELECT *,(SELECT name FROM `supplier_type` st where st.id=ss.supplier_type)stype,(SELECT state_name FROM `states` st where st.state_code=ss.state)sname FROM `supplier` ss");
        return $row = $query->result();
    }



    /*function insert_entry($table,$data)
    {
        $res = $this->db->insert($table, $data);
        if($res){
            return true;
        }else{
            return $this->db->_error_message();
        }
    }

    function select_query($table,$select,$where){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        
        $query = $this->db->get();

        return $query->result(); 
    }

    function select_limit_query($table,$select,$where,$order,$limit){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order); 
        $this->db->limit($limit);
        $query = $this->db->get();

        return $query->result(); 
    }

    function update_entry($table,$data,$where)
    {
        $res = $this->db->update($table, $data, $where);
        if($res){
            return true;
        }else{
            return $this->db->_error_message();
        }
    }


    function deleteQuery($table, $where=array()){
        $this->db->delete($table, $where); 
    }

    function startTransaction()
    {
        $this->db->trans_start(true);
    }
    
    function trxstatus(){
        $x = $this->db->trans_status();
        $res = $this->completeTransaction($x);
        return $res;
    }


    function completeTransaction($trx_stat)
    {
        if ($trx_stat === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
        }

        return $this->db->trans_status();
    }

    
    public function gettotalleadspertimezone($per_page,$offset){
        $sdata = array();
    $this->db->select('count(z_task.task_id) as totalleads, z_customer.timezone')->from("z_task, z_listing, z_customer");
        $this->db->where("z_task.item_fuzzy_id = z_listing.item_fuzzy_id "
        ."AND z_listing.user_fuzzy_id = z_customer.user_fuzzy_id AND z_task.state=1001");
    $this->db->group_by("z_customer.timezone");

        $this->db->limit($per_page,$offset);
        $query_result = $this->db->get();
        if($query_result->num_rows() > 0) {

            foreach ($query_result->result_array() as $row)
            {
                $sdata[] = array('totalleads' => $row['totalleads'], 'timezone'=> $row['timezone']);
            }           
        }
        return $sdata;
    }


    public function customerinfo($per_page,$offset,$search_keywords_array,$search_orderby_string) {
        
        $sdata = array();

        $this->db->select('zc.nickname, zt.task_id, zt.reason, zc.timezone, zt.state')->from("z_task zt, z_listing zl, z_customer zc");
        $this->db->where("zt.item_fuzzy_id = zl.item_fuzzy_id "
        ."AND zl.user_fuzzy_id = zc.user_fuzzy_id ");
        if(count($search_keywords_array)>0) $this->db->where($search_keywords_array);
        
        if(!empty($search_orderby_string)) $this->db->order_by($search_orderby_string);
        
        $this->db->limit($per_page,$offset);
        $query_result = $this->db->get();
        //echo $this->db->last_query(); // shows last executed query
        
        if($query_result->num_rows() > 0) {

            foreach ($query_result->result_array() as $row)
            {
                $sqry = $this->db->query("Select disposition from t_disposition where dispositionid='".$row['state']."'");
                $oqry = $sqry->result_array();

                $sdata[] = array('nickname' => $row['nickname'],'task_id' => $row['task_id'],'reason' => $row['reason'], 'timezone'=> $row['timezone'], 'state'=>$oqry[0]['disposition']);
            }           
        }
        return $sdata;
    }

    public function searchterm_handler($field,$searchterm)
    {
        if($searchterm)
        {
            $this->session->set_userdata($field, $searchterm);
            return $searchterm;
        }
        elseif($this->session->userdata($field))
        {
            $searchterm = $this->session->userdata($field);
            return $searchterm;
        }
        else
        {
            $searchterm ="";
            return $searchterm;
        }
    }*/
}
