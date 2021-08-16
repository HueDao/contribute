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
  <h2>Cập nhật người đóng góp</h2>   
  <form name="category" action="{{ url("/contributor/update/$contributor->id") }}" method="post">
      @csrf
      <div class="form-group">
          <label for="name">Tên:</label>
          <input type="text" name="name" class="form-control" id="name" value="{{ $contributor->name}}">
      </div>

      <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" name="email" class="form-control" id="email" value="{{ $contributor->email}}">
      </div>
      <div class="form-group">
          <label>Số điện thoại</label>
          <input type="text" name="number_phone" class="form-control" id="number_phone" value="{{ $contributor->number_phone}}">
      </div>
      <div class="form-group">
          <label>Địa chỉ</label>
          <input type="text" name="address" class="form-control" id="address" value="{{ $contributor->address}}">
      </div>
      <div class="form-group">
          <label for="desc">Mô tả</label>
          <textarea name="desc" class="form-control" rows="5" id="desc"></textarea>
      </div>
      <button type="submit" class="btn btn-info">Cập nhật</button>
    </form>
</div>
</body>
</html>
