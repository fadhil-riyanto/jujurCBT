@extends("layout._layout_pengajar")

@section("content") 
<div class="alert alert-primary mt-1" id="welcome">
    Selamat datang 
  </div>
  
@endsection

@section("script")
<script>
    $(document).ready(function() {
        $.ajax({
            url: "/api/global/get_me",
            success: function(data) {
                $("#welcome").html("selamat datang " + data["data"])
            }
        })
    })
</script>
@endsection