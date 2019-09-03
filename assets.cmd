@echo off
call sass .\assets\scss\styles.scss .\assets\dist\styles.css --no-source-map
call tsc .\assets\ts\main.ts --outFile .\assets\dist\main.js --module system
rd /s /q C:\xampp\htdocs\basic\web\assets\8eaf6eda
