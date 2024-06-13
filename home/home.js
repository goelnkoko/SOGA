function adjustTextarea(el) {
    el.style.height = 'auto';
    el.style.height = (el.scrollHeight) + 'px';
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

    leftBar.style.height = '100vh';
    rightBar.style.height = '100vh';

    const width = leftBar.offsetWidth;
    console.log(width);
    feed.style.marginLeft = width + 'px';
    rightBar.style.left = width + feed.offsetWidth + 'px';

    const menu_home_size = menu_home.offsetWidth;
    logo.style.width = menu_home_size + 'px';
    menu_profile.style.width = (menu_home_size * 1.1) + 'px';

    // Drag and Drop
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('drag-over');
    });

    dropZone.addEventListener('dragleave', function() {
        dropZone.classList.remove('drag-over');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    // File input click
    uploadButton.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        const files = fileInput.files;
        handleFiles(files);
    });

    function handleFiles(files) {
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const thumbnail = document.createElement('div');
                thumbnail.classList.add('thumbnail');

                const img = document.createElement('img');
                img.src = e.target.result;

                const removeBtn = document.createElement('button');
                removeBtn.classList.add('remove');
                removeBtn.textContent = '×';
                removeBtn.addEventListener('click', function() {
                    thumbnails.removeChild(thumbnail);
                });

                const progress = document.createElement('div');
                progress.classList.add('progress');

                thumbnail.appendChild(img);
                thumbnail.appendChild(removeBtn);
                thumbnail.appendChild(progress);
                thumbnails.appendChild(thumbnail);

                // Simular o progresso do carregamento, já que não sabemos não simular
                setTimeout(() => {
                    progress.style.width = '100%';
                }, 200);

            };

            reader.readAsDataURL(file);
        }
    }

    // Enviar a publicação no Backend
    sendButton.addEventListener('click', function() {
        const formData = new FormData();
        formData.append('content', postContent.value);

        const files = fileInput.files;
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }

        fetch('URL_DA_SUA_API', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });
});