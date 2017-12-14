<?php
function test(){
    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'ten_dang_nhap_email',
        'smtp_pass' => 'mat_khau_dang_nhap_email',
        'mailtype'  => 'html',
        'charset' => 'utf-8',
    );
    return $config;
}