<?php
/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 23/11/2017
 * Time: 11:12 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box-form">
    <?php echo form_open_multipart('',array('id'=>'form-groups'));?>
    <div class="clearfix"></div>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-12">Hình ảnh</label>
            <div class="col-sm-3">
                <input type="file" accept="image/*" name="picture" />
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
        <label>Tên</label>
        <textarea class="form-control area-input" rows="1" name="title"><?=(isset($items)) ? $items->title : ''?></textarea>
    </div>
    <div class="form-group">
        <label>Hiển thị</label>
        <select class="form-control" name="hide">
            <option value="1" <?=(isset($items) && $items->hide==1) ? 'selected="selected"' : '' ?>>Có</option>
            <option value="0" <?=(isset($items) && $items->hide==0) ? 'selected="selected"' : '' ?>>Không</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><?=$button_title?></button>
    </div>
    <?php echo form_close();?>
</div>
