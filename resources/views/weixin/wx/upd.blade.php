<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>课程修改</h1>
    <form action="{{url('wx/update')}}" method="post">
        @csrf
        <table>
            <tr>
                <td>第一节课：</td>
                <td><select name="ka" id="">
                        <option value="">--请选择--</option>    
                        <option value="php" {{$link->ka=='php' ? 'selected' : ''}}>php</option>    
                        <option value="语文" {{$link->ka=='语文' ? 'selected' : ''}}>语文</option>    
                        <option value="数学" {{$link->ka=='数学' ? 'selected' : ''}}>数学</option>    
                        <option value="英语" {{$link->ka=='英语' ? 'selected' : ''}}>英语</option>    
                </select></td>
            </tr>
            <tr>
                <td>第二节课：</td>
                <td><select name="kb" id="">
                        <option value="">--请选择--</option>    
                        <option value="php" {{$link->kb=='php' ? 'selected' : ''}}>php</option>    
                        <option value="语文" {{$link->kb=='语文' ? 'selected' : ''}}>语文</option>    
                        <option value="数学" {{$link->kb=='数学' ? 'selected' : ''}}>数学</option>    
                        <option value="英语" {{$link->kb=='英语' ? 'selected' : ''}}>英语</option>    
                </select></td>
            </tr>
            <tr>
                <td>第三节课：</td>
                <td><select name="kc" id="">
                        <option value="">--请选择--</option>    
                        <option value="php" {{$link->kc=='php' ? 'selected' : ''}}>php</option>    
                        <option value="语文" {{$link->kc=='语文' ? 'selected' : ''}}>语文</option>    
                        <option value="数学" {{$link->kc=='数学' ? 'selected' : ''}}>数学</option>    
                        <option value="英语" {{$link->kc=='英语' ? 'selected' : ''}}>英语</option>    
                </select></td>
            </tr>
            <tr>
                <td>第四节课：</td>
                <td><select name="kd" id="">
                        <option value="">--请选择--</option>    
                        <option value="php" {{$link->kd=='php' ? 'selected' : ''}}>php</option>    
                        <option value="语文" {{$link->kd=='语文' ? 'selected' : ''}}>语文</option>    
                        <option value="数学" {{$link->kd=='数学' ? 'selected' : ''}}>数学</option>    
                        <option value="英语" {{$link->kd=='英语' ? 'selected' : ''}}>英语</option>    
                </select></td>
            </tr>
            <tr>
                <td><input type="submit" value="确认修改"></td>
                <td><input type="hidden" name="openid" value="{{$link->openid??''}}">
                <input type="hidden" name="k_id" value="{{$link->k_id}}">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>