document.addEventListener('DOMContentLoaded', function() {

    const logo = document.querySelector('#logo');
    const menu_home = document.querySelector('#left-menu');
    const menu_profile = document.querySelector('.user-profile');
    const logout = document.querySelector('#logout');
    let userId = 0;

    fetch('/logged-user')
        .then(response => response.json())
        .then(data => {

            const profileLeft = document.getElementById('profile-left');

            profileLeft.innerHTML = `
                <img src="/storage/${data.profile.photo}" alt="Foto do Gyomei">
                <div id="profile-content">
                    <span>${data.profile.name}</span>
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

            logout.addEventListener('click', function (event) {
                event.preventDefault();

                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = '/';
                        } else {
                            // Handle error
                            console.error('Logout failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });


        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
});
