document.addEventListener('DOMContentLoaded', () => {
    const followButton = document.getElementById('followButton');
    const messageButton = document.getElementById('messageButton');
    const publicationsButton = document.getElementById('publicationsButton');
    const photosButton = document.getElementById('photosButton');
    const videosButton = document.getElementById('videosButton');
    
    followButton.addEventListener('click', () => {
        if (followButton.textContent === 'Seguir') {
            followButton.textContent = 'Seguindo';
            // Increment follower count (example logic, adjust as needed)
            const followersCount = document.getElementById('followers');
            followersCount.textContent = parseInt(followersCount.textContent) + 1 + ' Seguidor(es)';
        } else {
            followButton.textContent = 'Seguir';
            // Decrement follower count (example logic, adjust as needed)
            const followersCount = document.getElementById('followers');
            followersCount.textContent = parseInt(followersCount.textContent) - 1 + ' Seguidor(es)';
        }
    });

    messageButton.addEventListener('click', () => {
        alert('Mensagem functionality is not yet implemented.');
    });

    publicationsButton.addEventListener('click', () => {
        alert('Publicações functionality is not yet implemented.');
    });

    photosButton.addEventListener('click', () => {
        alert('Fotos functionality is not yet implemented.');
    });

    videosButton.addEventListener('click', () => {
        alert('Vídeos functionality is not yet implemented.');
    });
});
