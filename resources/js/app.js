require('./bootstrap');
import Alpine from 'alpinejs';

//// ACE
import 'ace-builds';
import 'ace-builds/webpack-resolver';

let testScriptEditor = document.getElementById('testScriptEditor');
let testLanguage = document.getElementById('language');
let executableCheck = document.getElementById('executable');
let editor;
let acceptedModes = ['css', 'html', 'javascript', 'python', 'java', 'json', 'php', 'xml'];
let testScriptInfo = document.getElementById('testScriptInfo');

// If we have an editor element
if(testScriptEditor){
    // pass options to ace.edit
    editor = ace.edit(document.getElementById('testScriptEditor'), {
        mode: "ace/mode/javascript",
        theme: "ace/theme/dracula",
        maxLines: 50,
        minLines: 10,
        fontSize: 18
    })
    // use setOptions method to set several options at once
    editor.setOptions({
        autoScrollEditorIntoView: true,
        copyWithEmptySelection: true,
    });

    
    testLanguage.onchange = function(){
        let newMode = this.value;
        //console.log(newMode);
        if(acceptedModes.indexOf(newMode)!=-1){
            //change the mode
            editor.session.setMode("ace/mode/" + newMode);
        }
        adaptEditorDisplay();
    }
    executableCheck.onchange = adaptEditorDisplay;

    document.getElementById("newAssignment").onsubmit = function(evt) {
        document.getElementById("script").value = editor.getValue();
      }
}



function adaptEditorDisplay(){
    let validLanguage = acceptedModes.indexOf(testLanguage.value)!=-1;
    if(executableCheck.checked && validLanguage){
        testScriptEditor.style.display = 'block';
        testScriptInfo.style.display = 'none';
        editor.setReadOnly(false);
    } else {
        testScriptEditor.style.display = 'none';
        testScriptInfo.style.display = 'block';
        editor.setReadOnly(true);
    }
}

window.Alpine = Alpine;

Alpine.start();
