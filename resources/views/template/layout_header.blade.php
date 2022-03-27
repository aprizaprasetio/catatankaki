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

{{-- Latar Belakang --}}
@section('background')
    {{-- class="bg-cover" style="background-image: url('http://source.unsplash.com/TS4eBHeIIq8')" --}}
    class="bg-gray-50"
@endsection

{{-- Header --}}
@section('header')
    {{-- Khusus Bagian Atas --}}
    <header>
        <nav class="flex justify-around text-slate-50 bg-gradient-to-r from-blue-900 to-slate-800">
            {{-- Navigasi Kiri --}}
            <div class="flex items-center drop-shadow-sm">
                <div class="items-center p-1 tracking-widest">
                    <a class="grid text-center opacity-60 hover:opacity-90" href="/">
                        <h1 class="text-xl font-medium uppercase">Peduli Diri</h1>
                        <span class="text-xs ">Catatan Perjalanan</span>
                    </a>
                </div>
            </div>
            {{-- /Navigasi Kiri --}}

            {{-- Navigasi Tengah --}}
            <div class="flex items-center gap-12 uppercase">
                <div class="border-b-2 border-transparent opacity-70 hover:opacity-100 hover:border-slate-50 hover:animate-pulse"><a class="" href="/">Home</a></div>
                <div class="border-b-2 border-transparent opacity-70 hover:opacity-100 hover:border-slate-50 hover:animate-pulse"><a class="" href="/catatan-perjalanan">Catatan Perjalanan</a></div>
                <div class="border-b-2 border-transparent opacity-70 hover:opacity-100 hover:border-slate-50 hover:animate-pulse"><a class="" href="/isi-data">Isi Data</a></div>
            </div>
            {{-- /Navigasi Tengah --}}

            {{-- Navigasi Kanan --}}
            <div class="flex items-center gap-2 text-sm">
                <span>{{ Session::get('akun.nama') }}, {{ Session::get('akun.nik') }}</span>
                <form action="/keluar" method="post">
                    @csrf
                    <button class="px-2 font-medium rounded-lg bg-slate-100 text-slate-800 hover:bg-opacity-40 hover:text-slate-50" type="submit">Keluar</button>
                </form>
            </div>
            {{-- /Navigasi Kanan --}}

        </nav>
    </header>
    {{-- /Khusus Bagian Atas --}}
    
@endsection
@section('body')
    {{-- Khusus Body Aplikasi --}}
    <div class="w-2/3 my-8 outline outline-1 outline-blue-900 p-14 drop-shadow-md">
        @yield('app')
    </div>
    {{-- /Khusus Body Aplikasi --}}
    
@endsection