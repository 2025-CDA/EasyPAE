/**
 * Construit l'URL complète de l'avatar
 * Gère les cas où la BDD contient:
 * - Juste le nom du fichier (ex: "6908b85c090591.23988081.png")
 * - Le chemin complet (ex: "/uploads/avatars/6908b85c090591.23988081.png")
 * 
 * @param {string|null} avatarPath - Le chemin de l'avatar depuis la BDD
 * @returns {string|null} - L'URL complète de l'avatar ou null
 */
export const getAvatarUrl = (avatarPath) => {
    if (!avatarPath) {
        return null;
    }

    const baseUrl = import.meta.env.VITE_DB_URL || 'http://localhost:8000';
    
    // Si le chemin commence déjà par /uploads/, c'est un chemin complet
    if (avatarPath.startsWith('/uploads/')) {
        return `${baseUrl}${avatarPath}`;
    }
    
    // Si c'est juste un nom de fichier, construire le chemin complet
    return `${baseUrl}/uploads/avatars/${avatarPath}`;
};
