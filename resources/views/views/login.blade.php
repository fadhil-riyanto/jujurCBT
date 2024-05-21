@extends("layout._layout_all")

@section("include-opt")
    @vite("resources/css/components/_container.css")
    @vite("resources/css/components/_navbar.css")
    @vite("resources/css/components/_modal.css")
    @vite("resources/css/components/_buttons.css")
    @vite("resources/css/login.css")

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="/js/utils.js"></script>
@endsection

@section("login")
<div class="login-container">   
    <div class="login-container-text">
        <span class="login-txt">Login</span>
    </div>
    <div class="login-container-form">
        <form method="post" action="/api/auth" id="login-form">

            <div class="form-radio-field">
                <input type="radio" name="role" id="student" value="student" onclick="changeform_placeholder()">
                <label for="student">siswa</label>

                <input type="radio" name="role" id="pengajar" value="pengajar" onclick="changeform_placeholder()">
                <label for="pengajar">pengajar</label>

                <input type="radio" name="role" id="superadmin" value="superadmin" onclick="changeform_placeholder()">
                <label for="superadmin">admin</label>
            </div>
            
            <div class="form-field">
                <i class="bi bi-person-circle"></i>
                <input id="identity" type="text" name="identity" placeholder="nomor ujian" required>
            </div>  

            <div class="form-field">
                <i class="bi bi-key"></i>
                <input id="password" type="password" name="password" placeholder="password" required>
            </div>

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
    function changeform_placeholder() {
        if ($("#superadmin").is(":checked")) {
            $("#identity").prop("placeholder","username")
        } else if ($("#pengajar").is(":checked")) {
            $("#identity").prop("placeholder","username")
        } else {1
            $("#identity").prop("placeholder","nomor ujian")
        }
    }

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
                if (data["status"] == false) {
                    show_modal("perhatian", data["message"])
                } else {
                    window.location.href = data["redirect"]
                }
            },
            error: function(data) {
                show_modal("perhatian", data.responseJSON["message"])
            }
        });

    });

</script>
@endsection('script')