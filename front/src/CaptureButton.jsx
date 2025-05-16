import React from 'react';

const CaptureButton = ({ id, imageData }) => {
    const handleSendImage = async () => {
        try {
            await fetch('http://localhost:58000/parking/image', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, imageData }),
            });
            alert('Imagen enviada correctamente');
        } catch (error) {
            console.error('Error al enviar la imagen:', error);
        }
    };

    return (
        <button onClick={handleSendImage} disabled={!imageData}>
            Enviar imagen
        </button>
    );
};

export default CaptureButton;