$(document).ready(function() {
    $('.stt').blur(function(){
        var id = $(this).attr('data-id');
        var stt = $(this).val();
        var url = $(this).attr('data-url');
        if($.isNumeric(stt)==true) {
            $.ajax({
                url: url,
                type: "POST",
                data: {'id': id, 'stt': stt},
                dataType: "json",
            })
        }
        else {
            alert('Nhập số');
            $(this).focus();
        }
    });

    $('.a-hide span').click(function(){
        var id = $(this).attr('data-id');
        var hide = $(this).attr('data-hide');
        var url = $(this).attr('data-url');
        $.ajax({
            url: url,
            type: "POST",
            data: {'id': id, 'hide': hide},
            dataType: "json",
            success:function(data){
                if(data.hide==1) {
                    $('.a-hide .hide0'+id).addClass('hide');
                    $('.a-hide .hide1'+id).removeClass('hide');
                }
                else {
                    $('.a-hide .hide1'+id).addClass('hide');
                    $('.a-hide .hide0'+id).removeClass('hide');
                }
            }
        })
    });

    if($("#form-users").length) {
        var error1=$('#form-users #username').attr('data-error');
        var url_username=$('#form-users #username').attr('data-url');
        var error_username=$('#form-users #username').attr('data-error-1');
        var error2=$('#form-users #password').attr('data-error');
        var error3=$('#form-users #re_password').attr('data-error');
        var error4=$('#form-users #name').attr('data-error');
        var error5=$('#form-users #email').attr('data-error');
        var url_email=$('#form-users #email').attr('data-url');
        var error_email=$('#form-users #email').attr('data-error-1');
        var error6=$('#form-users #phone').attr('data-error');
        var error7=$('#form-users #address').attr('data-error');
        $("#form-users").validate({
            rules: {
                username: {
                    required: true,
                    remote: {
                        url: url_username,
                        type: "post",
                        data: {
                            username: function() {
                                return $('#form-users #username').val();
                            },
                            id_user: function() {
                                return $('#form-users').attr('id_user');
                            },
                        }
                    }
                },
                password: "required",
                re_password: {
                    required: true,
                    equalTo: "#password",
                },
                name: "required",
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: url_email,
                        type: "post",
                        data: {
                            email: function() {
                                return $('#form-users #email').val();
                            },
                            id_user: function() {
                                return $('#form-users').attr('id_user');
                            },
                        }
                    }
                },
                phone: "required",
                address: "required",
                day: "required",
                month: "required",
                year: "required",
                gender: "required",
            },
            messages: {
                username: {
                    required: error1,
                    remote: error_username
                },
                password: error2,
                re_password: {
                    required: error2,
                    equalTo: error3,
                },
                name: error4,
                email: {
                    required: error5,
                    email: error5,
                    remote: error_email,
                },
                phone: error6,
                address: error7,
                day: '',
                month: '',
                year: '',
                gender: '',
            },
            highlight : function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight : function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
        });
    }
});