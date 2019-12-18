@extends('layouts.admin')
@section('title','Excel导入工具')
@section('content')
    <style>
        .title {
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            margin-bottom: 30px;
            font-size: 50px;
        }

        .content {
            text-align: center;
        }
    </style>
    <body>
    <div class="row">
        <div>
            <div class="offset-md-4 col-md-4">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group mt-5">
                        <div class="input-group mt-2 mb-2">
                            <input id="excel" type="file" name="excel" class="form-control" style="width: 100px;"
                                   required>
                            <div class="input-group-prepend">
                                <input type="button" id="btnClick" class="btn btn-success" value="导入"/>
                            </div>
                            <div class="input-group-prepend">
                                <input type="button" id="resetButton" class="btn btn-danger" value="重置按钮"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


            <div id="panel-body">

                <div class="content">
                    <label for="excel" class="title m-b-md">Excel表中数据</label>
                </div>
                <div class="content">
                    <label for="excel" class="title" style="font-size: 15px;">请确保excel中数据不存在公式</label>
                </div>
                <table class="table table-model-2 " style="table-layout:fixed">
                    <colgroup>
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>组别</th>
                        <th>性别</th>
                        <th>手机号码</th>
                        <th>个人邮箱</th>
                        <th>部门</th>
                        <th>责任人</th>
                        <th>到期日期</th>
                        <th>备注</th>
                    </tr>
                    </thead>
                    <tbody id='tablelist'>

                    </tbody>
                </table>


            </div>
        </div>
    </div>
    </body>
@endsection
@section('scripts')
    <script>
        $(function () {
            $(document).keydown(function (e) {
                if (e.keyCode == "13") {
                    $("#btnClick").click();
                }
            });


            $('#btnClick').click(function () {

                var btn = $(this);
                btn.prop('disabled',true);

                var file = new FormData();
                var excelfile = document.getElementById('excel').files[0];
                file.append('excel', excelfile);
                $.ajax({
                    url: '/api/excel/init',
                    type: 'POST',
                    data: file,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        console.log(res);
                        var list = res.arr[0];
                        $('#tablelist').empty();
                        if (res.errcode == 0) {
                            $.each(list, function (index, item) {
                                var $trStr = $("<tr></tr>");
                                $trStr.append("<td>" + item.姓名 + "</td>");
                                $trStr.append("<td>" + item.组别 + "</td>");
                                $trStr.append("<td>" + item.性别 + "</td>");
                                $trStr.append("<td>" + item.手机号 + "</td>");
                                $trStr.append("<td>" + item.个人邮箱 + "</td>");
                                $trStr.append("<td>" + item.部门 + "</td>");
                                $trStr.append("<td>" + item.责任人 + "</td>");
                                $trStr.append("<td>" + item.到期日期 + "</td>");
                                $trStr.append("<td>" + item.备注 + "</td>");
                                $trStr.appendTo("#tablelist");
                            });
                        } else {
                            alert(params.errmsg);
                        }
                    },
                    error: function () {
                        alert("失败");
                    }
                });
            });

            $('#resetButton').click(function () {
                $('#btnClick').removeAttr("disabled");
            });

        });
    </script>
@endsection


