@echo off
call sass .\assets\scss\styles.scss .\assets\dist\styles.css --no-source-map
rd /s /q C:\xampp\htdocs\basic\web\assets\c1a6164b
