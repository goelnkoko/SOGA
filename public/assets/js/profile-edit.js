document.addEventListener("DOMContentLoaded", function() {
    const userId = getProfileId();
    fetchProfileData(userId);

    //Funções para lidarem com o upload da foto de perfil
    document.getElementById('upload-photo-btn').addEventListener('click', () => {
        document.getElementById('profile-photo-input').click();
    });

    document.getElementById("simple-edit-btn").addEventListener("click", function(event) {
        event.preventDefault();
        updateProfile(userId);
    });

    document.getElementById("remove-photo-btn").addEventListener("click", function(event) {
        event.preventDefault();
        removeProfilePhoto(userId);
    });

    fetchProfileData(userId);
});

const photoInput = document.getElementById('profile-photo-input');
const modal = document.getElementById('photoModal');
const span = document.getElementsByClassName('close')[0];
const imageToCrop = document.getElementById('image-to-crop');
let cropper;

function fetchProfileData(userId) {
    fetch(`/profiles/${userId}`)
        .then(response => response.json())
        .then(data => {

            const profilePhoto = document.getElementById('edit-profile-pic');
            const mediaUrl = `/storage/${data.photo}`;
            profilePhoto.innerHTML = `<img src="${mediaUrl}" alt="User Image">`;

            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-location').value = data.location;
            document.getElementById('edit-biography').value = data.biography;

            const genderSelect = document.getElementById('edit-gender');
            genderSelect.innerHTML = `
                <option value="Masculino" ${data.gender === 'male' ? 'selected' : ''}>Masculino</option>
                <option value="Feminino" ${data.gender === 'female' ? 'selected' : ''}>Feminino</option>
                <option value="Outro" ${data.gender === 'other' ? 'selected' : ''}>Outro</option>
            `;

            // Lists part hobby
            const hobbies = document.getElementById('edit-hobbies');
            let hobbyArray = JSON.parse(data.hobbies);

            hobbyArray.forEach(hobby => {
                const li = document.createElement('li');
                li.textContent = hobby;
                appendRemoveButton(li, hobby, removeHobby, userId);
                hobbies.appendChild(li);
            });

            // Lists part interests
            const interests = document.getElementById('edit-interests');
            let interestArray = JSON.parse(data.interests);

            interestArray.forEach(interest => {
                const li = document.createElement('li');
                li.textContent = interest;
                appendRemoveButton(li, interest, removeInterest, userId);
                interests.appendChild(li);
            });

            // Adicionar educação
            const educations = document.getElementById('edit-education');
            educations.innerHTML = '';

            data.educations.forEach(education => {
                const educationItem = document.createElement('div');
                educationItem.className = 'item education-item';

                educationItem.innerHTML = `
                    <span>${education.institution}</span>
                    <div class="edit-curso">
                        <p>${education.course}</p>
                        <p>-</p>
                        <p>Licenciatura</p>
                    </div>
                    <div class="education-dates">
                        <p class="dates start-date">${education.startDate}</p>
                        <p>-</p>
                        <p class="dates end-date">${education.endDate}</p>
                    </div>
                    <p>${education.description}</p>
                `;

                // Adicionar botão de apagar
                appendRemoveButtonForEducation(userId, education.id, educationItem);

                educations.appendChild(educationItem);
            });
        })
        .catch(error => console.error('Error fetching profile:', error));
}

function appendRemoveButtonForEducation(userId, educationId, educationItem) {
    const removeButton = document.createElement('button');
    removeButton.className = 'remove-button';
    removeButton.innerText = 'Apagar';

    removeButton.addEventListener('click', () => {
        educationItem.remove();
        removeEducation(userId, educationId);
    });

    educationItem.appendChild(removeButton);
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

photoInput.addEventListener('change', (event) => {

    console.log("Aqui proximo")

    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = (e) => {
        imageToCrop.src = e.target.result;
        modal.style.display = 'block';
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 1,
            viewMode: 1,
        });
    };
    reader.readAsDataURL(file);
});

span.onclick = function() {
    modal.style.display = 'none';
    cropper.destroy();
};

window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = 'none';
        cropper.destroy();
    }
};

document.getElementById('save-photo-btn').addEventListener('click', function(event) {
    event.preventDefault();
    console.log('save photo called');

    const userId = getProfileId();
    saveProfilePhoto(userId);
});

