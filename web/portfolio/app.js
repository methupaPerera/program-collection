// Changing the showcase items structure

const headerShowcase = document.querySelector('#showcase .container');

if (window.innerWidth < 768) {
    headerShowcase.innerHTML = `
        <div class="info">
            <h3>
                <span>Welcome</span>
                <span> to my</span>
                <span> space !</span>
            </h3>
            <h1>I'm Methupa</h1>
            <h2>Frontend Developer</h2>
            <a href="#contact" class="contact btn-lg btn-primary">Contact me <i class="bi bi-envelope-fill"></i></a>
            <div class="contact-info">
                <a href="https://facebook.com/methupaB" target="_blank"><i class="bi bi-facebook"></i></a>
                <a href="https://instagram.com/_methupa" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="https://github.com/methupaPerera" target="_blank"><i class="bi bi-github"></i></a>
                <a href="https://wa.me/+94755260309" target="_blank"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>`;
}