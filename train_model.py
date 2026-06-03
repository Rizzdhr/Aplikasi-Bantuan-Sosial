import pandas as pd
from sklearn.tree import DecisionTreeClassifier
from sklearn.calibration import CalibratedClassifierCV
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score, classification_report
import joblib

data = pd.read_csv('training.csv')

X = data[['penghasilan', 'usia', 'pekerjaan', 'kondisi_rumah']]
y = data['label']

X_train, X_test, y_train, y_test = train_test_split(
    X, y, test_size=0.2, random_state=42
)

base_model = DecisionTreeClassifier(
    max_depth=5,           # lebih dangkal
    min_samples_leaf=30,   # tiap leaf min 30 sampel
    min_samples_split=50,  # split hanya kalau ada 50+ sampel
    random_state=42
)

model = CalibratedClassifierCV(base_model, cv=5, method='isotonic')
model.fit(X_train, y_train)

y_pred = model.predict(X_test)
print(f"Akurasi: {accuracy_score(y_test, y_pred):.2%}")
print(classification_report(y_test, y_pred, target_names=['Ditolak', 'Diterima']))

joblib.dump(model, 'model.pkl')
print("Model berhasil disimpan!")
