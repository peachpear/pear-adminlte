# pear-api
pear让你更畅快地编程。pear-web是以pear-api为基础，增加web必要服务，重构为提供web访问服务的框架。

### 使用说明

```
cd /yourProjectParentPath

composer create-project peachpear/pear-web yourProjectName

cd /path/yourProjectName/backend/config

ln -sf dev.php main.php
```

nginx 配置
```
server {
    charset utf-8;
    client_max_body_size 128M;

    listen 80; ## listen for ipv4
    #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

    server_name yourServerName;
    root        /path/yourProjectName/backend/web;
    index       index.php;

    location / {
        # Redirect everything that isn't a real file to index.php
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include fastcgi.conf;
        fastcgi_pass   127.0.0.1:9000;
        #fastcgi_pass unix:/var/run/php5-fpm.sock;
        try_files $uri =404;
    }

    #error_page 404 /404.html;

    location ~ /\.(ht|svn|git) {
        deny all;
    }
}
```

#### 目录结构
```
├── backend
|   ├── components
|   ├── config
|   ├── controllers
|   └── lib
├── common
│   ├── components
│   ├── config
│   ├── dao
│   ├── exception
│   ├── lib
│   ├── misc
│   ├── models
│   └── service
└── console
    ├── components
    ├── config
    └── controllers    
```

#### 编码规范
```
1.PHP所有 关键字 必须 全部小写（常量 true 、false 和 null 也 必须 全部小写）
2.命名model对应的class 必须 以Model结尾
3.命名service对应的class 必须 以Service结尾
4.命名dao对应的class 必须 以Dao结尾
5.数据库查询返回接口 应该 使用model对象/对象列表
6.数据库的key必须是dbname+DB形式，e.g:dbname为test,则key为testDB
7.dao目录存放sql语句或者orm
8.model目录存放对应的数据实例对象
9.service目录存放业务逻辑处理
```

#### 用户表
```
-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` smallint(6) NOT NULL DEFAULT '30' COMMENT '用户类型：10、超级管理员；20：管理员；30：普通用户',
  `username` varchar(255) NOT NULL COMMENT '用户账户',
  `auth_key` varchar(32) NOT NULL COMMENT '认证key',
  `password_hash` varchar(255) NOT NULL COMMENT '密码',
  `password_reset_token` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) NOT NULL COMMENT '用户姓名',
  `phone` varchar(24) NOT NULL DEFAULT '' COMMENT '用户手机号码',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '用户状态：10、正常；99：禁用',
  `created_time` int(11) NOT NULL COMMENT '添加时间',
  `created_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '添加用户',
  `updated_time` int(11) NOT NULL COMMENT '更新时间',
  `updated_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '10', 'admin', 'mwrf34kLfW85FVN5X88166bulEhRkzQe', '$2y$13$LDJ4J0rX0YIQX/TcPPilqOzSQb.mhaPC7HjaTef9i0MfrLGwoUQny', null, '超级管理员', '1010', 'admin@demo.com', '10', '1541507292', '0', '1545362198', '1');
```