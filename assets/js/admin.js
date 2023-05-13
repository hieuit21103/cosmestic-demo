function showFloatForm(element, form) {
    var showFloatBtn = document.getElementById(element);
    var floatForm = document.getElementById(form);

    showFloatBtn.addEventListener("click", function() {
        floatForm.style.display = 'block';
    });
}

function sendDataToPHP(data,url) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.timeout =10000;
    xhr.ontimeout = function () {
        console.log("Timeout!");
    };
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
        }else{
            console.log(xhr.readyState);
        }
    };
    var jsonData = JSON.stringify({data: data});
    xhr.send(jsonData);
}

function addProduct(){
    var modal = document.getElementById("product-modal");

    // Get the button that opens the modal
    var btn = document.getElementById("product-modal-trigger");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
	var form = document.querySelector("form");
	form.addEventListener("product-add-submit", function(event) {
        event.preventDefault();
		form.reset();
		modal.style.display = "none";
	});
}

function deleteProduct(){
    var modal = document.getElementById("product-modal-delete");

    // Get the button that opens the modal
    var btn = document.getElementById("product-modal-delete-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("delete-close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var form = document.querySelector("form");
    form.addEventListener("product-delete-submit", function(event) {
        event.preventDefault();
        form.reset();
        modal.style.display = "none";
    });
}

function deleteOrder(){
    var modal = document.getElementById("order-modal-delete");

    // Get the button that opens the modal
    var btn = document.getElementById("order-modal-delete-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("order-delete-close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var form = document.querySelector("form");
    form.addEventListener("order-delete-submit", function(event) {
        event.preventDefault();
        form.reset();
        modal.style.display = "none";
    });
}

function deleteAccount(){
    var modal = document.getElementById("account-modal-delete");

    // Get the button that opens the modal
    var btn = document.getElementById("account-modal-delete-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("account-delete-close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var form = document.querySelector("form");
    form.addEventListener("account-delete-submit", function(event) {
        event.preventDefault();
        form.reset();
        modal.style.display = "none";
    });
}

function editAccount() {
    var modal = document.getElementById("account-modal");

    // Get the button that opens the modal
    var btn = document.getElementById("account-modal-edit-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("account-edit-close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var form = document.querySelector("form");
    form.addEventListener("account-edit-submit", function(event) {
        event.preventDefault();
        form.reset();
        modal.style.display = "none";
    });
}

function addTransport(){
    var modal = document.getElementById("transport-modal");

    // Get the button that opens the modal
    var btn = document.getElementById("transport-add-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("transport-close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var form = document.querySelector("form");
    form.addEventListener("transport-add-submit", function(event) {
        event.preventDefault();
        form.reset();
        modal.style.display = "none";
    });
}

function deleteTransport(){
    var modal = document.getElementById("transport-modal-delete");

    // Get the button that opens the modal
    var btn = document.getElementById("transport-delete-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("transport-delete-close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var form = document.querySelector("form");
    form.addEventListener("transport-delete-submit", function(event) {
        event.preventDefault();
        form.reset();
        modal.style.display = "none";
    });
}

function addtype(){
    var modal = document.getElementById("type-modal");

    // Get the button that opens the modal
    var btn = document.getElementById("type-add-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var form = document.querySelector("form");
    form.addEventListener("type-add-submit", function(event) {
        event.preventDefault();
        form.reset();
        modal.style.display = "none";
    });
}

function deletetype(){
    var modal = document.getElementById("type-modal-delete");

    // Get the button that opens the modal
    var btn = document.getElementById("type-delete-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("type-delete-close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var form = document.querySelector("form");
    form.addEventListener("type-delete-submit", function(event) {
        event.preventDefault();
        form.reset();
        modal.style.display = "none";
    });
}

