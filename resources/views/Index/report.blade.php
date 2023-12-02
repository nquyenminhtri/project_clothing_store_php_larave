<!DOCTYPE html>
<html>

<head>
    <title>Thống kê Doanh Thu</title>
    {!! $chart->script() !!}
</head>

<body>
    <div class="container">
        <h2>Biểu đồ Doanh Thu</h2>
        <div>{!! $chart->container() !!}</div>
    </div>
</body>

</html>
