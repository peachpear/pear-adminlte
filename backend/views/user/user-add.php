<p>
    <select id="user_type" class="form-control">
        <?php if ( Yii::$app->user->identity->type == 10 ) { ?>
            <option value="" <?php if ( empty($data->type) ) { ?> selected="selected" <?php } ?>>请选择用户类型</option>
            <option value="10" <?php if ( !empty($data->type) && $data->type == 10 ) { ?> selected="selected" <?php } ?>>超级管理员</option>
            <option value="20" <?php if ( !empty($data->type) && $data->type == 20 ) { ?> selected="selected" <?php } ?>>管理员</option>
            <option value="30" <?php if ( !empty($data->type) && $data->type == 30 ) { ?> selected="selected" <?php } ?>>普通用户</option>
        <?php } elseif ( Yii::$app->user->identity->type == 20 ) { ?>
            <option value="30" selected="selected">普通用户</option>
        <?php } ?>
    </select>
</p>
<p>
    <input class="input-bottom" id="user_nickname" placeholder="请输入用户姓名" value="<?= empty($data['nickname']) ? '' : $data['nickname'] ?>">
</p>
<p>
    <input class="input-bottom" id="user_username" placeholder="请输入用户账户" value="<?= empty($data['username']) ? '' : $data['username'] ?>">
</p>
<p>
    <input class="input-bottom" id="user_phone" placeholder="请输入用户手机号码" value="<?=empty($data['phone']) ? '' : $data['phone'] ?>">
</p>
<p>
    <input class="input-bottom" id="user_email" placeholder="请输入用户邮箱" value="<?=empty($data['email']) ? '' : $data['email'] ?>">
</p>
<p>
    <select id="user_status" class="form-control">
        <option <?php if ( !isset($data->status) ) { ?> selected="selected" <?php } ?> value="">请选择用户状态</option>
        <option <?php if ( isset($data->status) && $data->status == 10 ) { ?> selected="selected" <?php } ?> value="10">正常</option>
        <option <?php if ( isset($data->status) && $data->status == 99 ) { ?> selected="selected" <?php } ?> value="99">禁用</option>
    </select>
</p>
<input type="hidden" id="user_id" value="<?= empty($data['id']) ? 0 : $data['id'] ?>" />