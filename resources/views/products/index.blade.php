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
      <a href="{{ url("/contributor/infor")}}" class="btn btn-info">Thông tin tài khoản</a>
      <a style="float: right" href="{{ url("/logout")}}" class="btn btn-info">Logout</a>
    </div>
    <h2>Danh sách đóng góp</h2>
    @if (session('infor'))
        <div class="alert alert-success">
            {{ session('infor') }}
          </div>
    @endif
    @if (session('note'))
        <div class="alert alert-danger">
            {{ session('note') }}
          </div>
    @endif
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
        <option value="quantity_asc" {{ $sort == "quantity_asc" ? " selected" : "" }}>Số lượng đóng góp tăng dần</option>
        <option value="quantity_desc" {{ $sort == "quantity_desc" ? " selected" : "" }}>Số lượng đóng góp giảm dần</option>
        <option value="date_contribute_asc" {{ $sort == "date_contribute_asc" ? " selected" : "" }}>Ngày đóng góp tăng dần</option>
        <option value="date_contribute_desc" {{ $sort == "date_contribute_desc" ? " selected" : "" }}>Ngày đóng góp giảm dần</option>
        <option value="product_enpiry_asc" {{ $sort == "product_enpiry_asc" ? " selected" : "" }}>Hạn sử dụng tăng dần</option>
        <option value="product_enpiry_desc" {{ $sort == "product_enpiry_desc" ? " selected" : "" }}>Hạn sử dụng giảm dần</option>
      </select>
      <input type="submit" name="search" class="btn btn-success" value="Lọc kết quả">
    </form>
  </div>
    <div style = "padding: 20px">
      <a href="{{ url("/product/create")}}" class="btn btn-info">Thêm sản phẩm đóng góp</a>
      <a style="float: right" href="{{ url("/category/contribute")}}" class="btn btn-info">Đóng góp</a>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>STT</th>
          <th>Tên sản phẩm đóng góp</th>
          <th>Loại danh mục sản phẩm</th>
          <th>Số lượng</th>
          <th>Mô tả(đơn vị)</th>
          <th>Hạn sử dụng</th>
          <th>Ngày có thể quyên góp</th>
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
              <td>{{ $p->category_name }}</td>
              <td>{{ $p->product_quantity }}</td>
              <td>{{ $p->product_desc }}</td>
              <td>{{date('d-m-Y', strtotime($p->product_enpiry))}}</td>
              <td>{{date('d-m-Y', strtotime($p->date_contribute))}}</td>
              <td>{{ $p->status_name}}</td>
              <td>
                <a href="{{url("/product/edit/$p->id")}}" class="btn btn-warning">Sửa sản phẩm</a>
                <a href="{{url("/product/delete/$p->id")}}" class="btn btn-danger">Xóa sản phẩm</a>
              </td>
            </tr>
          @endforeach
        @else
          Chưa có bản ghi nào trong bảng này
        @endif
      </tbody>
    </table>
    {{ $products->links() }}
  </div>
</body>
</html>
