
// Função para buscar e exibir usuários
const fetchNonFriends = async () => {

    fetch('/non-friends')
        .then(response => response.json())
        .then(data => {

            const profileSuggestions = document.getElementById('profile-suggestions');
            profileSuggestions.innerHTML = '';

            if (data.length > 0) {
                profileSuggestions.style.display = 'block';
            }

            const h3 = document.createElement('h3');
            h3.innerHTML = 'Pessoas que talvez conheças';
            profileSuggestions.appendChild(h3);

            for (let i = 0; i < 3 && i < data.length; i++) {
                const user = data[i];
                console.log(user);
                const userProfile = document.createElement('div');
                userProfile.classList.add('user-profile');

                userProfile.innerHTML = `
                    <div class="user-profile-profile">
                        <img src="/storage/${user.profile.photo}" alt="Foto da Mitsuri">
                        <div id="profile-content">
                            <span>${user.profile.name}</span>
                            <p>@${user.username}</p>
                        </div>
                    </div>
                    <button onclick="sendFriendRequest(${user.id}, this)">Conectar</button>
                `;

                profileSuggestions.appendChild(userProfile);
            }
        })
        .catch(error => {
            console.error('Error fetching users:', error);
        });
}

//Função para buscar requisições de amizade
const fetchFriendsRequest = async () => {

    fetch('/friend-requests')
        .then(response => response.json())
        .then(data => {

            const friendRequest = document.getElementById('friend-request');
            friendRequest.innerHTML = '';

            if (data.length > 0) {
                console.log("Entrou mesmo");
                friendRequest.style.display = 'block';
            }

            const h3 = document.createElement('h3');
            h3.innerHTML = 'Solicitações de amizade';
            friendRequest.appendChild(h3);

            for(let i=0; i < 3 && i <= data.length; i++){

                const request = data[i];

                const userProfile = document.createElement('div');
                userProfile.classList.add('user-profile');

                userProfile.innerHTML = `
                    <div class="user-profile-profile">
                        <img src="assets/img/rengoku.png" alt="Foto da Mitsuri">
                        <div id="profile-content">
                            <span>${request.user.name}</span>
                            <p>@${request.user.username}</p>
                        </div>
                    </div>
                    <button id="confirmar" onclick="acceptFriendRequest(${request.id})">Confirmar</button>
                    <button id="rejeitar" onclick="rejectFriendRequest(${request.id})">Rejeitar</button>
                `;

                friendRequest.appendChild(userProfile);
            }
        })
}


document.addEventListener('DOMContentLoaded', () => {
    fetchNonFriends();
    fetchFriendsRequest();
});
