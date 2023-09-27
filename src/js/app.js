document.addEventListener('DOMContentLoaded', function() {

    eventListeners();
});

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    if (navegacion.classList.contains('mostrar')) {
        navegacion.classList.remove('mostrar');
    } else {
        navegacion.classList.add('mostrar');
    }

    //el if se puede resumir en esto, toogle quita y pone una clase
   // navegacion.classList.toggle('mostrar')
}