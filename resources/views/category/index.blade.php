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
        <li ><a href="{{ url("/admin/product")}}">Sản phẩm quyên góp</a></li>
        <li><a href="{{ url("/contributor/index/4")}}">Người quản lí</a></li>
        <li><a href="{{ url("/contributor/index/1")}}">Người quyên góp</a></li>
        <li><a href="{{ url("/contributor/index/2")}}">Người nhận quyên góp</a></li>
        <li><a href="{{ url("/contributor/index/3")}}">Người vận chuyển</a></li>
        <li><a href="{{ url("/contributor/index/5")}}">Quản lí kho</a></li>
        <li class="active"><a href="{{ url("/category/index")}}">Quản lí danh mục sản phẩm</a></li>
        </ul>
      </div>
    </nav>
  <h2>Danh mục sản phẩm cần đóng góp</h2>   
  <div style = "padding: 20px">
    <a href="{{ url("/category/create")}}" class="btn btn-info">Thêm danh mục</a>
  </div>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tên danh mục </th>
        <th>Mô tả</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($categorys) && !empty($categorys))
        @foreach ($categorys as $c)
          <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->category_name }}</td>
            <td>{{ $c->category_desc }}</td>
            <td>
              <a href="{{url("/category/edit/$c->id")}}" class="btn btn-warning">Sửa danh mục</a>
              <a href="{{url("/category/delete/$c->id")}}" class="btn btn-danger">Xóa danh mục</a>
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
