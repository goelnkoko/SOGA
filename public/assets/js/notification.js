const fetchNotifications = () => {
    fetch('/notifications')
        .then(response => response.json())
        .then(notifications => {

            const unreadNotifications = document.querySelector('.new-notifications');
            unreadNotifications.innerHTML = '';

            const readNotifications = document.querySelector('.old-notifications');
            readNotifications.innerHTML = '';

            const h3 = document.createElement('h3');
            h3.textContent = 'Novas';
            unreadNotifications.appendChild(h3);

            const h4 = document.createElement('h3');
            h4.textContent = 'Lidas';
            readNotifications.appendChild(h4);

            notifications.forEach(notification => {
                console.log(notification);

                const notificationElement = document.createElement('div');
                notificationElement.classList.add('notification');
                notificationElement.innerHTML = `
                    <p>${notification.content.message}</p>
                    <button onclick="deleteNotification(${notification.id})">Eliminar</button>
                `;

                if (!notification.read){
                    unreadNotifications.appendChild(notificationElement);
                    markAsRead(notification.id);
                } else {
                    readNotifications.appendChild(notificationElement);
                }

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

document.addEventListener('DOMContentLoaded', () => {
    fetchNotifications();
});
