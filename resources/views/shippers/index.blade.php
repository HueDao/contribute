<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
  <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand" href="#">Đóng góp</a>
        </div>
        <ul class="nav navbar-nav">
        <li ><a href="{{ url("")}}">Home</a></li>
        <li class="active"><a href="{{ url("/ship/index")}}">Danh sách đơn chờ lấy</a></li>
        <li ><a href="{{ url("/ship/list_wait_delivery")}}">Danh sách đơn chờ giao</a></li>
        <li ><a href="{{ url("/ship/order_receive")}}">Danh sách đơn lấy đã nhận</a></li>
        <li><a href="{{ url("/ship/order_delivery_receive")}}">Danh sách đơn giao đã nhận</a></li>
        </ul>
      </div>
    </nav>
    <div style = "padding: 20px">
      <a href="{{ url("/contributor/infor")}}" class="btn btn-info">Thông tin tài khoản</a>
      <a style="float: right" href="{{ url("/logout")}}" class="btn btn-info">Logout</a>
    </div>
    <h2>Danh sách các đơn hàng chờ giao đến khu cách li</h2>
    @if (session('infor'))
      <div class="alert alert-success">
          {{ session('infor') }}
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
    @endif
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Mã đơn</th>
          <th>Tổng sản phẩm</th>
          <th>Ngày tạo</th>
          <th>Trạng thái</th>
          <th>Xem</th>
        </tr>
      </thead>
      <tbody>
        @if(isset($orders) && !empty($orders))
          @foreach ($orders as $order)
            <tr>
              <td>{{ $order->id}}</td>
              <td>{{ $order->total_product}}</td>
              <td>{{date('d-m-Y', strtotime($order->created_at))}}</td>
              <td>{{ $order->order_status_name}}</td>
              <td>
                <a href="{{url("/order_detail/$order->id")}}" class="btn btn-warning">Xem chi tiết đơn hàng</a>
              </td>
            </tr>
          @endforeach
        @else
          Chưa có bản ghi nào trong bảng này
        @endif
      </tbody>
    </table>
    
  </div>
</body>
</html>
