<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.bootcss.com/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
</head>
<body>
<div class="container-fluid">
    @yield('content')
</div>
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
{{--<script src="https://g.alicdn.com/dingding/dingtalk-jsapi/2.7.13/dingtalk.open.js"></script>--}}
<script>
    {{--if(dd) {--}}
    {{--    dd.ready(function () {--}}
    {{--        dd.biz.navigation.setTitle({--}}
    {{--            title: "@yield('title')"--}}
    {{--        });--}}

    {{--        DingTalkPC.addEventListener('leftBtnClick', function () {--}}
    {{--            dd.biz.navigation.close();--}}
    {{--        });--}}
    {{--    });--}}
    {{--}--}}
</script>
@yield('scripts')
</body>
</html>
