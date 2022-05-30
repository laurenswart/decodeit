@extends( empty(Auth::user()) ? 'layouts.guest' : (Auth::user()->isTeacher()  ?  'layouts.teacher' : ( Auth::user()->isStudent() ? 'layouts.student' : '' )))

@section('content')

<section class="container guest">
    <h2 class="light-card block-title layer-2" style="padding:15px;">Contact Us</h2>
</section>
@endsection