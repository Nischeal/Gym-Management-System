// const taskInput = document.getElementById('task-input');
// const addTaskButton = document.getElementById('add-task');
// const taskList = document.getElementById('task-list');

// addTaskButton.addEventListener('click', () => {
//     const taskText = taskInput.value.trim();
//     if (taskText !== "") {
//         const taskItem = document.createElement('li');
//         taskItem.classList.add('task-item');
//         taskItem.innerHTML = `
//             <input type="checkbox" >
//             <label>${taskText}</label>
//             <button class="delete-btn">Delete</button>
//         `;
//         taskList.appendChild(taskItem);
//         taskInput.value = "";
//         const checkbox = taskItem.querySelector('input[type="checkbox"]');
//         checkbox.addEventListener('change', () => {
//             taskItem.classList.toggle('completed');
//         });
//         const deleteButton = taskItem.querySelector('.delete-btn');
//         deleteButton.addEventListener('click', () => {
//             taskList.removeChild(taskItem);
//         });
//     }
// });
// taskInput.addEventListener("keypress", function(event) {
//     if (event.key === "Enter") {
//         event.preventDefault();
//         addTaskButton.click();
//     }
// });



// // replaces signin/signup button




// Function to toggle visibility of content sections
function loadContent(sectionId) {
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        if (section.id === sectionId) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
}


// // document.addEventListener("DOMContentLoaded", function () {
// //     const renewButton = document.querySelector(".renew-button");
// //     const planSection = document.getElementById("plan");

// //     if (renewButton && planSection) {
// //         renewButton.addEventListener("click", function (event) {
// //             event.preventDefault(); // Prevent default jump
// //             planSection.style.display = "block"; // Show the section
// //             planSection.scrollIntoView({ behavior: "smooth" }); // Smooth scroll
// //         });
// //     }
// // });





document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent form submission
        // Custom validation logic
        if (validateLoginForm()) {
            this.submit(); // Manually submit if validation passes
        }
    });

    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent form submission
        // Custom validation logic
        if (validateRegisterForm()) {
            this.submit(); // Manually submit if validation passes
        }
    });

    function validateLoginForm() {
        // Example: Ensure email and password are filled
        let email = document.querySelector('#loginForm input[name="email"]').value.trim();
        let password = document.querySelector('#loginForm input[name="password"]').value.trim();
        
        if (email === '' || password === '') {
            alert('Please fill in all fields');
            return false;
        }
        return true;
    }

    function validateRegisterForm() {
        // Example: Ensure all registration fields are filled
        let email = document.querySelector('#registerForm input[name="email"]').value.trim();
        let password = document.querySelector('#registerForm input[name="password"]').value.trim();
        let confirmPassword = document.querySelector('#registerForm input[name="confirm_password"]').value.trim();

        if (email === '' || password === '' || confirmPassword === '') {
            alert('Please fill in all fields');
            return false;
        }
        if (password !== confirmPassword) {
            alert('Passwords do not match');
            return false;
        }
        return true;
    }
});
