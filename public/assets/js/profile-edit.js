document.addEventListener("DOMContentLoaded", function() {
    const userId = getProfileId();
    fetchProfileData(userId);

    document.getElementById("simple-edit-btn").addEventListener("click", function(event) {
        event.preventDefault();
        updateProfile(userId);
    });

    document.getElementById("upload-photo-btn").addEventListener("click", function(event) {
        event.preventDefault();
        uploadProfilePhoto(userId);
    });

    document.getElementById("remove-photo-btn").addEventListener("click", function(event) {
        event.preventDefault();
        removeProfilePhoto(userId);
    });
});

function fetchProfileData(userId) {
    fetch(`/profiles/${userId}`)
        .then(response => response.json())
        .then(data => {
            console.log("Vindo do profile: " + data);

            const profilePhoto = document.querySelectorAll('.profile-pic');
            profilePhoto.innerHTML = `<img src="${data.photo}" alt="">`;

            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-location').value = data.location;
            document.getElementById('edit-biography').value = data.biography;

            const genderSelect = document.getElementById('edit-gender');
            genderSelect.innerHTML = `
                <option value="Masculino" ${data.gender === 'male' ? 'selected' : ''}>Masculino</option>
                <option value="Feminino" ${data.gender === 'female' ? 'selected' : ''}>Feminino</option>
                <option value="Outro" ${data.gender === 'other' ? 'selected' : ''}>Outro</option>
            `;

            if (data.photo) {
                document.getElementById('profile-photo').src = `/storage/${data.photo}`;
            }
        })
        .catch(error => console.error('Error fetching profile:', error));
}

const updateProfile = (userId) => {
    const profileData = {
        name: document.getElementById('edit-name').value,
        gender: document.getElementById('edit-gender').value,
        location: document.getElementById('edit-location').value,
        biography: document.getElementById('edit-biography').value
    };

    fetch(`/profiles/${userId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(profileData),
    })
        .then(response => response.json())
        .then(data => {
            alert('Profile updated successfully');
        })
        .catch(error => console.error('Error updating profile:', error));
}

const uploadProfilePhoto = (userId) => {
    const photoInput = document.getElementById('profile-photo-input');

    if (photoInput.files.length === 0) {
        alert('Please select a file to upload.');
        return;
    }

    const formData = new FormData();
    formData.append('photo', photoInput.files[0]);

    fetch(`/profiles/${userId}/photo`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => console.error('Error uploading photo:', error));
}

const removeProfilePhoto = (userId) => {
    fetch(`/profiles/${userId}/photo`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            alert('Photo removed successfully');
            document.getElementById('profile-photo').src = '';
        })
        .catch(error => console.error('Error removing photo:', error));
}
