<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class catatanController extends Controller
{
    public function daftarClass(Request $request){
        // *Autentikasi masuk/login
        if(session()->has('akun.nik')){return redirect('/');}// <-Jika ada sesi/session NIK maka kembali ke beranda/home

        // *Route get untuk view
        if($request->isMethod('get')){// <-Jika route-nya tipe get
            return view('auth.register');// <-Buka view blade Auth/Register

        // *Route post untuk aksi daftar/register
        }if($request->isMethod('post')){// <-Jika route-nya tipe post
            // *Menyimpan data formulir daftar/register
            $nik=$request->nik;// <-Simpan NIK
            $nama=$request->nama;// <-Simpan Nama

            // *Membandingkan data formulir dengan setiap baris/row data config
            $config_temp=Storage::get('public/docs/config.txt');// <-Ambil semua data config
            $config_rows=explode("\n",$config_temp);// <-Bagi setiap baris/row data config
            foreach ($config_rows as $config_row) {// <-Bandingkan dari baris/row pertama pada data config
                $config_row_value=explode('|',$config_row);// <-Seleksi baris/row tersebut menjadi NIK dan Nama
                if($config_row_value[0]==$nik) {// <-Jika NIK tersebut ada yang sama pada data config
                    return redirect('/daftar')->with('gagal','NIK sudah digunakan!');// <-Kembali ke halaman sebelumnya/daftar/register
                }
            }

            // *Memasukkan data formulir pada data config
            $config_row_create=$nik.'|'.$nama;// <-Simpan data formulir yang akan dimasukkan pada data config
            Storage::append('public/docs/config.txt', $config_row_create);// <-Tambah data form ulir pada data config di baris/row terakhir
            Storage::put('public/docs/'.$nik.'.txt', '');// <-Buat data penyimpanan akun/account dengan nama sesuai NIK
            return redirect('/masuk');// <-Pergi ke halaman selanjutnya/masuk/login
        }
    }
    public function masukClass(Request $request){
        // *Autentikasi masuk/login
        if(session()->has('akun.nik')){return redirect('/');}// <-Jika ada sesi/session NIK maka kembali ke beranda/home

        // *Route get untuk aksi masuk/login
        if($request->isMethod('get')){// <-Jika route-nya tipe get
            return view('auth.login');// <-Buka view blade Auth/Register

        // *Route post untuk aksi masuk/login
        }if($request->isMethod('post')){// <-Jika route-nya tipe post
            // *Menyimpan data formulir daftar
            $masuk=collect([$request->nik,$request->nama])->toArray();// <-Simpan NIK dan Nama
            // *Membandingkan data formulir dengan setiap baris/row data config
            $config_temp=Storage::get('public/docs/config.txt');// <-Ambil semua data config
            $config_rows=explode("\n",$config_temp);// <-Bagi setiap baris/row data config
            foreach ($config_rows as $config_row) {// <-Bandingkan dari baris/row pertama pada data config
                $config_row_value=explode('|',$config_row);// <-Memilah baris/row tersebut menjadi NIK dan Nama
                if ($config_row_value==$masuk){// <-Periksa data formulir tersebut jika ada yang sama pada data config
                    session()->put('akun',[// <-Buat sesi/session akun
                        'nik'=>$masuk[0],// <-Simpan array nik pada sesi/session akun
                        'nama'=>$masuk[1]// <-Simpan array nama pada sesi/session akun
                    ]);
                    return redirect('/');// <-Pergi ke halaman selanjutnya/beranda/home
                }
            }
    
            // *Jika data formulir tidak ada pada data config
            return redirect('/masuk')->with('gagal','NIK atau Nama Lengkap salah!');// <-Kembali ke halaman sebelumnya/masuk/login
        }
    }
    public function keluarClass(){
        // *Aksi post keluar/logout
        session()->flush();// <-Hapus semua sesi/session yang tersimpan
        return redirect('/masuk');// <-Pergi ke halaman masuk/login
    }
    public function berandaClass(){
        // *Autentikasi masuk/login
        if(session()->missing('akun.nik')){return redirect('/masuk');}// <-Jika tidak ada sesi/session NIK maka kembali ke masuk/login
        return view('app.home');// <-Buka view blade App/Home
    }
}