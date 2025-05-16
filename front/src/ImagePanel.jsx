import React, { useRef, useState } from 'react';

const ImagePanelWithCapture = ({ src, id, onShowResult }) => {
    const panelRef = useRef(null);
    const [imageData, setImageData] = useState(null);
    const [loading, setLoading] = useState(false);

    const handleCapture = () => {
        const canvas = document.createElement('canvas');
        const panel = panelRef.current;
        const ctx = canvas.getContext('2d');
        const img = panel.querySelector('img');

        if (img && img.complete) {
            canvas.width = img.naturalWidth;
            canvas.height = img.naturalHeight;
            ctx.drawImage(img, 0, 0);
            const capturedData = canvas.toDataURL('image/jpeg');
            setImageData(capturedData);
        } else {
            console.warn('Imagen aún no está completamente cargada');
        }
    };

    const handleSendImage = async () => {
        if (!imageData) return;

        setLoading(true);

        try {
            const res = await fetch(imageData);
            const blob = await res.blob();

            const file = new File([blob], `${id}.jpg`, { type: 'image/jpeg' });

            const formData = new FormData();
            formData.append('file', file);

            const response = await fetch('http://localhost:8000/parking/image', {
                method: 'POST',
                body: formData,
            });

            const json = await response.json();
            if (json.status === 'success') {
                // Enviamos al padre el resultado para mostrar modal
                onShowResult({ id, data: json.data });
            } else {
                alert('Error del servidor');
            }
        } catch (error) {
            console.error('Error al enviar la imagen:', error);
            alert('Error al enviar la imagen');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div ref={panelRef} style={{ position: 'relative', zIndex: 0 }}>
            <img
                src={src}
                alt={`Panel ${id}`}
                style={{ width: '100%', display: 'block' }}
                onLoad={() => console.log('Imagen cargada')}
            />
            <button onClick={handleCapture}>Comprobar espacio</button>
            <button onClick={handleSendImage} disabled={!imageData || loading}>
                {loading ? 'Analizando...' : 'Enviar imagen'}
            </button>
        </div>
    );
};

export default ImagePanelWithCapture;
