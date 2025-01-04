const sideLinks = document.querySelectorAll('.sidebar .side-menu li a:not(.logout)');

sideLinks.forEach(item => {
    const li = item.parentElement;
    item.addEventListener('click', () => {
        sideLinks.forEach(i => {
            i.parentElement.classList.remove('active');
        })
        li.classList.add('active');
    })
});

const menuBar = document.querySelector('.content nav .bx.bx-menu');
const sideBar = document.querySelector('.sidebar');

menuBar.addEventListener('click', () => {
    sideBar.classList.toggle('close');
});

const searchBtn = document.querySelector('.content nav form .form-input button');
const searchBtnIcon = document.querySelector('.content nav form .form-input button .bx');
const searchForm = document.querySelector('.content nav form');

searchBtn.addEventListener('click', function (e) {
    if (window.innerWidth < 576) {
        e.preventDefault;
        searchForm.classList.toggle('show');
        if (searchForm.classList.contains('show')) {
            searchBtnIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchBtnIcon.classList.replace('bx-x', 'bx-search');
        }
    }
});

window.addEventListener('resize', () => {
    if (window.innerWidth < 768) {
        sideBar.classList.add('close');
    } else {
        sideBar.classList.remove('close');
    }
    if (window.innerWidth > 576) {
        searchBtnIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
});

const toggler = document.getElementById('theme-toggle');

toggler.addEventListener('change', function () {
    if (this.checked) {
        document.body.classList.add('dark');
    } else {
        document.body.classList.remove('dark');
    }
});

// added

// Get references to the body and the toggle button
const body = document.body;
const darkModeToggle = document.getElementById("darkModeToggle");

// Function to apply the theme
function applyTheme(theme) {
    if (theme === "dark") {
        body.classList.add("dark");
    } else {
        body.classList.remove("dark");
    }
}

// Function to toggle the theme
function toggleDarkMode() {
    const isDark = body.classList.contains("dark");
    const newTheme = isDark ? "light" : "dark";

    // Apply the new theme and save it to localStorage
    applyTheme(newTheme);
    localStorage.setItem("theme", newTheme);
}

// Load the theme from localStorage on page load
const savedTheme = localStorage.getItem("theme") || "light"; // Default to light theme
applyTheme(savedTheme);

// Add event listener for the toggle button
darkModeToggle.addEventListener("click", toggleDarkMode);
