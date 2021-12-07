BrownLNMP（Docker + Nginx + MySQL + PHP7 + Redis+supervisor）是一款全功能的**LNMP一键安装程序**。



## 项目目的：

1. 支持**多版本PHP**切换
2. 支持**HTTPS**
3. **PHP源代码、MySQL数据、配置文件、日志文件**在相应目录中中直接修改查看
4. **完整PHP扩展安装**命令
5. 后续加入：
   - 数据库：memcached（后续加入）、MongoDB（后续加入）、ElasticSearch（后续加入）
   - 消息队列：RabbitMQ（后续加入）
   - 辅助工具：Kibana（后续加入）、Logstash（后续加入）、phpMyAdmin（后续加入）、phpRedisAdmin（后续加入）、AdminMongo（后续加入）
6. 支持快速安装扩展命令 `install-php-extensions apcu`



## 目录结构

```
/
├── data                        数据库数据目录（容器启动后创建）
│   ├── mysql                   MySQL8 数据目录
│   └── mysql5                  MySQL5 数据目录
├── services                    服务构建文件和配置文件目录（初始目录）
│   ├── mysql8                  MySQL8 配置文件目录
│   ├── mysql5                  MySQL5 配置文件目录
│   ├── nginx                   Nginx 配置文件目录
│   ├── php                     PHP 配置目录
│   ├── openresty               openresty 配置目录
│   ├── supervisor              supervisor 配置目录
│   └── redis                   Redis 配置目录
├── logs                        日志目录（容器启动后创建）
├── docker-compose.example.yml   Docker 服务配置示例文件
├── env.example                  环境配置示例文件
└── www                         PHP 代码目录（初始目录）
```

## 快速使用

