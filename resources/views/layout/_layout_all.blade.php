<!DOCTYPE html>

<html>
    <head>
        <title>jujurCBT</title>
        @yield("include-opt")
        <script src="js/utils.js"></script>
    </head>

    <body>
        @include("components/_include_navbar")
        @include("components/_include_modal")
        <div class="container">
            @yield("login")
            @include("components/_include_footer")
        </div>
    </body>
    <script src="http://cdn.fadhil:1234/jquery/dist/jquery.min.js"></script>

    @yield("script")
    
</html>