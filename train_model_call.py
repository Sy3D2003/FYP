import joblib
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score
from feature_combiner import FeatureCombiner

# Load dataset
data = pd.read_excel(r'D:\OneDrive - student.newinti.edu.my\Desktop\FYP 1\final_combined_corrected_call_analysis_dataset_v2.xlsx')

# Check for missing values and fill them if necessary
data = data.fillna({
    'callType': 'missing',
    'personalInfoRequest': 'missing',
    'emotionTactics': 'missing',
    'commonWords': ''
})

# Prepare the data
X = data.drop(columns=['label'])
y = data['label']

# Split data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Initialize the FeatureCombiner
feature_combiner = FeatureCombiner()

# Transform the data
X_train_combined = feature_combiner.fit_transform(X_train)
X_test_combined = feature_combiner.transform(X_test)

# Train the model
model = RandomForestClassifier(random_state=42)
model.fit(X_train_combined, y_train)

# Save the model and feature combiner
joblib.dump(model, 'scam_call_analyzer_model.pkl')
joblib.dump(feature_combiner, 'scam_call_feature_combiner.pkl')

# Evaluate the model
y_pred = model.predict(X_test_combined)
accuracy = accuracy_score(y_test, y_pred)
print(f'Accuracy: {accuracy:.2%}')