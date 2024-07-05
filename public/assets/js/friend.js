//Função para capturar a resposta
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
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ recipient_id: recipientId })
    })
        .then(response => response.json())
        .then(data => {

            if (data.error) {
                alert(data.error);
            }
            else {
                fetchNonFriends();
                console.log("Request sent successfully");
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
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        fetchFriendsRequest();

        const data = await handleFetchResponse(response);
        console.log('Accept friend request:', data);
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
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        fetchFriendsRequest();

        const data = await handleFetchResponse(response);
        console.log('Reject friend request:', data);
    } catch (error) {
        console.error('Error rejecting friend request:', error);
    }
};

const cancelFriendRequest = async (requestId) => {
    try {
        const response = await fetch(`/friend-requests/${requestId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        fetchSentRequests();

        const data = await handleFetchResponse(response);
        console.log('Canceled friend request:', data);
    } catch (error) {
        console.error('Error removing friendship:', error);
    }
};

// Function to remove a friendship
const removeFriend = async (friendshipId) => {
    try {
        fetch(`/friend/${friendshipId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    } catch (error) {
        console.error('Error removing friendship:', error);
    }
};

const fetchNonFriends = async () => {

    fetch('/non-friends')
        .then(response => response.json())
        .then(data => {

            const profileSuggestions = document.getElementById('profile-suggestions');
            profileSuggestions.innerHTML = '';

            console.log("Não amigos" + data)

            const h3 = document.createElement('h4');
            h3.innerHTML = 'Pessoas que talvez conheças';
            profileSuggestions.appendChild(h3);

            data.forEach(user => {

                console.log(user);

                const userProfile = document.createElement('div');
                userProfile.classList.add('user-request-profile');

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
            })

        })
        .catch(error => {
            console.error('Error fetching users:', error);
        });
}


//Função para buscar requisições de amizade
const fetchSentRequests = async () => {

    fetch('/sent-requests')
        .then(response => response.json())
        .then(data => {

            const sentRequests = document.getElementById('sent-requests');
            sentRequests.innerHTML = '';

            console.log("Pedidos feitos" + data)

            const h3 = document.createElement('h4');
            h3.innerHTML = 'Solicitações enviadas';
            sentRequests.appendChild(h3);

            data.forEach(request =>{

                console.log(request)

                const userProfile = document.createElement('div');
                userProfile.classList.add('user-request-profile');

                userProfile.innerHTML = `
                    <div class="user-profile-profile ">
                        <img src="/storage/${request.recipient.profile.photo}" alt="Foto da Mitsuri">
                        <div id="profile-content">
                            <span>${request.recipient.profile.name}</span>
                            <p>@${request.recipient.username}</p>
                        </div>
                    </div>
                    <button id="cancelar" onclick="cancelFriendRequest(${request.id})">Cancelar</button>
                `;

                sentRequests.appendChild(userProfile);
            });
        })
}

//Função para buscar requisições de amizade
const fetchFriendsRequest = async () => {

    fetch('/friend-requests')
        .then(response => response.json())
        .then(data => {

            const friendRequest = document.getElementById('friend-request');
            friendRequest.innerHTML = '';

            console.log("Pedidos de amizade" + data)

            const h3 = document.createElement('h4');
            h3.innerHTML = 'Solicitações de amizade';
            friendRequest.appendChild(h3);

            data.forEach(request => {

                console.log(request);

                const userProfile = document.createElement('div');
                userProfile.classList.add('user-request-profile');

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
            });
        })
}

document.addEventListener('DOMContentLoaded', () => {
    fetchNonFriends();
    fetchFriendsRequest();
    fetchSentRequests();
});
