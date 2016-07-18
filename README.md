I fork form [https://github.com/iignatov/LightOpenID](https://github.com/iignatov/LightOpenID)  
and translate it readability for chinese users

# LightOpenID

輕量的OpenID認證library(PHP5)

* `版本:` [**1.3.1** :arrow_double_down:][1] ( *看 [原作者的改版日誌][2] 更詳細* )
* `發佈於:` 2016年 3月4號
* `作者的原始碼:` [Official GitHub Repo :octocat:][3]
* `作者:` [Mewp][4]

[1]: https://github.com/lovenery/LightOpenID/archive/master.zip
[2]: https://github.com/iignatov/LightOpenID/blob/master/CHANGELOG.md
[3]: https://github.com/Mewp/lightopenid
[4]: https://github.com/Mewp


## 快速開始

### 加到 composer.json

`composer require lovenery/lightopenid`

或

```javascript
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/lovenery/LightOpenID"
  }
],

"require": {
  "php": ">=5.4.0",
  "lovenery/lightopenid": "1.3.1"
}
```

### 兩個步驟 登入 OpenID :

  1. (Authentication)認證使用provider:

     ```php
     $openid = new LightOpenID('my-host.example.org');

     $openid->identity = 'ID supplied by user';

     header('Location: ' . $openid->authUrl());
     ```

     The provider then sends various parameters via GET, one of which is `openid_mode`.

  2. (Verification)驗證是否成功:

     ```php
     $openid = new LightOpenID('my-host.example.org');

     if ($openid->mode) {
       echo $openid->validate() ? 'Logged in.' : 'Failed!';
     }
     ```

### 註:

   變更 'my-host.example.org' 變更成你的 domain name. 不要用 `$_SERVER['HTTP_HOST']`
   除非你知道自己在幹麻

   選擇性地, 你可以設定 `$returnUrl` 和 `$realm` (或 `$trustRoot`, which is an alias).
   程式的初始值是以下:

   ```php
   $openid->realm = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
   $openid->returnUrl = $openid->realm . $_SERVER['REQUEST_URI'];
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

## 基本設定選項詳細(可略):

  <table>
    <tr>
      <th>名字</th>
      <th>詳細</th>
    </tr>
    <tr>
      <td>identity</td>
      <td>
        Sets (or gets) the identity supplied by an user. Set it
        before calling authUrl(), and get after validate().
      </td>
    </tr>
    <tr>
      <td>returnUrl</td>
      <td>
        Users will be redirected to this url after they complete
        authentication with their provider. Default: current url.
      </td>
    </tr>
    <tr>
      <td>realm</td>
      <td>
        The realm user is signing into. Providers usually say
        "You are sgning into $realm". Must be in the same domain
        as returnUrl. Usually, this should be the host part of
        your site's url. And that's the default.
      </td>
    </tr>
    <tr>
      <td>required and optional</td>
      <td>
        Attempts to fetch more information about an user.
        See <a href="#common-ax-attributes">Common AX attributes</a>.
      </td>
    </tr>
    <tr>
      <td>verify_peer</td>
      <td>
        When using https, attempts to verify peer's certificate.
        See <a href="http://php.net/manual/en/function.curl-setopt.php">CURLOPT_SSL_VERIFYPEER</a>.
      </td>
    </tr>
    <tr>
      <td>cainfo and capath</td>
      <td>
        When verify_peer is true, sets the CA info file and directory.
        See <a href="http://php.net/manual/en/function.curl-setopt.php">CURLOPT_SSL_CAINFO</a>
        and <a href="http://php.net/manual/en/function.curl-setopt.php">CURLOPT_SSL_CAPATH</a>.
      </td>
    </tr>
  </table>


### Common AX attributes (可略)

    Here is a list of the more common AX attributes (from [axschema.org](http://www.axschema.org/types/)):

    Name                    | Meaning
    ------------------------|---------------
    namePerson/friendly     | Alias/Username
    contact/email           | Email
    namePerson              | Full name
    birthDate               | Birth date
    person/gender           | Gender
    contact/postalCode/home | Postal code
    contact/country/home    | Country
    pref/language           | Language
    pref/timezone           | Time zone

    Note that even if you mark some field as required, there is no guarantee that you'll get any
    information from a provider. Not all providers support all of these attributes, and some don't
    support these extensions at all.

    Google, for example, completely ignores optional parameters, and for the required ones, it supports,
    according to [it's website](http://code.google.com/apis/accounts/docs/OpenID.html):

    * namePerson/first (first name)
    * namePerson/last (last name)
    * contact/country/home
    * contact/email
    * pref/language
