<?php
/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 23/11/2017
 * Time: 4:42 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['remove_spaces'] = true;
        $config['file_ext_tolower'] = true;
        $this->load->library('upload', $config);
    }
    public function index() {
        $where = "";
        $suffix = "";
        if($this->input->get()) {
            $key=$this->input->get('key');
            if($key!='') {
                $where.=" where title like '%$key%'";
            }
            $suffix = "?".$_SERVER['QUERY_STRING'];
        }
        $config['base_url'] = base_url('admin/users');
        $config['total_rows'] = $this->db->query("select id from users $where")->num_rows();
        $config['per_page'] = 2;
        $config['use_page_numbers'] = true;
        //$config['suffix'] = '.html'.$suffix;
        $config['first_url'] = site_url('admin/users').$suffix;
        $config['first_link'] = 'Trang đầu';
        $config['last_link'] = 'Trang cuối';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        $start = $page*$config['per_page']-$config['per_page'];
        $limit = $start.",".$config['per_page'];
        $this->data['model'] = $this->db->query("select * from users $where order by stt asc, id desc limit $limit")->result();
        $this->render('admin/users/list');
    }

    public function create() {
        $this->data['button_title'] = 'Thêm users';
        if($this->input->post()) {
            //upload hinh
            $pic_name = '';
            if($this->upload->do_upload('picture')) {
                $pic_name = $this->upload->file_name;
            }
            $model = [
                'stt' => $this->mcode->clean($this->input->post('stt')),
                'hide' => $this->mcode->clean($this->input->post('hide')),
                'picture' => $pic_name,
                'username' => $this->mcode->username($this->mcode->clean($this->input->post('username'))),
                'user_token' => $this->mcode->hash($this->mcode->clean($this->input->post('username'))),
                'pass_token' => $this->mcode->hash($this->mcode->clean($this->input->post('password'))),
                'group_id' => $this->mcode->clean($this->input->post('group_id')),
                'name' => $this->mcode->clean($this->input->post('name')),
                'email' => $this->mcode->clean($this->input->post('email')),
                'phone' => $this->mcode->clean($this->input->post('phone')),
                'address' => $this->mcode->clean($this->input->post('address')),
                'birthday' => strtotime($this->input->post('day')."-".$this->input->post('month')."-".$this->input->post('year')),
                'gender' => $this->mcode->clean($this->input->post('gender')),
                'create_at' => time(),
            ];
            if($this->db->insert('users',$model)) {
                redirect('admin/users/','refresh');
            }
            else {
                echo $this->db->error();
            }
        }
        else {
            $this->data['id_user'] = "";
            $this->data['list_group'] = $this->db->query("select * from groups where hide=1 order by id asc")->result();
            $this->render('admin/users/create');
        }
    }

    public function edit($id = NULL) {
        $this->data['button_title'] = 'Sửa users';
        if($this->input->post()) {
            //upload hinh
            $query = $this->db->query("select * from users where id='$id'")->row();
            $pic_name=$query->picture;
            if($this->upload->do_upload('picture')) {
                $pic_name = $this->upload->file_name;
                if(is_file('./uploads/'.$query->picture)) {
                    unlink('./uploads/'.$query->picture);
                }
            }
            $pass_token = $query->pass_token;
            if($this->input->post('password')!=$query->pass_token) {
                $pass_token = $this->mcode->hash($this->mcode->clean($this->input->post('password')));
            }
            $model = [
                'stt' => $this->mcode->clean($this->input->post('stt')),
                'hide' => $this->mcode->clean($this->input->post('hide')),
                'picture' => $pic_name,
                'username' => $this->mcode->username($this->mcode->clean($this->input->post('username'))),
                'user_token' => $this->mcode->hash($this->mcode->clean($this->input->post('username'))),
                'pass_token' => $pass_token,
                'group_id' => $this->mcode->clean($this->input->post('group_id')),
                'name' => $this->mcode->clean($this->input->post('name')),
                'email' => $this->mcode->clean($this->input->post('email')),
                'phone' => $this->mcode->clean($this->input->post('phone')),
                'address' => $this->mcode->clean($this->input->post('address')),
                'birthday' => strtotime($this->input->post('day')."-".$this->input->post('month')."-".$this->input->post('year')),
                'gender' => $this->mcode->clean($this->input->post('gender')),
            ];
            if($this->db->update('users', $model, array('id' => $id))) {
                redirect('admin/users','refresh');
            }
            else {
                echo $this->db->error();
            }
        }
        else {
            $this->data['id_user'] = $id;
            $this->data['list_group'] = $this->db->query("select * from groups where hide=1 order by id asc")->result();
            $this->data['items'] = $this->db->query("select * from users where id='$id'")->row();
            $this->render('admin/users/edit');
        }
    }

    public function delete($id = NULL) {
        $query = $this->db->query("select * from users where id = '$id'")->row();
        //xoa hinh
        if(is_file('./uploads/'.$query->picture)) {
            unlink('./uploads/'.$query->picture);
        }
        $this->db->delete('users', array('id' => $id));
        redirect('admin/users','refresh');
    }

    public function stt() {
        $id = $this->input->post('id');
        $model = array(
            'stt' => $this->input->post('stt'),
        );
        if($id !== null) {
            $this->db->update('users', $model, array('id' => $id));
        }
    }
    public function hide() {
        $id = $this->input->post('id');
        $model = array(
            'hide' => $this->input->post('hide'),
        );
        if($id !== null) {
            $this->db->update('users', $model, array('id' => $id));
            $output = array(
                'hide' => $model['hide'],
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }

    public function check_username() {
        $id_user = $this->input->post('id_user');
        $username = $this->mcode->username($this->input->post('username'));
        $check = $this->db->query("select id from users where username='$username' and id!='$id_user'")->num_rows();
        if($check>0) {
            echo "false";
        }
        else {
            echo "true";
        }
    }
    public function check_email() {
        $id_user = $this->input->post('id_user');
        $email = $this->input->post('email');
        $check = $this->db->query("select id from users where email='$email' and id!='$id_user'")->num_rows();
        if($check>0) {
            echo "false";
        }
        else {
            echo "true";
        }
    }
}
?>