from ultralytics import YOLO

# Cargar modelo base y entrenar
model = YOLO("yolov8n.pt")  # Puedes usar yolov8s.pt o yolov8m.pt también

model.train(
    data="training/datasets/parking.yaml",
    epochs=50,
    imgsz=640,
    project="parking_detection",
    name="exp",
    exist_ok=True
)