<table class="table table-striped table-hover no-margin">
    <thead>
    <tr>
        <th>ID</th>
        <th>类型</th>
        <th>账户</th>
        <th>姓名</th>
        <th>手机号码</th>
        <th>邮箱</th>
        <th>状态</th>
        <th>添加时间</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $item): ?>
        <tr>
            <td>
                <span><?= $item['id'] ?></span>
            </td>
            <td>
                <span><?= $item['type_desc'] ?></span>
            </td>
            <td>
                <span><?= $item['username'] ?></span>
            </td>
            <td>
                <span><?= $item['nickname'] ?></span>
            </td>
            <td>
                <span><?= $item['phone'] ?></span>
            </td>
            <td>
                <span><?= $item['email'] ?></span>
            </td>
            <td>
                <span><?= $item['status_desc'] ?></span>
            </td>
            <td>
                <span><?=date('Y-m-d H:i:s',$item['created_time'])?></span>
            </td>
            <td>
                <span><?=date('Y-m-d H:i:s',$item['updated_time'])?></span>
            </td>
            <td>
                <a data-id="<?= $item['id'] ?>" rel="user_update" href="javascript:;"><span class="btn-green fa fa-edit"> 修改 </span></a>
                <?php if ( $item['status'] == 10 ) { ?>
                    <a data-id="<?= $item['id'] ?>" rel="user_delete" href="javascript:;"><span class="btn-red fa fa-close"> 删除 </span></a>
                <?php } ?>
                <a data-id="<?= $item['id'] ?>" rel="user_password_reset" href="javascript:;"><span class="btn-blue fa fa-refresh"> 重置密码 </span></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>