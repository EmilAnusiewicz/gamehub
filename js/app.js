const coverInput = document.getElementById("cover");
const preview = document.getElementById("preview");

if (coverInput && preview) {

    coverInput.addEventListener("change", function () {

        const file = this.files[0];

        if (file) {

            const reader = new FileReader();

            reader.onload = function () {

                preview.src = reader.result;
                preview.style.display = "block";

            };

            reader.readAsDataURL(file);
        }

    });

}

const searchInput =
document.getElementById("searchInput");

const searchResults =
document.getElementById("searchResults");

if(searchInput && searchResults){

    searchInput.addEventListener(
        "keyup",
        function(){

            let query = this.value.trim();

            if(query.length < 2){

                searchResults.innerHTML = "";
                

                return;
            }

            fetch(
                "search_ajax.php?q=" +
                encodeURIComponent(query)
            )

            .then(response => response.text())

           .then(data => {


    searchResults.innerHTML = data;

    if(data.trim() !== ""){

        searchResults.classList.add("active");

    }else{

        searchResults.classList.remove("active");

    }

})

            .catch(error => {

                console.error(error);

            });

        }
    );

    document.addEventListener(
        "click",
        function(e){

            if(
                !searchInput.contains(e.target) &&
                !searchResults.contains(e.target)
            ){

                searchResults.classList.remove(
    "active"
);

            }

        }
    );

}
let deleteUrl = "";

const modal =
document.getElementById("confirmModal");
const confirmBtn =
document.getElementById("confirmDelete");

const cancelBtn =
document.getElementById("cancelDelete");

document

.querySelectorAll(".delete-btn")

.forEach(btn => {

    btn.addEventListener(
        "click",
        function(e){

            e.preventDefault();

            deleteUrl =
            this.href;

            modal.classList.add(
                "show"
            );

        }
    );

});

if(confirmBtn){

    confirmBtn.addEventListener(
        "click",
        function(){

            window.location =
            deleteUrl;

        }
    );

}

if(cancelBtn){

    cancelBtn.addEventListener(
        "click",
        function(){

            modal.classList.remove("show");
deleteUrl = "";

        }
    );

}