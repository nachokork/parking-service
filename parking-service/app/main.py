from fastapi import FastAPI, File, UploadFile, HTTPException
from fastapi.middleware.cors import CORSMiddleware
import cv2
import numpy as np
from detector import ParkingDetector
from models import ParkingSpot, DetectionResponse
from config import settings
import logging

app = FastAPI(
    title="Parking Detection Service",
    description="Microservicio para detección y clasificación de plazas de aparcamiento",
    version="1.0.0"
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

logger = logging.getLogger(__name__)
detector = ParkingDetector()

@app.post("/detect", response_model=DetectionResponse)
async def detect_parking_spots(file: UploadFile = File(...)):
    if not file.content_type.startswith('image/'):
        raise HTTPException(400, "Solo se aceptan archivos de imagen")

    try:
        print(file.content_type)
        contents = await file.read()
        nparr = np.frombuffer(contents, np.uint8)
        img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)

        spots = detector.detect_spots(img)

        counts = {
            "car": 0,
            "empty_slot": 0,
            "special_slot": 0
        }

        for spot in spots:
            if spot["class"] in counts:
                counts[spot["class"]] += 1

        response = DetectionResponse(
            total_detections=len(spots),
            cars=counts["car"],
            empty_slots=counts["empty_slot"],
            special_slots=counts["special_slot"],
            detections=[
                ParkingSpot(
                    class_name=spot["class"],
                    confidence=spot["confidence"],
                    bbox=spot["bbox"]
                ) for spot in spots
            ]
        )

        return response

    except Exception as e:
        logger.error(f"Error procesando imagen: {str(e)}")
        raise HTTPException(500, f"Error procesando imagen: {str(e)}")

@app.get("/health")
async def health_check():
    return {"status": "healthy", "model": settings.MODEL_PATH}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8100)
