require('./bootstrap');
import Alpine from 'alpinejs';

//// ACE
import 'ace-builds';
import 'ace-builds/webpack-resolver';

let testScriptEditor = document.getElementById('testScriptEditor');
let testLanguage = document.getElementById('language');
let newMode;

let acceptedModes = ['css', 'html', 'javascript', 'python', 'java', 'json', 'php', 'xml'];

// If we have an editor element
if(testScriptEditor){
    // pass options to ace.edit
    let editor = ace.edit(document.getElementById('testScriptEditor'), {
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
        newMode = this.value;
        //console.log(newMode);
        if(acceptedModes.indexOf(newMode)!=-1){
            //console.log(1);
            //change the mode
            editor.session.setMode("ace/mode/" + newMode);
            editor.setReadOnly(false);
            testScriptEditor.style.display = 'block';
        } else if(newMode == ''){
            //hide the editor
            //console.log(2);
            editor.setReadOnly(true);
            testScriptEditor.style.display = 'none';
        } else {
            //error
            //console.log(3);
            editor.setReadOnly(true);
            testScriptEditor.style.display = 'none';
        }
        
    }
}


window.Alpine = Alpine;

Alpine.start();
