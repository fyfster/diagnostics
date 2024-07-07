$(document).ready(function () {

    function handleNotificationTypeIcons(type) {
        switch (type) {
            case 'speed':
                return { icon: 'fa-car-crash', btn: 'btn-danger' };
            case 'rpm':
                return { icon: 'fa-car-battery', btn: 'btn-warning' };
            default:
                return { icon: 'fa-info-circle', btn: 'btn-primary' };
        }
    }

    function fetchNotifications() {
        let element = document.querySelector('.alert-dropdown');

        if (element.classList.contains('show')) {
            return;
        }

        fetch(BASE_URL.notifications)
            .then(response => response.json())
            .then(notifications => {
                const dropdown = document.querySelector('.dropdown-menu');
                dropdown.innerHTML = '';

                notifications.forEach(notification => {
                    const dropdownItem = document.createElement('a');
                    let iconDetails = handleNotificationTypeIcons(`${notification.type}`);
                    dropdownItem.classList.add('dropdown-item', 'd-flex', 'align-items-center');
                    dropdownItem.href = '#';
                    dropdownItem.innerHTML = `
                        <div class="mr-3">
                            <div class="icon-circle ` + iconDetails.btn + `">
                                <i class="fas ` + iconDetails.icon + ` text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">${notification.created_at}</div>
                            <span class="font-weight-bold">${notification.data}</span>
                        </div>
                    `;
                    dropdown.appendChild(dropdownItem);
                });

                const counter = document.querySelector('.badge-counter');
                if (notifications.length === 0) {
                    counter.innerHTML = "";
                } else {
                    counter.innerHTML = notifications.length > 100 ? '99+' : notifications.length;
                }

            });
    }

    fetchNotifications();

    setInterval(fetchNotifications, 10000);

    document.querySelector('.fa-bell').addEventListener('click', function () {
        fetch(BASE_URL.notifications_read)
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
        });
    });
});