<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>UKK KASIR</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
    <form action="{{ route('login.auth') }}" method="POST" class="border p-4 rounded shadow bg-white" style="width: 300px">
        @csrf
        <h4>Login Form</h4>
        <div class="mb-3">
          <label  class="form-label">Email address</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="Masukan email">
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Masukan password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
</body>
</html>