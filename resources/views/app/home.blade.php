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
    Home   
@endsection

{{-- App Home --}}
@section('app')
    <section class="grid gap-9">
            <span class="w-full py-12 text-2xl bg-white rounded-md text-slate-800 px-9">Selamat Datang, {{ Session::get('akun.nama') }}</span>
            <div class="flex w-full text-2xl text-slate-800 gap-9">
                <a class="w-1/2 py-12 bg-white rounded-md outline-0 px-9 outline hover:outline-1 hover:outline-blue-500 hover:bg-slate-300 hover:text-blue-500" href="/catatan-perjalanan">Catatan Perjalanan</a>
                <a class="w-1/2 py-12 bg-white rounded-md outline-0 px-9 outline hover:outline-1 hover:outline-blue-500 hover:bg-slate-300 hover:text-blue-500" href="/isi-data">Isi Data</a>
            </div>
    </section>
@endsection