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
    
<h2>Chi tiết đơn lấy hàng</h2>
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
    <form name="receive_order" action="{{ url("/import_store")}}" method="post">
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
          <th>Trạng thái sản phẩm</th>
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
              <td>{{ $p->status_name}}</td>
              <input type='hidden' name='products_id[]' value='{{ $p->id}}'/>
            </tr>
          @endforeach
        @else
          Chưa có bản ghi nào trong bảng này
        @endif
      </tbody>
    </table>
    <div style = "padding: 20px">
      <input type='hidden' name='order_id' value='{{ $order_id}}'/>
      @if($order_status == 2)
        <button type="submit" class="btn btn-primary">Nhập kho</button>
      @endif
      <a style="float: right" href="{{ url("/list_order_contributor")}}" class="btn btn-primary">Back</a>
    </div>
  </form>
  </div>
</body>
</html>