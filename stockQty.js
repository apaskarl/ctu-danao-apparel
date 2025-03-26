document.addEventListener("DOMContentLoaded",function(){
    var outOfStock = null;
    var a_qty = null;
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const productCategory = parseInt(urlParams.get('product_category'));
    const product_a_id = parseInt(urlParams.get('product_id'));
    var product_Identification = null;
    var size = null;
    var color = null;
    const stockElement = document.getElementById("stocks");

    function getStockAccessories(productId) {
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();
    
        // Configure the AJAX request
        xhr.open("GET", "product-accessories-stock.php?product_id=" + productId, true);
    
        // Define the function to handle the response
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Parse the JSON response
                var response = JSON.parse(xhr.responseText);
                a_qty = parseInt(response.quantity);
                // Check if there was an error
                if (response.error) {
                    console.error("Error:", response.error);
                } else {
                    stockElement.style.display = 'block';
                    stockElement.textContent = "STOCK : " + response.quantity;
                }
            }
        };
        xhr.send();
    }

    function fetchStock(productId, id1, id2, fetchBySize) {
        const xhttp = new XMLHttpRequest();
    
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const response = JSON.parse(this.responseText);
                stock = response.stock; // Assuming the response contains the stock data
                outOfStock = stock;
                updateStock(stock); // Update the stock information on the webpage
            }
        };
    
        // Adjust the URL based on your server setup and endpoint for fetching stock
        let url = "product-variant-stock.php?productId=" + productId;
        if (fetchBySize) {
            url += "&sizeId=" + id1 + "&colorId=" + id2;
        } else {
            url += "&sizeId=" + id2 + "&colorId=" + id1;
        }
        xhttp.open("GET", url, true);
        xhttp.send();
    }
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
    let sizesCnt = 0;
    let colorCnt = 0;
    let selectedColorBtn = null;
    let selectedSizeBtn = null;


    getCategoryID(productCategory, function(categoryName) {
        if (categoryName === "Accessories") {
            getStockAccessories(product_a_id);
        }
    });

function updateStock(stock) {
    if (sizesCnt === 1 && colorCnt === 1) {
        stockElement.style.display = 'block';
        if (stock !== undefined && stock !== null) {
            if (stock > 0) {
                stockElement.style.color = 'black';
                stockElement.textContent = "STOCK : " + stock;
            } else {
                stockElement.textContent = "Out of stock";
                stockElement.style.color = 'red';
            }
        } else if (stock === null) {
            stockElement.style.color = 'red';
            stockElement.textContent = "Out of stock";
        }
    }
}

    let sizeButtons = document.querySelectorAll(".size-btn");
    sizeButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            if (button === selectedSizeBtn) {
                // If the same button is clicked again, do nothing
                return;
            }else{
                a=1;
                num.value = a;
            }
            sizeButtons.forEach(function (btn) {
                btn.classList.remove("selected");
            });
            const sizeID = button.getAttribute("data-size-id");
            const product_ID = button.getAttribute("data-product-id");
            selectedSizeBtn = button;
            size = parseInt(sizeID);
            product_Identification = parseInt(product_ID);
            button.classList.add("selected");
            sizesCnt = 1;
            getCategoryID(productCategory);
            updateStock();
            twoSelectedBtn()
        });
    });
    let colorButtons = document.querySelectorAll(".color-btn");
    colorButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            if (button === selectedColorBtn) {
                return;
            }else{
                a=1;
                num.value = a;
            }
            colorButtons.forEach(function (btn) {
                btn.classList.remove("selected");
            });
            const colorID = button.getAttribute("data-color-id");
            selectedColorBtn = button;
            color = parseInt(colorID);
            button.classList.add("selected");
            a=1;
            num.value = a;
            colorCnt = 1;
            updateStock();
            twoSelectedBtn()
        });
    });
    function twoSelectedBtn(){
        if(selectedColorBtn && selectedSizeBtn){
            const fetchBySize = true;
                fetchStock(product_Identification, size, color, fetchBySize);
        }
    }

    const plus = document.querySelector(".plus");
    const minus = document.querySelector(".minus");
    const num = document.querySelector(".quantity");
    let a = 1;

    plus.addEventListener ("click", () => {
        if (categoryName === "Accessories") {
            if (a < a_qty) {
                a++;
                num.value = a;
            } else {
                showMessage("Out of stock");
            }
        } else {
            if (a < parseInt(outOfStock)) {
                a++;
                num.value = a;
            } else {
                if (!selectedColorBtn || !selectedSizeBtn) {
                    showMessage("Select a color and size");
                } else {
                    showMessage("Out of stock");
                }
            }
        }
    });

    minus.addEventListener ("click", () => {
        if (a > 1) a--;
        num.value = a;
    });

    function showMessage(message) {
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
});