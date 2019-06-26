<?php
// createMenu.php

header('Content-Type: text');

// 1.URL(appid和appsecret换成自己测试账号对应值)
$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxadfce85759f4629d&secret=e03b11b28d406a42b04f60920ab72c7a';
// 2.CURL函数四步
// 2.1 初始化对象
$ch = curl_init();
// 2.2 设置选项: URL, 默认就是GET请求
curl_setopt($ch, CURLOPT_URL, $url);
// curl_exec()获取的信息以字符串返回
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 2.3 执行请求; 接收返回JSON
$result = curl_exec($ch);
// 2.4 关闭会话(释放内存)
curl_close($ch);
// 3.查看$result结果是否是正确; 形如下面JSON格式: {"access_token":"ACCESS_TOKEN","expires_in":7200}
//echo $result;
// 4.解析, 读取
$jsonArr     = json_decode($result, true);
$accessToken = $jsonArr['access_token'];

// 1.拼接URL(access_token)
$menuUrl = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $accessToken;
// 2.准备JSON字符串
$jsonStr = '{
     "button":[
     {
          "type":"click",
          "name":"优惠券",
          "key":"V1001"
      },
      {
           "name":"自主服务",
           "sub_button":[
{
               "type":"click",
               "name":"宅急送|天天1元",
               "key":"V1002"
            },
           {
               "type":"view",
               "name":"手机点餐不排队",
               "url":"http://www.soso.com/"
            },
{
               "type":"view",
               "name":"app下载|送66大礼包",
               "url":"http://m.jd.com"
            },
{
               "type":"view",
               "name":"新浪云HTML页面",
               "url":"http://1.shirleytest.applinzi.com/sina.html"
            },
{
               "type":"view",
               "name":"儿童餐",
               "url":"http://www.apple.com.cn/"
            }
            ]
       },
{
          "type":"click",
          "name":"WOW会员",
          "key":"V1003"
      }]
 }';

// 3.向微信服务器发送POST请求
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $menuUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
// 4.接收返回JSON
$result = curl_exec($ch);
curl_close($ch);

// 5.判断是否正确{"errcode":0,"errmsg":"ok"}
echo $result;
