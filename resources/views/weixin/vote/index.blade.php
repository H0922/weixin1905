<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>用户展示页面</h1>
   @php
         foreach($number as $k=>$v){
             $u_k = 'h:u:'.$k;
             $u = Redis::hgetAll($u_k);
             echo ' <img src="'.$u['headimgurl'].'"> ';
       }
   @endphp
</body>
</html>