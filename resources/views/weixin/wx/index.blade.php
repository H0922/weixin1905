<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>课程管理</h1>
    <form action="{{url('wx/insert')}}" method="post">
        @csrf
        <table>
            <tr>
                <td>第一节课：</td>
                <td><select name="ka" id="">
                        <option value="">--请选择--</option>    
                        <option value="php">php</option>    
                        <option value="语文">语文</option>    
                        <option value="数学">数学</option>    
                        <option value="英语">英语</option>    
                </select></td>
            </tr>
            <tr>
                <td>第二节课：</td>
                <td><select name="kb" id="">
                        <option value="">--请选择--</option>    
                        <option value="php">php</option>    
                        <option value="语文">语文</option>    
                        <option value="数学">数学</option>    
                        <option value="英语">英语</option>    
                </select></td>
            </tr>
            <tr>
                <td>第三节课：</td>
                <td><select name="kc" id="">
                        <option value="">--请选择--</option>    
                        <option value="php">php</option>    
                        <option value="语文">语文</option>    
                        <option value="数学">数学</option>    
                        <option value="英语">英语</option>       
                </select></td>
            </tr>
            <tr>
                <td>第四节课：</td>
                <td><select name="kd" id="">
                        <option value="">--请选择--</option>    
                        <option value="php">php</option>    
                        <option value="语文">语文</option>    
                        <option value="数学">数学</option>    
                        <option value="英语">英语</option>    
                </select></td>
            </tr>
            <tr>
                <td><input type="submit" value="提交"></td>
                <td><input type="hidden" name="openid" value="{{$openid??''}}"></td>
            </tr>
        </table>
    </form>
</body>
</html>