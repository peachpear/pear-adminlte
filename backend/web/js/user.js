/**
 * 用户管理js
 */
$(function () {
    /**
     * 用户列表相关操作
     */
    // 获取用户列表数据
    function getUsersPage()
    {
        var type = $.trim($(".users-search #search-box-users_type").val());
        var status = $.trim($(".users-search #search-box-users_status").val());
        var nickname = encodeURI( $.trim($('.users-search #search-box-users_nickname').val()) );

        ZENG.msgbox.show("正在加载数据...", 6);
        $(".content .users-lists").empty().load('/user/users-page?type=' + type
            + '&status=' + status
            + '&nickname=' + nickname, function () {
                ZENG.msgbox.hide();
        });
    }

    // 用户类型
    $(document).on('change', '.users-search #search-box-users_type', function(){
        getUsersPage();
    });

    // 用户状态
    $(document).on('change', '.users-search #search-box-users_status', function(){
        getUsersPage();
    });

    // 快搜
    $(document).on('change', '.users-search #search-box-users_nickname', function(){
        getUsersPage();
    });
    $(document).on('keydown', '.users-search #search-box-users_nickname', function(e){
        // 回车事件
        var theEvent = e || window.event;
        var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
        if ( code == 13 ) {
            e.preventDefault();
            getUsersPage();
        }
    });

    // 排序
    $(document).on('click','.search-box-order .users-sort li',function () {
        // 点击自己
        if ( $(this).hasClass('current') ) {
            if ( $(this).hasClass('up') ) {
                // down排序
                $(this).removeClass('up').addClass('down');
                $(this).find('.fa').removeClass('fa-long-arrow-up').addClass('fa-long-arrow-down');
            } else {
                // up排序
                $(this).removeClass('down').addClass('up');
                $(this).find('.fa').removeClass('fa-long-arrow-down').addClass('fa-long-arrow-up');
            }
        } else {
            $('.search-box-order .users-sort li').removeClass();
            $('.search-box-order .users-sort li').find('span').remove();
            $(this).addClass('current up');
            $(this).html($(this).text() + "<span>&nbsp;</span><span class='fa fa-long-arrow-up'></span>");
        }

        getUsersPage();
    });

    // 用户添加页面
    $(document).on('click', '#btn-user_add', function () {
        $("#smallModal").modal({backdrop: "static"});
        $("#smallModal .modal-title").text("添加用户");
        $("#smallModal .modal-footer .pull-right").attr('id', 'confirm-user_add');
        $('#smallModal .modal-body').empty().load('/user/user-add');
    });

    // 用户修改页面
    $(document).on('click', '.users-lists a[rel=user_update]', function () {
        var id = $(this).data('id');
        $("#smallModal").modal({backdrop: "static"});
        $("#smallModal .modal-title").text("用户修改");
        $("#smallModal .modal-footer .pull-right").attr('id', 'confirm-user_add');
        $('#smallModal .modal-body').empty().load('/user/user-add?user_id=' + id);
    });

    // 用户提交保存的执行操作
    $(document).on('click', '#smallModal .modal-footer #confirm-user_add', function () {
        var id = $.trim($("#smallModal .modal-body #user_id").val());
        var type = $.trim($("#smallModal .modal-body #user_type").val());
        var nickname = $.trim($("#smallModal .modal-body #user_nickname").val());
        var username = $.trim($("#smallModal .modal-body #user_username").val());
        var phone = $.trim($("#smallModal .modal-body #user_phone").val());
        var email = $.trim($("#smallModal .modal-body #user_email").val());
        var status = $.trim($("#smallModal .modal-body #user_status").val());

        if ( type == "" ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '请选择用户类型',
            });
            return false;
        }
        if ( nickname == "" ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '请输入用户姓名',
            });
            return false;
        }
        if ( username == "" ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '请输入用户账户',
            });
            return false;
        }
        if ( phone == "" ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '请输入用户手机号码',
            });
            return false;
        }
        if ( email == "" ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '请输入用户邮箱',
            });
            return false;
        }
        if ( status == "" ) {
            $.toast({
                position: 'top-center', icon: 'error', stack: false,
                heading: 'Error', text: '请选择用户状态',
            });
            return false;
        }
        $(this).text("正在提交中").attr('disabled', true);

        var para = {
            id : id,
            type : type,
            nickname : nickname,
            username : username,
            phone : phone,
            email : email,
            status : status,
        };
        $.post('/user/user-post', para, function (res) {
            if ( res.code == 200 ) {
                if ( id > 0 ) { //修改
                    $("#smallModal").modal('hide');
                    swal({title: "修改成功", text: "", type: "success"}, function () {
                        // 移除按钮的不可选状态，刷新列表
                        $('#smallModal .modal-footer #confirm-user_add').text("确 定").removeAttr("disabled");
                        getUsersPage();
                    });
                } else { //添加
                    $.toast({
                        position: 'top-center', icon: 'success', stack: false,
                        heading: 'Success', text: '添加成功，请继续添加下一条！',
                    });
                    // 清空页面不必要数据
                    $("#user_type").val('');
                    $("#user_nickname").val('');
                    $("#user_username").val('');
                    $("#user_phone").val('');
                    $("#user_email").val('');
                    $("#user_status").val('');

                    // 移除按钮的不可选状态，刷新列表
                    $('#smallModal .modal-footer #confirm-user_add').text("确 定").removeAttr("disabled");
                    getUsersPage();
                }
            } else {
                sweetAlert('失败', res.msg, 'error');
                $('#smallModal .modal-footer #confirm-user_add').text("确 定").removeAttr("disabled");
            }
        }, 'json');
    });

    // 用户删除操作
    $(document).on('click', '.users-lists a[rel=user_delete]', function () {
        var user_id = $(this).data('id');
        var elem = $(this).parent().parent();
        swal({
                title: "确认要删除吗?",
                text: "该用户将会被禁用",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "取 消",
                confirmButtonColor: "#00b7ee",
                confirmButtonText: "确 认",
                closeOnConfirm: false
            },
            function () {
                $.post("/user/user-delete", {'id': user_id}, function (res) {
                    if ( res.code == 200 ) {
                        $(elem).remove();
                        swal({title: "删除成功", text: "", type: "success"}, function () {
                            // 重载页面
                            getUsersPage();
                        });
                    } else {
                        sweetAlert("删除失败", res.msg, "error");
                    }
                }, 'json');
            }
        );
    });

    // 用户密码重置
    $(document).on('click', '.users-lists a[rel=user_password_reset]', function () {
        var user_id = $(this).data('id');
        swal({
                title: "确认要重置该用户密码吗?",
                text: "重置密码后，该用户需要用初始密码登录",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "取 消",
                confirmButtonColor: "#00b7ee",
                confirmButtonText: "确 认",
                closeOnConfirm: false
            },
            function () {
                $.post("/user/user-password-reset", {'id': user_id}, function (res) {
                    if ( res.code == 200 ) {
                        swal({title: "重置成功", text: "", type: "success"}, function () {
                        });
                    } else {
                        sweetAlert("重置失败", res.msg, "error");
                    }
                }, 'json');
            }
        );
    });
});
