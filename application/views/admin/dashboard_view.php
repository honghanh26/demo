<!--/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 23/11/2017
 * Time: 9:41 AM
 */-->
<div class="container">
    <h1 class="text-center">phan giao dien admin</h1>
    <h3>Chào <?=$this->session->admin_name;?></h3>
    <p><a href="<?=site_url('admin/check/logout');?>" title="Đăng xuất">Đăng xuất</a></p>
</div>