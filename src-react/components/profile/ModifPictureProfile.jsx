import React, { useRef } from 'react'
import Container from '../ui/Container'
import Avatar from '../ui/Avatar'
import Button from '../ui/Button'
import useAxios from "../../hooks/useAxios";
import { useAuthContext } from "../../store/auth_context/authContext";
import { getAvatarUrl } from "../../helpers/avatarHelper";
import { toast } from 'react-toastify';


function ModifPictureProfile() {
    const { userData, getUser } = useAuthContext();
    const userId = userData.id;
    const { fetchData } = useAxios();
    const fileInputRef = useRef(null);
    
    // Construire l'URL complète de l'avatar
    const avatarUrl = getAvatarUrl(userData?.avatar);

    const handleButtonClick = () => {
        if (fileInputRef.current) {
            console.log("🚀 ~ handleButtonClick ~ fileInputRef:", fileInputRef)

            fileInputRef.current.click();
        }
    };

    const handleFileChange = async (e) => {
        const file = e.target.files[0];
        
        if (!file) {
            return;
        }

        console.log("🚀 ~ handleFileChange ~ file:", file);

        // Créer un FormData pour envoyer le fichier
        const formData = new FormData();
        formData.append('avatar', file);

        try {
            const res = await fetchData('POST', `account/${userId}/avatar`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            
            console.log("🚀 ~ handleFileChange ~ res:", res);
            
            if (res.success) {
                toast.success(`Image uploadée avec succès : KAAAAAAAAARIMMMMMM`);
                // Recharger les données utilisateur pour mettre à jour l'avatar
                await getUser();
            } else {
                alert('Erreur lors de l\'upload de l\'image');
            }
        } catch (error) {
            console.error('Erreur upload:', error);
            alert('Erreur lors de l\'upload de l\'image');
        }
    };

    return (
        <Container className={'mb-5 flex'}>
            <Avatar size={'sm'} color={"yellow"} url={avatarUrl} />
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
                <Button className={'w-25'} type="button" onClick={handleButtonClick}>Modifier {'>'}</Button>
            </div>
        </Container>
    )
}

export default ModifPictureProfile
