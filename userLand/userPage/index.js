const taskInput = document.getElementById('task-input');
const addTaskButton = document.getElementById('add-task');
const taskList = document.getElementById('task-list');

addTaskButton.addEventListener('click', () => {
    const taskText = taskInput.value.trim();
    if (taskText !== "") {
        const taskItem = document.createElement('li');
        taskItem.classList.add('task-item');
        taskItem.innerHTML = `
            <input type="checkbox" >
            <label>${taskText}</label>
            <button class="delete-btn">Delete</button>
        `;
        taskList.appendChild(taskItem);
        taskInput.value = "";
        const checkbox = taskItem.querySelector('input[type="checkbox"]');
        checkbox.addEventListener('change', () => {
            taskItem.classList.toggle('completed');
        });
        const deleteButton = taskItem.querySelector('.delete-btn');
        deleteButton.addEventListener('click', () => {
            taskList.removeChild(taskItem);
        });
    }
});
taskInput.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        addTaskButton.click();
    }
});



// replaces signin/signup button




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


document.addEventListener("DOMContentLoaded", function () {
    const renewButton = document.querySelector(".renew-button");
    const planSection = document.getElementById("plan");

    if (renewButton && planSection) {
        renewButton.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default jump
            planSection.style.display = "block"; // Show the section
            planSection.scrollIntoView({ behavior: "smooth" }); // Smooth scroll
        });
    }
});


