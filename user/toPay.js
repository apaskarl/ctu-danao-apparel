document.addEventListener("DOMContentLoaded", function() {
    // TO PAY CONTENT
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
    
                let orders = {};
                cartItems.forEach(item => {
                    if (!orders[item.order_id]) {
                        orders[item.order_id] = [];
                    }
                    orders[item.order_id].push(item);
                });
    
                // Get the order IDs in reverse order
                let orderIds = Object.keys(orders).reverse();
    
                orderIds.forEach(orderId => {
                    let totalCost = 0;
                    orderHTML += `<div class="prod to-pay">`;
                    orderHTML += `<p class="orderid">Order ID: ${orderId}</p>`;
                    orders[orderId].forEach((item, index) => {
                        let subtotal = item.price * item.quantity;
                        totalCost += subtotal;
    
                        orderHTML += `
                            <div class="prod-details">
                                <img src="../${item.product_img}" alt="">
                                <div class="prod-details-desc">
                                    <h3>${item.product_name}</h3>
                                    <p>Variation: ${item.color}, ${item.size}</p>
                                    <p>Qty: ${item.quantity} <span class="subtotal" style="float: right">₱${subtotal}.00</span></p>
                                </div>
                            </div>
                            `;
                    });
    
                    orderHTML += `
                        <div class="prod-actions">
                            <p>Please make your payment at the SSG Office to start the processing of your order.</p>
                            <p class="order-total">Order Total: <span>₱${totalCost}.00</span></p>
                        </div>
                        <div class="cancel">
                            <a href="" class="cancel_btn" data-order-id="${orderId}">Cancel Order</a>
                        </div>
                    </div>`;
                });
    
                orderContainer.innerHTML = orderHTML;
    
                // Attach event listeners to all cancel buttons
                document.querySelectorAll('.cancel_btn').forEach(button => {
                    button.addEventListener('click', function(event){
                        event.preventDefault(); // Prevent the default anchor behavior
                        let orderId = parseInt(this.getAttribute('data-order-id'));
                        let items = orders[orderId];
    
                        // Check if there are items in the order
                        if (items && items.length > 0) {
                            // Create data object to send in AJAX request
                            let requestData = {
                                orderId: orderId,
                                items: items.map(item => ({
                                    orderId: orderId,
                                    size: item.size || '',
                                    color: item.color || '',
                                    productId: item.prod_id,
                                    quantity:item.quantity,
                                    price: item.price,
                                    productImg:item.product_img,
                                    userID:item.user_id
                                }))
                            };
                            console.log("Request Data:", requestData);
                            // Send AJAX request
                            fetch('order_cancel.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(requestData)
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log("Cancel request successful:", data);
                                window.location.reload();
                                // Handle successful cancellation, e.g., update UI
                            })
                            .catch(error => {
                                console.error('Error with cancel request:', error);
                            });
                        } else {
                            console.log("No items to cancel for order ID:", orderId);
                        }
    
                    });
                });
    
            })
            .catch(error => {
                console.error('Error fetching cart items:', error);
            });
    }

    // PROCESSING CONTENT
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
    
            let orders = {};
            cartItems.forEach(item => {
                if (!orders[item.order_id]) {
                    orders[item.order_id] = [];
                }
                orders[item.order_id].push(item);
            });
    
            // Get the keys as an array and reverse it
            let reversedKeys = Object.keys(orders).reverse();
    
            // Iterate over the reversed keys
            reversedKeys.forEach(orderId => {
                let totalCost = 0; 
                orderHTML += `<div class="prod">`;
                orderHTML += `<p class="orderid">Order ID: ${orderId}</p>`;
                orders[orderId].forEach(item => {
                    let subtotal = item.price * item.quantity;
                    totalCost += subtotal;
    
                    orderHTML += `
                        <div class="prod-details">
                            <img src="../${item.product_img}" alt="">
                            <div class="prod-details-desc">
                                <h3>${item.product_name}</h3>
                                <p>Variation: ${item.color}, ${item.size}</p>
                                <p>Qty: ${item.quantity} <span class="subtotal" style="float: right">₱${subtotal}.00</span></p>
                            </div>
                        </div>
                        `;
                });
                
                orderHTML += `
                        <div class="prod-actions">
                            <p>The SSG are now processing your order/orders. Please give us some time.</p>
                            <p class="order-total">Order Total: <span>₱${totalCost}.00</span></p>
                        </div>
                    </div>
                `;
            });
    
            orderContainer.innerHTML = orderHTML;
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
    }

    // TO RECEIVE CONTENT
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
    
            let orders = {};
            cartItems.forEach(item => {
                if (!orders[item.order_id]) {
                    orders[item.order_id] = [];
                }
                orders[item.order_id].push(item);
            });
    
            // Get the keys as an array and reverse it
            let reversedKeys = Object.keys(orders).reverse();
    
            // Iterate over the reversed keys
            reversedKeys.forEach(orderId => {
                let totalCost = 0; 
                orderHTML += `<div class="prod">`;
                orderHTML += `<p class="orderid">Order ID: ${orderId}</p>`;
                orders[orderId].forEach(item => {
                    let subtotal = item.price * item.quantity;
                    totalCost += subtotal;
    
                    orderHTML += `
                        <div class="prod-details">
                            <img src="../${item.product_img}" alt="">
                            <div class="prod-details-desc">
                                <h3>${item.product_name}</h3>
                                <p>Variation: ${item.color}, ${item.size}</p>
                                <p>Qty: ${item.quantity} <span class="subtotal" style="float: right">₱${subtotal}.00</span></p>
                            </div>
                        </div>
                        `;
                });
    
                orderHTML += `
                    <div class="prod-actions">
                        <p>Your order is now ready for pickup at the SSG Office.</p>
                        <p class="order-total">Order Total: <span>₱${totalCost}.00</span></p>
                    </div>
                </div>`;
            });
    
            orderContainer.innerHTML = orderHTML;
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
    }
    

    // COMPLETED CONTENT
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
    
            let orders = {};
            cartItems.forEach(item => {
                if (!orders[item.order_id]) {
                    orders[item.order_id] = [];
                }
                orders[item.order_id].push(item);
            });
    
            // Get the keys as an array and reverse it
            let reversedKeys = Object.keys(orders).reverse();
    
            // Iterate over the reversed keys
            reversedKeys.forEach(orderId => {
                let totalCost = 0; 
                orderHTML += `<div class="prod">`;
                orderHTML += `<p class="orderid">Order ID: ${orderId}</p>`;
                orders[orderId].forEach(item => {
                    let subtotal = item.price * item.quantity;
                    totalCost += subtotal;
                    
                    orderHTML += `
                        <div class="prod-details">
                            <img src="../${item.product_img}" alt="">
                            <div class="prod-details-desc">
                                <h3>${item.product_name}</h3>
                                <p>Variation: ${item.color}, ${item.size}</p>
                                <p>Qty: ${item.quantity} <span class="subtotal" style="float: right">₱${subtotal}.00</span></p>
                            </div>
                        </div>
                        `;
                });
    
                orderHTML += `
                    <div class="prod-actions">
                        <p>Your order has been successfully received.</p>
                        <p class="order-total">Order Total: <span>₱${totalCost}.00</span></p>
                    </div>
                </div>`;
            });
    
            orderContainer.innerHTML = orderHTML;
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
    }
    

    // CANCELLED CONTENT
    function displayCancelled() {
        fetch('get_cancel.php')
        .then(response => response.json())
        .then(cartItems => {
            let orderContainer = document.getElementById('cancelled-content');
            if (!cartItems || cartItems.length === 0) {
                orderContainer.innerHTML = '<div class="no-prod"> <h3>Nothing to see here yet</h3> </div>';
                return;
            }
    
            let orderHTML = '';
    
            let orders = {};
            cartItems.forEach(item => {
                if (!orders[item.order_id]) {
                    orders[item.order_id] = [];
                }
                orders[item.order_id].push(item);
            });
    
            // Reverse the order of the keys
            let reversedOrderIds = Object.keys(orders).reverse();
    
            reversedOrderIds.forEach(orderId => {
                let totalCost = 0; 
                orderHTML += `<div class="prod">`;
                orderHTML += `<p class="orderid">Order ID: ${orderId}</p>`;
                orders[orderId].forEach(item => {
                    let subtotal = item.price * item.quantity;
                    totalCost += subtotal;
                    
                    orderHTML += `
                        <div class="prod-details">
                            <img src="../${item.product_img}" alt="">
                            <div class="prod-details-desc">
                                <h3>${item.product_name}</h3>
                                <p>Variation: ${item.color}, ${item.size}</p>
                                <p>Qty: ${item.quantity} <span class="subtotal" style="float: right">₱${subtotal}.00</span></p>
                            </div>
                        </div>
                        `;
                });
    
                orderHTML += `
                    <div class="prod-actions">
                        <p>Your order has been cancelled.</p>
                        <p class="order-total">Order Total: <span>₱${totalCost}.00</span></p>
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
    displayCancelled();
});
