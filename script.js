// HEADER HIDE / SHOW
// document.addEventListener('DOMContentLoaded', function () {
//     let lastScrollTop = 0;
//     const header = document.getElementById('main-header');
//     const filter = document.getElementById('filter');

//     window.addEventListener('scroll', function() {
//         let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

//         if (scrollTop > lastScrollTop) {
//             header.style.top = '-100px'; 
//         } else {
//             header.style.top = '0';
//         }
//         lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;

//         // Handle the sticky filter
//         let sticky = header.offsetHeight;
//         if (scrollTop > sticky) {
//             filter.classList.add('sticky');
//         } else {
//             filter.classList.remove('sticky');
//         }
//     }, false);
// });

// NAV MOBILE HIDE / SHOW
document.addEventListener('DOMContentLoaded', function () {
    let lastScrollTop = 0;
    const navMobile = document.querySelector('.nav-mobile');

    window.addEventListener('scroll', function () {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop) {
            navMobile.classList.add('hide');
        } else {
            navMobile.classList.remove('hide');
        }
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }, false);
});

// FILTER STICKY / shop.php
window.addEventListener('scroll', function() {
    const filterDiv = document.querySelector('.filter');
    const filterBtn = document.getElementById("filterBtn");
    const sticky = filterDiv.offsetTop;
    
    if (window.pageYOffset > sticky) {
        filterDiv.classList.add('sticky');
    } else {
        filterDiv.classList.remove('sticky');
    }
});

// MENU BAR

const bar = document.getElementById('bar');
const nav = document.getElementById('navbar');
const close = document.getElementById("close");

if (bar) {
    bar.addEventListener('click', () => {
        nav.classList.add('active');
    })
}

if (close) {
    close.addEventListener("click", () => {
        nav.classList.remove("active");
    });
}

// SUB MENU

let subMenu = document.getElementById("subMenu");

function toggleMenu() {
    subMenu.classList.toggle("open-menu");
}


