@echo off
chcp 65001 >nul
title IMPORT CƠ SỞ DỮ LIỆU QUẢN LÝ PHÒNG TRỌ
cls
echo =========================================================================
echo       TỰ ĐỘNG KHỞI TẠO CƠ SỞ DỮ LIỆU 'quanlyphongtro' VÀO MYSQL
echo =========================================================================
echo.

set MYSQL_CMD=mysql
where mysql >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    if exist "C:\xampp1\mysql\bin\mysql.exe" (
        set MYSQL_CMD=C:\xampp1\mysql\bin\mysql.exe
    ) else if exist "C:\xampp\mysql\bin\mysql.exe" (
        set MYSQL_CMD=C:\xampp\mysql\bin\mysql.exe
    ) else (
        echo [LỖI] Không tìm thấy MySQL Client trong XAMPP.
        pause
        exit /b 1
    )
)

echo [1/2] Đang tạo database 'quanlyphongtro' (nếu chưa có)...
"%MYSQL_CMD%" -u root -e "CREATE DATABASE IF NOT EXISTS quanlyphongtro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

echo [2/2] Đang import cấu trúc bảng và dữ liệu mẫu từ database\quanlyphongtro.sql...
"%MYSQL_CMD%" -u root --default-character-set=utf8mb4 quanlyphongtro < "%~dp0database\quanlyphongtro.sql"

if %ERRORLEVEL% EQU 0 (
    echo.
    echo =========================================================================
    echo [THÀNH CÔNG] Đã import CSDL quanlyphongtro thành công với đầy đủ 16 bảng!
    echo =========================================================================
) else (
    echo.
    echo [LỖI] Quá trình import gặp sự cố. Vui lòng kiểm tra lại MySQL trong XAMPP!
)

pause
