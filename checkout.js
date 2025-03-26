let userID;
const finalArray = [];
const stringItem = [];
document.addEventListener("DOMContentLoaded", function () {
    const baseUrl = "http://localhost/ctudanaoapparel/";

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

    getUserID()
    .then((id) => {
        userID = id;
        // Proceed with logic that relies on userID
        console.log(userID); // Just for testing

        // Call functions that rely on userID
        displayCart();
        orderBtn();
    })
    .catch((error) => {
        console.error('Error getting user ID:', error);
    });

    function getLastOrder() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "get_last_order_id.php",
                type: "GET",
                success: function(data) {
                    const orderID = parseInt(data.trim());
                    resolve(orderID);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    reject(error);
                }
            });
        });
    }

    function displayCart() {
        // Retrieve checked items from sessionStorage
        const checkedItems = JSON.parse(sessionStorage.getItem('checkedItems'));
        console.log(checkedItems);

        if (!checkedItems || checkedItems.length === 0) {
            // If no items are found or the array is empty, display a message
            let cartTableBody = document.querySelector('#cart tbody');
            cartTableBody.innerHTML = '<tr><td colspan="7" class="cartIsEmpty">Your checkout is empty</td></tr>';
            return;
        }

        // If items are found, proceed to display them in the table
        let cartTableHeader = document.querySelector('#cart thead');
        let cartTableBody = document.querySelector('#cart tbody');

        cartTableHeader.innerHTML = `
            <tr>
                <td></td>
                <td></td>
                <td>Product</td>
                <td></td>
                <td></td>
                <td>Unit Price</td>
                <td>Qty</td>
                <td>Subtotal</td>
            </tr>`;
        cartTableBody.innerHTML = '';
        let totalCost = 0;

        checkedItems.forEach((item, index) => {
            let subtotal = item.price * item.quantity;
            totalCost += subtotal;
            
            // Generate a unique identifier for each row
            const rowId = `row_${index}`;
            console.log(item.product_name);
            
            // Display the cart item in the table
            cartTableBody.innerHTML += `
                <tr id="${rowId}" class="tRow">
                    <td></td>
                    <td><img src="${item.product_img}" /></td> 
                    <td>${item.product_name}</td>
                    <td>${item.size}</td>
                    <td>${item.color}</td>
                    <td>₱${item.price}.00</td>
                    <td>
                        <span class="quantity">${item.quantity}</span>
                    </td>
                    <td class="subtotal">₱${subtotal}.00</td>
                </tr>`;
            
            // Now you can access elements specific to each row using the rowId
            const row = document.getElementById(rowId);
            const productNameElement = row.querySelector('td:nth-child(3)');
            const sizeElement = row.querySelector('td:nth-child(4)');
            const colorElement = row.querySelector('td:nth-child(5)');
            const quantityElement = row.querySelector('.quantity');
            const priceElement = row.querySelector('td:nth-child(6)');
            const imgElement = row.querySelector('img');
            
            // Check if all necessary elements are present for each row
            if (productNameElement && sizeElement && colorElement && quantityElement && priceElement && imgElement) {
                // Set data in the elements
                sizeElement.textContent = item.size;
                colorElement.textContent = item.color;
                quantityElement.textContent = item.quantity;
                priceElement.textContent = `₱${item.price}.00`;

            } else {
                console.error("Some elements are missing in the table row:", row);
            }
        });

        cartTableBody.innerHTML += `
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right" class="basketTotalText">Total</td>
                <td class="total">₱${totalCost}.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="checkout-btn">
                    <a href="#" id="orderBtn"><span>Place Order</span></a>
                </td>
            </tr>`;
    }

    function showConfirmationMessage() {
    const background = document.querySelector('.background');
    const alertBox = document.querySelector('.alert-box');

    // Show the background and alert box
    background.style.opacity = '1';
    background.style.pointerEvents = 'auto';
    alertBox.style.opacity = '1';
    alertBox.style.pointerEvents = 'auto';
}

function hideConfirmationMessage() {
    const background = document.querySelector('.background');
    const alertBox = document.querySelector('.alert-box');

    // Hide the background and alert box
    background.style.opacity = '0';
    background.style.pointerEvents = 'none';
    alertBox.style.opacity = '0';
    alertBox.style.pointerEvents = 'none';
}

document.getElementById('confirmYes').addEventListener('click', function () {
    hideConfirmationMessage();
    // Proceed with the order
    placeOrder();
});

document.getElementById('confirmNo').addEventListener('click', function () {
    hideConfirmationMessage();
    // Do nothing, keep the user on the page
});

function placeOrder() {
    const checkedItems = JSON.parse(sessionStorage.getItem('checkedItems'));

    if (!checkedItems || checkedItems.length === 0) {
        console.error('No items to order.');
        return;
    }

    const itemsToOrder = {
        userID: userID,
        items: checkedItems
    };

    $.ajax({
        url: "order.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(itemsToOrder),
        success: function (response) {
            console.log("Order placed successfully:", response);
            // Redirect the user to the success page
            window.location.href = 'user/purchase.php';
            // Clear checkedItems after successful order
            sessionStorage.removeItem('checkedItems');
        },
        error: function (xhr, status, error) {
            console.error('Failed to place order:', error);
        }
    });
}

function orderBtn() {
    const orderBtn = document.getElementById('orderBtn');
    orderBtn.addEventListener('click', function (event) {
        event.preventDefault();
        showConfirmationMessage();
    });
}

orderBtn();


    displayCart();
    orderBtn();
});
