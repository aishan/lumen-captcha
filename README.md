# Captcha for Lumen

本项目修改自 [Captcha for Laravel 5](https://github.com/mewebstudio/captcha).


## 预览效果图
![Preview](http://i.imgur.com/HYtr744.png)

## 安装
* 项目必须启用缓存才能使用，因为验证码和验证码绑定的uuid都是保存在缓存的。
project's `composer.json`.
```json
composer require aishan/lumen-captcha
```

or

```json
{
    "require": {
        "laravel/lumen-framework": "5.3.*",
        "aishan/lumen-captcha": "v1.1"
    },
    "minimum-stability": "dev"
}
```

## 使用

在`bootstrap/app.php`中注册Captcha Service Provider：

```php
    //验证码
    $app->register(Aishan\LumenCaptcha\CaptchaServiceProvider::class);
    class_alias('Aishan\LumenCaptcha\Facades\Captcha','Captcha');
```


## 配置

在`bootstrap/app.php`中可以配置各种自定义类型的验证码属性：
更多详细配置请查看https://github.com/mewebstudio/captcha
```php
/**
 * captcha配置
 */
config(['captcha'=>
            [
                'useful_time'=>5,//验证码有效时间，单位（分钟）
                'default'   => [//默认验证码样式
                    'length'    => 4,
                    'width'     => 120,
                    'height'    => 36,
                    'quality'   => 90,
                ],
            ]
]);
```
当然，也可以不配置，默认就是default的样式，验证码有效时间5分钟。
## 使用范例
因为lumen一般写的都是无状态的API，所以此处验证码的图片必须绑定一个uuid，获取图片验证码时，先获取验证码url地址和uuid，然后在验证时，提交验证码和uuid一并验证码。
### 生成验证码
获取验证码信息：
```
{站点域名}/captchaInfo/{type?}
```
其中`type`就是在配置文件中定义的验证码类型（如果你定义了的话），当然也可以不指定`type`，则默认为`default`，返回信息：
```json
{
  "code": "10000",
  "msg": "success",
  "sub_code": "",
  "sub_msg": "",
  "result": {
    "captchaUrl": "{站点域名}/captcha/default/fc1d7d7f-3d8c-652a-5e92-90e9822740ad",
    "captchaUuid": "fc1d7d7f-3d8c-652a-5e92-90e9822740ad"
  }
}
```
`captchaUrl`为验证码图片地址，`captchaUuid`为绑定验证码图片的uuid。
#### 验证验证码
在请求中将验证码的值和uuid随着你的post请求一起发到服务端，在接收参数的地方做验证即可：
```php
public function checkCaptcha(Request $request, $type = 'default',$captchaUuid)
    {
        $this->validate($request,[
            'captcha'=>'required|captcha:'.$captchaUuid
        ]);
        ...
    }
```


## Links
* [Intervention Image](https://github.com/Intervention/image)
* [L5 Captcha on Github](https://github.com/mewebstudio/captcha)
* [L5 Captcha on Packagist](https://packagist.org/packages/mews/captcha)
* [For L4 on Github](https://github.com/mewebstudio/captcha/tree/master-l4)
* [License](http://www.opensource.org/licenses/mit-license.php)
* [Laravel website](http://laravel.com)
* [Laravel Turkiye website](http://www.laravel.gen.tr)
* [MeWebStudio website](http://www.mewebstudio.com)

