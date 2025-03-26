document.querySelectorAll('.cancelOrder').forEach(button => {
    button.addEventListener('click', function() {
        let orderId = this.getAttribute('data-order-id');
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin_order_cancel.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function() {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);

                if (response.success) {
                    // Log the order items to the console
                   window.location.reload();
                } else {
                    console.error(response.message);
                }
            }
        };
        xhr.send(JSON.stringify({ orderId: orderId }));
        console.log("CLICK: ", orderId);
    });
});