1. 本地安装

   - `git`
   - `Docker`(系统需为Linux，Windows 10 Build 15063+，或MacOS 10.12+，且必须要`64`位）
   - `docker-compose 1.7.0+`

2. ```
   clone
   ```

   项目：

   ```
   $ git clone https://gitee.com/brown_sweet/brown-lnmp.git
   ```

3. 如果不是**root**用户，还需将当前用户加入**docker**用户组：

   ```
   $ sudo gpasswd -a ${USER} docker
   ```

4. 拷贝并命名配置文件，启动：

   ```
   $ cd brown-lnmp                                     # 进入项目目录
   $ cp env.example .env                               # 复制环境变量文件
   $ cp docker-compose.example.yml docker-compose.yml  # 复制 docker-compose 配置文件。默认启动3个服务：
                                                       # Nginx、PHP7和MySQL8。要开启更多其他服务，如Redis、
                                                       # PHP5.6、PHP5.4、MongoDB，ElasticSearch等，请删
                                                       # 除服务块前的注释
   $ docker-compose up                                 # 启动
   $ docker-compose up -d                              # 后台启动
   ```

5. 在浏览器中访问

## PHP和扩展

### 切换Nginx使用的PHP版本

切换其他版本的PHP，需要在.env中php版本切换（仅支持php5.6-php7），php5.6以下及php8暂不支持。

重新build镜像

```bash
docker-compose build php
```

**重启 Nginx**

```bash
$ docker exec -it tynginx nginx -s reload
```

### 安装PHP扩展

`.env`文件修改如下的PHP配置， 增加需要的PHP扩展：

```bash
PHP_EXTENSIONS=pdo_mysql,opcache,redis       # PHP 要安装的扩展列表，英文逗号隔开
```

然后重新build镜像。

```bash
docker-compose build php
```

可以安装的拓展

```
# pdo_mysql,zip,pcntl,mysqli,mbstring,exif,bcmath,calendar,
# sockets,gettext,shmop,sysvmsg,sysvsem,sysvshm,pdo_rebird,
# pdo_dblib,pdo_oci,pdo_odbc,pdo_pgsql,pgsql,oci8,odbc,dba,
# gd,intl,bz2,soap,xsl,xmlrpc,wddx,curl,readline,snmp,pspell,
# recode,tidy,gmp,imap,ldap,imagick,sqlsrv,mcrypt,opcache,
# redis,memcached,xdebug,swoole,pdo_sqlsrv,sodium,yaf,mysql,
# amqp,mongodb,event,rar,ast,yac,yar,yaconf,msgpack,igbinary,
# seaslog,varnish,xhprof,xlswriter,memcache,rdkafka,zookeeper,
# psr,phalcon,sdebug,ssh2,yaml,protobuf,hprose
```

### 快速安装php扩展

*Number of supported extensions: 115*

此扩展来自https://github.com/mlocati/docker-php-extension-installer

1.进入容器:

```sh
docker exec -it php /bin/sh

install-php-extensions 拓展名称
```

2.支持快速安装扩展列表

| Extension                                           | PHP 5.5 | PHP 5.6 | PHP 7.0 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 | PHP 8.1 |
| --------------------------------------------------- | ------- | ------- | ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| amqp                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| apcu                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| apcu_bc                                             |         |         | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |
| ast                                                 |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| bcmath                                              | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| blackfire                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| bz2                                                 | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| calendar                                            | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| cmark                                               |         |         | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |
| csv                                                 |         |         |         |         |         | ✓       | ✓       | ✓       | ✓       |
| dba                                                 | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| decimal                                             |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| ds                                                  |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| enchant                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| ev                                                  | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| event                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| excimer                                             |         |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| exif                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| ffi                                                 |         |         |         |         |         |         | ✓       | ✓       | ✓       |
| gd                                                  | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| gearman                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| geoip                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |
| geospatial                                          | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| gettext                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| gmagick                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| gmp                                                 | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| gnupg                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| grpc                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| http                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| igbinary                                            | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| imagick                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| imap                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| inotify                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| interbase                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |         |
| intl                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| ioncube_loader                                      | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |
| jsmin                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |
| json_post                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| ldap                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| lzf                                                 | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| mailparse                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| maxminddb                                           |         |         |         |         | ✓       | ✓       | ✓       | ✓       | ✓       |
| mcrypt                                              | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| memcache                                            | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| memcached                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| mongo                                               | ✓       | ✓       |         |         |         |         |         |         |         |
| mongodb                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| mosquitto                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |
| msgpack                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| mssql                                               | ✓       | ✓       |         |         |         |         |         |         |         |
| mysql                                               | ✓       | ✓       |         |         |         |         |         |         |         |
| mysqli                                              | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| oauth                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| oci8                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| odbc                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| opcache                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| opencensus                                          |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| parallel[*](#special-requirements-for-parallel)     |         |         |         | ✓       | ✓       | ✓       | ✓       |         |         |
| pcntl                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| pcov                                                |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| pdo_dblib                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| pdo_firebird                                        | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| pdo_mysql                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| pdo_oci                                             |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| pdo_odbc                                            | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| pdo_pgsql                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| pdo_sqlsrv[*](#special-requirements-for-pdo_sqlsrv) |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| pgsql                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| propro                                              | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |
| protobuf                                            | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| pspell                                              | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| pthreads[*](#special-requirements-for-pthreads)     | ✓       | ✓       | ✓       |         |         |         |         |         |         |
| raphf                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| rdkafka                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| recode                                              | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |         |
| redis                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| seaslog                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| shmop                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| smbclient                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| snmp                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| snuffleupagus                                       |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| soap                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| sockets                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| solr                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| sourceguardian                                      | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| spx                                                 |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| sqlsrv[*](#special-requirements-for-sqlsrv)         |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| ssh2                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| stomp                                               | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |
| swoole                                              | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| sybase_ct                                           | ✓       | ✓       |         |         |         |         |         |         |         |
| sysvmsg                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| sysvsem                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| sysvshm                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| tensor                                              |         |         |         |         | ✓       | ✓       | ✓       | ✓       |         |
| tidy                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| timezonedb                                          | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| uopz                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| uploadprogress                                      | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| uuid                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| vips[*](#special-requirements-for-vips)             |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| wddx                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |         |         |
| xdebug                                              | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| xhprof                                              | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| xlswriter                                           |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| xmldiff                                             | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| xmlrpc                                              | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| xsl                                                 | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| yac                                                 |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| yaml                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |         |
| yar                                                 | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| zephir_parser                                       |         |         | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| zip                                                 | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| zookeeper                                           | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |
| zstd                                                | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       | ✓       |

### 使用composer

### 容器内使用composer命令

进入容器，再执行`composer`命令

```bash
docker exec -it php /bin/sh
cd /www/localhost
composer require  ***
```

## 管理命令

### 服务器启动和构建命令

如需管理服务，请在命令后面加上服务器名称，例如：

```bash
$ docker-compose up                         # 创建并且启动所有容器
$ docker-compose up -d                      # 创建并且后台运行方式启动所有容器
$ docker-compose up nginx php mysql         # 创建并且启动nginx、php、mysql的多个容器
$ docker-compose up -d nginx php  mysql     # 创建并且已后台运行的方式启动nginx、php、mysql容器


$ docker-compose start php                  # 启动服务
$ docker-compose stop php                   # 停止服务
$ docker-compose restart php                # 重启服务
$ docker-compose build php                  # 构建或者重新构建服务

$ docker-compose rm php                     # 删除并且停止php容器
$ docker-compose down                       # 停止并删除容器，网络，图像和挂载卷
```



