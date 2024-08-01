import sys
import joblib
import pandas as pd

# Load the model and feature combiner
model = joblib.load('scam_call_analyzer_model.pkl')
feature_combiner = joblib.load('scam_call_feature_combiner.pkl')

def main(args):
    if len(args) < 6:
        print("Error: Missing arguments")
        return

    # Collect input arguments
    input_data = {
        "callDuration": args[1],
        "commonWords": args[2],
        "callType": args[3],
        "personalInfoRequest": args[4],
        "emotionTactics": args[5]
    }

    # Convert input data to DataFrame
    input_df = pd.DataFrame([input_data])

    # Transform and predict
    data_transformed = feature_combiner.transform(input_df)
    prediction = model.predict(data_transformed)

    # Output user-friendly prediction message
    if prediction[0] == 'fraud':  # Adjust this condition based on your actual model output
        print("This call is most likely a fraud.")
    else:
        print("This call is most likely not a fraud.")

if __name__ == "__main__":
    main(sys.argv)
