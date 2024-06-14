document.addEventListener('DOMContentLoaded', function() {

    const logo = document.querySelector('#logo');
    const menu_home = document.querySelector('#menu');
    const menu_profile = document.querySelector('.user-profile');

    // const widthLeft = leftBar.offsetWidth;
    logo.addEventListener('click', () => {
        window.location.href = "../home/home.html";
    });

    menu_home.addEventListener('click', () => {
        window.location.href = "../home/home.html";
    });

    menu_profile.addEventListener('click', () => {
        window.location.href = "../perfil/perfil.html";
    });

});