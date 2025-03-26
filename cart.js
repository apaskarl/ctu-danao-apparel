let userID;
document.addEventListener("DOMContentLoaded", function () {
    let productStock = null;

    let addCartLinks = document.querySelectorAll(".add-cart");

    
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
    getUserID().then((id) => {
        userID = id;
        // Now that userID is available, you can proceed with your logic that relies on it
        // For example, you can call functions or perform actions that require userID here
        console.log(userID); // Just for testing
    }).catch((error) => {
        console.error('Error getting user ID:', error);
    });

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const productCategory = urlParams.get('product_category');
    let emptyCart = false;

    function getCategoryID(productCategory, callback) {
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const response = JSON.parse(this.responseText);
                if (response.error) {
                    console.error("Error:", response.error);
                    console.log("Response:", response);
                } else {
                    categoryName = response.category;
                    callback(categoryName);
                }
            }
        };
        let url = "getCategory_id.php?product_category=" + productCategory;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    addCartLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            let stockElement = document.getElementById("stocks");
            let textContent = stockElement.textContent;
            let stockNumber;
            let matchResult = textContent.match(/\d+/);
            if (matchResult !== null) {
                stockNumber = parseInt(matchResult[0]);
            } else {
                stockNumber = 0;
            }
            let selectedSize = document.querySelector(".size-btn.selected");
            let selectedColor = document.querySelector(".color-btn.selected");
            let quantity = parseInt(document.querySelector(".quantity").value);
            getCategoryID(productCategory, function(categoryName) {
                if (categoryName === "Accessories") {
                    if (stockNumber === 0) {
                        showFailedMessage("Out of stock");
                    } else {
                        let product = products[0];
                        product.inCart = quantity;
                        product.stock = stockNumber;
                        let num = document.querySelector(".quantity");
                        const numQty = parseInt(num.value);
                        if (!product.name) {
                            product.name = "Sample Product Name";
                        }
                        getUserID().then(userID => {
                            fetch('user_cart.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    product: product,
                                    userID: userID,
                                    numQty: numQty
                                }),
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        console.log('Product saved:', data.message);
                                    } else {
                                        console.error('Error saving product:', data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        }).catch(error => {
                            console.error('Error getting user ID:', error);
                        });
                        console.log(product.stock);
                        showSuccessMessage(product.name, product.size, product.color);
                    }
                } else {
                    if (!selectedSize && !selectedColor) {
                        showFailedMessage("Select a color and size");
                    } else if (!selectedSize) {
                        showFailedMessage("Please select a size");
                    } else if (!selectedColor) {
                        showFailedMessage("Please select a color");
                    } else if (stockNumber === 0) {
                        showFailedMessage("Out of stock");
                    } else {
                        let product = products[0];
                        let num = document.querySelector(".quantity");
                        const numQty = parseInt(num.value);
                        product.size = selectedSize.getAttribute("data-size");
                        product.color = selectedColor.getAttribute("data-color");
                        product.stock = stockNumber;
                        emptyCart = true;
                        console.log(emptyCart);
                        if (!product.name) {
                            product.name = "Sample Product Name";
                        }
                        getUserID().then(userID => {
                            fetch('user_cart.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    product: product,
                                    userID: userID,
                                    numQty: numQty
                                }),
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        console.log('Product saved:', data.message);
                                    } else {
                                        console.error('Error saving product:', data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        }).catch(error => {
                            console.error('Error getting user ID:', error);
                        });
                        console.log(typeof (product.stock));
                        showSuccessMessage(product.name, product.size, product.color);
                    }
                }
            });

        });
    });

    function displayCart() {
        fetch('get_cart_items.php')
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
                    <td><input type="checkbox" class="select-all-checkbox"></td>
                    <td></td>
                    <td>Product</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Unit Price</td>
                    <td>Qty</td>
                    <td>Subtotal</td>
                    <td></td>
                </tr>`;
    
                cartTableBody.innerHTML = '';
                let totalCost = 0;
    
                cartItems.forEach((item, index) => {
                    let subtotal = item.price * item.quantity;
                    productStock = item.stock;
                    totalCost += subtotal;
    
                    cartTableBody.innerHTML += `
                        <tr>
                            <td><input type="checkbox" class="item-checkbox"></td>
                            <td><img src="${item.product_img}" /></td>
                            <td>${item.product_name}</td>
                            <td>${item.size}</td>
                            <td>${item.color}</td>
                            <td>${item.stock}</td>
                            <td>₱${item.price}.00</td>
                            <td>
                                <div class="qty-container">
                                <ion-icon class="decrease" name="remove-outline"></ion-icon>
                                <p class="quantity">${item.quantity}</p>
                                <ion-icon class="increase" name="add-outline"></ion-icon>
                                </div>
                            </td>
                            <td class="subtotal">₱${subtotal}.00</td>
                            <td><ion-icon class="delete" name="trash-outline"></ion-icon></ion-icon></td>
                        </tr>`;
                });
                cartTableBody.innerHTML += `
                <tr>
                    <td></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td class="checkout-btn">
                        <a href="#" id="checkout-link" ><span>Check Out</span></a>
                    </td>
                </tr>`;
                const stockColumnIndex = 5;
                const headerCell = cartTableHeader.querySelector(`tr > td:nth-child(${stockColumnIndex + 1})`);
                headerCell.style.display = 'none';
    
                const rows = cartTableBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    cells[stockColumnIndex].style.display = 'none';
                });
                attachEventListeners();
                attachSelectAllListener();
            })
            .catch(error => {
                console.error('Error fetching cart items:', error);
            });
    }

    let totalEmpty = 0;

    function attachSelectAllListener() {
        const selectAllCheckbox = document.querySelector('.select-all-checkbox');
        selectAllCheckbox.addEventListener('change', () => {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateTotalBasedOnChecked();
        });
    }

    function attachEventListeners() {
        const parentElement = document.getElementById('parentElementId');
        parentElement.addEventListener('click', (event) => {
            const target = event.target;

            if (target.classList.contains('increase')) {
                let totalCost = 0;
                const parentRow = target.closest('tr');
                const productName = parentRow.querySelector('td:nth-child(3)').textContent;
                const size = parentRow.querySelector('td:nth-child(4)').textContent;
                const color = parentRow.querySelector('td:nth-child(5)').textContent;
                const stock = parseInt(parentRow.querySelector('td:nth-child(6)').textContent);
                const price = parseFloat(parentRow.querySelector('td:nth-child(7)').textContent.replace('₱', '').replace('.00', ''));
                const quantitySpan = parentRow.querySelector('.quantity');
                let quantityValue = parseInt(quantitySpan.textContent);
                if (quantityValue < stock) {
                    quantityValue++;
                } else {
                    showFailedMessage(stock + " is the available stock");
                }

                quantitySpan.textContent = quantityValue;

                const subtotalElement = parentRow.querySelector('td:nth-child(9)');
                const subtotal = price * quantityValue;
                subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;

                const subtotalElements = document.querySelectorAll('td.subtotal');

                subtotalElements.forEach(subtotalElement => {
                    const subtotalValue = parseFloat(subtotalElement.textContent.replace('₱', '').replace('.00', ''));

                    totalCost += subtotalValue;
                });
                var totalVal = document.querySelector('.total');
                totalVal.innerHTML = "₱" + totalCost + ".00";

                getUserID()
                    .then(userId => {
                        const formData = {
                            user_id: userId,
                            product_name: productName,
                            size: size,
                            color: color,
                            price: price,
                            quantity: quantityValue,
                            subtotal: price * quantityValue
                        };

                        return updateCartInDatabase(formData);
                    })
                    .then(response => {

                    })
                    .catch(error => {
                        console.error('Error updating cart in the database:', error);
                    });
                updateTotalQuantity();
            } else if (target.classList.contains('decrease')) {
                let totalCost = 0;
                const parentRow = target.closest('tr');
                const productName = parentRow.querySelector('td:nth-child(3)').textContent;
                const size = parentRow.querySelector('td:nth-child(4)').textContent;
                const color = parentRow.querySelector('td:nth-child(5)').textContent;
                const price = parseFloat(parentRow.querySelector('td:nth-child(7)').textContent.replace('₱', '').replace('.00', ''));
                const quantitySpan = parentRow.querySelector('.quantity');
                let quantityValue = parseInt(quantitySpan.textContent);
                if (quantityValue > 1) {
                    quantityValue--;
                    quantitySpan.textContent = quantityValue;
                } else {
                    quantitySpan.textContent = quantityValue;
                }

                const subtotalElement = parentRow.querySelector('td:nth-child(9)');
                const subtotal = price * quantityValue;
                subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;

                const subtotalElements = document.querySelectorAll('td.subtotal');

                subtotalElements.forEach(subtotalElement => {
                    const subtotalValue = parseFloat(subtotalElement.textContent.replace('₱', '').replace('.00', ''));

                    totalCost += subtotalValue;
                });
                var totalVal = document.querySelector('.total');
                totalVal.innerHTML = "₱" + totalCost + ".00";

                getUserID()
                    .then(userId => {
                        const formData = {
                            user_id: userId,
                            product_name: productName,
                            size: size,
                            color: color,
                            price: price,
                            quantity: quantityValue,
                            subtotal: price * quantityValue
                        };

                        return updateCartInDatabase(formData);
                    })
                    .then(response => {

                    })
                    .catch(error => {
                        console.error('Error updating cart in the database:', error);
                    });
                updateTotalQuantity();
            } else if (target.classList.contains('delete')) {

                const parentRow = target.closest('tr');
                const imageElements = parentRow.querySelectorAll('img');
                const productName = parentRow.querySelector('td:nth-child(3)').textContent;
                const size = parentRow.querySelector('td:nth-child(4)').textContent;
                const color = parentRow.querySelector('td:nth-child(5)').textContent;
                const price = parseFloat(parentRow.querySelector('td:nth-child(7)').textContent.replace('₱', '').replace('.00', ''));
                const quantitySpan = parentRow.querySelector('.quantity');
                let quantityValue = parseInt(quantitySpan.textContent);
                let imageUrl, finalUrl;
                let baseUrl = "http://localhost/ctudanaoapparel/";
                const subtotalValue = parseFloat(parentRow.querySelector('.subtotal').textContent.replace('₱', ''));
                const totalElement = document.querySelector('.total');
                let totalCost = parseFloat(totalElement.textContent.replace('₱', ''));

                totalCost -= subtotalValue;
                totalElement.textContent = `₱${totalCost.toFixed(2)}`;
                totalEmpty = totalCost;


                imageElements.forEach(image => {
                    imageUrl = image.src;
                    finalUrl = imageUrl.replace(baseUrl, "");
                    console.log(finalUrl);
                    getUserID()
                        .then(userId => {
                            const deleteData = {
                                user_id: userId,
                                product_img: finalUrl,
                                product_name: productName,
                                size: size,
                                color: color,
                                price: price,
                                quantity: quantityValue,
                            };

                            return deleteCartInDatabase(deleteData);
                        })
                        .then(response => {
                            console.log('Item deleted successfully in the database.');

                        })
                        .catch(error => {
                            console.error('Error updating cart in the database:', error);
                        });
                    let cartTableHeader = document.querySelector('#cart thead');
                    let cartTableBody = document.querySelector('#cart tbody');
                    if (totalEmpty === 0) {
                        cartTableHeader.innerHTML = '';
                        cartTableBody.innerHTML = '<tr><td colspan="7" class="cartIsEmpty">Your cart is empty</td></tr>';
                        return;
                    }
                });

                parentRow.remove();
                updateTotalQuantity();
            }else if (target.closest('.checkout-btn')) {
                handleCheckout();
            }

            // Update total based on checked items
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTotalBasedOnChecked);
            });
        });
    }
    
    function updateTotalBasedOnChecked() {
        let totalCost = 0;
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const parentRow = checkbox.closest('tr');
                const subtotalElement = parentRow.querySelector('td.subtotal');
                const subtotalValue = parseFloat(subtotalElement.textContent.replace('₱', '').replace('.00', ''));
                totalCost += subtotalValue;
            }
        });
        const totalElement = document.querySelector('.total');
        totalElement.textContent = `₱${totalCost}.00`;
    }

function updateTotalBasedOnChecked() {
    let totalCost = 0;
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            const parentRow = checkbox.closest('tr');
            const subtotalElement = parentRow.querySelector('td.subtotal');
            const subtotalValue = parseFloat(subtotalElement.textContent.replace('₱', '').replace('.00', ''));
            totalCost += subtotalValue;
        }
    });
    const totalElement = document.querySelector('.total');
    totalElement.textContent = `₱${totalCost}.00`;
}

function handleCheckout() {
    const checkedItems = [];
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            const parentRow = checkbox.closest('tr');
            const userIDs = userID; // Assuming userID is globally accessible
            const productName = parentRow.querySelector('td:nth-child(3)').textContent;
            const size = parentRow.querySelector('td:nth-child(4)').textContent;
            const color = parentRow.querySelector('td:nth-child(5)').textContent;
            const price = parseFloat(parentRow.querySelector('td:nth-child(7)').textContent.replace('₱', '').replace('.00', ''));
            const quantityValue = parseInt(parentRow.querySelector('.quantity').textContent);
            const subtotal = price * quantityValue;
            const productImgSrc = parentRow.querySelector('img').src; // Get the src attribute of the img element

            // Trim the base URL
            const baseUrl = "http://localhost/ctudanaoapparel/";
            const productImg = productImgSrc.replace(baseUrl, "");

            checkedItems.push({
                user_id: userIDs,
                product_name: productName,
                size: size,
                color: color,
                price: price,
                quantity: quantityValue,
                subtotal: subtotal,
                product_img: productImg // Include product_img in the checkedItems array
            });
        }
    });

    if (checkedItems.length > 0) {
        // Store the checked items in sessionStorage
        sessionStorage.setItem('checkedItems', JSON.stringify(checkedItems));
        window.location.href = 'checkout.php';
    } else {
        showFailedMessage("No items selected for checkout");
    }
}

    function updateCartInDatabase(formData) {
        return fetch('update_cart_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update cart in the database.');
                }
                return response.json();
            });
    }

    function deleteCartInDatabase(deleteData) {
        return fetch('delete_cart_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(deleteData)

        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to delete cart in the database.');
                }
                console.log(deleteData);
                return response.json();
            });
    }

    function updateTotalQuantity() {
        const quantityElements = document.querySelectorAll('.quantity');
        let totalQuantity = 0;
        quantityElements.forEach(element => {
            totalQuantity += parseInt(element.textContent);
        });
        cartCnt = totalQuantity;
        let cartSpan = document.querySelector('.cart span');
        cartSpan.textContent = totalQuantity;
    }
    

    function showSuccessMessage(name, size, color) {
        const toast = document.querySelector('.toast');
        toast.innerHTML = `
            <div class="toast-content">
                <ion-icon name="checkmark-outline" class="check success"></ion-icon>
                <div class="message">
                    <span class="text text-1">Successfully added to cart</span>
                </div>
                <div class="progress success"></div>
            </div>
        `;
        toast.classList.add("active");
        const progress = document.querySelector('.progress');
        progress.classList.add("active");

        setTimeout(() => {
            toast.classList.remove("active");
        }, 2000);

        setTimeout(() => {
            progress.classList.remove("active");
        }, 2300);
    }

    function showFailedMessage(message) {
        const toast = document.querySelector('.toast');
        toast.innerHTML = `
            <div class="toast-content">
                <ion-icon name="close-outline" class="check failed"></ion-icon>
                <div class="message">
                    <span class="text text-1"></span>
                </div>
                <div class="progress failed"></div>
            </div>
        `;
        const text1Span = toast.querySelector('.text-1');
        text1Span.textContent = message;

        toast.classList.add("active");
        const progress = document.querySelector('.progress');
        progress.classList.add("active");

        setTimeout(() => {
            toast.classList.remove("active");
        }, 2000);

        setTimeout(() => {
            progress.classList.remove("active");
        }, 2300);
    }
    
    updateTotalQuantity();
    displayCart();
});