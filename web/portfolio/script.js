// Changing theme according to even/odd date

function datePicker() {
    let date = new Date().getDay();
    if (date % 2 == 0) {
        return 'BLUE';
    } else {
        return 'GREEN';
    }
}

function imageChanger() {
    let day = datePicker();

    const logo = document.querySelector('.logo');
    const favicon = document.querySelector('.favicon');
    const aboutImg = document.querySelector('.about-img');

    if (day == 'BLUE') {
        logo.src = 'images/blue-theme/logo.png';
        favicon.href = 'images/blue-theme/favicon.png';
        aboutImg.src = 'images/blue-theme/about-img.svg';
    } else {
        logo.src = 'images/green-theme/logo.png';
        favicon.href = 'images/green-theme/favicon.png';
        aboutImg.src = 'images/green-theme/about-img.svg';
    }
}

function colorChanger() {
    let day = datePicker();
    let root = document.querySelector(':root');

    if (day == 'BLUE') {
        root.style.setProperty('--color-primary', '#00a8e8');
        root.style.setProperty('--color-primary-transparent', '#00a8e840');
    } else {
        root.style.setProperty('--color-primary', '#01d449');
        root.style.setProperty('--color-primary-transparent', '#01d44940');
    }

    imageChanger();
}

colorChanger();

// Activating navbar shadow effect when scrolling

const navbar = document.querySelector('nav');

window.addEventListener('scroll', () => {
    if (window.scrollY > 0) {
        navbar.style.boxShadow = '0 0 1rem var(--color-dark)';
    } else {
        navbar.style.boxShadow = 'none';
    }
});

// Contact form functionalities
/*
const contactBtn = document.querySelector('.contact');
const formCloseBtn = document.querySelector('.close');

const contactForm = document.querySelector('.contact-form');
const showcase = document.querySelector('#showcase');
const headerCircle = document.querySelector('header > div.circle');

contactBtn.addEventListener('click', () => {
    contactForm.style.right = '0';
    contactForm.style.boxShadow = '0 0 2rem var(--color-dark)';
    showcase.classList.add('opacity');   
    navbar.classList.add('opacity');   
    headerCircle.classList.add('opacity');   
});

formCloseBtn.addEventListener('click', () => {
    contactForm.style.right = '-50rem';
    contactForm.style.boxShadow = 'none';
    showcase.classList = '';
    navbar.classList = '';
    headerCircle.classList = 'circle circle-one';
});
*/

// Revealling elements on scroll

window.addEventListener('scroll', reveal);
function reveal() {
    let reveals = document.querySelectorAll('.reveal');
    for (let i = 0; i < reveals.length; i++) {
        let windowHeight = window.innerHeight;
        let revealTop = reveals[i].getBoundingClientRect().top;
        let revealPoint = 60;

        if (revealTop < windowHeight - revealPoint) {
            reveals[i].classList.add('active');
        } else {
            reveals[i].classList.remove('active');
        }
    }
}

// Opening skills when clicking arrow down

const downArrow = document.querySelectorAll('.down-arrow');
const skillBody = document.querySelectorAll('.body');

let opened = 0;

function skillController(order) {
    if (opened == 0) {
        skillBody[order].style.display = 'flex';
        downArrow[order].textContent = 'keyboard_arrow_up';
        opened = 1;
    } else {
        skillBody[order].style.display = 'none';
        downArrow[order].textContent = 'keyboard_arrow_down';
        opened = 0;
    }
}

downArrow[0].addEventListener('click', () => {
    skillController(0);
});

downArrow[1].addEventListener('click', () => {
    skillController(1);
});

downArrow[2].addEventListener('click', () => {
    skillController(2);
});

downArrow[3].addEventListener('click', () => {
    skillController(3);
});

// Responsive design for navigation items

const openNav = document.getElementById('open-nav');
const closeNav = document.getElementById('close-nav');
const navItems = navbar.children[0].children[1];

openNav.addEventListener('click', () => {
    openNav.style.display = 'none';
    closeNav.style.display = 'block';
    navItems.style.scale = '1';
});

closeNav.addEventListener('click', () => {
    openNav.style.display = 'block';
    closeNav.style.display = 'none';
    navItems.style.scale = '0';
});