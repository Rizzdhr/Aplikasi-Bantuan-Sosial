from flask import Flask, request, jsonify
import joblib

app = Flask(__name__)
model = joblib.load('model.pkl')

print(type(model))

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json

    fitur = [[
        data['penghasilan'],
        data['usia'],
        data['pekerjaan'],
        data['kondisi_rumah']
    ]]

    prob = model.predict_proba(fitur)[0][1]

    return jsonify({
        "status": "diterima" if prob > 0.5 else "ditolak",
        "skor": float(prob)
    })

if __name__ == '__main__':
    app.run(port=5000)
