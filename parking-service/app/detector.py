import cv2
import numpy as np
import pytesseract
from ultralytics import YOLO
from config import settings
from typing import List, Dict
import logging
import torch
from torch.nn import Module, BatchNorm2d, ReLU, SiLU, MaxPool2d, Upsample, Conv2d
from torch.nn.modules.container import Sequential, ModuleList
from ultralytics.nn.tasks import DetectionModel
from ultralytics.nn.modules.block import C2f, Bottleneck, SPPF
from ultralytics.nn.modules.conv import Conv, DWConv, Concat
from ultralytics.nn.modules.transformer import TransformerBlock, TransformerLayer
import torch.serialization
from ultralytics.nn.modules.head import Detect
from ultralytics.nn.modules.block import DFL

logging.basicConfig(level=settings.LOG_LEVEL)
logger = logging.getLogger(__name__)

class ParkingDetector:
    def __init__(self):
            torch.serialization.add_safe_globals([
                Module,
                BatchNorm2d,
                ReLU,
                SiLU,
                MaxPool2d,
                Upsample,
                Sequential,
                Conv2d,
                DetectionModel,
                Conv,
                C2f,
                ModuleList,
                Bottleneck,
                SPPF,
                Concat,
                DWConv,
                TransformerBlock,
                TransformerLayer,
                Detect,
                DFL,

            ])

            self.model = YOLO(settings.MODEL_PATH)

    def detect_spots(self, img: np.ndarray) -> List[Dict]:
        """Detecta y clasifica plazas de aparcamiento con YOLO y devuelve lista de detecciones."""
        try:
            results = self.model(img, conf=0.3)
            spots = []

            for result in results:
                for box in result.boxes:
                    class_id = int(box.cls[0])
                    class_name = self.model.names[class_id]
                    confidence = float(box.conf[0])
                    bbox = box.xyxy[0].tolist()

                    spots.append({
                        "class": class_name,
                        "confidence": confidence,
                        "bbox": bbox,
                    })

            return spots

        except Exception as e:
            logger.error(f"Detection error: {str(e)}")
            raise
