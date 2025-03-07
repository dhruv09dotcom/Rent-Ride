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

//======================// 
// User Profile Details //
//======================//
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

//=====================// 
// Car Details Section //
//=====================//
function showTab(tabName) {
    // Remove active class from all tab content
    document.querySelectorAll(".car-tab-content").forEach(tab => tab.classList.remove("active"));
    
    // Add active class to the selected tab content
    document.getElementById(tabName).classList.add("active");
    
    // Remove active class from all tab buttons
    document.querySelectorAll(".car-tab").forEach(button => button.classList.remove("active"));
    
    // Add active class to the clicked tab button
    document.querySelector(`[onclick="showTab('${tabName}')"]`).classList.add("active");
}

//==================================// 
// Cancel Booking and Print Invoice //
//==================================//
function cancelBooking() {
    if (confirm("Are you sure you want to cancel this booking?")) {
        alert("Booking has been canceled.");
        document.querySelector(".status").innerHTML = "Cancelled";
        document.querySelector(".status").style.color = "red";
        document.querySelector(".status").style.borderColor = "red";
    }
}

function printInvoice() {
    var printContents = document.querySelector(".my-bookings").innerHTML;
    var originalContents = document.body.innerHTML;
    
    document.body.innerHTML = "<html><head><title>Invoice</title></head><body>" + printContents + "</body></html>";
    window.print();
    document.body.innerHTML = originalContents;
    location.reload(); // Reload page to restore original content
}