require('./functions.js');

window.onload = function(){
    let readBtn = document.getElementById('readBtn');

    readBtn.addEventListener('click', function(){
        console.log('clicked');
        let xhr = new XMLHttpRequest();

        xhr.onload = function() { //Fonction de rappel
            if(this.status === 200) {
                let data = this.responseText;
                data = JSON.parse(data);
                if (data.isRead){
                    if(readBtn.classList.contains('btn-highlight')){
                        readBtn.classList.remove('btn-highlight');
                        readBtn.classList.add('empty');
                    }
                    readBtn.innerText = 'Mark as not read';
                } else if(!data.isRead){
                    if(!readBtn.classList.contains('btn-highlight')){
                        readBtn.classList.add('btn-highlight');
                        readBtn.classList.remove('empty');
                    }
                    readBtn.innerText = 'I Have Read This Chapter';
                }
            }
        };
        const data = JSON.stringify({
            _token: csrfToken
        });

        xhr.open('POST', "/student/chapters/"+chapterId);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(data);
        // end of ajax call
    });
}