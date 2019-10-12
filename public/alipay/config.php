<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016101400685881",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAxsQN4jsXEWKxVB/AHPY6KL0MrRQALZwLctkXPXpn4YGj+dy/uH2ftqGpHlwHr6Si1clVKYEZFFKl+e+JIbmeY88QUR3WLRF3YgMFCSbB+fqRWBmsWf6z8sr8NfdBADYKS7KTLx/vGyEEcBm9Wwg5NzAlpksdc+6zNyLMECjk/ezT04nxtXSrKMfDTJHqDuhRGMX3zp/gnzPbdvK0kBPJ42ZAivGwKkSk3AeTofSLCkR2/q5epwNjhrciZa+/uK9EykF2E7noSL/KDMhiUIyKdWfHPIyqDs8YKxoPSZYvHfeOyeL4YfyZgaOFNXK2APclgqkettDzFhopXI6dHaoLvQIDAQABAoIBAF9pTwzQtpMG3/50u0BrxaE2lnYiiq9aH3jC0tAVCPaLx42yNGm4C8mcMlU7cgkTK4MaAQJKUSKbRccC/72rn2djxv5ZJy09HCR1NJ6e9zAq4kf7EuukQvcCDy1Mgew7BJgvoU1Ws+0+3SV+hZHEEcr3FquLlRjIdUi7MF91ce6dPr+jEefke6ulzCu0Tbxarxe+5UyJQh3ZkeUXM0KPzYSSJfyGitCU1RujrCbJ33CApH/soEATp00ggngIftJ302QUpbFQc5SlHymmZLetJr081UqkyTW7BdL4ZRrvGo8N1azRub+dJOWPtMjpTDQh1ogXE0XAjJe4NVDpn2KvAfUCgYEA5MEo00Ys+BmIMgLFn/Bjkc/VqvLutx1Bc854IVl++crRAvSomeiCANg6mkrDNnj81eGLgRA80OLtV4yujlaGVVE0EWYSBUrY8oIM+0vybgkO5775OUlKubed+TLkBrnsouPwE6DoDjVOZFm4TOWf6tPXUpXxltN7S6Eyliq9uL8CgYEA3nCGQzNX+mik11Ua+e8v3mAGavSe/FGapsBi4CXVapv5mMVwPf/yS/63a1P4UyPvPS4FSLj6i1/uOC4Ck9UGT6r78rpqExNxvmo53ZDMFrDzTbn0xGGFSLMNvXnVlbOZvPao/dsa50/ofShmVQtPMz7oGXo7kIBUVXNulBF5/oMCgYAKqrcsoukV6JrhOh/dBWifNAHSpuFayJJ0w/v2EiZJn5t/d8kk5CKrx2l0KGhR8fJYRtwqeIdddjd7DaRWHtLEx7SV2xycApF7PXU9gp0bZHC9fbpBYZmKb3V+WVEovyK5tcdMIwSvJO0y4LwnWc3LNXWk9Dj/v3zQWgPx3KxcIQKBgQCUFpfcP19wD6DG1xr5kDrvMkCzjh4WX4G1SFnLXoTB0AuQoMmEDVTTMUYNhz7IoyDQO0Y7TyNGDNy8vCztHKJyAaRwyZh7ELPmEDRsBM1Kwg2JDqcc4svoRYR9Q5JlcseEXTbOosM7giCGypGuRrQ4qsW8yHrFThpXNV1F6IiuXwKBgGfSnquMdfYULWscS0hNe9FS2rOXn7+XFxbnWgxqjPDVGpZkxLjWTJmS6f1HUqxDhGTCuLBE18E5p/WwCWVgjktb0CYPxhT8eYEi4MgG0Ai6VRB9m/qaE4z3uQBYRoPNvZ6IqkxpQN/qCo+1qwmw/TrPjvz9rIgYJHAZx/w0dUqB",
		//异步通知地址
		'notify_url' => "http://www.shop.com/alipay/notify_url.php",
		
		//同步跳转
		'return_url' => "http://www.shop.com/alipay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnYX9/HEUYFHrIN4+Y2jsxGR+dls9Y0iU86iejofI4So/LOmuevh0jJbU6FoxVh4mBPk48HBGwT8lJ+Upncq7gZH55slEdRZTRnv0Js89NOu0HKpI3CHq1Jy4R7x0gxy7oIwTU5ulNV6mj+jzLueXQzKCA7xghUIuq9dFbbJCsu9j69j/QgJjrni33w+Y8SMj6GA9jT7PHcApiQKvWLJ5Ju1CLhAV2rv8vWy/2iYAflDv+a8SsYcQo58QdianmL0RD8eIrmpJhAOpt8GnBMgG5T0qrepOt+PeRjhlF8lTuOcnLH69AuQA010oxlbt9nDhyJZLyREIvBeL+jEt977bewIDAQAB",
);