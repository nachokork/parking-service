from pydantic import BaseModel
from typing import List

class ParkingSpot(BaseModel):
    class_name: str
    confidence: float
    bbox: List[float]

class DetectionResponse(BaseModel):
    total_detections: int
    cars: int
    empty_slots: int
    special_slots: int
    detections: List[ParkingSpot]
