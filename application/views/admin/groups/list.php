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
    <div>
        <form method="get" action="<?=site_url('admin/groups'); ?>" id="form-search">
            <div class="form-group">
                <input name="key" type="text" class="form-control" placeholder="Nhập từ khóa">
                <button class="btn btn-primary" type="submit">Tìm</button>
            </div>
        </form>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-list">
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
            <tbody>
            <?php foreach ($model as $i => $item) { ?>
                <tr>
                    <td class="w50"><?=$i+1?></td>
                    <td><input type="text" value="<?=$item->stt?>" class="stt w50" data-url="<?=base_url('admin/groups/stt')?>" data-id="<?=$item->id?>"></td>
                    <td>
                        <?php if($item->picture!='') { ?>
                            <img src="<?=base_url()?>uploads/<?=$item->picture?>" height="80">
                        <?php } ?>
                    </td>
                    <td><?=$item->title?></td>
                    <td class="w100 a-hide">
                        <span class="glyphicon glyphicon-ok-circle iconfa-show hide1<?=$item->id?> <?php if($item->hide==0) echo 'hide'; ?>" data-id="<?=$item->id?>" data-hide="0" data-url="<?=base_url('admin/groups/hide')?>"></span>
                        <span class="glyphicon glyphicon-remove-circle iconfa-hide hide0<?=$item->id?> <?php if($item->hide==1) echo 'hide'; ?>" data-id="<?=$item->id?>" data-hide="1" data-url="<?=base_url('admin/groups/hide')?>"></span>
                    </td>
                    <td class="w100 act">
                        <a href="<?=site_url('admin/groups/edit/'.$item->id); ?>" ><span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="delete-confirm" href="<?=site_url('admin/groups/delete/'.$item->id); ?>"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
    <div class="pagination-page"><?=$this->pagination->create_links();?></div>
    <?php //echo $captcha['image'];?>
    <!--<input type="text" class="form-control" name="captcha" id="captcha" autocomplete="off">
    <input type="hidden" name="re_captcha" id="re_captcha" class="show-re-captcha" value="?<=//$captcha['word'];>?">-->

</div>