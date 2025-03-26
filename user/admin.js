const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');
const successPayIcons = document.querySelectorAll('.successPay');
const toReceiveIcons = document.querySelectorAll('.toReceive');
const completedIcons = document.querySelectorAll('.completed');

successPayIcons.forEach(function(icon) {
    icon.addEventListener('click', function() {
        const orderId = parseInt(this.getAttribute('data-order-id'));

        const xhr = new XMLHttpRequest();

        // Define the request
        xhr.open('POST', '../processing_order.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Set up the callback function for when the request completes
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Request was successful
                console.log('Server Response:', xhr.responseText);
                window.location.reload();
                // Optionally, update the UI or perform other actions based on the response
            } else {
                // Request failed
                console.error('Request failed with status:', xhr.status);
            }
        };

        // Set up the callback function for when an error occurs
        xhr.onerror = function() {
            console.error('Request failed');
        };

        // Send the request with the order ID as data
        xhr.send('order_id=' + orderId);

    });
});

toReceiveIcons.forEach(function(icon) {
    icon.addEventListener('click', function() {
        const orderId = parseInt(this.getAttribute('data-order-id'));

        const xhr = new XMLHttpRequest();

        // Define the request
        xhr.open('POST', '../receive_order.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Set up the callback function for when the request completes
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Request was successful
                console.log('Server Response:', xhr.responseText);
                window.location.reload();
                // Optionally, update the UI or perform other actions based on the response
            } else {
                // Request failed
                console.error('Request failed with status:', xhr.status);
            }
        };

        // Set up the callback function for when an error occurs
        xhr.onerror = function() {
            console.error('Request failed');
        };

        // Send the request with the order ID as data
        xhr.send('order_id=' + orderId);

    });
});

completedIcons.forEach(function(icon) {
    icon.addEventListener('click', function() {
        const orderId = parseInt(this.getAttribute('data-order-id'));

        const xhr = new XMLHttpRequest();

        // Define the request
        xhr.open('POST', '../completed_order.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Set up the callback function for when the request completes
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Request was successful
                console.log('Server Response:', xhr.responseText);
                window.location.reload();
                // Optionally, update the UI or perform other actions based on the response
            } else {
                // Request failed
                console.error('Request failed with status:', xhr.status);
            }
        };

        // Set up the callback function for when an error occurs
        xhr.onerror = function() {
            console.error('Request failed');
        };

        // Send the request with the order ID as data
        xhr.send('order_id=' + orderId);

    });
});

allSideMenu.forEach(item=>{
    const li = item.parentElement;

    item.addEventListener('click', function() {
        allSideMenu.forEach(i=>{
            i.parentElement.classList.remove('active');
        })

        li.classList.add('active');
    })
});

const menuBar = document.querySelector('#content ion-icon');
const sideBar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
    sideBar.classList.toggle('hide');
})

if (window.innerWidth < 768) {
    sideBar.classList.add('hide');
} else if (window.innerWidth < 576) {
    
}
