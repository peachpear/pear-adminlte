<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        用户列表
        <small>所有用户</small>
    </h1>
    <button id="btn-user_add" type="submit" class="btn header-right-btn btn-primary pull-right">添加用户</button>
</section>

<!-- Main content -->
<section class="content">
    <!-- Info boxes -->
    <div class="box box-info">
        <div class="box-body">
            <div class="search-box users-search">
                <div class="search-box-li search-box-selects">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-3 search-box-li-title">筛选：</div>
                        <div class="col-md-11 col-sm-10 col-xs-9 search-box-li-content">
                            <select id="search-box-users_type" class="form-control search-box-select" style="width: 200px;">
                                <?php if ( Yii::$app->user->identity->type == 10 ) { ?>
                                    <option value="">全部类型</option>
                                    <option value="10">超级管理员</option>
                                    <option value="20">管理员</option>
                                    <option value="30">普通用户</option>
                                <?php } elseif ( Yii::$app->user->identity->type == 20 ) { ?>
                                    <option value="30" selected="selected">普通用户</option>
                                <?php } ?>
                            </select>
                            <select id="search-box-users_status" class="form-control search-box-select" style="width: 160px;">
                                <option value="">所有状态</option>
                                <option value="10">正常</option>
                                <option value="99">禁用</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="search-box-li search-box-text">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-3 search-box-li-title">快搜：</div>
                        <div class="col-md-11 col-sm-10 col-xs-9 search-box-li-content">
                            <div class="fa fa-search text-grey search-box-text-img"></div>
                            <input class="form-control search-box-text-area" id="search-box-users_nickname" placeholder="姓名" type="text">
                        </div>
                    </div>
                </div>
                <div class="search-box-li search-box-order">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-3 search-box-li-title">排序：</div>
                        <div class="col-md-11 col-sm-10 col-xs-9 search-box-li-content">
                            <ul class="sort-type users-sort">
                                <li id="1" class="current up">按ID<span>&nbsp;</span><span class="fa fa-long-arrow-up"></span></li>
                                <li id="2">按类型</li>
                                <li id="3">按账户</li>
                                <li id="4">按姓名</li>
                                <li id="5">按手机号码</li>
                                <li id="6">按邮箱</li>
                                <li id="7">按状态</li>
                                <li id="8">按添加时间</li>
                                <li id="8">按更新时间</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-lists users-lists">

            </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<!-- /.content -->