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