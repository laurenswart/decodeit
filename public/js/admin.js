let togglers = document.querySelectorAll('.admin-toggler');
togglers.forEach( x => x.addEventListener('click', toggleNav));
let nav = document.getElementById('navigation');
let menuButtonClose = document.querySelector('#top-bar .admin-toggler.close');
let menuButtonOpen = document.querySelector('#top-bar .admin-toggler.open');

function toggleNav(){
    if(nav.classList.contains('slide-in')){
        nav.classList.remove('slide-in');
        nav.classList.add('slide-out');
        menuButtonOpen.style.display = 'inline';
        menuButtonClose.style.display = 'none';
        setTimeout(function(){
            nav.style.display = 'none';
        }, 200);
    } else {
        nav.classList.add('slide-in');
        nav.classList.remove('slide-out');
        menuButtonOpen.style.display = 'none';
        menuButtonClose.style.display = 'inline';
        setTimeout(function(){
            nav.style.display = 'block';
        }, 300);
    }
}