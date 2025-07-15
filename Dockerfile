# 使用 PHP 官方映像檔作為基礎
FROM php:8.2-cli

# 設定工作目錄
WORKDIR /var/www/html

# 複製檔案到容器
COPY . .

# 安裝相依套件
#RUN pip install --no-cache-dir -r requirements.txt

# 暴露 Flask 預設埠
EXPOSE 5000

# 啟動應用程式
CMD ["php", "-S", "0.0.0.0:5000", "app.php"]
