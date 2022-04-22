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
    }
}


window.Alpine = Alpine;

Alpine.start();
