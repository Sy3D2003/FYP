import sys
import base64
import joblib

def main():
    # Load the model and vectorizer
    model = joblib.load('email_phishing_model.pkl')
    vectorizer = joblib.load('tfidf_vectorizer.pkl')

    # Decode the email text from base64 input
    email_text = base64.b64decode(sys.argv[1]).decode('utf-8')

    # Transform the email text to match the training data format
    email_tfidf = vectorizer.transform([email_text])

    # Predict using the trained model
    prediction = model.predict(email_tfidf)
    result = "spam" if prediction[0] == 1 else "not spam"

    # Encode the result as a base64-encoded string and print
    encoded_result = base64.b64encode(result.encode('utf-8')).decode('utf-8')
    print(encoded_result)

if __name__ == "__main__":
    main()
