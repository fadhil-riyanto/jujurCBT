<!DOCTYPE html>

<html>
    <head>
        <title>jujurCBT</title>

        @vite("resources/css/error.css")
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="assets/js/utils.js"></script>
    </head>

    <body>
        

        <div class="container">
            <h1>Waduh</h1>
            <hr>
            <p class="error-reason">Tersesat? Kamu seharusnya tidak berada dihalaman ini :(</p>
            <a href="/" class="back">kembali ke awal</a>
        </div>
        <script>
            setInterval(function() {
                setHtml("nav-time-js", getTimeStr())
            }, 1000)
            
        </script>
    </body>
</html>