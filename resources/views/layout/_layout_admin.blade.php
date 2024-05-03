<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite("resources/css/bs5_custom.css")

        <!-- bootstrap -->
        <link href="http://127.0.0.1:4593/bootstrap.min.css" rel="stylesheet">
        <script src="http://127.0.0.1:4593/bootstrap.min.js"></script>

        <!-- bootstrap icon -->
        <link rel="stylesheet" href="http://127.0.0.1:4593/bootstrap-icons.min.css">
        
        <!-- jquery -->
        <script src="http://127.0.0.1:4593/jquery.min.js"></script>

        <!-- datatables -->
        <link rel="stylesheet" href="http://127.0.0.1:4593/dataTables.dataTables.css" />
        <script src="http://127.0.0.1:4593/dataTables.js"></script>

        <script src="/js/utils.js"></script>
        <title>jujurCBT Admin</title>
    </head>
    <style>
      
    </style>
    <body>
        @include("bs_components/_nav")
        @include("bs_components/_modal_session_expired")
        @include("bs_components/_modal_alert")
        
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