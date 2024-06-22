document.addEventListener('DOMContentLoaded', function(){

// Função para buscar e exibir usuários
    fetch('/users')
        .then(response => response.json())
        .then(data => {
            const profileSuggestions = document.getElementById('profile-suggestions');

            for (let i = 0; i < 3 && i < data.length; i++) {
                const user = data[i];

                const userProfile = document.createElement('div');
                userProfile.classList.add('user-profile right');

                userProfile.innerHTML = `
                <div class="user-profile-profile">
                    <img src="assets/img/rengoku.png" alt="Foto da Mitsuri">
                    <div id="profile-content">
                        <span>${user.name}</span>
                        <p>@${user.username}</p>
                    </div>
                </div>
                <button class="send-request" onclick="sendFriendRequest('${user.id}')">Conectar</button>
            `;
            }
        })
        .catch(error => {
            console.error('Error fetching users:', error);
        });


    fetch('/friend-requests')
        .then(response => response.json())
        .then(data => {

            console.log("R Dados dos usuarios: " + data);

            const friendRequest = document.getElementById('friend-request');

            for(let i=0; i < 3 && i <= data.length; i++){

                const user = data[i];

                console.log("R Dados do usuario -> " + user);

                const userProfile = document.createElement('div');
                userProfile.classList.add('user-profile');

                userProfile.innerHTML = `
                <div class="user-profile-profile">
                    <img src="assets/img/rengoku.png" alt="Foto da Mitsuri">
                    <div id="profile-content">
                        <span>${user.user.name}</span>
                        <p>@${user.user.username}</p>
                    </div>
                </div>
                <button id="confirmar" onclick="(${user.id})">Confirmar</button>
                <button id="rejeitar" onclick="(${user.id})">Rejeitar</button>
            `;

                friendRequest.appendChild(userProfile);
            }
        })


})
