I fork form [https://github.com/iignatov/LightOpenID](https://github.com/iignatov/LightOpenID)  
and translate it

# LightOpenID

Lightweight PHP5 library for easy OpenID authentication.

* `版本:` [**1.3.1** :arrow_double_down:][1] ( *看 [改版日誌][2] 更詳細* )
* `發佈於:` 2016年 3月4號
* `原始碼:` [Official GitHub Repo :octocat:][3]
* `作者:` [Mewp][4]

[1]: https://github.com/iignatov/LightOpenID/archive/master.zip
[2]: https://github.com/iignatov/LightOpenID/blob/master/CHANGELOG.md
[3]: https://github.com/Mewp/lightopenid
[4]: https://github.com/Mewp


## 快速開始

### 加到 composer.json

```javascript
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/lovenery/LightOpenID"
  }
],

"require": {
  "php": ">=5.4.0",
  "iignatov/lightopenid": "1.3.1"
}
```

### 兩個步驟 登入 OpenID :

  1. Authentication with the provider:

     ```php
     $openid = new LightOpenID('my-host.example.org');

     $openid->identity = 'ID supplied by user';

     header('Location: ' . $openid->authUrl());
     ```
  2. Verification:

     ```php
     $openid = new LightOpenID('my-host.example.org');

     if ($openid->mode) {
       echo $openid->validate() ? 'Logged in.' : 'Failed!';
     }
     ```

### 也支援 AX and SREG extensions:

  在呼叫 `$openid->authUrl()` 之前, 只需要設定 `$openid->required` and/or `$openid->optional`  
  裡面都是放array,內容是 AX schema paths
  (path是網址的一部份). 例如:

  ```php
  $openid->required = array('namePerson/friendly', 'contact/email');
  $openid->optional = array('namePerson/first');
  ```

  取得你要得數值:
  ```php  
  $openid->getAttributes();
  ```

  更多使用方法可以看 [USAGE.md](http://github.com/iignatov/LightOpenID/blob/master/USAGE.md).
