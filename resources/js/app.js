require('./bootstrap');
import Alpine from 'alpinejs';

//// ACE
import 'ace-builds';
import 'ace-builds/webpack-resolver';

let editorElement = document.getElementById('editor');

console.log('hello');
// If we have an editor element
if(editorElement){
    // pass options to ace.edit
    let editor = ace.edit(document.getElementById('editor'), {
        mode: "ace/mode/python",
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
}
//// END ACE


window.Alpine = Alpine;

Alpine.start();
