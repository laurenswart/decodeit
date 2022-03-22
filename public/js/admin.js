let togglers = document.querySelectorAll('.admin-toggler');
togglers.forEach( x => x.addEventListener('click', toggleNav));
let nav = document.getElementById('navigation');
let menuButton = document.querySelector('#top-bar .admin-toggler');

function toggleNav(){
    console.log('clicked');
    if(nav.classList.contains('slide-in')){
        nav.classList.remove('slide-in');
        nav.classList.add('slide-out');
        menuButton.style.visibility = 'visible';
        setTimeout(function(){
            nav.style.display = 'none';
        }, 200);
    } else {
        nav.classList.add('slide-in');
        nav.classList.remove('slide-out');
        menuButton.style.visibility = 'hidden';
        setTimeout(function(){
            nav.style.display = 'block';
        }, 300);
    }
}