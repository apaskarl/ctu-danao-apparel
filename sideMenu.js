const menuBtnMobile = document.getElementById('menuBtnMobile');
const menuBtn = document.getElementById('menuBtn');
const menuWrap = document.getElementById('menuWrap');
const closeBtn = document.getElementById('closeBtn');
const overlay = document.getElementById('overlay');

function openMenu() {
    menuWrap.classList.add('active');
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeMenu() {
    menuWrap.classList.remove('active');
    overlay.style.display = 'none';
    document.body.style.overflow = '';
}

menuBtnMobile.addEventListener('click', function () {
    if (menuWrap.classList.contains('active')) {
        closeMenu();
    } else {
        openMenu();
    }
});

menuBtn.addEventListener('click', function () {
    if (menuWrap.classList.contains('active')) {
        closeMenu();
    } else {
        openMenu();
    }
});

closeBtn.addEventListener('click', closeMenu);

document.addEventListener('click', function (event) {
    if (!menuWrap.contains(event.target) && event.target !== menuBtn && event.target !== menuBtnMobile) {
        closeMenu();
    }
});