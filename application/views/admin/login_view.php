<!--/**
 * Created by PhpStorm.
 * User: hanh.cthh
 * Date: 28/11/2017
 * Time: 4:27 PM
 */-->
<div class="container">
    <div class="login-form">
        <?php if($this->session->message!='') {?>
            <div class="show_error">
                <?=$this->session->message?>
            </div>
        <?php } ?>
        <?php //echo validation_errors(); ?>
        <?php echo form_open('',array('id'=>'form-plogin'));?>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"> <i class="entypo-user"></i></div>
                <input type="text" class="form-control" name="username" id="username" data-error="Nhập tài khoản" placeholder="Tài khoản" autocomplete="off">
            </div>
            <?php echo form_error('username'); ?>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"> <i class="entypo-key"></i> </div>
                <input type="password" class="form-control" name="password" id="password" data-error="Nhập mật khẩu" placeholder="Mật khẩu" autocomplete="off">
            </div>
            <?php echo form_error('password'); ?>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block"><i class="entypo-login"></i>Đăng nhập</button>
        </div>
        <?php echo form_close();?>
    </div>
</div>