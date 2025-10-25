import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import OneHotEncoder, StandardScaler
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
from sklearn.tree import DecisionTreeClassifier
from sklearn.impute import SimpleImputer
import joblib

# Load dataset
df = pd.read_csv("Student Mental health.csv")

# Rename columns to clean names
df.rename(columns={
    "Choose your gender": "gender",
    "Age": "age",
    "What is your course?": "course",
    "Your current year of Study": "year_study",
    "What is your CGPA?": "cgpa",
    "Marital status": "marital_status",
    "Do you have Depression?": "depression",
    "Do you have Anxiety?": "anxiety",
    "Do you have Panic attack?": "panic_attack"
}, inplace=True)

# Fill missing values in key columns
df["age"] = df["age"].fillna(df["age"].median())
df["gender"] = df["gender"].fillna("Unknown")
df["course"] = df["course"].fillna("Unknown")
df["year_study"] = df["year_study"].fillna("Unknown")
df["cgpa"] = df["cgpa"].fillna("Unknown")
df["marital_status"] = df["marital_status"].fillna("Unknown")
df["depression"] = df["depression"].fillna("No")
df["anxiety"] = df["anxiety"].fillna("No")
df["panic_attack"] = df["panic_attack"].fillna("No")

# Create risk category based on symptoms
def risk_level(row):
    score = 0
    if row["depression"] == "Yes": score += 1
    if row["anxiety"] == "Yes": score += 1
    if row["panic_attack"] == "Yes": score += 1
    
    if score >= 2:
        return "High"
    elif score == 1:
        return "Moderate"
    else:
        return "Low"

df["risk_level"] = df.apply(risk_level, axis=1)

# Features and target
X = df[["age", "gender", "course", "year_study", "cgpa", "marital_status"]]
y = df["risk_level"]

# Preprocessing pipeline
numeric_features = ["age"]
numeric_transformer = Pipeline(steps=[
    ("imputer", SimpleImputer(strategy="median")),
    ("scale", StandardScaler())
])

categorical_features = ["gender", "course", "year_study", "cgpa", "marital_status"]
categorical_transformer = Pipeline(steps=[
    ("imputer", SimpleImputer(strategy="most_frequent")),
    ("encode", OneHotEncoder(handle_unknown="ignore"))
])

preprocess = ColumnTransformer([
    ("num", numeric_transformer, numeric_features),
    ("cat", categorical_transformer, categorical_features)
])

model = Pipeline([
    ("preprocess", preprocess),
    ("classifier", DecisionTreeClassifier(max_depth=5, random_state=42))
])

model.fit(X, y)

# Save model
joblib.dump(model, "mental_model.pkl")

print("\n✅ MODEL TRAINED & SAVED SUCCESSFULLY ✅")
