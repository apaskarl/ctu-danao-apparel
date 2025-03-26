let intro = document.querySelector('.intro');
let logo = document.querySelector('.intro-logo-header');
let logoSpan = document.querySelectorAll('.intro-logo');

window.addEventListener('DOMContentLoaded', () => {
    setTimeout(()=>{
        logoSpan.forEach((span, index)=>{
            setTimeout(()=>{
                span.classList.add('active');
            }, (index + 1) * 400)
        });

        setTimeout(()=>{
            logoSpan.forEach((span, index)=>{
                setTimeout(()=>{
                    span.classList.remove('active');
                    span.classList.add('fade');
                }, (index + 1) * 50)
            })
        }, 2000);

        setTimeout(()=>{
            intro.style.top = '-100vh';
        }, 1700);
    })
})

// let intro = document.querySelector('.intro');
// let logo = document.querySelector('.intro-logo-header');
// let logoSpan = document.querySelectorAll('.intro-logo');

// window.addEventListener('DOMContentLoaded', () => {
//     if (!localStorage.getItem('animationShown')) {
//         setTimeout(() => {
//             logoSpan.forEach((span, index) => {
//                 setTimeout(() => {
//                     span.classList.add('active');
//                 }, (index + 1) * 400)
//             });

//             setTimeout(() => {
//                 logoSpan.forEach((span, index) => {
//                     setTimeout(() => {
//                         span.classList.remove('active');
//                         span.classList.add('fade');
//                     }, (index + 1) * 50)
//                 })
//             }, 2000);

//             setTimeout(() => {
//                 intro.style.top = '-100vh';
//             }, 1700);

//             localStorage.setItem('animationShown', true);
//         })
//     } else {
//         intro.style.display = 'none';
//     }
// })