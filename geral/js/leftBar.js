document.addEventListener('DOMContentLoaded', function() {

    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {

                const body = document.querySelector('body');
                const leftBar = document.querySelector('.leftBar');
                const rightBar = document.querySelector('.rightBar');
                const logo = document.querySelector('#logo');
                const menu_home = document.querySelector('#menu');
                const menu_profile = document.querySelector('.user-profile');

                const widthLeft = leftBar.offsetWidth;
                console.log("Left: " + widthLeft);
                body.style.paddingLeft = widthLeft + 'px';
                body.style.backgroundColor = `#111`;

                if (rightBar !== null) {
                    rightBar.style.height = '100vh';
                    const widthRight = rightBar.offsetWidth;
                    body.style.paddingRight = `${widthRight}px`;
                }

                const menu_home_size = menu_home.offsetWidth;
                console.log("Menu: " + menu_home_size);
                logo.style.width = menu_home_size + 30 + 'px';

                menu_profile.style.width = (menu_home_size * 1.1) + 'px';

                logo.addEventListener('click', () => {
                    window.location.href = "../home/home.html";
                });

                menu_home.addEventListener('click', () => {
                    window.location.href = "../home/home.html";
                });

                menu_profile.addEventListener('click', () => {
                    window.location.href = "../perfil/perfil.html";
                });
            }
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });
});