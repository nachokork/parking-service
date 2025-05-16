import { useState } from 'react';
import './App.css';
import ImagePanelWithCapture from './ImagePanel.jsx';
import Modal from './Modal';

const imageOptions = [
    'image1.png', 'image2.png', 'image3.png', 'image4.png', 'image5.png', 'image6.png',
    'image7.png', 'image8.png', 'image9.png', 'image11.png', 'image12.png', 'image13.png',
    'image14.png', 'image15.png', 'image16.png', 'image17.png', 'image18.png', 'image20.png',
    'image21.png', 'image22.png', 'image23.png', 'image24.png', 'image25.png', 'image26.png',
    'image27.png', 'image28.png', 'image29.png',
];

const App = () => {
    function getRandomUniqueImages() {
        const shuffled = [...imageOptions].sort(() => 0.5 - Math.random());
        return {
            imagen1: `/${shuffled[0]}`,
            imagen2: `/${shuffled[1]}`,
            imagen3: `/${shuffled[2]}`,
            imagen4: `/${shuffled[3]}`,
        };
    }

    const [panelImages, setPanelImages] = useState(getRandomUniqueImages());
    const [modalData, setModalData] = useState(null);

    const handleChangeImages = () => {
        setPanelImages(getRandomUniqueImages());
        setModalData(null); // cerrar modal al cambiar imágenes
    };

    const handleShowResult = (result) => {
        setModalData(result);
    };

    const handleCloseModal = () => {
        setModalData(null);
    };

    return (
        <div className="main">
            <h1>Simulador de Espacios</h1>
            <div className="container">
                {['imagen1', 'imagen2', 'imagen3', 'imagen4'].map((id) => (
                    <div className="panel" key={id}>
                        <ImagePanelWithCapture
                            src={panelImages[id]}
                            id={id}
                            onShowResult={handleShowResult}
                        />
                    </div>
                ))}
                <button className="full-width-button" onClick={handleChangeImages}>
                    Cambiar imágenes
                </button>
            </div>

            {modalData && (
                <Modal onClose={handleCloseModal}>
                    <div className="result-card">
                        <h4>Resultado para {modalData.id}</h4>
                        <ul>
                            <li><strong>Plazas ocupadas:</strong> {modalData.data["Plazas ocupadas"]}</li>
                            <li><strong>Plazas especiales:</strong> {modalData.data["Plazas especiales"]}</li>
                            <li><strong>Plazas libres:</strong> {modalData.data["Plazas libres"]}</li>
                            <li><strong>Plazas totales:</strong> {modalData.data["Plazas totales"]}</li>
                        </ul>
                    </div>
                </Modal>
            )}
        </div>
    );
};

export default App;
