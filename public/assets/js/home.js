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

const fetchLoggedInUser = async () => {
    try {
        const response = await fetch('/logged-user');
        const data = await response.json();

        document.querySelector('.user-photo').innerHTML = `<img src = "/storage/${data.profile.photo}" alt = "Foto do Gyomei" >`;

        console.log("Aqui esta os dados buscados: " + data);
        return data;
    } catch (error) {
        console.error('Erro ao buscar usuário logado:', error);
        return 0;
    }
}

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

const loadPosts = async () => {
    const data = await fetchLoggedInUser();

    fetch('/posts')
        .then(response => response.json())
        .then(posts => {
            postsContainer.innerHTML = '';
            posts.forEach(post => displayPost(post, data));
        })
        .catch(error => console.error('Error:', error));
};

const displayPost = (post, loggedUser) => {

    let count = 0;
    let mediaContent = '';
    let hiddenMediaContent = '';

    if (post.media) {
        const mediaArray = JSON.parse(post.media);
        mediaArray.forEach((mediaPath, index) => {
            const mediaUrl = `/storage/${mediaPath}`;
            const type = mediaPath.split('.').pop().toLowerCase();
            const mediaHtml = ['jpeg', 'jpg', 'png', 'gif'].includes(type) ?
                `<img src="${mediaUrl}" alt="Post Image">` :
                `<video controls src="${mediaUrl}"></video>`;

            if (index < 4) {
                mediaContent += mediaHtml;
            } else {
                hiddenMediaContent += mediaHtml;
            }
            count++;
        });
    }

    let mediaClass = '';
    if (count === 1) {
        mediaClass = 'single-media';
    } else if (count === 2) {
        mediaClass = 'double-media';
    } else if (count === 4) {
        mediaClass = 'four-media';
    } else if (count >= 5) {
        mediaClass = 'multi-media';
    }

    const postTemplate = `
        <div class="post">
            <div class="post-left">
                <div class="user-photo">
                    <a href="/profile?profile_id=${post.user.profile.id}"><img src="/storage/${post.user.profile.photo}" alt="Pessoa linda"></a>
                </div>
            </div>
            <div class="post-right">
                <div class="post-header">
                    <a href="/profile?profile_id=${post.user.profile.id}">
                        <div id="post-header-info">
                            <span>${post.user.profile.name}</span>
                            <p>@${post.user.username}</p>
                            <p>·</p>
                            <p>${timeAgo(post.created_at)}</p>
                        </div>
                    </a>
                    <div class="more-options" onclick="showPostMenu(${post.id}, event)">
                        <span class="material-symbols-outlined material-style">more_vert</span>
                    </div>
                    <div class="menu" id="menu-${post.id}">
                        <ul>
                            ${
                                loggedUser.id === post.user.id ? `
                                    <li onclick="editPostContent(${post.id})">Editar</li>
                                    <li onclick="removePost(${post.id})">Eliminar</li>
                                ` : `
                                    <li onclick="sendFriendRequest(${post.user.id}, this)">Seguir</li>
                                    <li onclick="hidePost(${post.id})">Ocultar</li>
                                `
                            }
                            <li><a href="/profile?userId=${post.user.profile.id}">Ver perfil</a></li>
                        </ul>
                    </div>
                </div>
                <div class="post-content">
                    <p>${post.content === null ? '' : post.content}</p>
                    <div class="medias ${mediaClass}">
                        ${mediaContent}
                        ${
                            count > 4 ? `
                                <button class="show-more" onclick="showHiddenMedia(this)">Ver mais (+${count - 4})</button>
                            ` : ''
                        }
                    </div>
                </div>
                <div class="icons">
                    <button onclick="updateLikeStatus(${post.id})" id="like-${post.id}" class="${post.user_liked ? 'liked' : 'unliked'}">
                        <span class="material-symbols-outlined material-style">${post.user_liked ? 'sentiment_satisfied' : 'sentiment_sad'}</span>
                    </button>
                    <button onclick="postComment(${post.id}, ${loggedUser.id})" id="comment">
                        <span class="material-symbols-outlined material-style">comment</span>
                    </button>
                    <button id="share">
                        <span class="material-symbols-outlined material-style">share</span>
                    </button>
                </div>
                ${commentArea(post, loggedUser)}
                <div class="comment-container" id="comment-container-${post.id}"></div>
            </div>
        </div>
    `;

    postsContainer.insertAdjacentHTML('beforeend', postTemplate);
};

