const button = document.querySelector(".add-cart"),
toast = document.querySelector(".toast"),
closeIcon = document.querySelector(".close"),
progress = document.querySelector(".progress");

button.addEventListener("click", () => {
    toast.classList.add("active");
    progress.classList.add("active");

    setTimeout(() => {
        toast.classList.remove("active");
    }, 2000);

    setTimeout(() => {
        progress.classList.remove("active");
    }, 2300);
});

closeIcon.addEventListener("click", () => {
    toast.classList.remove("active");
    
    setTimeout(() => {
        progress.classList.remove("active");
    }, 300);
});