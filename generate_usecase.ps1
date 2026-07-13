$plantUml = @"
@startuml
!theme cerulean-outline
left to right direction
skinparam packageStyle rectangle

actor Admin
actor Pasien

rectangle "SPK Gout Care" {
  usecase "Login / Logout" as UC1
  
  ' Admin Use Cases
  usecase "Kelola Data Pengguna" as UC2
  usecase "Kelola Master Makanan" as UC3
  usecase "Kelola Data Kriteria" as UC4
  usecase "Kelola Skala Kriteria" as UC5
  usecase "Kelola Bobot GAP" as UC6
  usecase "Kelola Pengaturan" as UC7
  usecase "Laporan Rekomendasi" as UC8

  ' Pasien Use Cases
  usecase "Registrasi Akun" as UC9
  usecase "Profil Kesehatan & BMR" as UC10
  usecase "Kelola Makanan Pribadi" as UC11
  usecase "Jelajah Menu Makanan" as UC12
  usecase "Hitung Rekomendasi Makanan" as UC13
  usecase "Riwayat Rekomendasi" as UC14
  usecase "AI Insight Rekomendasi" as UC15
}

Admin --> UC1
Admin --> UC2
Admin --> UC3
Admin --> UC4
Admin --> UC5
Admin --> UC6
Admin --> UC7
Admin --> UC8

Pasien --> UC9
Pasien --> UC1
Pasien --> UC10
Pasien --> UC11
Pasien --> UC12
Pasien --> UC13
Pasien --> UC14
Pasien --> UC15
@enduml
"@

$body = @{
    diagram_source = $plantUml
    diagram_type = "plantuml"
    output_format = "png"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "https://kroki.io/" -Method Post -Body $body -ContentType "application/json" -OutFile "C:\laragon\www\spk-gout\public\use_case_diagram.png"

Write-Output "Image downloaded successfully."
