<button onclick="topFunction()" id="scrollToTop" title="Go to top"><i class="fas fa-arrow-up"></i></button>


<div class=" layer-1">
  <footer class="container py-3">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="{{ route('terms') }}" class="nav-link px-2 text-muted">Terms of Service</a></li>
      <li class="nav-item"><a href="{{ route('privacy') }}" class="nav-link px-2 text-muted">Privacy</a></li>
      @if(empty(Auth::user()) || Auth::user()->isTeacher())
        <li class="nav-item"><a href="{{  empty(Auth::user()) ? route('plans') : route('plan_teacherIndex') }}" class="nav-link px-2 text-muted">Pricing</a></li>
      @endif
      <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link px-2 text-muted">Contact Us</a></li>
    </ul>
    <p class="text-center text-muted">&copy; 2022 DecodeIt</p>
  </footer>
</div>