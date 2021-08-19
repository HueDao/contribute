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
    <div style = "padding: 20px">
      <a href="{{ url("/moving_product")}}">Sản phẩm đã đăng kí giao</a>
</div>
    <h2>Danh sách các sản phẩm chờ giao đến khu cách li</h2>
    
    <div style="padding: 10px; border: 1px solid #4e73df ;margin-bottom: 10px">
    <form name="search_product" method="get" action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" class="form-inline">
      <input name="product_name" class="form-control" value = "{{ $searchKeyword }}" style="width: 350px; margin-right: 20px" placeholder="Nhập tên sản phẩm bạn muốn tìm kiếm ..." autocomplete="off">
      <select name="category_id" class="form-control" style="width: 200px; margin-right: 20px">
        <option>--Chọn danh mục--</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
      </select>
      <select name="product_sort" class="form-control" style="width: 150px; margin-right: 20px">
        <option value="">Sắp xếp</option>
        <option value="name_asc" {{ $sort == "name_asc" ? " selected" : "" }}>Tên A-Z</option>
        <option value="name_desc" {{ $sort == "name_desc" ? " selected" : "" }}>Tên Z-A</option>
        <option value="date_contribute_asc" {{ $sort == "date_contribute_asc" ? " selected" : "" }}>Ngày đóng góp tăng dần</option>
        <option value="date_contribute_desc" {{ $sort == "date_contribute_desc" ? " selected" : "" }}>Ngày đóng góp giảm dần</option>
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
    <form name="delete_register_category" action="{{ url("/moving")}}" method="post">
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
          <th>Trạng thái sản phẩm</th>
          <th>Đang giao hàng</th>
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
    <div style = "padding: 20px">
      <button type="submit" class="btn btn-primary">Vận chuyển sản phẩm</button>
      <a style="float: right" href="{{ url("/recipients/home")}}" class="btn btn-primary">Back</a>
    </div>
  </form>
  </div>
</body>
</html>
