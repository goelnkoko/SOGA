function adjustTextarea(el) {
    el.style.height = 'auto';
    el.style.height = (el.scrollHeight - '40') + 'px';
}

window.addEventListener('scroll', function() {
    const leftBar = document.querySelector('.leftBar');
    const rightBar = document.querySelector('.rightBar');
    const feed = document.querySelector('.feed');

    // Remove fixed heights and allow full content height
    leftBar.style.height = 'auto';
    rightBar.style.height = 'auto';
    feed.style.height = 'auto';
});

document.addEventListener('DOMContentLoaded', function() {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                const body = document.querySelector('body');
                const leftBar = document.querySelector('.leftBar');
                const rightBar = document.querySelector('.rightBar');
                const feed = document.querySelector('.feed');
                const logo = document.querySelector('#logo');
                const menu_home = document.querySelector('#menu');
                const menu_profile = document.querySelector('.user-profile');
                const dropZone = document.getElementById('drop-zone');
                const fileInput = document.getElementById('file-input');
                const uploadButton = document.getElementById('upload-button');
                const thumbnails = document.getElementById('thumbnails');
                const sendButton = document.getElementById('send-button');
                const postContent = document.getElementById('post');
                const postsContainer = document.getElementById('posts-container');

                leftBar.style.height = '100vh';
                rightBar.style.height = '100vh';

                const widthLeft = leftBar.offsetWidth;
                const widthRight = rightBar.offsetWidth;

                body.style.paddingLeft = `${widthLeft}px`;
                body.style.paddingRight = `${widthRight}px`;
            
                const menu_home_size = menu_home.offsetWidth;
                logo.style.width = menu_home_size +30+ 'px';
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

                uploadButton.addEventListener('click', () => {
                    fileInput.click();
                });

                fileInput.addEventListener('change', (event) => {
                    const files = event.target.files;
                    handleFileUploads(files);
                });

                sendButton.addEventListener('click', () => {
                    const postText = postContent.value;
                    const images = Array.from(thumbnails.querySelectorAll('img')).map(img => img.src);
                    createPost(postText, images);
                });

                function handleFileUploads(files) {
                    for (let file of files) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const thumbnail = createThumbnail(event.target.result);
                            thumbnails.appendChild(thumbnail);
                        }
                        reader.readAsDataURL(file);
                    }
                }

                function createThumbnail(src) {
                    const thumbnail = document.createElement('div');
                    thumbnail.classList.add('thumbnail');

                    const img = document.createElement('img');
                    img.src = src;

                    const removeButton = document.createElement('button');
                    removeButton.classList.add('remove');
                    removeButton.textContent = '×';
                    removeButton.addEventListener('click', () => {
                        thumbnail.remove();
                    });

                    thumbnail.appendChild(img);
                    thumbnail.appendChild(removeButton);

                    return thumbnail;
                }

                function createPost(text, images) {
                    const postTemplate = `
                        <div class="post">
                            <div class="post-user-profile">
                                <a href="../perfil/perfil.html">
                                    <img src="../img/gyomei-chorando.jpeg" alt="Foto do Gyomei">
                                    <div id="profile-content">
                                        <span>Pedro</span>
                                        <p>Administrador</p>
                                    </div>
                                </a>
                            </div>
                            <div class="post-content">
                                <p>${text}</p>
                                ${images.map(image => `<img src="${image}" alt="Post Image">`).join('')}
                            </div>
                            <div class="icons">
                                <button><span class="material-symbols-outlined material-style">thumb_up</span></button>
                                <button><span class="material-symbols-outlined material-style">comment</span></button>
                                <button><span class="material-symbols-outlined material-style">share</span></button>
                            </div>
                        </div>
                    `;

                    postsContainer.insertAdjacentHTML('beforeend', postTemplate);

                    postContent.value = '';
                    thumbnails.innerHTML = '';
                }
            }
            
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });
});