## 安装

> 当前为未发布版本，暂不推荐线上使用

```shell
composer require weforge/weforge:dev-master -vvv
```

## 微信平台

### 接口请求

```php
/**
 * 目前支持微信公众号、微信小程序和微信开放平台第三方平台
 * 请注意命名空间的区别
 */
use WeForge\WeChat\MediaPlatform as Client; // 微信公众号
use WeForge\WeChat\MiniProgram as Client; // 微信小程序
use WeForge\WeChat\OpenPlatform as Client; // 微信开放平台第三方平台

/**
 * 三种平台的实例化所需传入的配置信息格式一致
 */
$client = new Client([
    /**
     * 配置信息可在各平台的管理后台获取
     */
    'app_id' => 'wx1f94j83f01313e20',
    'secret' => '84jf35627f93j119bd7bcc1ba9jf01xv',
    'token' => 'NGeKijDkmS3D0fOrxaHQ2tAd',
    'aes_key' => 'hJ4OZKqaKEpoJp32ad7IHF9rYFyxpx7JMNuRYAK5RFW',
]);

/**
 * $response 默认返回为 Symfony\Component\HttpFoundation\Response 对象
 * 你可以使用全局 ResponseCasting 对 $response 进行处理（转换格式等） (详见 Response Casting)
 * 支持如下请求方式：
 */
$response = $client->get('cgi-bin/foo/bar', ['next_openid' => null]);
$response = $client->post('cgi-bin/foo/bar', ['name' => 'weforge']);
```

### Access Token 相关

#### 默认行为

```php
$client = new WeForge\WeChat\MediaPlatform\AccessTokenClient([
    'app_id' => 'wx1f94j83f01313e20',
    'secret' => '84jf35627f93j119bd7bcc1ba9jf01xv',
]);

/**
 * 获取 AccessToken
 * 该方法会从缓存中获取 AccessToken，如不存在，则请求微信 API，并缓存结果
 * 注意该获取方式不能保证 AccessToken 是可用状态
 *
 * SDK 行为：请求接口会调用该方法获取 access_token
 */
$client->getToken();

/**
 * 刷新 AccessToken
 * 该方法会删除已存在的缓存，并请求微信 API 获取，并缓存结果
 *
 * SDK 行为：当接口返回的 code 为 access_token 已失效或不是最新的情况下会调用该方法
 */
$client->freshToken();

/**
 * 从微信 API 请求 AccessToken
 * 直接请求微信 API，但不会把结果缓存，所以已经缓存的 AccessToken 有可能已失效
 */
$client->requestToken();
```

#### 自定义 Access Token 获取方式

> 如果你想使用其他方法获取 Access Token，你可以通过覆盖内置行为来实现

```php
use WeForge\WeChat\MediaPlatform\AccessTokenClient;

/**
 * 传入 callable 参数，可以接收 AppId 参数信息
 * 需要返回数组形式，格式如下（和微信接口返回格式一致）
 */
AccessTokenClient::getTokenUsing(function ($appId) {
    return [
        'expires_in' => 7200,
        'access_token' => 'ACCESS_TOKEN_STRING',
    ];
});

AccessTokenClient::freshTokenUsing(function ($appId) {
    return [
        'expires_in' => 7200,
        'access_token' => 'ACCESS_TOKEN_STRING',
    ];
});
```

## Response Casting

### 全局配置

```php
use WeForge\Http\Client;
use Psr\Http\Message\ResponseInterface;

Client::castsResponseUsing(function (ResponseInterface $response) {
    // 在此处处理你的逻辑
    // ...
});
```

### 使用内置 Trait

你可以直接使用内置的 `WeForge\Concerns\CastsResponse` Trait 来实现转换操作

```php
use WeForge\Concerns\CastsResponse;

class Controller
{
    use CastsResponse;

    public function index()
    {
        // $response 需为 Psr\Http\Message\ResponseInterface，如果使用了全局配置，则此方法不可用
        $array = $this->castsResponseToArray($response); // 转换为数组格式
        // ...
    }
}
```

### 临时关闭 Response Casting

```php
/**
 * 此处返回的 $response 为 Symfony\Component\HttpFoundation\Response 对象
 */
$response = $client->withoutResponseCasting(function ($client) {
    return $client->get('api/endpoint');
});
```

### 服务端接入

```php
use WeForge\WeChat\MediaPlatform\Server; // 微信公众号
use WeForge\WeChat\MiniProgram\Server; // 微信小程序
use WeForge\WeChat\OpenPlatform\Server; // 微信开放平台第三方平台

$server = new Server([
    /**
     * 配置信息如下所示，请传入正确的配置，否则可能会导致加解密失败
     */
    'app_id' => 'wx1f94j83f01313e20',
    'token' => 'NGeKijDkmS3D0fOrxaHQ2tAd',
    'aes_key' => 'hJ4OZKqaKEpoJp32ad7IHF9rYFyxpx7JMNuRYAK5RFW',
]);

/**
 * $response 为 Symfony\Component\HttpFoundation\Response 对象
 */
$response = $server->resolve();

/**
 * 输出响应内容
 */
$response->request();

/**
 * Laravel 等框架可以直接返回
 */
return $response;
```

# 框架集成

## 在 Laravel 中使用

> 支持 Laravel 6.x 版本

### 事件集成

> 可点击类名查看事件具体信息

|  | 事件名称  | 描述 |
| - | - | - |
| 微信开放平台第三方平台| [WeForge\WeChat\OpenPlatform\Laravel\Events\Authorized](#foo) | 授权方授权成功 |
| 微信开放平台第三方平台| [WeForge\WeChat\OpenPlatform\Laravel\Events\UpdateAuthorized](#foo) | 授权方授权更新 |
| 微信开放平台第三方平台| [WeForge\WeChat\OpenPlatform\Laravel\Events\Unauthorized](#foo) | 授权方取消授权 |
| 微信公众号 | [WeForge\WeChat\MediaPlatform\Laravel\Events\MessageReceived](#foo) | 接收到用户信息事件 |
