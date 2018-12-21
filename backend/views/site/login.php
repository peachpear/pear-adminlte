<?php
use yii\helpers\Html;

$this->title = '用户登录';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= Html::encode($this->title) ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">--> <!-- https 同源限制 -->
    <link rel="stylesheet" href="//cdn.staticfile.org/twitter-bootstrap/3.3.4/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/css/login.css" />
</head>
<body>
<div id="loginbox">
    <div class="icon-logo">
        <img src="/images/icon.jpg" />
    </div>

    <div class="control-group normal_text">
        <h1>
            For Happy => Come on!
        </h1>
    </div>
    <div class="control-group">
        <div class="controls">
            <div class="main_input_box">
                <span class="add-on bg_lg"><i class="fa fa-user"></i></span>
                <input id="username" name="username" placeholder="用户名" type="text" />

            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <div class="main_input_box">
                <span class="add-on bg_ly"><i class="fa fa-lock"></i></span>
                <input id="password" name="password" placeholder="密 码" type="password" />
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <div class="main_input_box">
                <span class="add-on"></span>
                <input type="submit" class="btn btn-success" value="登  录" />
            </div>
        </div>
    </div>
    <div class="error"></div>
    <div class="form-actions">
        <div class="cy">CopyRight &copy; 2019 &nbsp;&nbsp; Powered by PEACHPEAR.CO</div>
    </div>
</div>

<script src="//cdn.staticfile.org/jquery/3.1.1/jquery.min.js"></script>
<script>
    $(function () {
        $(".btn-success").click(function () {
            var username = $("#username").val();
            var password = $("#password").val();

            if($.trim(username) == ""){
                $(".error").text("请填写用户名!");
                return false;
            }

            if($.trim(password) == ""){
                $(".error").text("请填写密码!");
                return false;
            }

            $(".btn-success").val("正在登陆...").attr("disabled","true");
            var params = {
                "LoginForm[username]": username,
                "LoginForm[password]": password,
            };
            $.post("<?= Yii::$app->urlManager->createUrl('site/login')?>", params, function (res) {
                if ( res.code == 200 ) {
                    window.location.href = "/";
                } else {
                    $(".error").text( res.msg );
                    $(".btn-success").val("登  录").removeAttr("disabled");
                }
            }, 'json');
        });
    });
</script>
</body>
</html>