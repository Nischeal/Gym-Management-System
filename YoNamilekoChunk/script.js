const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
// const switchBtn = document.getElementById('switch');
// const switchbackBtn = document.getElementById('switch');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

// switchbackBtn.addEventListener('click', () => {
//     console.log('Switch button clicked');
//     container.classList.add("active");
//     console.log(container.classList);
// });
// switchBtn.addEventListener('click', () => {
//     console.log('Switch button clicked');
//     container.classList.remove("active");
//     console.log(container.classList);
// });

