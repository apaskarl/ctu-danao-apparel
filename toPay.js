document.addEventListener("DOMContentLoaded", function() {
    function displayCart() {
        fetch('get_order_to_pay.php')
            .then(response => response.json())
            .then(cartItems => {
                let orderContainer = document.getElementById('to-pay-content');
                if (!cartItems || cartItems.length === 0) {
                    orderContainer.innerHTML = '<div class="no-prod"> <h3>Nothing to see here yet</h3> </div>';
                    return;
                }

                let orderHTML = '';

                // Group cart items by order_id
                let orders = {};
                cartItems.forEach(item => {
                    if (!orders[item.order_id]) {
                        orders[item.order_id] = [];
                    }
                    orders[item.order_id].push(item);
                });

                // Build HTML for each order
                Object.keys(orders).forEach(orderId => {
                    let totalCost = 0; // Initialize total cost for the current order
                    orderHTML += `<div class="prod">`;
                    orders[orderId].forEach(item => {
                        let subtotal = item.price * item.quantity;
                        totalCost += subtotal;

                        orderHTML += `
                            <div class="prod-details">
                                <img src="${item.product_img}" alt="">
                                <div class="prod-details-desc">
                                    <h3>${item.product_name}</h3>
                                    <p>Variation: ${item.color}, ${item.size}</p>
                                    <p>Qty: ${item.quantity} <span class="price" style="float: right">₱${item.price}.00</span></p>
                                </div>          
                            </div>`;
                    });

                    // Add order total and additional details
                    orderHTML += `
                        <div class="order-total">Order Total: <span>₱${totalCost}.00</span></div>
                        <div class="prod-actions">
                            <div class="actions">
                                <a href="">Cancel Order</a>
                            </div>
                        </div>
                        <p>Please make your payment at the SSG Office to start the processing of your order.</p>
                    </div>`;
                });

                orderContainer.innerHTML = orderHTML;
            })
            .catch(error => {
                console.error('Error fetching cart items:', error);
            });
    }

    function displayProcessing() {
        fetch('get_order_process.php')
        .then(response => response.json())
        .then(cartItems => {
            let orderContainer = document.getElementById('to-process-content');
            if (!cartItems || cartItems.length === 0) {
                orderContainer.innerHTML = '<div class="no-prod"> <h3>Nothing to see here yet</h3> </div>';
                return;
            }

            let orderHTML = '';

            // Group cart items by order_id
            let orders = {};
            cartItems.forEach(item => {
                if (!orders[item.order_id]) {
                    orders[item.order_id] = [];
                }
                orders[item.order_id].push(item);
            });

            // Build HTML for each order
            Object.keys(orders).forEach(orderId => {
                let totalCost = 0; // Initialize total cost for the current order
                orderHTML += `<div class="prod">`;
                orders[orderId].forEach(item => {
                    let subtotal = item.price * item.quantity;
                    totalCost += subtotal;

                    orderHTML += `
                        <div class="prod-details">
                            <img src="${item.product_img}" alt="">
                            <div class="prod-details-desc">
                                <h3>${item.product_name}</h3>
                                <p>Variation: <strong>${item.color}, ${item.size}</strong></p>
                                <p>Qty: <strong>${item.quantity}</strong> <span class="price" style="float: right">₱${item.price}.00</span></p>
                            </div>
                        </div>`;
                });

                // Add order total and additional details
                orderHTML += `
                    <div class="order-total" style="float: right">Order Total: <span>₱${totalCost}.00</span></div><br>
                    <p style="clear:both; text-align: center;">The SSG are now processing your order/orders. Please give us some time.</p>
                </div>`;
            });

            orderContainer.innerHTML = orderHTML;
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
    }
    function displayReceive() {
        fetch('get_receive.php')
        .then(response => response.json())
        .then(cartItems => {
            let orderContainer = document.getElementById('to-receive-content');
            if (!cartItems || cartItems.length === 0) {
                orderContainer.innerHTML = '<div class="no-prod"> <h3>Nothing to see here yet</h3> </div>';
                return;
            }

            let orderHTML = '';

            // Group cart items by order_id
            let orders = {};
            cartItems.forEach(item => {
                if (!orders[item.order_id]) {
                    orders[item.order_id] = [];
                }
                orders[item.order_id].push(item);
            });

            // Build HTML for each order
            Object.keys(orders).forEach(orderId => {
                let totalCost = 0; // Initialize total cost for the current order
                orderHTML += `<div class="prod">`;
                orders[orderId].forEach(item => {
                    let subtotal = item.price * item.quantity;
                    totalCost += subtotal;

                    orderHTML += `
                        <div class="prod-details">
                            <img src="${item.product_img}" alt="">
                            <div class="prod-details-desc">
                                <h3>${item.product_name}</h3>
                                <p>Variation: <strong>${item.color}, ${item.size}</strong></p>
                                <p>Qty: <strong>${item.quantity}</strong> <span class="price" style="float: right">₱${item.price}.00</span></p>
                            </div>
                        </div>
                        `;
                });

                // Add order total and additional details
                orderHTML += `
                
                    <div class="order-total" style="float: right">Order Total: <span>₱${totalCost}.00</span></div><br>
                    <div class="prod-actions">
                    <div class="actions" style="float: right">
                        <a href="" class="completed">Order Received</a>
                    </div>
                    <p style="clear:both; text-align: center;">Your order is now ready for pickup at the SSG Office.</p>
                </div>
                </div>`;
            });

            orderContainer.innerHTML = orderHTML;
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
    }
    function displayCompleted() {
        fetch('get_completed.php')
        .then(response => response.json())
        .then(cartItems => {
            let orderContainer = document.getElementById('completed-content');
            if (!cartItems || cartItems.length === 0) {
                orderContainer.innerHTML = '<div class="no-prod"> <h3>Nothing to see here yet</h3> </div>';
                return;
            }

            let orderHTML = '';

            // Group cart items by order_id
            let orders = {};
            cartItems.forEach(item => {
                if (!orders[item.order_id]) {
                    orders[item.order_id] = [];
                }
                orders[item.order_id].push(item);
            });

            // Build HTML for each order
            Object.keys(orders).forEach(orderId => {
                let totalCost = 0; // Initialize total cost for the current order
                orderHTML += `<div class="prod">`;
                orders[orderId].forEach(item => {
                    let subtotal = item.price * item.quantity;
                    totalCost += subtotal;

                    orderHTML += `
                        <div class="prod-details">
                            <img src="${item.product_img}" alt="">
                            <div class="prod-details-desc">
                                <h3>${item.product_name}</h3>
                                <p>Variation: <strong>${item.color}, ${item.size}</strong></p>
                                <p>Qty: <strong>${item.quantity}</strong> <span class="price" style="float: right">₱${item.price}.00</span></p>
                            </div>
                        </div>`;
                });

                // Add order total and additional details
                orderHTML += `
                
                    <div class="order-total" style="float: right">Order Total: <span>₱${totalCost}.00</span></div><br>
                    <div class="prod-actions">
                        <p>Your order has been successfully received.</p>
                        <div class="actions">
                            <a href="">Rate</a>
                            <a href="">Buy again</a>
                        </div>
                    </div>
                </div>`;
            });

            orderContainer.innerHTML = orderHTML;
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
    }

    displayCart();
    displayProcessing();
    displayReceive();
    displayCompleted();
});
