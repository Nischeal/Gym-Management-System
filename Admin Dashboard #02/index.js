const sideLinks = document.querySelectorAll('.sidebar .side-menu li:not(.logout)'); // Exclude logout

sideLinks.forEach(item => {
    item.addEventListener('click', () => {
        sideLinks.forEach(i => i.classList.remove('active'));
        item.classList.add('active');

        // Extract sectionId safely (handling cases where onclick might be missing)
        const onclickAttr = item.getAttribute('onclick');
        if (onclickAttr) {
            const match = onclickAttr.match(/'([^']+)'/);
            if (match) {
                const sectionId = match[1];
                loadContent(sectionId);
            }
        }
    });
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

// context switching

function loadContent(sectionId) {
    // Get all sections
    const sections = document.querySelectorAll(".content-section");
  
    // Hide all sections
    sections.forEach(section => {
      section.style.display = "none"; // Hide all
    });
  
    // Show the selected section
    const activeSection = document.getElementById(sectionId);
    if (activeSection) {
      activeSection.style.display = "block";
    }
  }
  