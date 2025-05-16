import os
from dotenv import load_dotenv

load_dotenv()

class Settings:
    MODEL_PATH = os.getenv("MODEL_PATH", "parking_detection/exp/weights/best.pt")
    TESSERACT_CMD = os.getenv("TESSERACT_CMD", "/usr/bin/tesseract")
    LOG_LEVEL = os.getenv("LOG_LEVEL", "INFO")

settings = Settings()
