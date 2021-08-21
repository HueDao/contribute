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
        <li><a href="{{ url("/admin/product")}}">Sản phẩm quyên góp</a></li>
        @if ($role == 4)
        <li class="active"><a href="{{ url("/contributor/index/4")}}">Người quản lí</a></li>
        @else
        <li><a href="{{ url("/contributor/index/4")}}">Người quản lí</a></li>
        @endif
        @if ($role == 1)
        <li class="active"><a href="{{ url("/contributor/index/1")}}">Người quyên góp</a></li>
        @else
        <li><a href="{{ url("/contributor/index/1")}}">Người quyên góp</a></li>
        @endif
        @if ($role == 2)
        <li class="active"><a href="{{ url("/contributor/index/2")}}">Người nhận quyên góp</a></li>
        @else
        <li><a href="{{ url("/contributor/index/2")}}">Người nhận quyên góp</a></li>
        @endif
        @if ($role == 3)
        <li class="active"><a href="{{ url("/contributor/index/3")}}">Người vận chuyển</a></li>
        @else
        <li><a href="{{ url("/contributor/index/3")}}">Người vận chuyển</a></li>
        @endif
        @if ($role == 5)
        <li class="active"><a href="{{ url("/contributor/index/5")}}">Quản lí kho</a></li>
        @else
        <li><a href="{{ url("/contributor/index/5")}}">Quản lí kho</a></li>
        @endif
        <li><a href="{{ url("/category/index")}}">Quản lí danh mục sản phẩm</a></li>
        </ul>
      </div>
    </nav>
    <div style = "padding: 20px">
      <a href="{{ url("/contributor/infor")}}" class="btn btn-info">Thông tin tài khoản</a>
      <a style="float: right" href="{{ url("/logout")}}" class="btn btn-info">Logout</a>
    </div>
    <h2>Danh sách người đóng góp</h2>
    <div style="padding: 10px; border: 1px solid #4e73df ;margin-bottom: 10px">
    <form name="search_contributor" method="get" action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" class="form-inline">
      <input name="contributor_name" class="form-control" value = "{{ $searchKeyword }}" style="width: 350px; margin-right: 20px" placeholder="Nhập tên cá nhân bạn muốn tìm kiếm ..." autocomplete="off">
      <select name="contributor_sort" class="form-control" style="width: 150px; margin-right: 20px">
        <option value="">Sắp xếp</option>
        <option value="name_asc" {{ $sort == "name_asc" ? " selected" : "" }}>Tên A-Z</option>
        <option value="name_desc" {{ $sort == "name_desc" ? " selected" : "" }}>Tên Z-A</option>
      </select>
      <input type="submit" name="search" class="btn btn-success" value="Lọc kết quả">
      <a href="#" id="clear-search" class="btn btn-warning">Clear filter</a>
      <input type="hidden" name="page" value="1">
    </form>
  </div>
    <div style = "padding: 20px">
      <a href="{{ url("/contributor/create")}}" class="btn btn-info">Thêm người đóng góp</a>
    </div>
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
        @if(isset($contributors) && !empty($contributors))
          @foreach ($contributors as $c)
            <tr>
              <td>{{ $c->id }}</td>
              <td>{{ $c->name }}</td>
              <td>{{ $c->email }}</td>
              <td>{{ $c->number_phone}}</td>
              <td>{{ $c->address}}</td>
              <td>{{ $c->desc }}</td>
              <td>
                <a href="{{url("/contributor/edit/$c->id")}}" class="btn btn-warning">Sửa người đóng góp</a>
                <a href="{{url("/contributor/delete/$c->id")}}" class="btn btn-danger">Xóa người đóng góp</a>
              </td>
            </tr>
          @endforeach
        @else
          Chưa có bản ghi nào trong bảng này
        @endif
      </tbody>
    </table>
    {{ $contributors->links() }}
  </div>
</body>
</html>
