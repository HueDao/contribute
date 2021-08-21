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
  <div style = "padding: 20px">
      <a href="{{ url("/volunteers/infor")}}" class="btn btn-info">Thông tin tài khoản</a>
      <a style="float: right" href="{{ url("/logout")}}" class="btn btn-info">Logout</a>
    </div>
    <h1> Danh sách sản phẩm muốn đóng góp </h1>
    @if (session('note'))
        <div class="alert alert-danger">
            {{ session('note') }}
          </div>
    @endif
    <form name="register_product" action="{{ url("/contribute")}}" method="post">
      @csrf
      <table class="table table-bordered">
      <thead>
          <tr>
          <th>STT</th>
          <th>Tên sản phẩm đóng góp</th>
          <th>Số lượng</th>
          <th>Hạn sử dụng</th>
          <th>Mô tả</th>
          <th>Ngày có thể quyên góp</th>
          <th>Trạng thái</th>
          <th>Đóng góp</th>
          </tr>
      </thead>
      <tbody>
        @if(isset($products) && !empty($products))
        @foreach ($products as $p)
          <tr>
          <td>{{ ++$stt}}</td>
          <td>{{ $p->product_name }}</td>
          <td>{{ $p->product_quantity }}</td>
          <td>{{ $p->product_enpiry }}</td>
          <td>{{ $p->product_desc }}</td>
          <td>{{ $p->date_contribute}}</td>
          <td>{{ $p->status_name}}</td>
          <td>
            <input type="checkbox" value="{{$p->id}}" name="product_id[]">
          </td>
          </tr>
        @endforeach
        @else
          Chưa có bản ghi nào trong bảng này
        @endif
      </tbody>
      </table>
      <input type='hidden' name='recipient_id' value='{{ $recipient_id }}'/>
      <button type="submit" class="btn btn-primary">Đóng góp</button>
    </form>
  </div>
</body>
</html>
