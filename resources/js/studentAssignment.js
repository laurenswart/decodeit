require('./functions.js');


let scriptEditor = document.getElementById('scriptEditor');
let editor;
let acceptedModes = ['css', 'html', 'javascript', 'python', 'java', 'json', 'php', 'xml'];
let hiddenScript = document.getElementById("script");
let hiddenConsole = document.getElementById("hiddenConsole");
let myConsole = document.getElementById('console');
let codeStatus = document.getElementById('codeStatus');
let testCode = null;
let judge0Codes = {
    python:71,
    php:68,
    javascript:63,
    java:62,
    html:42,
};
let btnRun = document.getElementById('btRun');

// If we have an editor element
if(scriptEditor){
    // pass options to ace.edit
    let lang = scriptEditor.dataset.lang;
    if(acceptedModes.indexOf(lang)!=-1){
        editor = ace.edit(document.getElementById('scriptEditor'), {
            mode: "ace/mode/"+lang,
            theme: "ace/theme/dracula",
            maxLines: 30,
            minLines: 10,
            fontSize: 18
        })
        // use setOptions method to set several options at once
        editor.setOptions({
            autoScrollEditorIntoView: true,
            copyWithEmptySelection: true,
        });

        document.getElementById("newSubmission").onsubmit = function(evt) {
            hiddenScript.value = editor.getValue();  
        }

        //set up judge0
        document.getElementById('btClearConsole').addEventListener('click', function(){
            myConsole.innerHTML = '<li></li>';
        })

        //load in testScript
        loadTestScript();

        //prepare to send submission to judge0
        let headers = {
            "content-type": "application/json",
            "x-rapidapi-host": "judge0-ce.p.rapidapi.com",
            "x-rapidapi-key": ""+process.env.MIX_JUDGE0_SECRET
        }
        if(btnRun){
            //check language is valid for judge0
            if (Object.keys(judge0Codes).indexOf(lang)==-1){
                //todo determine what to do
            } else {

                btnRun.addEventListener('click', function(){
                    
                    console.log(editor.getValue());

                    this.innerText = 'loading..';
                    let languageId = judge0Codes[lang];
                    let inputCode = editor.getValue();
                    if(inputCode==null || inputCode==''){
                        this.innerText = 'Run';
                        return;
                    }
                    let options = {
                        "method": "POST",
                        "headers": headers,
                        "body": JSON.stringify({
                            source_code: (new CodeSubmission(inputCode,testCode, lang)).getCodeSubmission(),
                            language_id: languageId,
                            number_of_runs: "1",
                            stdin:  btoa(unescape(encodeURIComponent("Judge0"))),
                            cpu_time_limit: "2",
                            cpu_extra_time: "0.5",
                            wall_time_limit: "5",
                            memory_limit: "128000",
                            stack_limit: "64000",
                            max_processes_and_or_threads: "60",
                            enable_per_process_and_thread_time_limit: false,
                            enable_per_process_and_thread_memory_limit: false,
                            max_file_size: "1024",	
                            expected_output:btoa(unescape(encodeURIComponent(null)))
                        })
                    };
            
                    sendSubmission(options)
                    .then(token => {
                        console.log(token);
                        return getSubmissionResponse(token);
                    })
                    .then( response => {
                        console.log(response);
                        let li = document.createElement('li');
                        if (response.status_id == 4){
                            //wrong answer
                            li.innerText = response.stdout;
                            codeStatus.innerText = 'Failed';
                        } else if (response.status_id == 11){
                            //error
                            li.innerText = response.stderr;
                            codeStatus.innerText = 'Error';
                        } else {
                            li.innerText = response.stdout;
                            codeStatus.innerText = 'Pass';
                        }
                        myConsole.appendChild(li);
                        this.innerText = 'Run';
                    })
                });

                //save script content and console content on form submission
                document.getElementById("newSubmission").onsubmit = function(evt) {
                    hiddenScript.value = editor.getValue();
                    hiddenConsole.value = myConsole.lastChild.innerText;
                }
            }
        }
    }
}

