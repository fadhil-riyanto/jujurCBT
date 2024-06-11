@extends("layout._layout_admin")

@section("content") 

<div class="alert alert-primary mt-1" role="alert">
    Nilai hanya bisa dilihat oleh pengajar yang bersangkutan
  </div>
  

@endsection

@section("script")
<script>
    // change state
    sidebar_change_state("#sidebar-nilai")
</script>
@endsection