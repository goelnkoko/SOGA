function adjustTextarea(el) {
    el.style.height = 'auto';
    el.style.height = (el.scrollHeight - '40') + 'px';
}

document.addEventListener('DOMContentLoaded', function() {

    const fileInput = document.getElementById('file-input');
    const uploadButton = document.getElementById('upload-button');
    const thumbnails = document.getElementById('thumbnails');
    const sendButton = document.getElementById('send-button');
    const postContent = document.getElementById('post');
    const postsContainer = document.getElementById('posts-container');

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
});