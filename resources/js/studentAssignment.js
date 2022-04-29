require('./bootstrap');
import Alpine from 'alpinejs';

//// ACE
import 'ace-builds';
import 'ace-builds/webpack-resolver';

console.log('studentAssignment script loaded');
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
        //loadTestScript();

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
                    let languageId = judge0Codes[lang];//python
                    let inputCode = editor.getValue();
                    if(inputCode==null || inputCode==''){
                        this.innerText = 'Run';
                        return;
                    }
                    let options = {
                        "method": "POST",
                        "headers": headers,
                        "body": JSON.stringify({
                            source_code: (new CodeSubmission(inputCode,testCode)).getCodeSubmission(),
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
                    hiddenConsole.value = myConsole.innerText;
                    
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
    let options = {
        "method":"GET"
    }
    
    fetch("myScript.js", options)
        .then( response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            console.log(response);
            return response.text();
            //
        })
        .then ( script => {
            testCode = script;
        })
        .catch(err => {
            console.error(err);
        });
}


//used for judge0
class CodeSubmission{
    constructor(studentInput, testScript){
        this.studentInput = studentInput;
        this.testScript = testScript;
    }
    static start = 'try {';
    static end = '} catch ( error ){ console.log(error.message);}';

    

    getCodeSubmission(){
        if(this.testScript!=null){
            return btoa(unescape(encodeURIComponent(CodeSubmission.start+this.studentInput+this.testScript+CodeSubmission.end)));
        } else {
            return btoa(unescape(encodeURIComponent(this.studentInput)));
        }
    }
}

window.Alpine = Alpine;

Alpine.start();
