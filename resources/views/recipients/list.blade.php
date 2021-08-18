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
      <a style="float: right" href="{{ url("/volunteers/logout")}}" class="btn btn-info">Logout</a>
    </div>
  <h1>Danh sách tổ chức nhận quyên góp</h1>
  <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tên cá nhân/ tổ chức</th>
          <th>Email</th>
          <th>Địa chỉ</th>
          <th>Số điện thoại</th>
          <th>Mô tả</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        @if(isset($recipients) && !empty($recipients))
          @foreach ($recipients as $r)
            <tr>
              <td>{{ $r->id }}</td>
              <td>{{ $r->name }}</td>
              <td>{{ $r->email }}</td>
              <td>{{ $r->number_phone}}</td>
              <td>{{ $r->address}}</td>
              <td>{{ $r->desc }}</td>
              <td>
                <a href="{{url("/product/contribute/$category_id/$r->id")}}" class="btn btn-success">Chọn</a>
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
