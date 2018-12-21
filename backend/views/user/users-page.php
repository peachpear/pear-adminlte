<div class="table-responsive lists-box">

</div>
<!-- /.table-responsive -->
<div class="pages-box">
    <ul class="pagination pull-left">
        <li>
            <a href="javascript:;">
                <span class="text-info">共 <b><?= $count ?></b> 条</span>
            </a>
        </li>
    </ul>
    <ul id="pagination-box" class="pagination pull-right"></ul>
</div>

<script>
$(function () {
    if ( <?= $count ?> > 0 ) {
        var getParams = <?= json_encode(Yii::$app->request->get(), JSON_UNESCAPED_SLASHES) ?>;
        var type = !getParams.type ? '' : $.trim(getParams.type);
        var status = !getParams.status ? '' : $.trim(getParams.status);
        var nickname = !getParams.nickname ? '' : $.trim(getParams.nickname);

        var order_name = $(".search-box-order .users-sort li.current").attr('id');
        switch ( order_name )
        {
            case '1':
                order_name = 'id';
                break;
            case '2':
                order_name = 'type';
                break;
            case '3':
                order_name = 'username';
                break;
            case '4':
                order_name = 'nickname';
                break;
            case '5':
                order_name = 'phone';
                break;
            case '6':
                order_name = 'email';
                break;
            case '7':
                order_name = 'status';
                break;
            case '8':
                order_name = 'created_time';
                break;
            case '9':
                order_name = 'updated_time';
                break;
            default:
                order_name = 'id';
        }
        var order_type = $(".search-box-order .users-sort li.current").attr('class');
        if ( new RegExp('down').test(order_type) ) {
            order_type = '1';
        } else {
            order_type = '0';
        }

        $('#pagination-box').jqPaginator({
            totalCounts: <?= $count ?>,
            pageSize: 15,
            visiblePages: 8,
            currentPage: 1,
            onPageChange: function (num) {
                $(".lists-box").load('/user/users-lists?type=' + type
                    + "&status=" + status
                    + "&nickname=" + nickname
                    + '&order_name=' + order_name
                    + '&order_type=' + order_type
                    + "&page_num=" + num
                );
            }
        });
    }
});
</script>