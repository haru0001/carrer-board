<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- BootStrap CDN --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />

    {{-- CSS読み込み --}}
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">


  <title>Title</title>
</head>
<body>
  <div id="app">
    
    <header-component></header-component>

    <div id="contents-wrapper">
      <router-view/>
    </div>
  </div>



{{-- jQuery CDN --}}
<script   src="https://code.jquery.com/jquery-3.5.1.js"   integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="   crossorigin="anonymous"></script>


<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>