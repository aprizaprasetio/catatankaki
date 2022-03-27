{{-- Layout --}}
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

@extends('template.layout_header')

{{-- Judul --}}
@section('title')
    Isi Data
@endsection

{{-- App Isi Data --}}
@section('app')
    <form class="grid justify-between w-full p-12 bg-white rounded-md gap-9 text-slate-800" action="/isi-data" method="post">
        @csrf
        @if (count($errors)>0)
            <label class="text-sm text-rose-600" for="">Semua harus terisi!</label>
        @elseif (Session::has('sukses'))
            <label class="text-sm text-lime-600" for="">Data berhasil tersimpan!</label>
        @endif
        {{-- <label class="text-sm font-thin text-rose-600" for="">Data harus terisi semua!</label> --}}
        <div class="flex justify-between gap-6">
            <div class="">
                <label class="block mb-1 font-medium w-">Tanggal</label>
                <input class="p-2 rounded-md focus:outline-none bg-slate-100" type="date" name="tanggal" id="">
            </div>
            <div class="">
                <label class="block mb-1 font-medium" for="">Jam</label>
                <input class="p-2 rounded-md focus:outline-none bg-slate-100" type="time" name="jam" id="">
            </div>
        </div>
        <div class="flex justify-between gap-6">
            <div class="">
                <label class="block mb-1 font-medium" for="">Lokasi yang dikunjungi</label>
                <textarea class="h-24 p-2 rounded-md bg-slate-100 w-80 focus:outline-none" name="lokasi" id="" placeholder="{{ $catatan_perjalanan_row_lokasi ?? 'Taman Mini Indonesia Indah, Jakarta' }}"></textarea>
            </div>
            <div class="">
                <label class="block mb-1 font-medium" for="">Suhu tubuh</label>
                <input class="p-2 rounded-md bg-slate-100 w-14 focus:outline-none" type="number" name="suhu" id="">
                <span>˚ C</span>
            </div>
        </div>
        <button class="w-1/4 px-3 py-1 text-lg text-white bg-blue-600 rounded-lg hover:bg-blue-100 hover:text-blue-800 outline outline-0 outline-blue-900 hover:outline-1" type="submit">Simpan</button>
    </form>
@endsection