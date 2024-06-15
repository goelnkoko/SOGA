function adjustTextarea(el) {
    el.style.height = 'auto';
    el.style.height = (el.scrollHeight - '40') + 'px';
}

const fileInput = document.getElementById('file-input');
const uploadButton = document.getElementById('upload-button');
const thumbnails = document.getElementById('thumbnails');
const sendButton = document.getElementById('send-button');
const postContent = document.getElementById('post');
const postsContainer = document.getElementById('posts-container');

var likeStatus = false;

uploadButton.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', (event) => {
    const files = event.target.files;
    handleFileUploads(files);
});

sendButton.addEventListener('click', () => {
    const postText = postContent.value;
    const media = Array.from(thumbnails.querySelectorAll('img, video')).map(media => {
        return {
            type: media.tagName.toLowerCase(),
            src: media.src
        };
    });
    createPost(postText, media);
});

function handleFileUploads(files) {
    for (let file of files) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const media = createMediaThumbnail(event.target.result, file.type);
            thumbnails.appendChild(media);
        }
        reader.readAsDataURL(file);
    }
}

function createMediaThumbnail(src, type) {
    const thumbnail = document.createElement('div');
    thumbnail.classList.add('thumbnail');

    let media;
    if (type.startsWith('image')) {
        media = document.createElement('img');
    } else if (type.startsWith('video')) {
        media = document.createElement('video');
        media.controls = true;
    }
    media.src = src;

    const removeButton = document.createElement('button');
    removeButton.classList.add('remove');
    removeButton.textContent = '×';
    removeButton.addEventListener('click', () => {
        thumbnail.remove();
    });

    thumbnail.appendChild(media);
    thumbnail.appendChild(removeButton);

    return thumbnail;
}

function createPost(text, media) {
    let mediaContent = '';

    if (media.length === 1) {
        mediaContent = `<div class="single-media">${createMediaElement(media[0])}</div>`;
    } else if (media.length === 2) {
        mediaContent = `
            <div class="double-media">
                <div class="media-left">${createMediaElement(media[0])}</div>
                <div class="media-right">${createMediaElement(media[1])}</div>
            </div>`;
    } else if (media.length > 2) {
        mediaContent = `
            <div class="multi-media">
                <div class="media-left">${createMediaElement(media[0])}</div>
                <div class="media-right">${createMediaElement(media[1])}</div>
                <div class="more-media">
                    <button onclick="viewMoreMedia(${media.length - 2})">+${media.length - 2}</button>
                </div>
            </div>`;
    }

    const postTemplate = `
        <div class="post">
            <div class="post-user-profile">
                <a href="../perfil/perfil.html">
                    <img src="../img/gyomei-chorando.jpeg" alt="Foto do Gyomei">
                    <div id="profile-content">
                        <span>Gyomei</span>
                        <p>Hashira da Pedra</p>
                    </div>
                </a>
            </div>
            <div class="post-content">
                <p>${text}</p>
                ${mediaContent}
            </div>
            <div class="icons">
<!--                <button id="like"><span class="material-symbols-outlined material-style">thumb_up</span></button>-->
                <button onclick="updateLikeStatus()" id="like" class="unliked"><span class="material-symbols-outlined material-style">sentiment_sad</span></button>
                <button id="comment"><span class="material-symbols-outlined material-style">comment</span></button>
                <button id="share"><span class="material-symbols-outlined material-style">share</span></button>
            </div>
        </div>
    `;

    postsContainer.insertAdjacentHTML('beforeend', postTemplate);

    postContent.value = '';
    thumbnails.innerHTML = '';
}

function createMediaElement(media) {
    if (media.type === 'img') {
        return `<img src="${media.src}" alt="Post Image">`;
    } else if (media.type === 'video') {
        return `<video controls src="${media.src}"></video>`;
    }
}

window.viewMoreMedia = function(count) {
    alert(`View ${count} more media items`);
    // Implement the logic to show more media items in a modal or new view
}

//Função para controlar os likes
// like.onclick = () => {
//     if (!likeStatus) {
//         like.style.fontVariationSettings = `'FILL' 1`;
//         like.style.color = '#0095b6';
//         likeStatus = true;
//     } else {
//         like.style.fontVariationSettings = `'FILL' 0`;
//         like.style.color = '#fff';
//         likeStatus = false;
//     }
// }

window.updateLikeStatus = () => {
    const like = document.getElementById('like');

    console.log("Like was clicked: " + like);
    like.classList.toggle('liked');
    like.classList.toggle('unliked');
};
