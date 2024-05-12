<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite("resources/css/bs5_custom.css")

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- jquery plugin  -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>

    <script src="/js/utils.js"></script>
    <script src="/js/datatableautoajax.js"></script>
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