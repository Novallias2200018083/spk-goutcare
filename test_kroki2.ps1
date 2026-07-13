$plantUml = @"
@startuml
!theme cerulean-outline

rectangle "Frame" {
|Admin|
start
:Membuka Aplikasi;
|Sistem|
:Validasi;
stop
}
@enduml
"@

$body = @{
    diagram_source = $plantUml
    diagram_type = "plantuml"
    output_format = "png"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "https://kroki.io/" -Method Post -Body $body -ContentType "application/json" -OutFile "C:\laragon\www\spk-gout\public\test_swimlane_box.png"

Write-Output "Image downloaded successfully."
