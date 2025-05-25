from flask import Flask
app = Flask(__name__)

@app.route('/')
def hello():
    return "<h1>Hello from Render!</h1><p>This is version 2.</p>"

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
