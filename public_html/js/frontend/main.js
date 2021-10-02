var collapse = Array.from(document.querySelectorAll(".sidebar-menu"));
collapse.forEach(function (collapser) {
    collapser.onclick = function () {
        
        collapser.querySelector(collapser.getAttribute("data-target")).classList.toggle("show");
    }
});

function makeToast (messages, status) {
    var toastContainer = document.querySelector(".toast-container");
    var toasts = Array.from(toastContainer.querySelectorAll(".toast"));
    messages.forEach(message => {
        var toastclone = toasts[0].cloneNode(true);
        if (status) {
            var toastHeader = toastclone.querySelector(".toast-header");
            toastHeader.classList.remove("bg-danger");
            toastHeader.classList.add("bg-success");
            toastHeader.querySelector("strong").textContent = "success !!";
        }
        toastclone.querySelector(".toast-body").textContent = message;
        toastContainer.appendChild(toastclone);
        var newToast = new bootstrap.Toast(toastclone);
        newToast.show();
    });
}

/*
    takes tow arguments 
        the first is the id of the element
        the second is the value to set
*/
function syncInputVal(ele, val){
    var element = document.querySelector(ele);
    element.textContent = val;
}

var minPriceRange = document.getElementById("minPriceRange");
var minPriceRangeSM = document.getElementById("minPriceRangeSM");
var maxPriceRange = document.getElementById("maxPriceRange");
var maxPriceRangeSM = document.getElementById("maxPriceRangeSM");

if (minPriceRange)
minPriceRange.oninput = function ()  {
    syncInputVal("#minPriceLable small", this.value);
}
if (maxPriceRange)
maxPriceRange.oninput = function ()  {
    syncInputVal("#maxPriceLable small", this.value);
}
if (minPriceRangeSM)
minPriceRangeSM.oninput = function ()  {
    syncInputVal("#minPriceLableSM small", this.value);
}
if (maxPriceRangeSM)
maxPriceRangeSM.oninput = function ()  {
    syncInputVal("#maxPriceLableSM small", this.value);
}

var jsBtnMinusBtns = Array.from(document.querySelectorAll(".js-btn-minus"));
var jsBtnPlusBtns = Array.from(document.querySelectorAll(".js-btn-plus"));
if (jsBtnMinusBtns !== []) {
    jsBtnMinusBtns.forEach(BtnMinus => {
        BtnMinus.onclick = function () {
            var qty = this.parentElement.parentElement.querySelector("input").value;
            var aftersubtraction = qty--;
            var that = this;
            if (aftersubtraction > 1) {
                setTimeout(() => {
                    var cartRowId = that.getAttribute("data-cart");
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (this.readyState === 4 && this.status === 200) {
                            var result = JSON.parse(this.responseText);
                            that.parentElement.parentElement.querySelector("input").value = result.newQty;
                        }
                    }
                    xhr.open("POST", `/cart/${cartRowId}/decrease`, false);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector("meta[name=csrf-token]").getAttribute("content"));
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.send();
                }, 300);
            }
        }
    });
}
if (jsBtnPlusBtns !== []) {
    jsBtnPlusBtns.forEach(BtnPlus => {
        BtnPlus.onclick = function () {
            var qty = this.parentElement.parentElement.querySelector("input").value;
            var aftersubtraction = qty++;
            var that = this;
            if (aftersubtraction < 12) {
                setTimeout(() => {
                    var cartRowId = that.getAttribute("data-cart");
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (this.readyState === 4 && this.status === 200) {
                            var result = JSON.parse(this.responseText);
                            that.parentElement.parentElement.querySelector("input").value = result.newQty;
                        }
                    }
                    xhr.open("POST", `/cart/${cartRowId}/increase`, false);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector("meta[name=csrf-token]").getAttribute("content"));
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.send();
                }, 300);
            }
        }
    });
}

var addToCartForm = document.querySelector(".add-to-cart-form");
if (addToCartForm) {
    addToCartForm.onsubmit = function (e) {
        if (addToCartForm) {
            var csrfToken = addToCartForm.querySelector("input[name=_token]").value,
                product_id = addToCartForm.querySelector("input[name=product_id]").value,
                size = addToCartForm.querySelector("select[name=size]").value,
                color = addToCartForm.querySelector("select[name=color]").value,
                qty = addToCartForm.querySelector("input[name=qty]").value;
            e.preventDefault();
            let errors = [];
            if (size == 0) {
                errors.push("please select your size");
            }
            if (color == 0) {
                errors.push("please select product color");
            }
            if (qty == 0 || qty > 12) {
                errors.push("the quantity must be between 1 - 12");
            }
            if (errors.length === 0) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        var result = JSON.parse(this.responseText);
                        if (!result.status) {
                            if (result.not_auth) {
                                window.location.href = "/auth/login";
                            }
                        } else {
                            makeToast(result.msg, result.status);
                            var essenceCartBtnSpan = document.querySelector("#essenceCartBtn span");
                            essenceCartBtnSpan.textContent = result.cartCount;
                        }
                    }
                };
                xhr.open("POST", "/cart/store", true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
                xhr.setRequestHeader("Accept", "application/json");
                xhr.send(`product_id=${product_id}&size=${size}&color=${color}&qty=${qty}`);
            } else {
                makeToast(errors, false);
            }
        }
    }
}

