@echo off
chcp 65001 >nul
title HỆ THỐNG QUẢN LÝ PHÒNG TRỌ - NHÀ TRỌ AN BÌNH
cls
echo =========================================================================
echo       ĐỒ ÁN CHUYÊN ĐỀ LẬP TRÌNH WEB PHP ^& MYSQL (MÔ HÌNH MVC)
echo               HỆ THỐNG QUẢN LÝ PHÒNG TRỌ AN BÌNH
echo =========================================================================
echo.

:: Liên kết tự động vào htdocs của XAMPP để chạy được cả trên Apache http://localhost/quanlyphongtro
if exist "C:\xampp1\htdocs" (
    if not exist "C:\xampp1\htdocs\quanlyphongtro" (
        cmd /c mklink /J "C:\xampp1\htdocs\quanlyphongtro" "%~dp0" >nul 2>&1
    )
)
if exist "C:\xampp\htdocs" (
    if not exist "C:\xampp\htdocs\quanlyphongtro" (
        cmd /c mklink /J "C:\xampp\htdocs\quanlyphongtro" "%~dp0" >nul 2>&1
    )
)

echo [1/3] Đang kiểm tra máy chủ web và PHP...
set PHP_CMD=php
where php >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    if exist "C:\xampp1\php\php.exe" (
        set PHP_CMD=C:\xampp1\php\php.exe
    ) else if exist "C:\xampp\php\php.exe" (
        set PHP_CMD=C:\xampp\php\php.exe
    ) else (
        echo [LỖI] Không tìm thấy PHP. Vui lòng cài đặt XAMPP hoặc thêm PHP vào PATH.
        pause
        exit /b 1
    )
)

echo [2/3] Kiểm tra MySQL trong XAMPP...
netstat -ano | findstr "3306" >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo Đang khởi động MySQL...
    if exist "C:\xampp1\mysql\bin\mysqld.exe" (
        start /b "" "C:\xampp1\mysql\bin\mysqld.exe" --defaults-file="C:\xampp1\mysql\bin\my.ini" --standalone
    ) else if exist "C:\xampp\mysql\bin\mysqld.exe" (
        start /b "" "C:\xampp\mysql\bin\mysqld.exe" --defaults-file="C:\xampp\mysql\bin\my.ini" --standalone
    )
) else (
    echo MySQL đang hoạt động tốt.
)

echo.
echo =========================================================================
echo   BẠN CÓ THỂ TRUY CẬP HỆ THỐNG THEO 1 TRONG 2 CÁCH:
echo.
echo   [Cách 1 - XAMPP Apache]: http://localhost/quanlyphongtro/
echo   [Cách 2 - PHP Server]:   http://localhost:8000/
echo.
echo   Tài khoản Admin:       admin  /  admin123
echo   Tài khoản Khách thuê: khach1 /  123456
echo =========================================================================
echo.
echo Đang mở trình duyệt...
start http://localhost:8000/

"%PHP_CMD%" -S 127.0.0.1:8000 -t "%~dp0"
