<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'http://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css',
        'AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css',  //  <!-- Bootstrap 3.3.7 -->
//        'http://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css',
        'AdminLTE/bower_components/font-awesome/css/font-awesome.min.css',  // <!-- Font Awesome 字体图标 -->
        'AdminLTE/bower_components/Ionicons/css/ionicons.min.css',  // <!-- Ionicons -->
//        'AdminLTE/bower_components/jvectormap/jquery-jvectormap.css',  // <!-- jvectormap 地图插件 -->
        'AdminLTE/dist/css/AdminLTE.min.css',  // <!-- Theme style -->
        'AdminLTE/dist/css/skins/_all-skins.min.css',  // <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
//        'plugins/msgbox/msgbox.css',  // ZENG.msgbox 腾讯弹窗插件
        'plugins/jquery.toast/jquery.toast.min.css',  // jquery.toast 弹窗插件
        'plugins/SweetAlert/sweetalert.css',  // SweetAlert 弹窗插件
        'plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css',  // bootstrap-datepicker 日期选择插件
        'css/msgbox.css?v=' .VERSION,  // ZENG.msgbox 腾讯弹窗插件 样式重写
        'css/home.css?v=' .VERSION,
    ];
    public $js = [
//        'http://cdn.staticfile.org/jquery/3.1.1/jquery.min.js',
        'AdminLTE/bower_components/jquery/dist/jquery.min.js',  // <!-- jQuery 3 -->
//        'http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js',
        'AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js',  // <!-- Bootstrap 3.3.7 -->
//        'AdminLTE/bower_components/fastclick/lib/fastclick.js',  // <!-- FastClick 点击插件 -->
        'AdminLTE/dist/js/adminlte.min.js',  // <!-- AdminLTE App 框架js -->
//        'AdminLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',  // <!-- Sparkline 图表插件 -->
//        'AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',  // <!-- jvectormap 地图控件 -->
//        'AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',  // <!-- jvectormap 地图插件 -->
//        'AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js',  // <!-- SlimScroll 侧边滚动条 -->
//        'AdminLTE/bower_components/chart.js/Chart.js',  // <!-- ChartJS 图表插件 -->
        'plugins/msgbox/msgbox.js',  // ZENG.msgbox  腾讯弹窗插件
        'plugins/jquery.toast/jquery.toast.min.js',  // jquery.toast  弹窗插件
        'plugins/SweetAlert/sweetalert.min.js',  // SweetAlert  弹窗插件
        'plugins/jqPaginator/src/js/jqPaginator.js',  // jqPaginator  分页组件
        'plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',  // bootstrap-datepicker 日期选择插件
        'plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-CN.min.js',  // bootstrap-datepicker 日期选择插件cn本土化
        'js/home.js?v=' .VERSION,
        'js/layoutSkins.js?v=' .VERSION,
        'js/menu.js?v=' .VERSION,
        'js/portal.js?v=' .VERSION,
        'js/user.js?v=' .VERSION,
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
