<?php
/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 29/11/2017
 * Time: 10:20 AM
 */
class M_groups extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function get_all()
    {
        $this->db->order_by('stt','asc');
        $this->db->order_by('id','desc');
        $db = $this->db->get('groups');
        if($db->num_rows() == 0){
            return false;
        }
        return $db->result();
    }

    public function page($index=1, $per_page){
        if($index==0) {
            $this->db->limit($per_page , $index);
        }else{
            $this->db->limit($per_page, ($index - 1) * $per_page);
        }
        return $this;
    }
}