const showHiddenMedia = (button) => {
    const hiddenMediaContainer = button.previousElementSibling;
    hiddenMediaContainer.classList.remove('hidden');
    button.remove();
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

const showPostMenu = (postId, event) => {
    event.stopPropagation();
    const menu = document.getElementById(`menu-${postId}`);

    document.querySelectorAll('.menu').forEach(menu => {     // Fecha todos os menus antes de abrir o menu selecionado
        menu.style.display = 'none';
    });

    menu.style.display = 'block';
}

window.addEventListener('click', function (event) {
    if (!event.target.closest('.more-options') && !event.target.closest('.menu')) {   // Fecha todos os menus quando clicar fora, a menos que o clique seja no botão "more-options" ou no próprio menu
        document.querySelectorAll('.menu').forEach(menu => {
            menu.style.display = 'none';
        });
    }
});

const removePost = async (postId) => {
    try {
        const response = await fetch(`/posts/${postId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });
        if (response.ok) {
            loadPosts();
        } else {
            const data = await response.json();
            alert(data.error);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Falha ao deletar o post. Por favor, tente novamente.');
    }
}


//Like area
const updateLikeStatus = async (postId) => {
    const like = document.getElementById(`like-${postId}`);
    const isLiked = like.classList.contains('liked');

    const response = await fetch(`/posts/${postId}/${isLiked ? 'unlike' : 'like'}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    });

    if (response.ok) {
        const data = await response.json();

        like.classList.toggle('liked');
        like.classList.toggle('unliked');

        if (like.classList.contains('liked')) {
            likePost(like);
        } else {
            unlikePost(like);
        }

        // likesCount.innerText = data.likes_count;

        document.getElementById(`likes-count-${postId}`).innerText = data.likes_count;
    } else {
        console.error('Failed to update like status.');
    }
};

const likePost = (like) => {
    like.innerHTML = '';
    like.innerHTML = `<span class="material-symbols-outlined material-style"> sentiment_satisfied</span>`;
}

const unlikePost = (like) => {
    like.innerHTML = '';
    like.innerHTML = `<span class="material-symbols-outlined material-style"> sentiment_sad</span>`;
}


//Comment Area
const postComment = (postId, user) => {

    const commentAreaId = document.getElementById('comment-area-'+postId);
    const commentContainer = document.getElementById('comment-container-'+postId);

    if (commentAreaId.style.display === 'flex') {
        commentAreaId.style.display = 'none';
        commentContainer.style.display = 'none';
    } else {
        commentAreaId.style.display = 'flex';
        commentContainer.style.display = 'flex';
    }
}

const commentArea = (post, user) => {
    loadComments(post.id, user.id);
    return `
        <div class="comment-area" id="comment-area-${post.id}">
            <div class="user-photo">
                <img src="/storage/${user.profile.photo}" alt="Foto do usuário">
            </div>
            <form id="comment-form-${post.id}" class="comment-form-content" onsubmit="handleCommentSubmit(event, ${post.id})">
                <div class="comment-content-area">
                    <textarea class="comment-text-area" name="content" id="comment-text-${post.id}" cols="30" rows="1" oninput="adjustTextarea(this)"></textarea>
                    <div class="icons comment-icons">
                        <button id="upload-button-${post.id}" type="button" onclick="document.getElementById('file-input-${post.id}').click()">
                            <span class="material-symbols-outlined">image</span>
                        </button>
                        <input type="file" id="file-input-${post.id}" multiple style="display:none;" accept="image/*,video/*" onchange="previewFiles(${post.id})">
                        <button type="submit" id="send-comment-button-${post.id}"><span class="material-symbols-outlined">send</span></button>
                    </div>
                </div>
                <div id="thumbnails-${post.id}" class="thumbnails"></div>
            </form>
        </div>
    `;
}

const handleCommentSubmit = (event, postId) => {
    event.preventDefault();

    const form = document.getElementById(`comment-form-${postId}`);
    const content = form.querySelector(`#comment-text-${postId}`).value;
    const fileInput = form.querySelector(`#file-input-${postId}`);
    const files = fileInput.files;

    const media = [];
    for (let i = 0; i < files.length; i++) {
        media.push(files[i]);
    }

    saveComment(postId, content, media);
}

const previewFiles = (postId) => {
    const fileInput = document.getElementById(`file-input-${postId}`);
    const thumbnailsContainer = document.getElementById(`thumbnails-${postId}`);

    const files = fileInput.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = (e) => {
            const type = file.type;
            const src = e.target.result;
            const thumbnail = createMediaThumbnail(src, type);
            thumbnailsContainer.appendChild(thumbnail);
        }

        reader.readAsDataURL(file);
    }
}

