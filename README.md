# 【OreoFrame微PHP快速开发框架】

> #### 手册阅读须知：本手册仅针对OreoFrame`1.0.*`版本
>
> *******************************************************************************

> **PHP框架各式各样，有很多出色的快速开发框架。但是，很多时候小白从框架开始入门往往会遇到很多难题，可能是因为自身技术不足或许框架的使用难度有点高，或者....。因为，这些问题，作者曾经也遇到过，但最终还是学会了使用这些优秀的框架。这个学的过程是漫长的，也是需要付出更多的时间来慢慢积累经验。但是现在，作者想做出一个疯狂的尝试，想开发出一款，简洁，易懂，易开发小型后端程序的PHP开发框架。可能，这个框架不太完美，不能与市面上的优秀框架媲美。但，作者相信，总有一天会做出一个很好的框架（当然，作者更希望有更多的开发者参与开发贡献代码），毕竟这个尝试也是对自己是一个挑战和学习的过程。 本框架的开发目的是让更多的小白开发者更快速的学习PHP，打造了一款PHP小白也能操作的框架 。**

# 一、基本

> 目前版本暂时不提供composer安装，所以我们首先需要到GitHub克隆最新代码到本地。
>
> ***
>
> 本框架还附赠一套后台管理系统和RBAC权限认证模块。前端部分采用Layui。如果你的项目不需要此模块，可以删除Controller，View，public/static 目录内的所有文件。



## 1.安装

```git
git clone https://github.com/emran519/oreoFrame
```

你可以直接克隆到项目文件，或者打包下载到本地。

框架需要配置伪静态规则：

Apache

```apache
RewriteEngine on 
RewriteCond %{REQUEST_FILENAME} !-d 
RewriteCond %{REQUEST_FILENAME} !-f 
RewriteRule ^(.*)$ index.php/$1 [L] 
```

Nginx

```Nginx
if (!-d $request_filename){
	set $rule_0 1$rule_0;
}
if (!-f $request_filename){
	set $rule_0 2$rule_0;
}
if ($rule_0 = "21"){
	rewrite ^/(.*)$ /index.php/$1 last;
}
```

```
运行目录设置为： /public
```



## 2.目录介绍

```
wwwroot                    WEB部署目录（或者子目录）     
├─config                   配置文件目录
│  ├─oreo_app.php          基本配置文件
│  ├─oreo_database.php     数据库配置文件
├─controller               控制器目录（项目文件目录）
├─oreo                     框架核心文件(不需要改动)
│  ├─extend                扩展类库目录
│  │  └─...                类库内容不一介绍
│  ├─lib                   框架核心类
│  │  ├─db                 数据库核心类
│  │  │  └─...             
│  │  ├─Cache.php          缓存类文件
│  │  ├─Config.php         配置类文件
│  │  ├─Controller.php     控制器类文件
│  │  ├─Db.php             数据库类文件
│  │  ├─Request.php        请求类文件
│  │  ├─Response.php       回应类文件
│  │  ├─Route.php          路由类文件
│  │  ├─SafetyCheck.php    安全检查类文件
│  │  ├─Tool.php           工具类文件
│  │  ├─Vew.php            视图类文件
│  ├─common.php            公共函数库
│  ├─init.php              入口文件
├─public                   公共文件目录
│  ├─index.php             入口文件
├─runtime                  缓存目录
├─view                     视图存放目录
```

## 3.配置文件

配置文件主要包括 config目录内的两个文件。这些文件文件分别包括：

>  oreo_app.php 框架基本配置文件

|       变量        |      参数      |       说明       |
| :---------------: | :------------: | :--------------: |
|       debug       |   true/false   | 是否开启错误提示 |
|  url_html_suffix  |   .html/.htm   |  URL伪静态后缀   |
|   response_type   | html/json/xml  |     输出格式     |
|  path_info_index  |   true/false   | 是否显示入口文件 |
|  path_info_only   |   true/false   |   强制pathInfo   |
|      safety       |   true/false   |     安全监测(如需必须开启Redis)     |
| safety_frequency  |  自定义(int)   | 恶意操作触碰频率 |
|    admin_salt     | 自定义(string) |      密码盐      |
| session['state']  |   true/false   | 是否开启session  |
| session['expire'] |  自定义(int)   | session过期时间  |
| session['secure'] |   true/false   |     安全选项     |
|  session['name']  | 自定义(string) |   session名称    |
|   redis['host']   |     string     |    Redis地址     |
|   redis['port']   |     string     |    Redis端口     |
| redis['password'] |       /        |    Redis密码     |

> oreo_database.php 框架数据库配置文件

|   变量   |          说明          |
| :------: | :--------------------: |
|   host   |       数据库地址       |
|   port   |       数据库端口       |
|   type   |  数据库驱动,填写mysql  |
|   user   |       数据库账号       |
| database |       数据库库名       |
| password |       数据库密码       |
| charset  | 数据库编码默认采用utf8 |
|  prefix  |      数据库表前缀      |
| connect  |     是否使用长连接     |

## 4.开发规范

