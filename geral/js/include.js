function loadHTML(element, file) {
    fetch(file)
        .then(response => {
            if (response.ok) {
                return response.text();
            }
            throw new Error('Network response was not ok.');
        })
        .then(data => {
            document.querySelector(element).innerHTML = data;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

document.addEventListener('DOMContentLoaded', () => {
    loadHTML('leftBar', '../geral/leftBar.html');
    loadHTML('rightBar', '../geral/rightBar.html');
});