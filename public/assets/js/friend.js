// Function to send a friend request
async function sendFriendRequest(recipientId, button) {

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

            alert(data.message);

            if (data.error) {
                alert(data.error);
            } else {
                button.innerHTML = 'Cancelar';
                button.disabled = true; // Desabilita o botão após a solicitação ser enviada
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function createPost(text, files) {
    const formData = new FormData();
    formData.append('content', text);
    for (let file of files) {
        formData.append('media[]', file);
    }

    fetch('/posts', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                loadPosts();
                console.log(data)
                postContent.value = '';
                thumbnails.innerHTML = '';
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
        const data = await handleResponse(response);
        console.log('Friend request accepted:', data);
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
        const data = await handleResponse(response);
        console.log('Friend request rejected:', data);
    } catch (error) {
        console.error('Error rejecting friend request:', error);
    }
};

// Function to remove a friendship
const removeFriendship = async (friendshipId) => {
    try {
        const response = await fetch(`/friendships/${friendshipId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const data = await handleResponse(response);
        console.log('Friendship removed:', data);
    } catch (error) {
        console.error('Error removing friendship:', error);
    }
};

// Example usage
// Replace these IDs with actual user IDs from your application
const userId = 1;
const recipientId = 2;
const requestId = 3;
const friendshipId = 4;
const message = 'Hi, let’s connect!';

// Send a friend request
sendFriendRequest(userId, recipientId, message);

// Accept a friend request
acceptFriendRequest(requestId);

// Reject a friend request
rejectFriendRequest(requestId);

// Remove a friendship
removeFriendship(friendshipId);