所有的项目代码写进controller目录内，且控制器类首字母大写，注意使用控制器命名空间；例如 项目中创建 登录控制器，则需在controller目录内新增Login(当然命名自定义)文件。

实例：

```php
<?php

namespace controller;  //命名空间

use oreo\lib\Controller;  //引入Controller

class Login extends Controller{   //根据项目需要 也可以选择不继承Controller

	public function index(){  
	   //你的逻辑代码
	}

}

//以上代码的URL地址是 //域名/Login

//如果函数不是index或叫 oreo， 则路由地址为 //域名/Login/oreo
```

# 二、数据库

## 1.配置文件

> 在应用配置目录下面的`oreo_database.php`中（后面统称为数据库配置文件）配置下面的数据库参数：

```php
return [
    // 数据库地址
   "host" => "127.0.0.1",
    // 数据库端口
   "port" => 3306,
    // 数据库驱动
   "type" => "mysql",
    // 数据库账号
   "user" => "",
    // 数据库库名
    "database" => "",
   // 数据库密码
    "password" => "",
   // 数据库编码默认采用utf8
    "charset" => "utf8",
    // 数据库表前缀
   "prefix" => "",
    // 是否使用长连接
    "connect" => false,
];
```

## 2.查询构造器

框架提供数据库链式操作，table方法为数据库表名，如果配置文件中设置过 **数据库表前缀**，例如：数据库中有oreo_user表，配置文件 **数据库表前缀** 中设置了**oreo_**，则table方法内写入 user 即可，如果未配置则需写入完整的表名；

使用Db方法则需在项目文件中引入 Db类，例如：use oreo\lib\Db;

### 1.查询数据

查询单个数据使用`find`方法：

```php
//table方法如果未配置 数据库表前缀 则必须指定完整的数据表名
Db::table('oreo_user')->where('id',1)->find();
```

查询多个数据（数据集）使用`all`方法：

```php
Db::table('oreo_user')->where('status',1)->all();
```

如果设置了数据表前缀参数的话，可以使用

```php
Db::table('user')->where('id',1)->find();
Db::table('user')->where('status',1)->all();
```

当然数据库操作的过程中我们已经提供了参数绑定，但你也可以手动操作参数绑定

```php
Db::table('oreo_user')->where('id=:id')->bind(':id','1')->find();
```

### 2.添加数据

使用 `Db` 类的 `insert` 方法向数据库提交数据

```php
$data = ['name' => 'oreo', 'state' => '1'];
Db::table('oreo_user')->insert($data);
```

添加数据后如果需要返回新增数据的自增主键，可以使用`lastInsertId`方法新增数据并返回主键值：

```php
$data = ['foo' => 'bar', 'bar' => 'foo'];
Db::table('oreo_user')->insert($data);
Db::lastInsertId();
```

### 3.更新数据

```php
Db::table('oreo_user')->where('id', 1)->update(['name' => 'oreo']);
//
$data = ['name' => 'oreo', 'state' => '1'];
Db::table('oreo_user')->where('id', 1)->update($data);
```

### 4.删除数据

```php
Db::table('oreo_user')->where('id',1)->delete();
Db::table('oreo_user')->where('id',1,'<>')->delete();
```

### 5.查询表达式

查询表达式支持大部分的SQL查询语法，查询表达式的使用格式：

```php
where('字段名','查询条件','表达式');
//如果为 = 则不用写 表达式
```

表达式不分大小写，支持的查询表达式有下面几种：

| 表达式 | 含义     |
| ------ | -------- |
| =      | 等于     |
| <>     | 不等于   |
| >      | 大于     |
| >=     | 大于等于 |
| <      | 小于     |
| <=     | 小于等于 |

#### 等于（=）

```php
Db::table('user')->where('id',1)->find();
//和下面的查询等效
Db::table('user')->where('id',1,'=')->find();
```

#### 不等于（<>）

```php
Db::table('user')->where('id',1,'<>')->all();
```

#### 大于（>）

```php
Db::table('user')->where('id',1,'>')->all();
```

#### 大于等于（>=）

```php
Db::table('user')->where('id',1,'>=')->all();
```

#### 小于（<）

```php
Db::table('user')->where('id',10,'<')->all();
```

#### 小于等于（<=）

```php
Db::table('user')->where('id',10,'<=')->all();
```

#### 其他支持

当然除了以上几个基本条件外，SQL的查询条件也会有各种复杂条件的条件，这种情况框架也会支持原生方法，你可以直接在where方法内写入

```php
Db::table('user')->where(" `name` LIKE '%oreo' OR `name` LIKE 'php%' ")->all();
```

以上语句生成

```mysql
select * from oreo_test  where  `name` LIKE '%oreo' OR `name` LIKE 'php%' 
```

### 6.链式操作

#### table

`table`方法主要用于指定操作的数据表。

`table`方法分两种情况，1.设置了表前端 2.未设置表前端

例如，以下是未配置 表前端的实例：

```php
return [
   //.......
    // 数据库表前缀
   "prefix" => "", //未配置
   ..../
];
```

```php
Db::table('oreo_user')->where('type>1')->all();
```

