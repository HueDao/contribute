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
    <a style="float: right" href="{{ url("/contributor/logout")}}" class="btn btn-info">Logout</a>
  </div>
    <h2>Thông tin tài khoản</h2>   
  <table class="table table-bordered">
    <tr>
      <th>Tên cá nhân/ tổ chức</th>
      <td>{{ $contributor->name}}</td>
    <tr>
    <tr>
      <th>Email</th>
      <td>{{ $contributor->email}}</td>
    </tr>
    <tr>
      <th>Địa chỉ</th>
      <td>{{ $contributor->address}}</td>
    </tr>
    <tr>
      <th>Số điện thoại</th>
      <td>{{ $contributor->number_phone}}</td>
    </tr>
    <tr>
      <th>Mô tả</th>
      <td>{{ $contributor->desc}}</td>
    </tr>
    </table>
    <div style = "padding: 20px">
    
      <a style="float: right" href="{{ url(".$url")}}" class="btn btn-info">Back</a>
    </div>
  </div>
</body>
</html>
