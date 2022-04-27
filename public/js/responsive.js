let offCanvas = document.querySelector('#off-canvas');
function swapOffCanvas(){
    offCanvas.classList.add('show');
}
function hideOffCanvas(){
    offCanvas.classList.remove('show');
}

$(document).ready(function(){
    if($("#flashModal")){
        $("#flashModal").modal('show');
    }
    
});