以下是已配置表前端的实例：

```php
return [
   //.......
    // 数据库表前缀
   "prefix" => "oreo_", //已配置
   ..../
];
```

```php
Db::table('user')->where('type>1')->all();
```

总结：如果未配置**表前端**则需要添加**完整的数据表**，则只需写入后半部分

#### where

`where`方法主要用于查询表达式。

具体使用方法在 第二章-->查询构造器-->查询表达式内讲解

#### alias

`alias`用于设置当前数据表的别名，便于使用其他的连贯操作例如join方法等。

示例：

```php
Db::table('oreo_user')
->alias('a')
->join('oreo_wx b','b.user_id= a.id')
->all();
```

执行的SQL相当于：

```mysql
select * from oreo_oreo_user AS a  inner join oreo_wx b on b.user_id= a.id 
```

当让这里的join方法我们在后面继续讲

#### field

`field`方法主要作用是标识要返回或者操作的字段，可以用于查询和写入操作。

指定字段：

```php
Db::table('oreo_user')->field('id,name,type')->all();
```

这里使用field方法指定了查询的结果集中包含id,name,type三个字段的值。执行的SQL相当于：

```mysql
SELECT id,title,type FROM oreo_user
```

可以给某个字段设置别名，例如：

```php
Db::table('oreo_user')->field('id,username as name,email as mail,phone')->find();
```

执行的SQL语句相当于：

```mysql
SELECT id,username as name,email as mail,phone FROM oreo_user
```

**使用SQL函数**

可以在field方法中直接使用函数，例如：

```php
Db::table('oreo_user')->field('user_money,SUM(money)')->all();
```

执行的SQL相当于：

```mysql
SELECT user_money,SUM(money) FROM oreo_user
```

> 除了all方法之外，所有的查询方法，包括find等都可以使用field方法。

**使用数组参数**

field方法的参数可以支持数组，例如：

```php
Db::table('oreo_user')->field(['id','username','email'])->all();
```

最终执行的SQL和前面用字符串方式是等效的。

数组方式的定义可以为某些字段定义别名，例如：

```php
Db::table('oreo_user')->field(['id','username'=>'name'])->all();
```

执行的SQL相当于：

```mysql
SELECT id,username as name FROM oreo_user
```

#### limit

`limit`方法主要用于指定查询和操作的数量

**限制结果数量**

例如获取满足要求的5个用户，如下调用即可：

```php
Db::table('oreo_user')
    ->where('type',1)
    ->limit(5)
    ->all();
```

**分页查询**

用于文章分页查询是limit方法比较常用的场合，例如：

```php
Db::table('oreo_user')->limit(10,60)->all();
```

表示查询文章数据，从第10行开始的60条数据（可能还取决于where条件和order排序的影响 这个暂且不提）。

#### order

`order`方法用于对操作的结果排序或者优先级限制。

用法如下：

```php
Db::table('oreo_user')
->where('type', 1)
->order('id', 'desc')
->limit(10)
->all();
```

执行的SQL相当于：

```mysql
 SELECT * FROM `oreo_user` WHERE `type` = 1 ORDER BY `id` desc LIMIT 10
```

如果没有指定`desc`或者`asc`排序规则的话，默认为``desc``。

#### join

`JOIN`方法用于根据两个或多个表中的列之间的关系，从这些表中查询数据。join通常有下面几种类型，不同类型的join操作会影响返回的数据结果。

- **INNER JOIN**: 等同于 JOIN（默认的JOIN类型）,如果表中有至少一个匹配，则返回行
- **LEFT JOIN**: 即使右表中没有匹配，也从左表返回所有的行
- **RIGHT JOIN**: 即使左表中没有匹配，也从右表返回所有的行
- **FULL JOIN**: 只要其中一个表中存在匹配，就返回行

```
要关联的（完整）表名以及别名
```

支持的写法：

- 写法1：[ '完整表名或者子查询'=>'别名' ]
- 写法2：'不带数据表前缀的表名'（自动作为别名）
- 写法2：'不带数据表前缀的表名 别名'

例如

```php
Db::table('oreo_user')
->alias('a')
->join('oreo_wx b','a.id = b.wx_id')
->join('oreo_test c','a.test_id = c.id')
->all();
```

//

```php
 Db::table('oreo_user')
     ->alias('a')
     ->join('oreo_auth_role b','a.role_id = b.id')
     ->field('a.id,b.id as role_id,a.username,a.gender,a.real_name,a.user_phone,a.user_email,a.state,a.create_time,b.role_name')
     ->limit(0,30)->all();
```

#### count

`count`方法用于统计数据。

获取用户数：

```php
Db::table('oreo_user')->count();
```

实际生成的SQL语句是：

```php
select count(*) from oreo_user limit 1
```

### 3.事务操作

例如：

```php
// 启动事务
Db::begin();
try {
    Db::table('oreo_user')->where('id',1)->update(['name'=>'oreo']);
    Db::table('oreo_user')->where('id',10)->delete();
    // 提交事务
    Db::commit();
} catch (\Exception $e) {
    // 回滚事务
    Db::rollback();
}
```
