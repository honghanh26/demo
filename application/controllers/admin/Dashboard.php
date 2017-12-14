<?php
/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 23/11/2017
 * Time: 9:39 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends Admin_Controller {
    function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->render('admin/dashboard_view');
    }
}