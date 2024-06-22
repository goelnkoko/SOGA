document.addEventListener("DOMContentLoaded", function() {

    function adjustTextarea(el) {
        el.style.height = 'auto';
        el.style.height = (el.scrollHeight - '40') + 'px';
    }

    const fileInput = document.getElementById('file-input');
    const uploadButton = document.getElementById('upload-button');
    const thumbnails = document.getElementById('thumbnails');
    const postForm = document.getElementById('post-form');
    const postsContainer = document.getElementById('posts-container');
    const postContent = document.getElementById('post');

    uploadButton.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', (event) => {
        const files = event.target.files;
        handleFileUploads(files);
    });

    postForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const postText = postContent.value;
        const files = fileInput.files;
        createPost(postText, files);
    });

    function handleFileUploads(files) {
        thumbnails.innerHTML = '';
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

    function createPost(text, files) {
        const formData = new FormData();
        formData.append('content', text);
        for (let file of files) {
            formData.append('media[]', file);
        }

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
                    console.log(data)
                    postContent.value = '';
                    thumbnails.innerHTML = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function loadPosts() {
        fetch('/posts')
            .then(response => response.json())
            .then(posts => {
                postsContainer.innerHTML = '';
                posts.forEach(post => {
                    displayPost(post);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function displayPost(post) {
        const mediaContent = post.media ? JSON.parse(post.media).map(mediaPath => {
            const mediaUrl = `/storage/${mediaPath}`;
            const type = mediaPath.split('.').pop();
            if (['jpeg', 'jpg', 'png', 'gif'].includes(type)) {
                return `<img src="${mediaUrl}" alt="Post Image">`;
            } else if (['mp4', 'avi', 'mkv'].includes(type)) {
                return `<video controls src="${mediaUrl}"></video>`;
            }
        }).join('') : '';

        const postTemplate = `
            <div class="post">
                <div class="post-user-profile">
                    <a href="../perfil/perfil.html">
                        <img src="../img/gyomei-chorando.jpeg" alt="Foto do Gyomei">
                        <div id="profile-content">
                            <span>${post.user.name}</span>
                            <p>${timeAgo(post.created_at)}</p>
                        </div>
                    </a>
                </div>
                <div class="post-content">
                    <p>${post.content}</p>
                    ${mediaContent}
                </div>
                <div class="icons">
                    <button onclick="updateLikeStatus()" id="like" class="unliked"><span class="material-symbols-outlined material-style">sentiment_sad</span></button>
                    <button id="comment"><span class="material-symbols-outlined material-style">comment</span></button>
                    <button id="share"><span class="material-symbols-outlined material-style">share</span></button>
                </div>
            </div>
        `;

        postsContainer.insertAdjacentHTML('beforeend', postTemplate);
    }

    // Chamada da função que processa os posts na página principal
    loadPosts();

    //Função para simular o efeito do like, ainda não está terminada
    window.updateLikeStatus = () => {
        const like = document.getElementById('like');
        like.classList.toggle('liked');
        like.classList.toggle('unliked');
    };

    //Função para calcular quanto tempo passou desde que a publicação foi feita
    function timeAgo(timestamp){
        const now = new Date();
        const publishDate = new Date(timestamp);
        const interval = Math.floor((now - publishDate)/1000);

        if(interval < 60) {
            return `há ${interval} segundos`;
        }

        const minutesAgo = Math.floor(interval/60);
        if(minutesAgo < 60) {
            return `há ${minutesAgo} minutos`;
        }

        const hoursAgo = Math.floor(minutesAgo/60);
        if(hoursAgo < 24) {
            return `há ${hoursAgo} horas`;
        }

        const daysAgo = Math.floor(hoursAgo/24);
        if(daysAgo < 15) {
            return `há ${daysAgo} dias`;
        }

        const weeksAgo = Math.floor(daysAgo/7);
        if(weeksAgo < 4) {
            return `há ${weeksAgo} semanas`;
        }

        const monthsAgo = Math.floor(weeksAgo/2);
        if(monthsAgo < 12) {
            return `há ${monthsAgo} mêses`;
        }

        const yearsAgo = Math.floor(monthsAgo/12);
        return `há ${yearsAgo} anos`;
    }

});