const loadComments = (postId, authUserId) => {
    fetch(`/posts/${postId}/comments`)
        .then(response => response.json())
        .then(comments => {
            comments.forEach(comment => displayComment(postId, comment, authUserId));
        })
        .catch(error => console.error('Erro ao carregar comentários:', error));
};

const displayComment = (postId, comment, authUserId) => {

    let count = 0;
    let mediaContent = '';
    const commentsContainer = document.getElementById('comment-container-'+ postId);

    if (comment.media) {
        const mediaArray = JSON.parse(comment.media);
        mediaArray.forEach(mediaPath => {
            const mediaUrl = `/storage/${mediaPath}`;
            const type = mediaPath.split('.').pop().toLowerCase();
            mediaContent += ['jpeg', 'jpg', 'png', 'gif'].includes(type) ?
                `<img src="${mediaUrl}" alt="Comment Image">` :
                `<video controls src="${mediaUrl}"></video>`;

            count++;
        });
    }

    let mediaClass = '';
    if (count === 1) {
        mediaClass = 'single-media';
    } else if (count === 2) {
        mediaClass = 'double-media';
    } else if (count === 4) {
        mediaClass = 'four-media';
    } else if (count >= 5) {
        mediaClass = 'multi-media';
    }


    const commentTemplate = `
        <div class="comment">
            <div class="comment-left">
                <a href="/profile?userId=${comment.user.id}"><img src="/storage/${comment.user.profile.photo}" alt="User Photo"></a>
            </div>
            <div class="comment-right">
                <div class="comment-header">
                    <a href="/profile?profile_id=${comment.user.id}">
                        <div id="comment-header-info">
                            <span>${comment.user.profile.name}</span>
                            <p>@${comment.user.username}</p>
                            <p>·</p>
                            <p>${timeAgo(comment.created_at)}</p>
                        </div>
                    </a>
                    ${authUserId === comment.user.id ? `
                        <button onclick="deleteComment(${comment.id})">Eliminar</button>
                    ` : ''}
                </div>
                <div class="comment-content">
                    <p>${comment.content || ''}</p>
                    <div class="medias ${mediaClass}">
                        ${mediaContent}
                    </div>
                </div>
            </div>
        </div>
    `;

    commentsContainer.insertAdjacentHTML('beforeend', commentTemplate);
};

const saveComment = (postId, content, media) => {
    const formData = new FormData();
    formData.append('post_id', postId);
    formData.append('content', content);
    media.forEach(file => formData.append('media[]', file));

    fetch('/comments', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
        .then(response => response.json())
        .then(comment => {
            // displayComment(comment, authUserId);
            document.getElementById(`comment-text-${postId}`).value = '';
            document.getElementById(`file-input-${postId}`).value = '';
            document.getElementById(`thumbnails-${postId}`).innerHTML = '';
        })
        .catch(error => console.error('Erro ao adicionar comentário:', error));
};

document.addEventListener("DOMContentLoaded", () => {
    loadPosts();
});
