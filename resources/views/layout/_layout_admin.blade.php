<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite("resources/css/bs5_custom.css")
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="http://127.0.0.1:4593/bootstrap-icons/font/bootstrap-icons.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
        <script src="js/utils.js"></script>
        <title>jujurCBT Admin</title>
    </head>
    <style>
      
    </style>
    <body>
        @include("bs_components/_nav")
        
        <div class="d-flex">
            <div class="d-flex flex-column bg-body-tertiary p-3 min-vh-100 " style="width: 250px;">
                @include("bs_components/_sidebar")
            </div>
            <div class="container-fluid">
                @yield("content")
            </div>
        </div>
        @yield("script")

        <script>
            setInterval(function() {
               setHtml("nav-time-js", getTimeStr())
           }, 1000)
       </script>
    </body>
</html>