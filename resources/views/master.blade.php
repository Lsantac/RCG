<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{App\Http\Controllers\IdentController::consulta_nome_ident()}}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    

    <!-- teste de input file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.7/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.7/js/plugins/piexif.min.js" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.7/js/plugins/sortable.min.js" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.7/js/fileinput.min.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.7/js/locales/LANG.js"></script>

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<header>

    @include('header')
</header>

<body>

    <br>
    @yield('content')

</body>

<!--<footer class=''>
    @include('footer')
</footer> -->

<style>

</style>


</html>
