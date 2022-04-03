# zarinpal php package for laravel and any php framework

Installation
```
composer require shopid/zarinpal
```
on virgool.io :
https://virgool.io/@shopid/zarinpal-agkiqa7tplra


```php
<?php

//make zarinpal object
$zarinpal = new zarinPal([
    "callBackUrl" => "https://www.mywebsice.com/zarinpalverify",
    "merchantId" => "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx",
]);

//make a request

try {
    $request = $zarinpal->apiRequest([
        "amount" => "1000",
        "description" => "payment #999",
        "email" => "me@web.net",
        "mobile" => "09120000000",
    ]);
    var_dump(json_decode($request));
} catch (Exception $error) {
    var_dump(json_decode($error->getMessage()));
}


//verify peyment
try {
    
    $verify = $zarinpal->verify(
        [
            "authority" => "A00000000000000000000000000000000000",
            "amount" => "1000"
        ]
    );
    var_dump(json_decode($verify));
} catch (Exception $error) {
    var_dump(json_decode($error->getMessage()));
}

?>
```

