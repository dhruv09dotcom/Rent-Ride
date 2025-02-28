//===============// 
// User Dropdown //
//===============//
document.addEventListener("DOMContentLoaded", function () {
    const userMenu = document.getElementById("userMenu");
    const dropdownMenu = document.getElementById("dropdownMenu");

    userMenu.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevents the event from bubbling to the window
        dropdownMenu.classList.toggle("show");
    });

    // Close dropdown if clicked outside
    window.addEventListener("click", function (event) {
        if (!event.target.closest("#userMenu")) {
            dropdownMenu.classList.remove("show");
        }
    });
});

//==================// 
// Sidebar Dropdown //
//==================//
document.addEventListener("DOMContentLoaded", function () {
    let dropdowns = document.querySelectorAll(".dropdown-toggle");

    dropdowns.forEach((dropdown) => {
        dropdown.addEventListener("click", function (event) {
            event.preventDefault();
            let parent = this.parentElement;
            
            // Close all other dropdowns
            document.querySelectorAll(".dropdown").forEach((item) => {
                if (item !== parent) {
                    item.classList.remove("active");
                }
            });

            // Toggle the clicked dropdown
            parent.classList.toggle("active");
        });
    });
});