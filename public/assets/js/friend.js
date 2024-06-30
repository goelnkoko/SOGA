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
                fetchNonFriends();
                console.log("Request sent successfully");
                button.innerHTML = "Não seguir";
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
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });

        fetchFriendsRequest();

        const data = await handleFetchResponse(response);
        console.log('Reject friend request:', data);
    } catch (error) {
        console.error('Error rejecting friend request:', error);
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
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });
    } catch (error) {
        console.error('Error removing friendship:', error);
    }
};
