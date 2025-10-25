from flask import Flask, request, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

def chatbot_reply(message):
    msg = message.lower()

    # Emotional Support Responses
    if "stress" in msg or "pressure" in msg:
        return ("I understand how overwhelming stress can feel. "
                "Try taking 10 minutes to breathe slowly or take a short walk. "
                "Would you like tips on managing academic stress?")
    
    if "depress" in msg or "sad" in msg or "down" in msg:
        return ("I'm really sorry that you're feeling this way. "
                "It's okay to not feel okay sometimes. You are not alone. "
                "Have you talked to anyone you trust about how you feel?")
    
    if "anxiety" in msg or "panic" in msg:
        return ("Anxiety can be scary. You're safe. "
                "Try placing your hand on your chest and take 3 slow breaths. "
                "I'm here with you. Want breathing exercises guidance?")
    
    # Symptom Screening Responses
    if "can't sleep" in msg or "insomnia" in msg:
        return ("Sleep issues are common under stress. "
                "Do you often stay awake thinking, or is it emotional discomfort keeping you up?")
    
    if "can't focus" in msg or "concentrate" in msg:
        return ("Difficulty focusing can be caused by mental fatigue. "
                "How many hours of rest do you usually get at night?")
    
    # General Support
    if "hello" in msg or "hi" in msg:
        return ("Hello 😊 I'm your KIU Mental Support Companion. "
                "How are you feeling today?")
    
    if "thank" in msg:
        return ("You're welcome 💚 I'm here anytime you need me.")

    # Default fallback
    return ("I hear you. Your feelings are valid. "
            "Tell me more, I'm listening.")

@app.post("/chat")
def chat():
    data = request.get_json()
    user_message = data.get("message", "")
    response = chatbot_reply(user_message)
    return jsonify({"reply": response})

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5002)
