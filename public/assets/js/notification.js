const fetchNotifications = () => {
    fetch('/notifications')
        .then(response => response.json())
        .then(notifications => {
            const notificationsList = document.getElementById('notifications-list');
            notificationsList.innerHTML = '';

            notifications.forEach(notification => {
                const notificationElement = document.createElement('div');
                notificationElement.classList.add('notification');
                notificationElement.innerHTML = `
                    <p>${notification.type}: ${notification.data.message}</p>
                    <button onclick="markAsRead(${notification.id})">Marcar como lida</button>
                    <button onclick="deleteNotification(${notification.id})">Eliminar</button>
                `;
                notificationsList.appendChild(notificationElement);
            });
        })
        .catch(error => console.error('Erro ao buscar notificações:', error));
};

const markAsRead = (notificationId) => {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            fetchNotifications();
        })
        .catch(error => console.error('Erro ao marcar notificação como lida:', error));
};

const deleteNotification = (notificationId) => {
    fetch(`/notifications/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            fetchNotifications();
        })
        .catch(error => console.error('Erro ao eliminar notificação:', error));
};
