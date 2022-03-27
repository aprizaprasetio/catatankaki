{{-- /*
|--------------------------------------------------------------------------
|
| Aplikasi Peduli Diri
| Disusun oleh Apriza Prasetio
|
|--------------------------------------------------------------------------
|
| Instagram : @aprizaprasetio
| Youtube : Apriza Prasetio
|
|--------------------------------------------------------------------------
*/ --}}

{{-- Layout --}}
@extends('template.layout_header')

{{-- Judul --}}
@section('title')
    Catatan Perjalanan
@endsection

{{-- App Catatan Perjalanan --}}
@section('app')

@if (isset($kosong))
    <div class="text-xl text-blue-900 drop-shadow-sm animate-bounce" for="">{{ $kosong }}</div>
@else
    <section class="grid gap-3 pb-4 text-slate-900">
        <span class="w-full p-4 text-sm font-thin bg-white rounded-md">Terakhir kali ditulis pada {{ \Carbon\Carbon::parse(Session::get('catatan_perjalanan_last_modified'))->diffForHumans() }} dengan jumlah {{ $catatan_perjalanan_rows_collection->count() }} catatan telah tersimpan.</span>
        <form class="w-full p-4 bg-white rounded-md text-md" action="/catatan-perjalanan" method="post">
            @csrf  
            <label for="">Urutkan berdasarkan :</label>
            <select name="urutan" id="">
                <option value="terbaru">Tanggal terbaru</option>
                <option value="terlama">Tanggal terlama</option>
                <option value="tertinggi">Suhu tertinggi</option>
                <option value="terendah">Suhu terendah</option>
            </select>
            <input class="px-2 w-36 focus:outline-none bg-slate-100 drop-shadow-md" type="text" name="urutan_lokasi" id="" placeholder="Lokasi">
            <button class="px-3 ml-4 text-white bg-blue-800 rounded-lg shadow-sm hover:bg-blue-900 hover:text-white" type="submit">Urutkan</button>
            <a class="px-3 ml-4 text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-100 hover:text-blue-800" href="/isi-data">Isi Data</a>
        </form>
        <table class="w-full mb-6 bg-white divide-y rounded-lg divide-slate-400">
            <thead>
                <tr class="font-medium text-center">
                    <td class="p-4">Tanggal</td>
                    <td class="p-4">Waktu</td>
                    <td class="p-4 capitalize whitespace-pre-line">Lokasi</td>
                    <td class="p-4 whitespace-nowrap">Suhu Tubuh</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-300">
                @foreach ($catatan_perjalanan_rows_collection as $catatan_perjalanan_row_value)
                    <tr>
                        <td class="w-3/12 px-4 py-3 text-center ">{{ \Carbon\Carbon::parse($catatan_perjalanan_row_value['tanggal'])->format('d M Y') }}</td>
                        <td class="w-3/12 px-4 py-3 text-center">{{ $catatan_perjalanan_row_value['jam'] }}</td>
                        <td class="w-4/12 px-4 py-3">{{ $catatan_perjalanan_row_value['lokasi'] }}</td>
                        <td class="w-2/12 px-4 py-3 text-center">{{ $catatan_perjalanan_row_value['suhu'] }}<span>˚ C</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    
@endif
@endsection