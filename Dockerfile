# 使用 Python 官方映像檔作為基礎
FROM python:3.10-slim

# 設定工作目錄
WORKDIR /app

# 複製檔案到容器
COPY . .

# 安裝相依套件
RUN pip install --no-cache-dir -r requirements.txt

# 暴露 Flask 預設埠
EXPOSE 5000

# 啟動應用程式
CMD ["python", "app.py"]
