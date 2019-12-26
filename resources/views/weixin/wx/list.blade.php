<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>用户管理展示</h1>
    <table>
        <tr>
            <td>第一节课</td>
            <td>{{$link->ka??''}}</td>
        </tr>
        <tr>
            <td>第二节课</td>
            <td>{{$link->kb??''}}</td>
        </tr>
        <tr>
            <td>第三节课</td>
            <td>{{$link->kc??''}}</td>
        </tr>
        <tr>
            <td>第四节课</td>
            <td>{{$link->kd??''}}</td>
        </tr>
        <tr>
            <td><a href="{{url('wei/upd/'.$link->k_id)}}">修改课程</a></td>
            <td></td>
        </tr>
    </table>
</body>
</html>