/* =============== toogle icon navbar =================*/

let menuIcon = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');

// menuIcon.onclick = () => {
//     menuIcon.classList.toogle('bx-x');
//     navbar.classList.toogle('active');
// };

menuIcon.addEventListener('click', ()=>{
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('active');
});



/* =============== scroll selection active link =================*/
let sections = document.querySelectorAll('section');
let navLinks = document.querySelectorAll('header nav a');

window.onscroll = () =>{
    sections.forEach(sec => {
        let top = window.scrollY;
        let offset = sec.offsetTop - 150;
        let height  = sec.offsetHeight;
        let id = sec.getAttribute('id');

        if(top >= offset && top < offset + height){
            navLinks.forEach(links =>{
                links.classList.remove('active');
                document.querySelector('header nav a[href*=' + id +']').classList.add('active')
            });
        };
    });
/* =============== Sticky nav bar =================*/
    let header = document.querySelector('header');

    header.classList.toggle('sticky', window.scrollY > 100);

/* ======= remove toggle icon & navbar when chick navbar ======*/
    menuIcon.classList.remove('bx-x');
    navbar.classList.remove('active');

};
/* =============== Scroll reveal =================*/
ScrollReveal({ 
    reset: true,
    distance: '80px',
    duration: 2000,
    delay: 300 
});

ScrollReveal().reveal('.home-content, .heading' ,  { origin: 'top' });

ScrollReveal().reveal('.home-img, .skill-container, .certificate-box, .contact-container',  { origin: 'bottom' });

ScrollReveal().reveal('.home-content h1, .about-img',  { origin: 'left' });

ScrollReveal().reveal('.home-content p, .about-content',  { origin: 'right' });


// auto type character
var typed = new Typed(".multiple-text", {
    strings: ["trained","experienced"],
    typeSpeed: 100,
    backSpeed: 100,
    backDelay: 1000,
    loop: true

});

// rate button section
const btn = document.querySelector('.btn1')
const rts = document.querySelector('.rate-section')
const items = document.querySelectorAll('.item')
const submit = document.querySelector('.submit')
const successPopup = document.querySelector('.success-popup')
const closebtn = document.querySelectorAll('.close')

btn.addEventListener('click', ()=>{
    if(rts.className === "rate-section"){
        rts.classList.add('rate-section-slide')
    }
    else{
        rts.classList.remove('rate-section-slide')
    }
});

items.forEach(item=>{
    item.addEventListener('click', ()=>{
        items.forEach(item=>{
            item.classList.remove('active')
        })
        item.classList.add('active')
    })
});

submit.addEventListener('click', ()=>{
        successPopup.classList.add('success-popup-slide')
        items.classList.remove('success-popup-slide')
});

closebtn.forEach(item=>{
    item.addEventListener('click',()=>{
        closebtn.forEach(item=>{
            successPopup.classList.remove('success-popup-slide')
            rts.classList.remove('rate-section-slide')
        })
    })
});

// // contact us data link
// const scriptURL = 'https://script.google.com/macros/s/AKfycbwJNLMLBaiVUnRzESupxoIVXyoPwxZDqxUnp-74KoeY7YduM9tOPqtn5INu9-0CeYJq/exec'
// const form = document.forms['Contactform']

// form.addEventListener('submit', e => {
//   e.preventDefault()
//   fetch(scriptURL, { method: 'POST', body: new FormData(form)})
//   .then(response => alert("Thank you! I will contact you soon" ))
//   .then(() => {  window.location.reload(); })
//   .catch(error => console.error('Error!', error.message))
// })