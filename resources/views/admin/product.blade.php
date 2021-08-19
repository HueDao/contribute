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
        <li><a href="{{ url("/admin/index")}}">Home</a></li>
        <li class="active"><a href="{{ url("/admin/product")}}">Sản phẩm quyên góp</a></li>
        <li><a href="{{ url("/contributor/index/4")}}">Người quản lí</a></li>
        <li><a href="{{ url("/contributor/index/1")}}">Người quyên góp</a></li>
        <li><a href="{{ url("/contributor/index/2")}}">Người nhận quyên góp</a></li>
        <li><a href="{{ url("/contributor/index/3")}}">Người vận chuyển</a></li>
        <li><a href="{{ url("/category/index")}}">Quản lí danh mục sản phẩm</a></li>
        </ul>
      </div>
    </nav>
    <div>
      <li><a href="{{ url("/contributor/infor")}}" class="btn btn-info">Thông tin tài khoản</a></li>
      <a style="float: right; padding: 10px" href="{{ url("/logout")}}" class="btn btn-info">Logout</a>
    </div>
    <h2>Danh sách các sản phẩm/ đồ dùng</h2>
    <div style="padding: 10px; border: 1px solid #4e73df ;margin-bottom: 10px">
    <form name="search_product" method="get" action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" class="form-inline">
      <input name="product_name" class="form-control" value = "{{ $searchKeyword }}" style="width: 350px; margin-right: 20px" placeholder="Nhập tên sản phẩm bạn muốn tìm kiếm ..." autocomplete="off">
      <select name="category_id" class="form-control" style="width: 200px; margin-right: 20px">
        <option>--Chọn danh mục--</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
      </select>
      <select name="product_status" class="form-control" style="width: 150px; margin-right: 20px">
        <option>--Chọn trạng thái--</option>
        @foreach ($status as $s)
        <option value="{{ $s->id }}">{{ $s->status_name }}</option>
        @endforeach
      </select>
      <select name="product_sort" class="form-control" style="width: 150px; margin-right: 20px">
        <option value="">Sắp xếp</option>
        <option value="name_asc" {{ $sort == "name_asc" ? " selected" : "" }}>Tên A-Z</option>
        <option value="name_desc" {{ $sort == "name_desc" ? " selected" : "" }}>Tên Z-A</option>
        <option value="date_contribute_asc" {{ $sort == "date_contribute_asc" ? " selected" : "" }}>Ngày đóng góp tăng dần</option>
        <option value="date_contribute_desc" {{ $sort == "date_contribute_desc" ? " selected" : "" }}>Ngày đóng góp giảm dần</option>
        <option value="product_enpiry_asc" {{ $sort == "product_enpiry_asc" ? " selected" : "" }}>Hạn sử dụng tăng dần</option>
        <option value="product_enpiry_desc" {{ $sort == "product_enpiry_desc" ? " selected" : "" }}>Hạn sử dụng giảm dần</option>
      </select>
      <input type="submit" name="search" class="btn btn-success" value="Lọc kết quả">
    </form>
  </div>
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
    @csrf
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>STT</th>
          <th>Tên sản phẩm/ đồ dùng</th>
          <th>Số lượng</th>
          <th>Hạn sử dụng</th>
          <th>Mô tả</th>
          <th>Ngày quyên góp</th>
          <th>Cá nhân/ tổ chức quyên góp</th>
          <th>SĐT quyên góp </th>
          <th>Địa chỉ của cá nhân/ tổ chức</th>
          <th>Tổ chức nhận quyên góp</th>
          <th>SĐT nhận quyên góp </th>
          <th>Địa chỉ của cá nhân/ tổ chức</th>
          <th>Shipper</th>
          <th>SĐT shipper </th>
          <th>Trạng thái sản phẩm</th>
          <th>Hành động</th>
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
              <td>{{ $p->name }}</td>
              <td>{{ $p->number_phone}}</td>
              <td>{{ $p->address }}</td>
              <td>{{ $p->recipient_name }}</td>
              <td>{{ $p->recipient_number_phone}}</td>
              <td>{{ $p->recipient_address }}</td>
              <td>{{ $p->shipper_name }}</td>
              <td>{{ $p->shipper_number_phone}}</td>
              <td>{{ $p->status_name}}</td>
              <td>
                <a href="{{url("/product/edit/$p->id")}}" class="btn btn-warning">Sửa</a>
                <a href="{{url("/product/delete/$p->id")}}" class="btn btn-danger">Xóa</a>
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