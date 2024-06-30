const adjustTextarea = el => {
    el.style.height = 'auto';
    el.style.height = `${el.scrollHeight - 40}px`;
};

const fileInput = document.getElementById('file-input');
const uploadButton = document.getElementById('upload-button');
const thumbnails = document.getElementById('thumbnails');
const postForm = document.getElementById('post-form');
const postsContainer = document.getElementById('posts-container');
const postContent = document.getElementById('post');

uploadButton.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', event => handleFileUploads(event.target.files));

postForm.addEventListener('submit', event => {
    event.preventDefault();
    createPost(postContent.value, fileInput.files);
});

const handleFileUploads = files => {
    thumbnails.innerHTML = '';
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = event => {
            thumbnails.appendChild(createMediaThumbnail(event.target.result, file.type));
        };
        reader.readAsDataURL(file);
    });
};

const createMediaThumbnail = (src, type) => {
    const thumbnail = document.createElement('div');
    thumbnail.classList.add('thumbnail');

    const media = type.startsWith('image') ? document.createElement('img') : document.createElement('video');
    media.src = src;
    if (type.startsWith('video')) media.controls = true;

    const removeButton = document.createElement('button');
    removeButton.classList.add('remove');
    removeButton.textContent = '×';
    removeButton.addEventListener('click', () => thumbnail.remove());

    thumbnail.append(media, removeButton);
    return thumbnail;
};

const createPost = (text, files) => {

    if (!text.trim() && files.length === 0) {
        alert('Por favor, adicione texto ou imagens ao post.');
        return;
    }

    const formData = new FormData();
    if (text.trim()) formData.append('content', text);
    Array.from(files).forEach(file => formData.append('media[]', file));

    fetch('/posts', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                loadPosts();
                postContent.value = '';
                thumbnails.innerHTML = '';
            }
        })
        .catch(error => console.error('Error:', error));
};

const loadPosts = () => {
    fetch('/posts')
        .then(response => response.json())
        .then(posts => {
            postsContainer.innerHTML = '';
            posts.forEach(displayPost);
        })
        .catch(error => console.error('Error:', error));
};

const displayPost = post => {

    let count = 0;

    const mediaContent = post.media ? JSON.parse(post.media).map(mediaPath => {
        const mediaUrl = `/storage/${mediaPath}`;
        const type = mediaPath.split('.').pop().toLowerCase();
        if (['jpeg', 'jpg', 'png', 'gif'].includes(type)) {
            count++;
            return `<img src="${mediaUrl}" alt="Post Image">`;
        } else if (['mp4', 'avi', 'mkv'].includes(type)) {
            count++;
            return `<video controls src="${mediaUrl}"></video>`;
        }
    }).join('') : '';



    const postTemplate = `
            <div class="post">
                <div class="post-left">
                    <a href="/profile?profile_id=${post.user.id}"><img src="assets/img/ningning.jpg" alt="Foto do Gyomei"></a>
                </div>
                <div class="post-right">
                    <div class="post-header">
                        <a href="/profile?profile_id=${post.user.id}">
                            <div id="post-header-info">
                                <span>${post.user.name}</span>
                                <p>@${post.user.username}</p>
                                <p>·</p>
                                <p>${timeAgo(post.created_at)}</p>
                            </div>
                        </a>
                        <div class="more-options">
                            <span class="material-symbols-outlined material-style">more_vert</span>
                        </div>
                        <div class="menu">
                            <ul>
                                <li><a href="#">Seguir</a></li>
                                <li><a href="#">Editar</a></li>
                                <li><a href="#">Eliminar</a></li>
                                <li><a href="#">Ver perfil</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>${post.content === null ? '' : post.content}</p>
                        <div class="medias">
                            ${mediaContent}
                        </div>
                    </div>
                    <div class="icons">
                        <button onclick="updateLikeStatus()" id="like" class="unliked">
                            <span class="material-symbols-outlined material-style">sentiment_sad</span>
                        </button>
                        <button id="comment">
                            <span class="material-symbols-outlined material-style">comment</span>
                        </button>
                        <button id="share">
                            <span class="material-symbols-outlined material-style">share</span>
                        </button>
                    </div>
                </div>

            </div>
        `;

    postsContainer.insertAdjacentHTML('beforeend', postTemplate);
};

const timeAgo = timestamp => {
    const now = new Date();
    const publishDate = new Date(timestamp);
    const interval = Math.floor((now - publishDate) / 1000);

    if (interval < 60) return `agora`;
    const minutesAgo = Math.floor(interval / 60);
    if (minutesAgo < 60) return `${minutesAgo}m`;
    const hoursAgo = Math.floor(minutesAgo / 60);
    if (hoursAgo < 24) return `${hoursAgo}h`;
    const daysAgo = Math.floor(hoursAgo / 24);
    if (daysAgo < 15) return `${daysAgo}d`;
    const weeksAgo = Math.floor(daysAgo / 7);
    if (weeksAgo < 4) return `${weeksAgo}`;
    const monthsAgo = Math.floor(weeksAgo / 4);
    if (monthsAgo < 12) return `${monthsAgo} ses`;
    const yearsAgo = Math.floor(monthsAgo / 12);
    return `${yearsAgo} as`;
};

window.updateLikeStatus = () => {
    const like = document.getElementById('like');
    like.classList.toggle('liked');
    like.classList.toggle('unliked');
};


document.addEventListener("DOMContentLoaded", () => {
    loadPosts();
});


