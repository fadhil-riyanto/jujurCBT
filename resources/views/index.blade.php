<!DOCTYPE html>

<html>
    <head>
        <title>jujurCBT</title>
        <link rel="stylesheet" href="assets/css/index.css">
        <link rel="stylesheet" href="assets/css/util.css">
        <link rel="stylesheet" href="http://127.0.0.1:8000/node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="assets/js/utils.js"></script>
        <script src="http://127.0.0.1:8000/node_modules/jquery/dist/jquery.min.js"></script>
    </head>

    <body>
        <nav>
            <div class="nav-name">
                jujurCBT | {{ config("app.appname") }}
            </div>

            <div class="nav-time">
                <a id="nav-time-js">error</a>
            </div>
        </nav>

        <div class="modal-container" id="modal-container-login-notify">
            <div class="modal-box">
                <div class="modal-text">
                    <span class="modal-text-txt" id="modal-text-txt">null title</span>
                    <span class="modal-text-close" onclick="close_display('modal-container-login-notify');">x</span>
                </div>

                <div class="modal-msg" id="modal-msg">
                    null
                </div>

                <div class="modal-btn">
                    <button type="button" class="btn-primary" onclick="close_display('modal-container-login-notify');">tutup</button>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="login-container">   
                <div class="login-container-text">
                    <span class="login-txt">Login</span>
                </div>
                <div class="login-container-form">
                    <form method="post" action="/api/auth" id="login-form">
                        <div class="form-field">
                            <i class="bi bi-person-circle"></i>
                            <input type="text" name="nomor_ujian" placeholder="nomor ujian" required>
                        
                        </div>  

                        <div class="form-field">
                            <i class="bi bi-key"></i>
                            <input type="password" name="password" placeholder="password" required>
                        </div>

                        <!-- <div class="form-radio-field-center"> -->
                            <div class="form-radio-field">
                                <input type="radio" name="role" id="student" value="siswa">
                                <label for="student">siswa</label>
    
                                <input type="radio" name="role" id="admin" value="admin">
                                <label for="admin">admin</label>
                            </div>
                        <!-- </div> -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="login-btn-container">
                            <!-- <a href="#" class="login-btn" onclick="show_modal('kesalahan', 'password kamu salah', 'modal-container-login-notify');">login</a> -->
                            <input class="login-btn" type="submit" value="submit">
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <script>
            setInterval(function() {
                setHtml("nav-time-js", getTimeStr())
            }, 1000)

            $("#login-form").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var actionUrl = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        //alert(data["message"]); // show response from the php script.
                        show_modal("perhatian", data["message"], "modal-container-login-notify")
                    }
                });

            });

            
        </script>
        
    </body>
    <footer>
        <span class="footer-txt">&copy Fadhil Riyanto</span>
    </footer>
    
</html>