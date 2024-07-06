document.addEventListener('DOMContentLoaded', function() {
    fetchFriends();
});

function fetchFriends() {
    fetch('/friends')
        .then(response => response.json())
        .then(data => {

            const connectionsList = document.querySelector('.connections-list');
            connectionsList.innerHTML = ''; // Limpa a lista de conexões

            data.forEach(friend => {

                const connectionElement = document.createElement('div');
                connectionElement.classList.add('connection');

                const photoElement = document.createElement('div');
                photoElement.classList.add('connection-photo');
                const imgElement = document.createElement('img');
                imgElement.src = `/storage/${friend.profile.photo}`; // Verifica se a foto existe
                imgElement.alt = `Foto de ${friend.profile.name}`;
                photoElement.appendChild(imgElement);

                const infoElement = document.createElement('div');
                infoElement.classList.add('connection-info');
                const nameElement = document.createElement('span');
                nameElement.textContent = friend.profile.name; // Nome do usuário
                const randomTextElement = document.createElement('p');
                randomTextElement.textContent = 'Texto aleatório'; // Texto aleatório
                const timeElement = document.createElement('p');
                timeElement.classList.add('last-message-time');
                timeElement.textContent = '08:00'; // Hora da última mensagem

                infoElement.appendChild(nameElement);
                infoElement.appendChild(randomTextElement);
                infoElement.appendChild(timeElement);

                connectionElement.appendChild(photoElement);
                connectionElement.appendChild(infoElement);

                connectionsList.appendChild(connectionElement);
            });
        })
        .catch(error => {
            console.error('Erro ao buscar amigos:', error);
        });
}
