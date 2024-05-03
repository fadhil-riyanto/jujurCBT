<!DOCTYPE html>

<html>
    <head>
        <title>jujurCBT</title>
        @yield("include-opt")
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>

    <body>
        
        @include("components/_include_navbar")
        @include("components/_include_modal")

        @yield("inject_before_container")
        <div class="container">
            @yield("login")
            @yield("dashboard")
            @yield("admin")
        </div>
        @include("components/_include_footer")
        
        @yield("script")

       
    </body>
</html>