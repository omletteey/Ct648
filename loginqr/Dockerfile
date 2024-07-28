# ใช้ PHP Apache base image
FROM php:7.4-apache

# กำหนด working directory
WORKDIR /var/www/html

# ติดตั้ง libcurl และ libmariadb-dev-compat ก่อน
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    libmariadb-dev-compat \
    libmariadb-dev \
    pkg-config

# ติดตั้ง curl และ mysqli extension สำหรับ PHP
RUN docker-php-ext-install curl mysqli

# คัดลอกไฟล์ใน local ไปยัง container
COPY src/ /var/www/html/

# เปิดพอร์ต 80
EXPOSE 80
