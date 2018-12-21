/**
 * 个人门户面板
 */
$(function () {
    // 密码修改页面
    $(document).on('click', '.navbar-custom-menu .user-menu .dropdown-menu .user-footer a[rel=my_password_reset]', function () {
        $("#smallModal").modal({backdrop: "static"});
        $("#smallModal .modal-title").text("修改密码");
        $("#smallModal .modal-footer .pull-right").attr('id', 'confirm-my_password_reset');
        $('#smallModal .modal-body').empty().load('/portal/password-reset');
    });

    // 密码修改——保存
    $(document).on('click', '#smallModal .modal-footer #confirm-my_password_reset', function () {
        var password_old = $.trim($("#smallModal .modal-body #password_old").val());
        var password_new = $.trim($("#smallModal .modal-body #password_new").val());
        var password_confirm = $.trim($("#smallModal .modal-body #password_confirm").val());

        if ( password_old == "" ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '请输入原密码',
            });
            return false;
        }
        if ( password_new == "" ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '请输入新密码',
            });
            return false;
        }
        if ( password_confirm == "" ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '请输入确认密码',
            });
            return false;
        }
        if ( password_new != password_confirm ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '新密码与确认密码不一致',
            });
            return false;
        }
        if ( password_new == password_old ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '新密码与原密码不能相同',
            });
            return false;
        }
        $(this).text("正在提交中").attr('disabled', true);

        var para = {
            password_old : password_old,
            password_new : password_new,
            password_confirm : password_confirm,
        };
        $.post('/portal/password-reset', para, function (res) {
            if ( res.code == 200 ) {
                $("#smallModal").modal('hide');
                swal({
                    title: "修改成功",
                    text: "",
                    type: "success",
                    // timer: 2000,
                    // showConfirmButton: false
                }, function () {
                    // 移除按钮的不可选状态
                    $('#smallModal .modal-footer #confirm-my_password_reset').text("确 定").removeAttr("disabled");

                    // 退出登录
                    // window.location.href = '/site/logout';
                    // $.post('/site/logout', [], function () {
                    //     window.location.href = '/';
                    // });
                });
            } else {
                sweetAlert('失败', res.msg, 'error');
                $('#smallModal .modal-footer #confirm-my_password_reset').text("确 定").removeAttr("disabled");
            }
        }, 'json');
    });

});