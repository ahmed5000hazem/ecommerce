var editUser = document.querySelector(".edit-user");
if (editUser){
    editUser.onclick = function () {
        var detailsForm = document.querySelector(".details-form");
        
        inputs = Array.from(detailsForm.querySelectorAll("input"));
        roleSellect = detailsForm.querySelector("#role");
        govSellect = detailsForm.querySelector("#country");

        inputs.forEach(input => {
            input.toggleAttribute("readonly");
        });

        roleSellect.toggleAttribute("disabled");
        govSellect.toggleAttribute("disabled");

        detailsForm.querySelector("button[type=submit]").classList.toggle("d-none");

    }
}

var selectProductColors = Array.from(document.querySelectorAll(".color .select-product-color"));
if (selectProductColors){
    selectProductColors.forEach(selectProductColor => {
        selectProductColor.onclick = function () {
            this.classList.toggle("active");
        };
    });
}

var selectProductImage = document.querySelector(".select-product-image");
if (selectProductImage) {
    selectProductImage.onclick = function (e) {
        if (e.target.getAttribute("data-clicked") === "true") return null;
        else e.target.setAttribute("data-clicked", "true");
        
        console.log(selectProductImage);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText);
                var card = document.querySelector(".modal-body-content");
                for (const image of data.images) {
                    var cardClone = card.cloneNode(true);
                    cardClone.querySelector(".card").classList.remove("d-none");
                    var imagePath = image;
                    var imgName = image.split("/");
                    imgName = imgName[imgName.length - 1];
                    cardClone.querySelector("img").setAttribute("src", "/"+data.disk+ data.path+"/"+imgName);
                    cardClone.querySelector(".card-title").textContent = imgName;
                    cardClone.querySelector("input[type=checkbox]").value = "/"+data.disk+ data.path+"/"+imgName;
                    cardClone.querySelector("input[type=checkbox]").setAttribute("id", imgName);
                    cardClone.querySelector("input[type=checkbox]").value = imgName;
                    cardClone.querySelector("label").setAttribute("for", imgName);
                    var modalBodyContent = document.querySelector(".modal-body-container");
                    modalBodyContent.appendChild(cardClone);
                }
                card.remove();

                var selectProductImagesModalCards =  Array.from(document.querySelectorAll(".select-product-images-modal .card"));
                selectProductImagesModalCards.forEach( (card) => {
                    card.onclick = function () {
                        if (this.querySelector("input[type=checkbox]").hasAttribute("checked")) this.querySelector("input[type=checkbox]").removeAttribute("checked");
                        else this.querySelector("input[type=checkbox]").setAttribute("checked", "checked");
                    }
                });

            }
        };
        xhttp.open("GET", "/admin/products/getImages", true);
        xhttp.send();
    }
}

var item_value_disc_value = document.querySelector("input[name=item_value_disc_value]");
    if (item_value_disc_value) {
        item_value_disc_value.oninput = function () {
            var productPrice = document.querySelector(".product-price span");
            var priceAfterDiscValue = document.querySelector(".price-after-disc span");
            if (this.value > 0 && this.value !== null) {
                if (!item_value_disc_percent.value)
                document.querySelector(".price-after-disc-percent").classList.add("d-none");
                document.querySelector(".price-after-disc").classList.remove("d-none");
                productPrice.parentElement.classList.add("text-decoration-line-through");
                var price =  productPrice.getAttribute("data-price") - this.value;
                priceAfterDiscValue.textContent = price;
            } else {
                if (!item_value_disc_percent.value)
                productPrice.parentElement.classList.remove("text-decoration-line-through");
                document.querySelector(".price-after-disc-percent").classList.remove("d-none");
                var price =  productPrice.getAttribute("data-price");
                priceAfterDiscValue.textContent = price;
            }
        } 
    }
    var item_value_disc_percent = document.querySelector("input[name=item_value_disc_percent]");
    if (item_value_disc_percent) {
        item_value_disc_percent.oninput = function () {
            var productPrice = document.querySelector(".product-price span");
            var priceAfterDiscPercent = document.querySelector(".price-after-disc-percent span");
            if (this.value > 0 && this.value !== null) {
                if (!item_value_disc_value.value)
                document.querySelector(".price-after-disc").classList.add("d-none");
                document.querySelector(".price-after-disc-percent").classList.remove("d-none");
                productPrice.parentElement.classList.add("text-decoration-line-through");
                var price =  productPrice.getAttribute("data-price") - (this.value / 100) * productPrice.getAttribute("data-price");
                priceAfterDiscPercent.textContent = price;
            } else {
                if (!item_value_disc_value.value)
                productPrice.parentElement.classList.remove("text-decoration-line-through");
                document.querySelector(".price-after-disc").classList.remove("d-none");
                var price =  productPrice.getAttribute("data-price");
                priceAfterDiscPercent.textContent = price;
            }
        } 
    }