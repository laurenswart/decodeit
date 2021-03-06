const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);


mix.copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce');
mix.js('resources/js/studentAssignment.js', 'public/js/student');
mix.js('resources/js/teacherForum.js', 'public/js/teacher');
mix.js('resources/js/functions.js', 'public/js');
mix.js('resources/js/studentChapter.js', 'public/js/student');
mix.js('resources/js/studentForum.js', 'public/js/student');
mix.js('resources/js/teacherCourseCreate.js', 'public/js/teacher');
mix.js('resources/js/teacherCourseManage.js', 'public/js/teacher');
mix.js('resources/js/teacherCourseEdit.js', 'public/js/teacher');
mix.js('resources/js/teacherStudentIndex.js', 'public/js/teacher');
mix.js('resources/js/teacherStudentAssignmentShow.js', 'public/js/teacher');
mix.js('resources/js/teacherStudentEnrolments.js', 'public/js/teacher');
mix.js('resources/js/register.js', 'public/js');
