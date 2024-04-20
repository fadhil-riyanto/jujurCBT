@extends("layout._layout_all")

@section("include-opt")
    @vite("resources/css/components/_container.css")
    @vite("resources/css/components/_navbar.css")
    @vite("resources/css/components/_modal.css")
    @vite("resources/css/components/_buttons.css")
    @vite("resources/css/login.css")
@endsection

@section("login")
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
@endsection


@section('script')
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
@endsection('script')