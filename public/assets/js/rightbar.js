document.addEventListener('DOMContentLoaded', function(){

    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    const numUsers = getQueryParam('numUsers') || 3;

    fetch('/users')
    .then(response => response.json())
    .then(data => {


        const profileSuggestions = document.getElementById('profile-suggestions');

        for(let i=0; i < 3 && i <= data.length; i++){

            const user = data[i];

            const userProfile = document.createElement('div');
            userProfile.classList.add('user-profile');

            userProfile.innerHTML = `
                <div class="user-profile-profile">
                    <img src="assets/img/rengoku.png" alt="Foto da Mitsuri">
                    <div id="profile-content">
                        <span>${user.name}</span>
                        <p>@${user.username}</p>
                    </div>
                </div>
                <button>Seguir</button>
            `;

            profileSuggestions.appendChild(userProfile);
        }
    })


})
