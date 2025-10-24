import React, { useRef } from 'react'
import Container from '../ui/Container'
import Avatar from '../ui/Avatar'
import Button from '../ui/Button'

function ModifPictureProfile() {
    const fileInputRef = useRef(null);

    const handleButtonClick = () => {
        if (fileInputRef.current) {
            fileInputRef.current.click();
        }
    };

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            // TODO: gérer ici l'upload du fichier
            alert(`Image sélectionnée : ${file.name}`);
        }
    };

    return (
        <Container className={'mb-5'}>
            <Avatar size={18} color={"yellow"} />
            <div className='flex flex-col ml-5 w-full'>
                <h4 className='text-primary font-semibold'> Modifier la photo de profil</h4>
                <p className='text-secondary-text mb-3'>Format acceptés : *.png, *.jpg</p>
                <input
                    type="file"
                    accept="image/png, image/jpeg"
                    ref={fileInputRef}
                    style={{ display: "none" }}
                    onChange={handleFileChange}
                />
                <Button type="button" onClick={handleButtonClick}>Modifier {'>'}</Button>
            </div>
        </Container>
    )
}

export default ModifPictureProfile
