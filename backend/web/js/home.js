/**
 * 入口及菜单控制js
 */
$(function () {
    /*************************       页面初次加载      ***************************/
    $.ajaxSetup ({ cache: false });

    // 左侧菜单——加载
    ZENG.msgbox.show("正在加载数据...", 6);
    $(".sidebar-menu").empty().load('/home/menu');

    // 右侧内容区——加载
    $(".content-wrapper").empty().load('home/content', function () {
        $("[data-toggle='tooltip']").tooltip();
        ZENG.msgbox.hide();
    });

    /*************************       左侧菜单      ***************************/
    /**
     * 菜单切换
     */
    $(document).on('click', '.sidebar-menu .treeview .treeview-menu li', function () {
        $('.sidebar-menu').find('li.active').removeClass('active');
        $(this).parent().parent().addClass('active');
        $(this).addClass('active');
    });



});