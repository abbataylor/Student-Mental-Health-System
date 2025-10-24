from flask import Flask, request, jsonify
import pandas as pd
import joblib, os
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.preprocessing import LabelEncoder
from sklearn.impute import SimpleImputer
from sklearn.pipeline import Pipeline
from sklearn.compose import ColumnTransformer

app = Flask(__name__)

DATA_FILE = "Student Mental health.csv"
RISK_MODEL = "model_risk.pkl"
NEED_MODEL = "model_need.pkl"

def train_models():
    df = pd.read_csv(DATA_FILE)
    df.columns = [c.strip().lower().replace(" ", "_") for c in df.columns]

    # Basic cleaning
    df = df.dropna(subset=["age"])
    df["age"] = df["age"].astype(float)

    # Create targets (derived if not directly present)
    if "depression" in df.columns:
        df["risk_level"] = df["depression"].apply(
            lambda x: "High" if x >= 7 else "Moderate" if x >= 4 else "Low"
        )
    else:
        df["risk_level"] = "Moderate"

    df["needs_counseling"] = df["risk_level"].apply(
        lambda r: "Yes" if r in ["High", "Moderate"] else "No"
    )

    features = ["gender", "age", "course", "year_of_study", "cgpa", "marital_status"]
    features = [f for f in features if f in df.columns]
    X = df[features]
    y_risk = df["risk_level"]
    y_need = df["needs_counseling"]

    cat_cols = X.select_dtypes(include=["object"]).columns.tolist()
    num_cols = X.select_dtypes(exclude=["object"]).columns.tolist()

    cat_pipe = Pipeline([("imp", SimpleImputer(strategy="most_frequent")), ("enc", LabelEncoder())])
    # But LabelEncoder doesn’t work on multiple columns; instead use ColumnTransformer
    from sklearn.preprocessing import OrdinalEncoder
    preprocessor = ColumnTransformer([
        ("cat", OrdinalEncoder(handle_unknown="use_encoded_value", unknown_value=-1), cat_cols),
        ("num", SimpleImputer(strategy="mean"), num_cols)
    ])

    # Train risk model
    model_risk = Pipeline([
        ("pre", preprocessor),
        ("clf", RandomForestClassifier(n_estimators=100, random_state=42))
    ])
    model_risk.fit(X, y_risk)
    joblib.dump(model_risk, RISK_MODEL)

    # Train need model
    model_need = Pipeline([
        ("pre", preprocessor),
        ("clf", RandomForestClassifier(n_estimators=100, random_state=42))
    ])
    model_need.fit(X, y_need)
    joblib.dump(model_need, NEED_MODEL)

    print("✅ Models trained and saved successfully")

if not os.path.exists(RISK_MODEL) or not os.path.exists(NEED_MODEL):
    print("📊 Training new models...")
    train_models()

model_risk = joblib.load(RISK_MODEL)
model_need = joblib.load(NEED_MODEL)

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json(force=True)
    df = pd.DataFrame([data])

    # ensure column names match
    df.columns = [c.strip().lower().replace(" ", "_") for c in df.columns]

    risk_pred = model_risk.predict(df)[0]
    need_pred = model_need.predict(df)[0]

    return jsonify({
        "risk": str(risk_pred),
        "needs_counseling": str(need_pred)
    })

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001)
