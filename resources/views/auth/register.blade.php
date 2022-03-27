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
@extends('template.layout')

{{-- Judul --}}
@section('title')
    Daftar    
@endsection

{{-- Latar Belakang --}}
@section('background')
    class="bg-gradient-to-r from-blue-900 to-slate-800"
@endsection

{{-- Body --}}
@section('body')
    <div class="p-16 rounded-md bg-gradient-to-r from-blue-600 via-cyan-800 to-blue-900 my-9 drop-shadow-md bg text-slate-900 bg-opacity-60">
        <form class="grid gap-12 p-12 bg-white rounded-md" action="/daftar" method="post">
            @csrf
            <label class="" for="">Masukkan NIK dan Nama Lengkap</label>
            <section class="grid gap-3">
                @if (count($errors)>0)
                    <label class="text-sm text-rose-600" for="">Semua kolom harus terisi!</label>
                @elseif (Session::has('gagal'))
                    <label class="text-sm thin text-rose-600" for="">{{ Session::get('gagal')}}</label>
                @endif
                <input class="px-6 py-2 rounded-md focus:outline-none bg-slate-100" type="text" name="nik" placeholder="NIK">
                <input class="px-6 py-2 rounded-md focus:outline-none bg-slate-100" type="text" name="nama" placeholder="Nama Lengkap">
            </section>
            <section class="grid gap-3">
                <button class="py-2 text-lg text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-100 hover:text-blue-800 outline outline-0 outline-blue-900 hover:outline-1" type="submit">Daftar</button>
                <a class="text-center text-slate-900 hover:text-blue-800" href="/masuk">Saya Pengguna Lama</a>
            </section>
        </form>
    </div>
@endsection