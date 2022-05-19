document.querySelector('#terms').addEventListener('change', function(){
    console.log(this);
    console.log(this.checked);
    document.querySelector('button.myButton').disabled = !this.checked;
});