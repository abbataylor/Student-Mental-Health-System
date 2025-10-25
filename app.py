from flask_cors import CORS

from flask import Flask, request, jsonify
import joblib
import pandas as pd

app = Flask(__name__)
CORS(app)


# Load trained model
model = joblib.load("mental_model.pkl")

@app.route("/predict", methods=["POST"])
def predict():
    try:
        data = request.json

        df = pd.DataFrame([data])

        prediction = model.predict(df)[0]

        # Generate advice based on risk level
        if prediction == "High":
            advice = "You may be experiencing significant psychological stress. It is strongly advised to talk to a counselor or mental health professional."
        elif prediction == "Moderate":
            advice = "You may be under noticeable emotional strain. Try stress-relief practices and consider speaking to a counselor."
        else:
            advice = "Your risk level appears low. Maintain healthy sleep, exercise and social habits."

        return jsonify({
            "risk_level": prediction,
            "advice": advice
        })

    except Exception as e:
        return jsonify({"error": str(e)})

if __name__ == "__main__":
    app.run(host="127.0.0.1", port=5001)
