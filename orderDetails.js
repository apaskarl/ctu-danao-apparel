document.addEventListener("DOMContentLoaded", function () {
    let userID;

    function getUserID() {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        userID = parseInt(xhr.responseText);
                        resolve(userID);
                    } else {
                        reject(new Error('Failed to get user ID'));
                    }
                }
            };
            xhr.open("GET", "getUser_id.php", true);
            xhr.send();
        });
    }

    function displayCart() {
        // Make an AJAX request to fetch cart items from the database
        fetch('get_order_details.php')
            .then(response => response.json())
            .then(cartItems => {
                let cartTableHeader = document.querySelector('#cart thead');
                let cartTableBody = document.querySelector('#cart tbody');
                if (!cartItems || cartItems.length === 0) {
                    cartTableHeader.innerHTML = '';
                    cartTableBody.innerHTML = '<tr><td colspan="7" class="cartIsEmpty">Your cart is empty</td></tr>';
                    return;
                }
    
                cartTableHeader.innerHTML = `
                <tr>
                    <td></td>
                    <td>Product Name</td>
                    <td>Size</td>
                    <td>Color</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Ordered Date</td>
                    <td>Subtotal</td>
                    <td>Status</td>
                </tr>`;
                
                cartTableBody.innerHTML = '';
                let totalCost = 0;
    
                cartItems.forEach((item, index) => {
                    let subtotal = item.price * item.quantity;
                    productStock = item.stock;
                    totalCost += subtotal;
    
                    // Display the cart item in the table
                    cartTableBody.innerHTML += `
                        <tr>
                            <td><img src="${item.product_img}" /></td>
                            <td>${item.product_name}</td>
                            <td>${item.size}</td>
                            <td>${item.color}</td>
                            <td>₱${item.price}.00</td>
                            <td>
                            <span class="quantity">${item.quantity}</span>
                            </td>
                            <td>${item.date}</td>
                            <td class="subtotal">₱${subtotal}.00</td>
                            <td>Pending</td>
                        </tr>`;
                });
            })
            .catch(error => {
                console.error('Error fetching cart items:', error);
            });

    }
    displayCart(); // This will log "Hello from file1!" to the console
});