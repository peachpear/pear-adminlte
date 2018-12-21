/**
 * 左侧菜单点击js
 */
$(function () {
    /**
     * 首页部分
     */
    // 我的首页
    $(document).on('click','.treeview-menu #menu_home-content',function () {
        ZENG.msgbox.show("正在加载数据...", 6);
        $(".content-wrapper").empty().load('/home/content',function () {
            ZENG.msgbox.hide();
        });
    });

    /**
     * 用户管理部分
     */
    // 用户列表
    $(document).on('click','.treeview-menu #menu_users',function () {
        ZENG.msgbox.show("正在加载数据...", 6);
        $(".content-wrapper").empty().load('/user/users',function () {
            $(".content .page-lists").empty().load('/user/users-page', function(){
                ZENG.msgbox.hide();
            });
        });
    });

    /**
     * 客户管理部分
     */
    // 客户列表
    $(document).on('click','.treeview-menu #menu_clients',function () {
        ZENG.msgbox.show("正在加载数据...", 6);
        $(".content-wrapper").empty().load('/client/clients',function () {
            $(".content .page-lists").empty().load('/client/clients-page', function(){
                ZENG.msgbox.hide();
            });
        });
    });
});