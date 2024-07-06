async function handleFetchResponse(response) {
    if (!response.ok) {
        const errorData = await response.json();
        const errorMessage = errorData.message || errorData.error || `HTTP error! status: ${response.status}`;
        throw new Error(errorMessage);
    }
    return response.json();
}

// Function to send a friend request
const sendFriendRequest = async (recipientId, button) => {

    fetch('/friend-requests', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ recipient_id: recipientId })
    })
        .then(response => response.json())
        .then(data => {

            if (data.error) {
                alert(data.error);
            }
            else {
                rightFetchNonFriends();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Function to accept a friend request
const acceptFriendRequest = async (requestId) => {
    try {
        const response = await fetch(`/friend-requests/${requestId}/accept`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });

        rightFetchFriendsRequest();

        const data = await handleFetchResponse(response);
    } catch (error) {
        console.error('Error accepting friend request:', error);
    }
};

// Function to reject a friend request
const rejectFriendRequest = async (requestId) => {
    try {
        const response = await fetch(`/friend-requests/${requestId}/reject`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });

        rightFetchFriendsRequest();

        const data = await handleFetchResponse(response);
    } catch (error) {
        console.error('Error rejecting friend request:', error);
    }
};

// Função para buscar e exibir usuários
const rightFetchNonFriends = async () => {

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
const rightFetchFriendsRequest = async () => {

    fetch('/friend-requests')
        .then(response => response.json())
        .then(data => {

            const friendRequest = document.getElementById('friend-request');
            friendRequest.innerHTML = '';

            if (data.length > 0) {
                friendRequest.style.display = 'block';
            }

            const h3 = document.createElement('h4');
            h3.innerHTML = 'Solicitações de amizade';
            friendRequest.appendChild(h3);

            for(let i=0; i < 3 && i <= data.length; i++){

                const request = data[i];

                const userProfile = document.createElement('div');
                userProfile.classList.add('user-profile');

                userProfile.innerHTML = `
                    <div class="user-profile-profile">
                        <img src="/storage/${request.user.profile.photo}" alt="Foto da Mitsuri">
                        <div id="profile-content">
                            <span>${request.user.profile.name}</span>
                            <p>@${request.username}</p>
                        </div>
                    </div>
                    <button id="confirmar" onclick="acceptFriendRequest(${request.id})">Aceitar</button>
                    <button id="rejeitar" onclick="rejectFriendRequest(${request.id})">Rejeitar</button>
                `;

                friendRequest.appendChild(userProfile);
            }
        })
}

document.addEventListener('DOMContentLoaded', () => {
    rightFetchNonFriends();
    rightFetchFriendsRequest();
});
