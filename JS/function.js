// Toggle Password on & off
function togglePassword() {
    let passwordField = document.getElementById("password");
    if (passwordField.type === "password", "confirm-password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}

// document.getElementById("signup-form").addEventListener("submit", function(event) {
//     event.preventDefault();
//     alert("Sign-up successful!");
// });

// Expand Search Bar
function expandSearch() {
    document.getElementById('search-container').classList.toggle('expanded');
}

// Shrink when clicking outside
document.addEventListener('click', function(event) {
    let searchContainer = document.getElementById('search-container');
    if (!searchContainer.contains(event.target)) {
        searchContainer.classList.remove('expanded');
    }
});



