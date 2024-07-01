document.addEventListener('DOMContentLoaded', () => { 
    alert("uioijh")
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


    const profileInfo = document.getElementById('profile-info');

    const template = 
    `
            <h2>User</h2>
            <p>User@gmail.com</p>
            <p><i class="fas fa-briefcase"></i>Trabalho</p> 
            <p><i class="fas fa-map-marker-alt"></i> Cidade/País</p>
            <p><i class="fas fa-gift"></i> Nascido(a) </p>
            <p><i class="fas fa-school"></i> Instituições Academicas</p>
           
            <button class="edit-button">Editar perfil</button>
    `;

    profileInfo.innerHTML = template;

});
