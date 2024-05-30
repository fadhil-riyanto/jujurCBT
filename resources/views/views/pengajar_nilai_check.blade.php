@extends("layout._layout_pengajar")

@section("content") 
<table id="nilai_siswa" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Nilai pilgan</th>
            <th>Nilai essay</th>
            <th>Nilai total</th>
            <th>status</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $data_s)
        <tr>
            <th>{{ $data_s["nama"] }}</th>
            <th>{{ $data_s["nama"] }}</th> 
            <th>{{ $data_s["nama"] }}</th> 
            <th>{{ $data_s["nama"] }}</th> 
            <th>{{ $data_s["nama"] }}</th>  
        </tr>
        @endforeach
    </tbody>
    
</table>
@endsection

@section("script")
<script>


new DataTable('#nilai_siswa');
</script>
@endsection