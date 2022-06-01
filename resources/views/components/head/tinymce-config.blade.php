<!--<script src="{{ asset('vendor/tinymce/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>-->

@props(['height'])
<script src="https://cdn.tiny.cloud/1/{{env('TINY_MCE')}}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: 'textarea#textEditor', // Replace this CSS selector to match the placeholder element for TinyMCE
    plugins: 'table lists links preview print',
    toolbar: 'undo redo | formatselect fontselect fontsizeselect textcolorselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table | preview print',
    menubar: 'format',
    block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3; Header 4=h4',
    height: {{$height}}
  });
</script>