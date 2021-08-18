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
      <a style="float: right" href="{{ url("/contributor/logout")}}" class="btn btn-info">Logout</a>
    </div>
    <h2>Danh sách sản phẩm nhận đóng góp</h2>   
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
        <option value="status_asc" {{ $sort == "name_asc" ? " selected" : "" }}>Tên A-Z</option>
        <option value="status_desc" {{ $sort == "name_desc" ? " selected" : "" }}>Tên Z-A</option>
        <option value="quantity_asc" {{ $sort == "quantity_asc" ? " selected" : "" }}>Số lượng đóng góp tăng dần</option>
        <option value="quantity_desc" {{ $sort == "quantity_desc" ? " selected" : "" }}>Số lượng đóng góp giảm dần</option>
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
          <th>Tên sản phẩm/ đồ dùng</th>
          <th>Số lượng</th>
          <th>Hạn sử dụng</th>
          <th>Mô tả</th>
          <th>Ngày quyên góp</th>
          <th>Trạng thái sản phẩm</th>
          <th>Cá nhân/ tổ chức quyên góp</th>
          <th>Đã nhận</th>
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
              <td></td>
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
    {{ $products->links() }} 
  </div>
</body>
</html>
