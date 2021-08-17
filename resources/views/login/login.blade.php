<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Signin Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
</head>
<body class="text-center">

<main class="form-signin">
    <div class="form-floating mb-5 msg-error">
        @if($errors->any())
            {{ implode('', $errors->all(':message')) }}
        @endif
    </div>
    <form name="contributor_login" action="{{ url('/contributor/login')}}" method="post">
        @csrf
        <h1 class="h-100 mb-3 fw-normal">Sign in</h1>

        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
        </div>

        <div class="checkbox mb-3" style="text-align: left">
            <label>
                <input name="remember_me" type="checkbox" value="remember-me"> Remember me
            </label>
            <label style="float: right">
                <a href="{{ url("/contributor/create")}}">Sign Up?</a>
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">Copyright&copy;2021</p>
    </form>
</main>
</body>
</html>
