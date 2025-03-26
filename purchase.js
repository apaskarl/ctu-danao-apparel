document.addEventListener("DOMCONTENTLOADED",function(){
/* 
var itemsFromDatabase = [
    {
        order_id: 1,
        name: "Cebu Tech University Shirt",
        variation: "Black, Medium",
        quantity: 2,
        price: 200
    },
    {
        order_id: 2,
        name: "Another Shirt",
        variation: "Blue, Large",
        quantity: 1,
        price: 150
    },
    {
        order_id: 1,
        name: "Cebu Tech University Shirt",
        variation: "Black, Medium",
        quantity: 1,
        price: 200
    }
]; */

// Function to group items by order_id and calculate total price
function groupItems(items) {
    var groupedItems = {};
    items.forEach(function(item) {
        if (!groupedItems[item.order_id]) {
            groupedItems[item.order_id] = {
                items: [],
                total: 0
            };
        }
        groupedItems[item.order_id].items.push(item);
        groupedItems[item.order_id].total += (item.quantity * item.price);
    });
    return groupedItems;
}

// Function to create HTML for each grouped item
/* function createItemHTML(item) {
    var itemHTML = '<div class="prod">';
    itemHTML += '<h4>To Pay</h4>';
    itemHTML += '<hr>';
    itemHTML += '<div class="prod-details">';
    itemHTML += '<img src="assets/images/uploads/univshirt1.jpg" alt="">';
    itemHTML += '<div class="prod-details-desc">';
    itemHTML += '<h3>' + item.name + '</h3>';
    itemHTML += '<p>Variation: ' + item.variation + '</p>';
    itemHTML += '<p>x' + item.quantity + ' <span style="float: right;">₱' + (item.quantity * item.price).toFixed(2) + '</span></p>';
    itemHTML += '</div>';
    itemHTML += '</div>';
    itemHTML += '<hr>';
    itemHTML += '<h4>Order Total : <span>₱' + item.total.toFixed(2) + '</span></h4>';
    itemHTML += '<div class="prod-actions">';
    itemHTML += '<p>Please make your payment at the SSG Office to start the processing of your order.</p>';
    itemHTML += '<div class="actions">';
    itemHTML += '<a href="">Cancel Order</a>';
    itemHTML += '</div>';
    itemHTML += '</div>';
    itemHTML += '</div>';
    return itemHTML;
} */

// Call the function to group items
var groupedItems = groupItems(itemsFromDatabase);

// Get the container where dynamically generated items will be added
var orderContainer = document.getElementById('orderContainer');

// Loop through each grouped order and create HTML for each
for (var orderId in groupedItems) {
    var order = groupedItems[orderId];
    var orderHTML = '';
    order.items.forEach(function(item) {
        orderHTML += createItemHTML(item);
    });
    // Append the order HTML to the container
    orderContainer.innerHTML += orderHTML;
}

});