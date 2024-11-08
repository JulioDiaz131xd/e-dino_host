document.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in').forEach(section => {
        observer.observe(section);
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const observerOptions = {
        threshold: 0.2,
    };

    const scrollObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            } else {
                entry.target.classList.remove('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in-scroll, .slide-left-scroll, .slide-right-scroll, .zoom-in-scroll').forEach(section => {
        scrollObserver.observe(section);
    });

    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            header.classList.add('sticky');
        } else {
            header.classList.remove('sticky');
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.querySelector('#theme-toggle');

    toggleButton.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
    });
});

window.addEventListener('DOMContentLoaded', (event) => {
    const viewer = document.getElementById('spline-viewer');
    viewer.style.position = 'relative';
    viewer.style.top = '-10px';
    viewer.style.height = 'calc(100vh - 150px)';
    viewer.style.display = 'block';
    viewer.style.margin = '0 auto'; 
});

document.addEventListener('DOMContentLoaded', function () {
    const themeCheckbox = document.querySelector('#checkbox');

    // Si la página se recarga, el estado del checkbox reflejará el tema actual
    if (document.body.classList.contains('dark-mode')) {
        themeCheckbox.checked = true;
    }

    themeCheckbox.addEventListener('change', () => {
        document.body.classList.toggle('dark-mode', themeCheckbox.checked);
    });
});
