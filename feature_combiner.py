from sklearn.compose import ColumnTransformer
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.impute import SimpleImputer
from sklearn.pipeline import Pipeline
from sklearn.preprocessing import OneHotEncoder, StandardScaler

class FeatureCombiner:
    def __init__(self):
        self.column_transformer = ColumnTransformer(
            transformers=[
                ('num', Pipeline([
                    ('imputer', SimpleImputer(strategy='median')),
                    ('scaler', StandardScaler())
                ]), ['callDuration']),
                ('cat', Pipeline([
                    ('imputer', SimpleImputer(strategy='most_frequent')),
                    ('encoder', OneHotEncoder(handle_unknown='ignore'))
                ]), ['callType', 'personalInfoRequest', 'emotionTactics']),
                ('text', TfidfVectorizer(), 'commonWords')
            ],
            remainder='drop'
        )
        
    def fit(self, X, y=None):
        self.column_transformer.fit(X, y)
        return self
    
    def transform(self, X):
        return self.column_transformer.transform(X)
    
    def fit_transform(self, X, y=None):
        return self.column_transformer.fit_transform(X, y)
