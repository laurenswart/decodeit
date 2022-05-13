window.createFlashPopUp = function (msg, error = false){
    let div = document.createElement('div');
    div.classList.add('alert', 'flash-popup');
    if(error){
        div.classList.add('alert-danger');
    } else {
        div.classList.add('alert-success');
    }
    div.innerText = msg;
    setTimeout(() => {
       div.remove(); 
    }, 5000);
    document.body.appendChild(div);
}