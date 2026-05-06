import pandas as pd
from sklearn.tree import DecisionTreeClassifier
import joblib

data = pd.read_csv('training.csv')

X = data[['penghasilan','usia','pekerjaan','kondisi_rumah']]
y = data['label']

model = DecisionTreeClassifier()
model.fit(X, y)

joblib.dump(model, 'model.pkl')

print("Model berhasil disimpan!")
