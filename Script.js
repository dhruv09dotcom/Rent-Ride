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

//=======================// 
// User Profile Details //
//=====================//
document.addEventListener("DOMContentLoaded", function () {
    const profileForm = document.querySelector(".profile-form");

    profileForm.addEventListener("input", function () {
        document.getElementById("display-full-name").textContent = document.getElementById("full-name").value || "N/A";
        document.getElementById("display-email").textContent = document.getElementById("email").value || "N/A";
        document.getElementById("display-phone").textContent = document.getElementById("phone").value || "N/A";
        document.getElementById("display-dob").textContent = document.getElementById("dob").value || "N/A";
        document.getElementById("display-address").textContent = document.getElementById("address").value || "N/A";
        document.getElementById("display-city").textContent = document.getElementById("city").value || "N/A";
    });
});