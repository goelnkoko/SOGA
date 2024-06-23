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
                // alert(data.message);
                button.innerHTML = 'Cancelar';
                button.disabled = true; // Desabilita o botão após a solicitação ser enviada
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
