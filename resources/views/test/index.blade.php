<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
      {{--This is {{$name}}, age is {{$age}} and gender is {{$gender}}! <br>--}}
      {{--我的朋友是:<br>--}}
      {{--@foreach($friends as $friend)--}}
       {{--{{$friend}} <br>--}}
      {{--@endforeach--}}
      {{--<br>--}}
      {{--@if($isMarried)--}}
          {{--已婚--}}
      {{--@else--}}
          {{--未婚--}}
      {{--@endif--}}

      {{--<br>--}}

      {{--<form action="/test" method="post">--}}
          {{--{{csrf_field()}}--}}

          {{--用户名: <input type="text" name="username"> <br>--}}
          {{--密码:  <input type="text" name="password"> <br>--}}
          {{--内容:  <input type="text" name="content"> <br>--}}
                {{--<input type="submit" value="提交">--}}

      {{--</form>--}}

</body>
</html>