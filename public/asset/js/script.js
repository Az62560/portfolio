document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.hidden');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Arrête d'observer une fois l'animation déclenchée
            }
        });
    }, {
        threshold: 0.1 // L'animation se déclenchera lorsque 10% de l'élément est visible
    });

    sections.forEach(section => {
        observer.observe(section);
    });
});