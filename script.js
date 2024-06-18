document.addEventListener('DOMContentLoaded', function () {
    let navbar = document.querySelector('.header .flex .navbar');
    let menuBtn = document.querySelector('#menu-btn');

    let profile = document.querySelector('.header .flex .profile');
    let userBtn = document.querySelector('#user-btn');
    
    menuBtn.addEventListener('click', function () {
        navbar.classList.toggle('active');
        profile.classList.remove('active');
    });
    
    userBtn.addEventListener('click', function () {
        profile.classList.toggle('active');
        //userBtn.classList.add('active');

        navbar.classList.remove('active');
    });

});

window.onscroll = () => {
    navbar.classList.remove('active');
    profile.classList.remove('active');
};
