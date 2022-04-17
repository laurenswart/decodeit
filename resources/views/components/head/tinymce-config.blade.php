<!--<script src="{{ asset('vendor/tinymce/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>-->

<script src="https://cdn.tiny.cloud/1/oht48wgk2stebbc1dkrmn32ccl5yz36hogrvv7d17rm9tfb1/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: 'textarea#textEditor', // Replace this CSS selector to match the placeholder element for TinyMCE
    plugins: 'table lists links preview print',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table | preview | print',
    menubar: 'view file',
    block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3'
  });
</script>