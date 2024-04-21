<!DOCTYPE html>

<html>
    <head>
        <title>jujurCBT</title>
        @yield("include-opt")
        
    </head>

    <body>
        
        @include("components/_include_navbar")
        @include("components/_include_modal")
        <div class="container">
            @yield("login")
            @yield("dashboard")
            
            @include("components/_include_footer")
        </div>
        
        @yield("script")
    </body>
</html>