@extends('dashboard.index')

@section('content')
    <div class="d-flex">
        <h2>Barang Data</h2>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Namaarang</th>
            <th>Deskripsi</th>
            <th>Harga</th>
        </tr>
        @if(count($barang))
            @foreach($barang as $b)
                <tr>
                    <td>{{$b->id}}</td>
                    <td>{{$b->nama}}</td>
                    <td>{{$b->deskripsi}}</td>
                    <td>{{$b->harga}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td align="center" colspan="3">Empty Data!! Have a nice day :3</td>
            </tr>
        @endif
    </table>
@endsection
