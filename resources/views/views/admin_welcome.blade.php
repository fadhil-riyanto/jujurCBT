@extends("layout._layout_admin")

@section("content") 

<div class="alert alert-primary mt-1" role="alert" id="welcome-name">
    
</div>
    
<div class="d-flex my-3 row">
    <div class="col-lg-4 mb-3-lg">
        <div class="card bg-info border-0">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-muted">Jumlah siswa</h6>
                <h1 class="card-text">180 siswa</h1>
            </div>
        </div>

    </div>
    <div class="col-lg-4 mb-3-lg">
        <div class="card bg-warning border-0">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-muted">Siswa Terblokir</h6>
                <h1 class="card-text">180 siswa</h1>
            </div>
        </div>

    </div>
    <div class="col-lg-4 mb-3-lg">
        <div class="card bg-success border-0">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-muted ">Siswa Aktif</h6>
                <h1 class="card-text">180 siswa</h1>
            </div>
        </div>

    </div>
        
</div>

@endsection

@section("script")
<script>
    var getName = fetch("api/global/get_me");
    getName.then((response) => response.json())
    .then((decoded) => {
        document.getElementById("welcome-name").innerHTML = "Selamat datang " + decoded["data"]
    })
</script>
@endsection