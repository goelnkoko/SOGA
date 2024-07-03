document.addEventListener('DOMContentLoaded', function() {

    const logo = document.querySelector('#logo');
    const menu_home = document.querySelector('#left-menu');
    const menu_profile = document.querySelector('.user-profile');
    let userId = 0;

    fetch('/logged-user')
        .then(response => response.json())
        .then(data => {

            const profileLeft = document.getElementById('profile-left');

            profileLeft.innerHTML = `
                <img src="assets/img/gyomei-chorando.jpeg" alt="Foto do Gyomei">
                <div id="profile-content">
                    <span>${data.name}</span>
                    <p>@${data.username}</p>
                </div>
            `;

            userId = data.id;

            logo.addEventListener('click', () => {
                window.location.href = "/home";
            });

            menu_home.addEventListener('click', () => {
                window.location.href = "/home";
            });

            menu_profile.addEventListener('click', (userId) => {
                window.location.href = `/profile?userId=${userId}`;
            });

            profileLeft.addEventListener('click', () => {
                window.location.href = `/profile?userId=${userId}`;
            });
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
});
