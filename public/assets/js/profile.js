//Função para capturar o id da url
function getProfileId() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('userId');
}

document.getElementById('edit-profile').onclick = () => {
    const editProfile = document.querySelector('.edit-profile');
    editProfile.style.display = 'block';
}

document.getElementById('back-profile').onclick = () => {
    const editProfile = document.querySelector('.edit-profile');
    editProfile.style.display = 'none';
}

const fetchProfile = async (userId) => {

    fetch(`/profiles/${userId}`)
        .then(response => response.json())
        .then(profile => {

            const profilePhoto = document.querySelector('.profile-pic');
            profilePhoto.innerHTML = `<img src="/storage/${profile.photo}" alt="">`;

            const profileInfo = document.querySelector('.profile-info');

            profileInfo.innerHTML = `
                <div id="left-info">
                    <div id="name">
                        <span>${profile.name}</span>
                        <p>@${profile.user.username}</p>
                    </div>

                    <p id="biography">${profile.biography}</p>

                    <div class="left-bottom">
                       <div class="left-bottom-items" id="location">
                           <i class="fas fa-map-marker-alt"></i>
                           <p>${profile.location}</p>
                       </div>
                       <p>·</p>
                      <div class="left-bottom-items" id="ver-mais">
                           <i class="fa-solid fa-circle-info"></i>
                           <p id="view-more">Ver mais</p>
                       </div>
                    </div>
                </div>

                <div id="right-info">
                    <div class="info-items">
                        <i class="fas fa-briefcase"></i>
                        <p>${profile.works[0].job}</p>
                    </div>
                    <div class="info-items">
                        <i class="fas fa-school"></i>
                        <p>${profile.educations[0].institution}</p>
                    </div>
                </div>

            `;
            profileRight(profile, userId);
        });
}

const profileRight = async (profile, userId) => {

    const profileInfo = document.querySelector('.profile-right');

    console.log(profile)
    // Lists part hobby
    const hobbies = document.getElementById('hobbies');
    let hobbyArray = JSON.parse(profile.hobbies);

    hobbyArray.forEach(hobby => {
        const li = document.createElement('li');
        li.textContent = hobby;
        hobbies.appendChild(li);
    });

    // Lists part interests
    const interests = document.getElementById('interests');
    let interestArray = JSON.parse(profile.interests);

    interestArray.forEach(interest => {
        const li = document.createElement('li');
        li.textContent = interest;
        interests.appendChild(li);
    });

    // Adicionar educação
    const educations = document.getElementById('educations');
    educations.innerHTML = '';

    profile.educations.forEach(education => {
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
                        <p class="dates start-date">${education.startDate ? education.startDate : ''}</p>
                        <p>${education.endDate ? '-' : ''}</p>
                        <p class="dates end-date">${education.endDate ? education.endDate : ''}</p>
                    </div>
                    <p>${education.description ? education.description : ''}</p>
                `;

        educations.appendChild(educationItem);
    });

    // Adicionar trabalho
    const works = document.getElementById('works');
    works.innerHTML = '';

    profile.works.forEach(work => {
        const workItem = document.createElement('div');
        workItem.className = 'item work-item';

        workItem.innerHTML = `
                    <span>${work.organization}</span>
                    <div class="edit-curso">
                        <p>${work.job}</p>
                    </div>
                    <div class="work-dates">
                        <p class="dates start-date">${work.startDate ? work.startDate : ''}</p>
                        <p>${work.endDate ? '-' : ''}</p>
                        <p class="dates end-date">${work.endDate ? work.endDate : ''}</p>
                    </div>
                    <p>${work.description ? work.description : ''}</p>
                `;

        works.appendChild(workItem);
    });

    // Adicionar contactos
    const contacts = document.getElementById('contacts');
    contacts.innerHTML = '';

    profile.contacts.forEach(contact => {
        const contactItem = document.createElement('div');
        contactItem.className = 'item contact-item';

        contactItem.innerHTML = `
                <span>${contact.type}</span>
                <p>${contact.contact}</p>
            `;

        contacts.appendChild(contactItem);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const userId = getProfileId();

    if(userId){
        fetchProfile(userId);
        document.querySelector('.edit-profile').style.display = 'none';
    } else {
        console.error('ID não encontrado na URL');
    }
});































































// alert("uioijh")
//
// const followButton = document.getElementById('followButton');
// const messageButton = document.getElementById('messageButton');
// const publicationsButton = document.getElementById('publicationsButton');
// const photosButton = document.getElementById('photosButton');
// const videosButton = document.getElementById('videosButton');
//
// followButton.addEventListener('click', () => {
//     if (followButton.textContent === 'Seguir') {
//         followButton.textContent = 'Seguindo';
//         // Increment follower count (example logic, adjust as needed)
//         const followersCount = document.getElementById('followers');
//         followersCount.textContent = parseInt(followersCount.textContent) + 1 + ' Seguidor(es)';
//     } else {
//         followButton.textContent = 'Seguir';
//         // Decrement follower count (example logic, adjust as needed)
//         const followersCount = document.getElementById('followers');
//         followersCount.textContent = parseInt(followersCount.textContent) - 1 + ' Seguidor(es)';
//     }
// });
//
// messageButton.addEventListener('click', () => {
//     alert('Mensagem functionality is not yet implemented.');
// });
//
// publicationsButton.addEventListener('click', () => {
//     alert('Publicações functionality is not yet implemented.');
// });
//
// photosButton.addEventListener('click', () => {
//     alert('Fotos functionality is not yet implemented.');
// });
//
// videosButton.addEventListener('click', () => {
//     alert('Vídeos functionality is not yet implemented.');
// });
//
// const profileInfo = document.getElementById('profile-info');
//
// const template =
//     `
//         <h2>Goel Nkoko</h2>
//         <p>User@gmail.com</p>
//         <p><i class="fas fa-briefcase"></i>Provavelmente será trabalho</p>
//         <p><i class="fas fa-map-marker-alt"></i> Mbanza Kongo</p>
//         <p><i class="fas fa-gift"></i>N'zeto, Zaite</p>
//         <p><i class="fas fa-school"></i>Instituto Superior de Administração e Finanças</p>
//
//         <button class="edit-button">Editar perfil</button>
// `;
//
// profileInfo.innerHTML = template;
