// error handler
window.onload = _ => {
    setTimeout(function () {
        var errors = document.querySelectorAll(".error-handle");
        if(errors)
        errors.forEach( error =>  error.remove() );
    }, 3000);

    
    var selectProductImage = document.querySelector(".select-product-image");
    if (selectProductImage) {
        selectProductImage.onclick = function (e) {
            if (e.target.getAttribute("data-clicked") === "true") return null;
            else e.target.setAttribute("data-clicked", "true");
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
            xhttp.open("GET", "/seller/products/getImages", true);
            xhttp.send();   
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

    // var colorPicker = document.getElementById("color-picker");
    // if (colorPicker){
    //     var saveButton = colorPicker.querySelector(".save-color");
    //     console.log(saveButton);
    //     saveButton.onclick = function (e) {
    //         e.preventDefault();
    //         var colorName = colorPicker.querySelector(".color-name").value;
    //         var colorInput = colorPicker.querySelector(".color-picker-input").value;
    //         var csrf_token = document.querySelector("meta[name=csrf-token]").getAttribute("content");
            
    //         if (colorName && colorInput && csrf_token) {
    //             var xhr = new XMLHttpRequest();
    //             xhr.onreadystatechange = function() {
    //                 if (this.readyState == 4 && this.status == 200) {
    //                     console.log(JSON.parse(this.responseText));
    //                 }
    //             }
    //             xhr.open("POST", "/color/add", true);
    //             xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    //             xhr.setRequestHeader("X-XSRF-TOKEN", csrf_token);
    //             xhr.send(`color_name=${colorName}&color_hex=${colorInput}`);
    //         }   
    //     }

    // }


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

}