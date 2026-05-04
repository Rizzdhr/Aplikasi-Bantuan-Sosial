import pandas as pd
from sklearn.tree import DecisionTreeClassifier
import joblib

# Dataset contoh (dummy, nanti bisa diganti real)
data = pd.DataFrame({
    'penghasilan': [500000, 2000000, 800000, 3000000, 600000],
    'usia': [60, 30, 45, 25, 50],
    'pekerjaan': [0, 2, 1, 2, 0],  # 0=tidak kerja,1=buruh,2=karyawan
    'kondisi_rumah': [0, 1, 1, 1, 0], # 0=buruk,1=baik
    'label': [1, 0, 1, 0, 1]
})

X = data[['penghasilan','usia','pekerjaan','kondisi_rumah']]
y = data['label']

model = DecisionTreeClassifier()
model.fit(X, y)

joblib.dump(model, 'model.pkl')

print("Model berhasil disimpan!")
