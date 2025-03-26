// Select elements
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');
const successPayIcons = document.querySelectorAll('.successPay');
const toReceiveIcons = document.querySelectorAll('.toReceive');
const completedIcons = document.querySelectorAll('.completed');

// Function to handle AJAX requests
function handleIconClick(icon, url) {
    icon.addEventListener('click', function () {
        const orderId = parseInt(this.getAttribute('data-order-id'));

        const xhr = new XMLHttpRequest();

        // Define the request
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Set up the callback function for when the request completes
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Request was successful
                console.log('Server Response:', xhr.responseText);
                window.location.reload();
            } else {
                // Request failed
                console.error('Request failed with status:', xhr.status);
            }
        };

        // Set up the callback function for when an error occurs
        xhr.onerror = function () {
            console.error('Request failed');
        };

        // Send the request with the order ID as data
        xhr.send('order_id=' + orderId);
    });
}

// Add event listeners to icons
successPayIcons.forEach(icon => handleIconClick(icon, '../processing_order.php'));
toReceiveIcons.forEach(icon => handleIconClick(icon, '../receive_order.php'));
completedIcons.forEach(icon => handleIconClick(icon, '../completed_order.php'));

// Side menu interaction
allSideMenu.forEach(item => {
    const li = item.parentElement;

    item.addEventListener('click', function () {
        allSideMenu.forEach(i => {
            i.parentElement.classList.remove('active');
        });

        li.classList.add('active');
    });
});

// Toggle sidebar
const menuBar = document.querySelector('#sidebar .menu-bar');
const sideBar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
    sideBar.classList.toggle('hide');
});

if (window.innerWidth < 768) {
    sideBar.classList.add('hide');
}

// Show/hide admin container
const button = document.getElementById('addAdmin');
const container = document.querySelector('.add-container');
const background = document.querySelector('.background');
const cancel = document.getElementById('cancel');

function showContainer() {
    background.style.opacity = '1';
    background.style.pointerEvents = 'auto';
    container.style.opacity = '1';
    container.style.pointerEvents = 'auto';
    container.style.transform = 'translate(-50%, -50%) scale(1)';
}

function hideContainer() {
    background.style.opacity = '0';
    background.style.pointerEvents = 'none';
    container.style.opacity = '0';
    container.style.pointerEvents = 'none';
    container.style.transform = 'translate(-50%, -50%) scale(0.97)';
}

button.addEventListener('click', function (event) {
    event.preventDefault();
    showContainer();
});

cancel.addEventListener('click', function (event) {
    event.preventDefault();
    hideContainer();
});