var deleteFromCartBtns = Array.from(document.querySelectorAll(".delete-from-cart"));
if (deleteFromCartBtns !== []) {
    deleteFromCartBtns.forEach(btn => {
        btn.onclick = function (e) {
            e.preventDefault();
            var href = this.getAttribute("href");
            var that = this;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var result = JSON.parse(this.responseText);
                    if (result.status) {
                        if (result.cartCount) {
                            that.parentElement.parentElement.remove();
                        } else {
                            var tableContainer = document.querySelector(".table-responsive");
                            tableContainer.removeChild(tableContainer.querySelector("table"));
                            tableContainer.innerHTML = '<div class="alert alert-info fs-5 fw-bold text-center"> لا توجد منتجات فى العربة <a href="/" class="text-primary fs-6"> الاستمرار فى التسوق </a> </div>';
                        }
                        var essenceCartBtnSpan = document.querySelector("#essenceCartBtn span");
                        essenceCartBtnSpan.textContent = result.cartCount;
                    }
                }
            }
            xhr.open("POST", href, false);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector("meta[name=csrf-token]").getAttribute("content"));
            xhr.setRequestHeader("Accept", "application/json");
            xhr.send();
        }
    });
}

var presents_modal_btn = document.getElementById("presents_modal_btn");
if (presents_modal_btn) {
    presents_modal_btn.onclick = function () {
        if (this.getAttribute("data-clicked") == "false"){
            this.setAttribute("data-clicked", "true");
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var result = JSON.parse(this.responseText);
                    if (result.status) {
                        var presents_modal_body = document.querySelector("#presents_modal .modal-body .row");
                        var presents = result.data.presents;
                        for (let i = 0; i < presents.length; i++) {
                            const present = presents[i];
                            var presents_modal_body_card = document.querySelector("#presents_modal .modal-body .card");
                            var presents_modal_body_card_clone = presents_modal_body_card.cloneNode(true);
                            presents_modal_body_card_clone.classList.remove("d-none");
                            var img = result.data.images[`${present.present_product_id}`][0];
                            presents_modal_body_card_clone.querySelector("img").setAttribute("src", `/images/products/sellers${img.path}`);
                            presents_modal_body_card_clone.querySelector(".card-title a").textContent = result.data.presents_products[present.present_product_id][0].name + " X " + present.presents_count;
                            presents_modal_body_card_clone.querySelector(".card-title a").href = `/products/${present.present_product_id}/show`;
                            
                            var selectSize = presents_modal_body_card_clone.querySelector(".select-size");
                            
                            var productSizes = result.data.sizes[present.present_product_id];
                            for (let v = 0; v < productSizes.length; v++) {
                                const size = productSizes[v];
                                var option = document.createElement("option");
                                option.value = size.id;
                                option.textContent = size.size;
                                if (size.id == present.default_size)
                                option.setAttribute("selected", "selected");
                                selectSize.name = `presents_sizes[${present.present_product_id}]`;
                                selectSize.appendChild(option);
                            }
                            
                            var selectColor = presents_modal_body_card_clone.querySelector(".select-color");
                            var productColors = result.data.colors[present.present_product_id];
                            for (let v = 0; v < productColors.length; v++) {
                                const color = productColors[v];
                                var option = document.createElement("option");
                                option.value = color.id;
                                option.textContent = color.color_name;
                                if (color.id == present.default_color)
                                option.setAttribute("selected", "selected");
                                selectColor.name = `presents_colors[${present.present_product_id}]`;
                                selectColor.appendChild(option);
                            }
                            presents_modal_body.appendChild(presents_modal_body_card_clone);
                        }
                    }
                }
            }
        }
        xhr.open("GET", `/checkout/getPresents`, false);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector("meta[name=csrf-token]").getAttribute("content"));
        xhr.setRequestHeader("Accept", "application/json");
        xhr.send();
    }
}

var editAccount = document.querySelector(".edit-account");
if (editAccount) {
    editAccount.onclick = function () {
        if (this.getAttribute("data-click") === "read") {
            this.setAttribute("data-click", "edit");
            var accountForm = document.querySelector(".account-form");
            var inputs = Array.from(accountForm.querySelectorAll("input"));
            inputs.forEach(input => {
                input.removeAttribute("readonly");
            });
            accountForm.querySelector("select").removeAttribute("disabled");
            accountForm.querySelector(".nice-select").classList.remove("disabled");
            accountForm.querySelector("button[type=submit]").classList.remove("d-none");
        } else {
            this.setAttribute("data-click", "read");
            var accountForm = document.querySelector(".account-form");
            var inputs = Array.from(accountForm.querySelectorAll("input"));
            inputs.forEach(input => {
                input.setAttribute("readonly", "readonly");
            });
            accountForm.querySelector("select").setAttribute("disabled", "disabled");
            accountForm.querySelector(".nice-select").classList.add("disabled");
            accountForm.querySelector("button[type=submit]").classList.add("d-none");
        }
    }
}