<?php
/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 23/11/2017
 * Time: 10:50 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Groups extends Admin_Controller {
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
        $config['base_url'] = base_url('admin/groups');
        $config['total_rows'] = $this->db->query("select id from groups")->num_rows();
        $config['per_page'] = 2;
        $config['use_page_numbers'] = true;
//        $config['suffix'] = '.html'.$suffix;
        $config['first_url'] = site_url('admin/groups').$suffix;
        $config['first_link'] = 'Trang đầu';
        $config['last_link'] = 'Trang cuối';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        $start = $page*$config['per_page']-$config['per_page'];
        $limit = $start.",".$config['per_page'];
//        $this->data['model'] = $this->db->query("select * from groups $where order by stt asc, id desc limit $limit")->result();

        /*$this->db->order_by('stt','asc');
        $this->db->order_by('id','desc');
        $this->db->limit($config['per_page'],$start);
        $this->data['model'] = $this->db->get('groups')->result();*/
//        $this->data['model'] = $this->db->order_by('stt','asc')
//                                        ->order_by('id','desc')
//                                        ->limit($start,$config['per_page'])
//                                        ->get('groups');
        $this->load->model('M_groups');
//        print_r($this->data['model'] = $this->M_groups->get_all());die();
        $this->data['model'] = $this->M_groups->page($page, $config['per_page'])->get_all();
        echo $this->mcode->hash('123');
        echo $this->mcode->stripUnicode('Cách sử dụng hàm');
        $this->render('admin/groups/list');
//        $this->render('admin/groups/datatable');
    }

    public function create() {
        $this->data['button_title'] = 'Thêm nhóm';
        if($this->input->post()) {
            //upload hinh
            $pic_name = '';
            if($this->upload->do_upload('picture')) {
                $pic_name = $this->upload->file_name;
            }

            $model = [
                'title' => $this->input->post('title'),
                'picture' => $pic_name,
                'hide' => $this->input->post('hide'),
                'create_at' => time(),
            ];
            if($this->db->insert('groups',$model)) {
                redirect('admin/groups/','refresh');
            }
            else {
                echo $this->db->error();
            }
        }
        else {
            $this->render('admin/groups/create');
        }
    }

    public function edit($id = NULL) {
        $this->data['button_title'] = 'Sửa nhóm';
        if($this->input->post()) {
            //upload hinh
            $images = $this->db->query("select * from groups where id='$id'")->row();
            $pic_name = $images->picture;
            if($this->upload->do_upload('picture')) {
                $pic_name = $this->upload->file_name;
                if(is_file('./uploads/'.$images->picture)) {
                    unlink('./uploads/'.$images->picture);
                }
            }
            $model = [
                'title' => $this->input->post('title'),
                'picture' => $pic_name,
                'hide' => $this->input->post('hide'),
                'update_at' => time(),
            ];
            if($this->db->update('groups', $model, array('id' => $id))) {
                redirect('admin/groups','refresh');
            }
            else {
                echo $this->db->error();
            }
        }
        else {
            $this->data['items'] = $this->db->query("select * from groups where id='$id'")->row();
            $this->render('admin/groups/edit');
        }
    }

    public function delete($id = NULL) {
        $query = $this->db->query("select * from groups where id = '$id'")->row();
        //xoa hinh
        if(is_file('./uploads/'.$query->picture)) {
            unlink('./uploads/'.$query->picture);
        }
        $this->db->delete('groups', array('id' => $id));
        redirect('admin/groups','refresh');
    }

    public function listGroups() {
        $this->render('admin/groups/datatable');
    }

    public function getListGroups() {
        $this->load->model('M_groups');
        $data = $this->M_groups->get_all();
//        print_r($this->data['data']);
//        $temp ="data:["
//        die();
//        $this->data['data'] = json_encode($this->data['data']);
        /*print_r(json_encode($this->data['data']));
        die();*/
        echo json_encode(array('data'=>$data));
    }

    public function stt() {
        $id = $this->input->post('id');
        $model = array(
            'stt' => $this->input->post('stt'),
        );
        if($id !== null) {
            $this->db->update('groups', $model, array('id' => $id));
        }
    }

    public function hide() {
        $id = $this->input->post('id');
        $model = array(
            'hide' => $this->input->post('hide'),
        );
        if($id !== null) {
            $this->db->update('groups', $model, array('id' => $id));
            $output = array(
                'hide' => $model['hide'],
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }

    public function mail() {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'caothihonghanh26@gmail.com',
            'smtp_pass' => 'congoaime',
            'mailtype'  => 'html',
            'charset' => 'utf-8',
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('caothihonghanh26@gmail.com','Hạnh');
        $this->email->to('caothihonghanh26@gmail.com');
        $this->email->subject('Tieu_de_email');
        $this->email->message('noi_dung_email');
        $this->email->send();
    }

    public function captcha() {
        $this->load->helper('captcha');
        $vals = array(
            'img_path' => './uploads/captcha',
            'img_url' => './uploads/captcha',
            'font_path' => './uploads/captcha',
            'img_width' => '120',
            'img_height' => 34,
            'expiration' => 0,
            'word_length' => 8,
            'font_size' => 25,
            'img_id' => 'Imageid',
            'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors' => array(
                'background' => array(235, 235, 235),
                'border' => array(51, 51, 51),
                'text' => array(255, 0, 0),
                'grid' => array(255, 255, 255)
            )
        );
        $this->data['captcha'] = create_captcha($vals);
        $this->load->view('xem_captcha',array('caprcha'=>create_captcha($vals))); //đẩy biến bằng hàm load
    }
}