//function declarations

async function sendSubmission(options){
    return await fetch("https://judge0-ce.p.rapidapi.com/submissions?base64_encoded=true&fields=*", options)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        console.log(response);
        return response.json();
    })
    .then (data => {
        return data.token;
        
    })
    .catch(err => {
        console.error(err);
    });
}
    
async function getSubmissionResponse(token){
    let options = {
    "method": "GET",
    "headers": {
        "x-rapidapi-host": "judge0-ce.p.rapidapi.com",
        "x-rapidapi-key": ""+process.env.MIX_JUDGE0_SECRET
    }
    }
    return await fetch("https://ce.judge0.com/submissions/"+token+"?fields=stdout,stderr,status_id,language_id", options)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .catch(err => {
        console.error(err);
    });
}


function loadTestScript(){
    let assignmentId = btnRun.value;
    let xhr = new XMLHttpRequest();

    xhr.onload = function() { //Fonction de rappel
        if(this.status === 200) {
            let data = this.responseText;
            data = JSON.parse(data);
            console.log(data);
            if(data.success){
                testCode = data.script;
            }
            
        }
    };
    const data = JSON.stringify({
        _token: "<?= csrf_token() ?>"
    });

    xhr.open('GET', "/student/assignments/"+assignmentId+"/testscript");
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(data);


   
}


//used for judge0
class CodeSubmission{
    static starts = {
        'python':'try:',
        'php':'try{',
        'javascript':'try{',
        'java':'try{',
    }
    static ends = {
        'python': 'except Error: print("error")',
        'php': '} catch(Exception $e)',
        'javascript': '} catch(e){ ',
        'java': '} catch(Exception e)',
    }
    constructor(studentInput, testScript, language){
        this.studentInput = studentInput;
        this.testScript = testScript;
        this.language = language;
    }
    

    getCodeSubmission(){
        console.log(this.testScript);
        if(this.testScript!=null && this.testScript!=''){
            if (Object.keys(CodeSubmission.starts).indexOf(this.language)==-1){
                //todo determine what to do
                return btoa(unescape(encodeURIComponent(this.studentInput)));
            }
            let start = CodeSubmission.starts[this.language];
            let end = CodeSubmission.ends[this.language];
            console.log(start+this.studentInput+this.testScript+end);
            return btoa(unescape(encodeURIComponent(start+this.studentInput+this.testScript+end)));
        } else {
            return btoa(unescape(encodeURIComponent(this.studentInput)));
        }
    }
}

////
let btnAddQuestion = document.getElementById('btnAddQuestion');
let question = document.getElementById('question');

window.addQuestion = function (button){
    let questionDiv = button.closest('.submissionQuestion');
    let questionContent = questionDiv.querySelector('textarea').value;
    let submissionId = button.dataset.submissionid;
    //if question empty do nothing
    if(questionContent=='') {
        createFlashPopUp('Please enter a question', true);
        return;
    }
    
    //send ajax request
    console.log(questionContent);
    console.log(submissionId);
    let xhr = new XMLHttpRequest();

    xhr.onload = function() { //Fonction de rappel
        if(this.status === 200) {
            let data = this.responseText;
            data = JSON.parse(data);
            if(data.success){
                //remove textareaand display question
                let p = document.createElement('p');
                p.innerText = questionContent;
                questionDiv.parentNode.insertBefore(p, questionDiv);
                
                //change h4 content
                questionDiv.parentElement.querySelector('h4').innerText = 'Note Attached';
                questionDiv.remove();
                createFlashPopUp('Note Successfully Added');
            }
        } else {
            createFlashPopUp('Oops, Something Went Wrong', true);
        }
        
    };
    const data = JSON.stringify({
        _token: csrfToken,
        question: questionContent,
    });

    xhr.open('POST', "/student/submission/"+submissionId+"/addQuestion");
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(data);
    // end of ajax call
};