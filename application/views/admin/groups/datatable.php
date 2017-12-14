<!--/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 23/11/2017
 * Time: 11:00 AM
 */-->
<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <h1>Danh sách nhóm</h1>
    <div class="text-right"><a class="btn btn-success" href="<?=site_url('admin/groups/create'); ?>" title="Thêm">Thêm nhóm</a></div>
    <hr>
    <div class="table-responsive">
        <table id="tableGroups" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th class="w50">#</th>
                <th class="w50">STT</th>
                <th>Hình Ảnh</th>
                <th>Tên</th>
                <th class="w100">Ẩn | Hiện</th>
                <th class="w100">Hành động</th>
            </tr>
            </thead>
        </table>
    </div>
</div>