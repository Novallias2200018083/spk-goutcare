$plantUml = @"
@startuml
!theme cerulean-outline

|Admin|
start
:Membuka Aplikasi SPK Gout Care;
:Memasukkan Email & Password;
:Menekan Tombol "Login";

|Sistem|
:Validasi Kredensial Database;

if (Data Valid & Role = Admin?) then (Tidak)
  :Tampilkan Pesan Error (Gagal Login);
  stop
else (Ya)
  :Mengarahkan ke Dashboard Admin;
  
  |Admin|
  :Berada di Halaman Dashboard;
  
  if (Pilih Kelola Data Pengguna?) then (Ya)
    :Melihat, Menambah, & Mengedit Data Pasien;
  elseif (Pilih Kelola Master Makanan?) then (Ya)
    :Mengelola Daftar Menu & Kandungan Gizi;
  elseif (Pilih Kelola Kriteria & Skala?) then (Ya)
    :Mengatur Parameter SPK & Nilai Batas;
  elseif (Pilih Kelola Bobot GAP?) then (Ya)
    :Menyesuaikan Nilai Core & Secondary Factor;
  elseif (Pilih Laporan Rekomendasi?) then (Ya)
    :Memantau Hasil Rekomendasi & Cetak PDF;
  else (Tidak Memilih Menu)
  endif
  
  :Menekan Tombol "Logout";
  
  |Sistem|
  :Menghapus Sesi (Session) Login;
  :Kembali ke Halaman Awal;
  stop
endif

@enduml
"@

$body = @{
    diagram_source = $plantUml
    diagram_type = "plantuml"
    output_format = "png"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "https://kroki.io/" -Method Post -Body $body -ContentType "application/json" -OutFile "C:\laragon\www\spk-gout\public\test_admin_act.png"

Write-Output "Image downloaded successfully."
