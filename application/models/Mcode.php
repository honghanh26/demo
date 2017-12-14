<?php
/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 23/11/2017
 * Time: 4:21 PM
 */
class Mcode extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function clean($strText) {
        $str=preg_replace('/<script\b[^>]*>(.*?)<\/script>/i', "", $strText);
        return $str;
    }

    public function hash($text) {
        $str=sha1(md5(sha1($text)));
        return $str;
    }

    public function stripUnicode($str) {
        if(!$str) return false;
        $str=strip_tags($str);
        $unicode=array('a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ','d' => 'đ','e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ','i' => 'í|ì|ỉ|ĩ|ị','o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ','u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự','y' => 'ý|ỳ|ỷ|ỹ|ỵ','A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ','D' => 'Đ','E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ','I' => 'Í|Ì|Ỉ|Ĩ|Ị','O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ','U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự','Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',);
        foreach($unicode as $nonUnicode => $uni) {
            $str=preg_replace("/($uni)/i",$nonUnicode,$str);
        }
        return $str;
    }

    public function generate_username_from_text($strText) {
        $strText=preg_replace('/[^A-Za-z0-9-]/',' ',$strText);
        $strText=preg_replace('/ +/',' ',$strText);
        $strText=trim($strText);
        $strText=str_replace(' ','',$strText);
        $strText=preg_replace('/-+/','',$strText);
        $strText=preg_replace("/-$/","",$strText);
        return $strText;
    }

    public function username($strText) {
        return  strtolower($this->generate_username_from_text($this->stripUnicode($strText)));
    }

    public function admin_login($user,$pass) {
        $username=$this->mcode->hash($user);
        $password=$this->mcode->hash($pass);
//        $query=$this->db->query("select * from users where user_token='$username' and pass_token='$password' and hide=1");
        $this->db->where('user_token', $username);
        $this->db->where('pass_token', $password);
        $this->db->where('hide', 1);
        $query = $this->db->get('users');
        $item=$query->row();
        if($query->num_rows()>0 && $username==$item->user_token && $password==$item->pass_token) {
            $this->session->set_userdata(array(
                'admin_name'=> $item->name,
                'admin_user'=> $item->username,
                'admin_id' => $item->id,
                'group_id' => $item->group_id,
            ));
            return $item;
        }
        else {
            return false;
        }
    }
    public function admin_logged_in() {
        if($this->session->has_userdata('admin_user') && $this->session->has_userdata('admin_id')) {
            return true;
        }
        else {
            return false;
        }
    }
    public function admin_logout() {
        $this->session->unset_userdata(array('admin_name','admin_user','admin_id','group_id'));
    }
}