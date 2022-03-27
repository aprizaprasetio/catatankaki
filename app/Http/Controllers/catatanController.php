<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

/*
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
*/

class catatanController extends Controller
{
    public function daftarClass(Request $request){
        // *Route get untuk view daftar/register
        if ($request->isMethod('get')) {// <-Jika route-nya tipe get
            return view('auth.register');// <-Buka view blade Auth/Register

        // *Route post untuk aksi daftar/register
        } if ($request->isMethod('post')) {// <-Jika route-nya tipe post
            // *Memvalidasi/memeriksa kondisi kolom data formulir
            $this->validate($request,[// <-Validasi isi request
                'nik'=>'required',// <-Cek ada NIK
                'nama'=>'required',// <-Cek ada Nama
            ]);

            // *Menyimpan data formulir daftar/register
            $daftar=[
                'nik'=>$request->nik,// <-Simpan NIK
                'nama'=>$request->nama,// <-Simpan Nama
            ];

            // *Membandingkan data formulir dengan setiap baris/row data config
            $config_temp=Storage::get('public/docs/config.txt');// <-Ambil semua data config
            $config_rows=explode(PHP_EOL,$config_temp);// <-Bagi setiap baris/row data config
            foreach ($config_rows as $config_row) {// <-Bandingkan dari baris/row pertama pada data config
                $config_row_value=explode('|',$config_row);// <-Seleksi baris/row tersebut menjadi NIK dan Nama
                if ($config_row_value[0]==$daftar['nik']) {// <-Jika NIK tersebut ada yang sama pada data config
                    return redirect('/daftar')->with('gagal','NIK sudah digunakan!');// <-Kembali ke halaman sebelumnya/daftar/register
                }
            }

            // *Mengelola data config dan penyimpanan akun
            $config_row_create=$daftar['nik'].'|'.$daftar['nama'];// <-Simpan data formulir yang akan dimasukkan pada data config
            Storage::append('public/docs/config.txt', $config_row_create);// <-Tambah data formulir pada data config di baris/row terakhir
            Storage::put('public/docs/'.$daftar['nik'].'.txt', '');// <-Buat data penyimpanan akun/account dengan nama sesuai NIK

            // *Program selesai dan pengembalikan
            return redirect('/masuk')->with('sukses','sukses');// <-Pergi ke halaman selanjutnya/masuk/login
        }
    }
    public function masukClass(Request $request){
        // *Route get untuk view masuk/login
        if ($request->isMethod('get')) {// <-Jika route-nya tipe get
            return view('auth.login');// <-Buka view blade Auth/Login

        // *Route post untuk aksi masuk/login
        } if ($request->isMethod('post')) {// <-Jika route-nya tipe post
            // *Memvalidasi/memeriksa kondisi kolom data formulir
            $this->validate($request,[// <-Validasi isi request
                'nik'=>'required',// <-Cek ada NIK
                'nama'=>'required',// <-Cek ada Nama
            ]);

            // *Menyimpan data formulir masuk
            $masuk=[$request->nik,$request->nama];// <-Simpan NIK dan Nama
            $config_temp=Storage::get('public/docs/config.txt');// <-Ambil semua data config
            $config_rows=explode(PHP_EOL,$config_temp);// <-Bagi setiap baris/row data config

            // *Memeriksa setiap baris/row data config sesuai dengan data formulir
            foreach ($config_rows as $config_row) {// <-Bandingkan dari baris/row pertama pada data config
                $config_row_value=explode('|',$config_row);// <-Memilah baris/row tersebut menjadi NIK dan Nama
                if ($config_row_value==$masuk) {// <-Periksa data formulir tersebut jika ada yang sama pada data config
                    session()->put('akun',[// <-Buat sesi/session akun
                        'nik'=>$masuk[0],// <-Simpan array nik pada sesi/session akun
                        'nama'=>$masuk[1]// <-Simpan array nama pada sesi/session akun
                    ]);
                    // *Program selesai dan pengembalikan
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
        if (session()->missing('akun')) { return redirect('/masuk'); }// <-Jika tidak ada sesi/session NIK maka kembali ke masuk/login
        return view('app.home');// <-Buka view blade App/Home
    }
    public function isi_dataClass(Request $request){
        // *Route get untuk view app/isi_data
        if ($request->isMethod('get')) {// <-Jika route-nya tipe get
            // *Menyimpan data lokasi terakhir pada penyimpanan
            if (Storage::disk('local')->size('public/docs/'.session()->get('akun.nik').'.txt')!=0) {// <-Jika data penyimpanan sudah pernah terisi
                $catatan_perjalanan_temp=Storage::disk('local')->get('public/docs/'.session()->get('akun.nik').'.txt');// <-Simpan data penyimpanan
                $catatan_perjalanan_rows=explode(PHP_EOL,$catatan_perjalanan_temp);// <-Bagi setiap baris/row data 
                $catatan_perjalanan_row_value_pertama=explode('|',$catatan_perjalanan_rows[0]);// <-Bagi lagi hanya di data baris/row pertama saja
                $catatan_perjalanan_row_lokasi=$catatan_perjalanan_row_value_pertama[2];// <-Simpan data lokasi
                return view('app.isi_data',compact('catatan_perjalanan_row_lokasi'));// <-Buka view blade App/Isi_Data dan kirim data lokasi
            }
            return view('app.isi_data');// <-Buka view blade App/Isi_Data jika data penyimpanan masih kosong/belum pernah terisi

        // *Route post untuk aksi app/isi_data
        } if ($request->isMethod('post')) {// <-Jika route-nya tipe post
            // *Memvalidasi/memeriksa kondisi kolom data formulir
            $this->validate($request,[// <-Validasi isi request
                'tanggal'=>'required',// <-Cek ada tanggal
                'jam'=>'required',// <-Cek ada jam
                'lokasi'=>'required',// <-Cek ada lokasi
                'suhu'=>'required',// <-Cek ada suhu
            ]);
            // *Menyimpan data formulir isi catatan perjalanan
            $isi_data=[// <-Simpan data formulir dalam bentuk array
                'tanggal'=>$request->tanggal,// <-Simpan tanggal
                'jam'=>$request->jam,// <-Simpan waktu jam
                'lokasi'=>$request->lokasi,// <-Simpan lokasi perjalanan
                'suhu'=>$request->suhu,// <-Simpan suhu tubuh
                'penyimpanan'=>'public/docs/'.session()->get('akun.nik').'.txt',// <-Simpan lokasi/path penyimpanan
            ];
            $isi_data_row=$isi_data['tanggal'].'|'.$isi_data['jam'].'|'.$isi_data['lokasi'].'|'.$isi_data['suhu'];// <-Simpan semua data formulir untuk disimpan pada penyimpanan
            
            // *Mengelola data config dan penyimpanan akun
            if (Storage::size($isi_data['penyimpanan'])==0) {// <-Jika penyimpanan masih kosong
                Storage::put($isi_data['penyimpanan'], $isi_data_row);// <-Timpa/replace dengan data formulir
            } else {// <-Jika tidak/penyimpanan sudah ada isinya
                Storage::prepend($isi_data['penyimpanan'], $isi_data_row);// <-Tambah data formulir pada penyimpanan
            }

            // *Mengirimkan pesan notifikasi
            // if ($request->has('')) {
            //     session()->put('pesan','Data berhasil tersimpan!');
            // }

            // *Jika data formulir tidak ada pada data config
            return redirect('/isi-data')->with('sukses','sukses');// <-Kembali ke halaman sebelumnya/masuk/login
        }
    }
    public function catatan_perjalananClass(Request $request){
        // *Memeriksa jika data penyimpanan belum terisi
        if (Storage::disk('local')->size('public/docs/'.session()->get('akun.nik').'.txt')==0) {// <-Jika data penyimpanan belum terisi/kosong
            return view('app.catatan_perjalanan')->with('kosong','Belum ada data yang tersimpan!');// <-Buka view blade App/Catatan_Perjalanan beserta pesan kosong
        }

        // *Mengelola data penyimpanan
        $catatan_perjalanan_temp=Storage::disk('local')->get('public/docs/'.session()->get('akun.nik').'.txt');// <-Simpan data penyimpanan
        $catatan_perjalanan_rows=explode(PHP_EOL,$catatan_perjalanan_temp);// <-Bagi setiap baris/row
        foreach ($catatan_perjalanan_rows as $catatan_perjalanan_row) {// <-Periksa satu baris/row
            $catatan_perjalanan_array=explode('|', $catatan_perjalanan_row);// <-Bagi isi satu baris/row
            $catatan_perjalanan_rows_collection_temp[]=[// <-Simpan sementara satu baris/row yang telah dibagi
                'tanggal'=>$catatan_perjalanan_array[0],// <-Simpan tanggal
                'jam'=>$catatan_perjalanan_array[1],// <-Simpan jam
                'lokasi'=>$catatan_perjalanan_array[2],// <-Simpan lokasi
                'suhu'=>$catatan_perjalanan_array[3],// <-Simpan suhu
            ];
        }

        // *Pemilahan data penyimpanan berdasarkan urutan/sortir
        switch ($request->get('urutan')) {// <-Metode urutan dari data formulir
            case 'terbaru':// <-Jika value urutannya tanggal terbaru
                $catatan_perjalanan_rows_collection=collect($catatan_perjalanan_rows_collection_temp)->sortByDesc('tanggal');// <-Tata ulang sesuai tanggal terbaru
                break;
            case 'terlama':// <-Jika value urutannya tanggal terlama
                $catatan_perjalanan_rows_collection=collect($catatan_perjalanan_rows_collection_temp)->sortBy('tanggal');// <-Tata ulang sesuai tanggal terlama
                break;
            case 'tertinggi':// <-Jika value urutannya suhu tertinggi
                $catatan_perjalanan_rows_collection=collect($catatan_perjalanan_rows_collection_temp)->sortByDesc('suhu');// <-Tata ulang sesuai suhu tertinggi
                break;
            case 'terendah':// <-Jika value urutannya suhu terendah
                $catatan_perjalanan_rows_collection=collect($catatan_perjalanan_rows_collection_temp)->sortBy('suhu');// <-Tata ulang sesuai suhu terendah
                break;
            default:// <-Jika value tidak ada/belum diurutkan
                $catatan_perjalanan_rows_collection=collect($catatan_perjalanan_rows_collection_temp);// <-Hanya ubah array menjadi koleksi/collection laravel tanpa sortir
                break;
        }

        // *Jika kolom pencarian data formulir terisi
        if($request->get('urutan_lokasi')) {// <-Jika value pada kolom pencarian terisi
            $catatan_perjalanan_rows_collection=$catatan_perjalanan_rows_collection->where('lokasi', $request->get('urutan_lokasi'));// <-Cari string berdasarkan isi lokasi pada kolom pencarian data formulir
            // $catatan_perjalanan_rows_collection=$catatan_perjalanan_rows_collection->filter(function ($request) {
            //     return false !== stripos('lokasi', $request->get('urutan_lokasi'));
            // });
            // ('lokasi', $request->get('urutan_lokasi'));// <-Cari string berdasarkan isi lokasi pada kolom pencarian data formulir
            // dd($catatan_perjalanan_rows_collection);
        }
        // dd($catatan_perjalanan_rows_collection);

        // *Mengambil data penyimpanan terakhir kali dimodifikasi
        $catatan_perjalanan_last_modified=Storage::lastModified('public/docs/'.session()->get('akun.nik').'.txt');// <-Simpan data penyimpanan terakhir kali dimodifikasi
        session()->put('catatan_perjalanan_last_modified', $catatan_perjalanan_last_modified);// <-Simpan data penyimpanan terakhir kali dimodifikasi sebagai sesi/session

        // *Program selesai dan pengembalikan
        return view('app.catatan_perjalanan', compact('catatan_perjalanan_rows_collection'));// <-Buka view blade App/Catatan_Perjalanan beserta data penyimpanan terakhir kali dimodifikasi
    }
}