const saveProfilePhoto = (userId) => {

    const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300,
    });

    canvas.toBlob((blob) => {
        const formData = new FormData();
        formData.append('imagem', blob);

        fetch(`/profiles/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                modal.style.display = 'none';
                cropper.destroy();
                fetchProfileData(userId);
            })
            .catch(error => console.error('Error uploading photo', error));
    });
}



// Função para adicionar hobby e interesses
document.getElementById('add-hobby-btn').addEventListener('click', function() {
    const newHobby = document.getElementById('new-hobby').value;

    const userId = getProfileId();
    addHobby(userId, newHobby);
});

document.getElementById('add-interest-btn').addEventListener('click', function() {
    const newInterest = document.getElementById('new-interest').value;

    const userId = getProfileId();
    addInterest(userId, newInterest);
});

function addHobby(userId, hobby) {

    if (hobby) {
        fetch(`/profiles/${userId}/add-hobby`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ hobby: hobby })
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message)
                if (data.message === 'Hobby added successfully') {
                    const hobbiesList = document.getElementById('hobbies');
                    const li = document.createElement('li');
                    li.textContent = hobby;
                    appendRemoveButton(li, hobby, removeHobby, userId);
                    hobbiesList.appendChild(li);
                } else {
                    console.error('Erro ao adicionar hobby:', data.error);
                }
            })
            .catch(error => console.error('Error adding hobby:', error));
    }
}

function removeHobby(userId, hobby) {
    fetch(`/profiles/${userId}/remove-hobby`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ hobby: hobby })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.message === 'Hobby removed successfully') {
                const hobbies = document.getElementById('hobbies');
                hobbies.innerHTML = '';

                let hobbyArray = JSON.parse(data.profile.hobbies);
                hobbyArray.forEach(hobby => {
                    const li = document.createElement('li');
                    li.textContent = hobby;
                    appendRemoveButton(li, hobby, removeHobby, userId);
                    hobbies.appendChild(li);
                });
            }
        })
        .catch(error => console.error('Error removing hobby:', error));
}

function addInterest(userId, interest) {
    if (interest) {
        fetch(`/profiles/${userId}/add-interest`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ interest: interest })
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message)
                if (data.message === 'Interest added successfully') {
                    const interests = document.getElementById('interests');
                    const li = document.createElement('li');
                    li.textContent = interest;
                    appendRemoveButton(li, interest, removeInterest, userId);
                    interests.appendChild(li);
                } else {
                    console.error('Erro ao adicionar interesse:', data.error);
                }
            })
            .catch(error => console.error('Error adding interest:', error));
    }
}

function removeInterest(userId, interest) {
    fetch(`/profiles/${userId}/remove-interest`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ interest: interest })
    })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Interest removed successfully') {
                const interests = document.getElementById('interests');
                interests.innerHTML = '';

                let interestsArray = JSON.parse(data.profile.interests);
                interestsArray.forEach(interest => {
                    const li = document.createElement('li');
                    li.textContent = interest;
                    appendRemoveButton(li, interest, removeInterest, userId);
                    interests.appendChild(li);
                });
            }
        })
        .catch(error => console.error('Error removing interest:', error));
}

function appendRemoveButton(li, item, removeFunction, userId) {
    const removeBtn = document.createElement('span');
    removeBtn.innerHTML = ' &times;';
    removeBtn.style.color = 'red';
    removeBtn.style.cursor = 'pointer';
    removeBtn.addEventListener('click', (event) => {
        event.stopPropagation(); // Impede a propagação do evento de clique
        removeFunction(userId, item);
    });
    li.appendChild(removeBtn);
}


//Educação
document.getElementById('add-education-btn').addEventListener('click', function(event) {
    event.preventDefault();

    console.log("Chamou o botão education");

    const userId = getProfileId();
    addEducation(userId);
});

const addEducation = (userId) => {

    console.log("Entrou na educação");

    const education = {
        description: document.getElementById('new-education-description').value,
        institution: document.getElementById('new-education-institution').value,
        course: document.getElementById('new-education-course').value,
        startDate: document.getElementById('new-education-startDate').value,
        endDate: document.getElementById('new-education-endDate').value,
    };

    console.log("Educação: " + education);

    fetch(`/profiles/${userId}/add-education`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(education)
    })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);

            if (data.message === 'Education added successfully') {
                fetchProfileData(userId);
            } else {
                console.error('Erro ao adicionar educação:', data.error);
            }
        })
        .catch(error => console.error('Error adding education:', error));
}

const removeEducation = (userId, educationId) => {
    fetch(`/profiles/${userId}/remove-education/${educationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Education removed successfully') {
                const educations = document.getElementById('educations');
                const itemToRemove = educations.querySelector(`li[data-id='${educationId}']`);
                if (itemToRemove) {
                    itemToRemove.remove();
                }
            }
        })
        .catch(error => console.error('Error removing education:', error));
}

