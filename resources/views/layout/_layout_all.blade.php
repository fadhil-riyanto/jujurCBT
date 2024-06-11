<!DOCTYPE html>

<html>
    <head>
        <title>jujurCBT</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @yield("include-opt")
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
        
    </head>

    <body>
        
        @include("components/_include_navbar")
        @include("components/_include_modal")

        @yield("inject_before_container")
        <div class="container">
            @yield("content")
            @yield("login")
        </div>
        @include("components/_include_footer")
        
        @yield("script")

       
    </body>
</html>