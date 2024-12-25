@extends('layouts.layoutquanly')

@section('content')

<h3>Kết quả tìm kiếm cho từ khóa: "{{ $keyword }}"</h3>

    @if ($seris->isEmpty())
        <p>Không tìm thấy seri nào.</p>
    @else

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mã seri</th>
                    <th>Chi tiết phiếu xuất</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($seris as $key => $seri)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $seri->maSeri }}</td>
                    <td>{{ $seri->chitietphieuxuat_id }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>


    @endif

@endsection
