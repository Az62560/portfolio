document.addEventListener('DOMContentLoaded', function () {
    const hiddenElements = document.querySelectorAll('.hidden');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Pour n'observer qu'une seule fois
            }
        });
    });

    hiddenElements.forEach((element) => {
        observer.observe(element);
    });
});
