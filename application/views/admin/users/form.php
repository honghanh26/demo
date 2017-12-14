<?php
/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 23/11/2017
 * Time: 4:53 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box-form">
    <?php echo form_open_multipart('',array('id'=>'form-users','id_user'=>$id_user));?>
    <div class="clearfix"></div>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-12">Hình ảnh đại diện</label>
            <div class="col-sm-3">
                <input type="file" accept="image/*" name="picture" class="filestyle" data-input="false" data-buttonText="Chọn hình"/>
            </div>
            <div class="col-sm-9">
                <?php if(isset($items) && $items->picture!='') { ?>
                    <img src="<?=base_url()?>uploads/<?=(isset($items->picture)) ? $items->picture : ''?>" height="80">
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
        <label>Nhóm tài khoản</label>
        <select class="form-control select2" name="group_id" style="width:100%;">
            <?php foreach($list_group as $item) {?>
                <option value="<?=$item->id?>" <?=(isset($items) && $items->group_id==$item->id) ? 'selected="selected"' : ''?>><?=$item->title?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label>Tên đăng nhập</label>
        <div class="relative"><textarea class="form-control area-input" rows="1" name="username" id="username" data-error="Nhập tài khoản" data-error-1="Tên tài khoản đã tồn tại" data-url="<?=base_url('admin/users/check_username')?>"><?=(isset($items)) ? $items->username : ''?></textarea></div>
        <div class="block red mt5 font12"><b>Lưu ý:</b> Tên tài khoản phải không có dấu và khoảng trống</div>
    </div>
    <div class="form-group">
        <label>Mật khẩu</label>
        <div class="relative"><textarea class="form-control area-input" rows="1" name="password" id="password" data-error="Nhập mật khẩu"><?=(isset($items)) ? $items->pass_token : ''?></textarea></div>
    </div>
    <div class="form-group">
        <label>Xác nhận mật khẩu</label>
        <div class="relative"><textarea class="form-control area-input" rows="1" name="re_password" id="re_password" data-error="Mật khẩu không trùng khớp"><?=(isset($items)) ? $items->pass_token : ''?></textarea></div>
    </div>
    <div class="form-group">
        <label>Tên hiển thị</label>
        <div class="relative"><textarea class="form-control area-input" rows="1" name="name" id="name" data-error="Nhập tên"><?=(isset($items)) ? $items->name : ''?></textarea></div>
    </div>
    <div class="form-group">
        <label>Email</label>
        <div class="relative"><textarea class="form-control area-input" rows="1" name="email" id="email" data-error="Nhập email" data-error-1="Email đã tồn tại" data-url="<?=base_url('admin/users/check_email')?>"><?=(isset($items)) ? $items->email : ''?></textarea></div>
    </div>
    <div class="form-group">
        <label>Điện thoại</label>
        <div class="relative"><textarea class="form-control area-input" rows="1" name="phone" id="phone" data-error="Nhập sô điện thoại"><?=(isset($items)) ? $items->phone : ''?></textarea></div>
    </div>
    <div class="form-group">
        <label>Địa chỉ</label>
        <div class="relative"><textarea class="form-control area-input" rows="1" name="address" id="address" data-error="Nhập địa chỉ"><?=(isset($items)) ? $items->address : ''?></textarea></div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-12">Ngày sinh *</label>
            <div class="col-sm-12">
                <select name="day" class="select2 w70">
                    <option value="">Ngày</option>
                    <?php for($i=1;$i<=31;$i++) { ($i<10) ? $j = "0".$i : $j = $i; ?>
                        <option value="<?=$j?>" <?=(isset($items) && date("d",$items->birthday)==$j) ? 'selected="selected"' : '' ?>><?=$j?></option>
                    <?php } ?>
                </select>
                <select name="month" class="select2 w80">
                    <option value="">Tháng</option>
                    <?php for($i=1;$i<=12;$i++) { ($i<10) ? $j = "0".$i : $j = $i; ?>
                        <option value="<?=$j?>" <?=(isset($items) && date("m",$items->birthday)==$j) ? 'selected="selected"' : '' ?>><?=$j?></option>
                    <?php } ?>
                </select>
                <select name="year" class="select2 w80">
                    <option value="">Năm</option>
                    <?php $year = (int)date("Y"); for($i=$year;$i>($year-200);$i--) {?>
                        <option value="<?=$i?>" <?=(isset($items) && date("Y",$items->birthday)==$i) ? 'selected="selected"' : '' ?>><?=$i?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-12">Giới tính *</label>
            <div class="col-sm-12">
                <label class="radio-inline">
                    <input class="icheck" type="radio" name="gender" value="1" <?=(isset($items) && $items->gender==1) ? 'checked="checked"' : '' ?>> Nam
                </label>
                <label class="radio-inline">
                    <input class="icheck" type="radio" name="gender" value="0" <?=(isset($items) && $items->gender==0) ? 'checked="checked"' : '' ?>> Nữ
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>STT</label>
        <input type="number" name="stt" class="form-control" min="0" value="<?=(isset($items->stt)) ? $items->stt : 0 ?>">
    </div>
    <div class="form-group">
        <label>Hiển thị</label>
        <select class="form-control select2" name="hide" style="width:100%;">
            <option value="1" <?=(isset($items) && $items->hide==1) ? 'selected="selected"' : '' ?>>Có</option>
            <option value="0" <?=(isset($items) && $items->hide==0) ? 'selected="selected"' : '' ?>>Không</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><?=$button_title?></button>
    </div>
    <?php echo form_close();?>
</div>