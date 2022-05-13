<x-guest-layout>

<section class="container">
  @foreach($plans as $plan)

    <h2 class="light-card block-title layer-2" style="padding:15px;">{{ ucfirst($plan->title) }} Plan</h2>
    <div class="row">
      <div class="col form-section layer-2">
          <h3 class="title-3">Description</h3>
         
          @if($plan->description)
          <p>{{ $plan->description }}</p>
          @endif
          <table class="table caption-top">
                <tbody>
                    <tr>
                        <th>Nb Courses</th>
                        <td>{{ $plan->nb_courses }}</td>
                    </tr>
                    <tr>
                        <th>Nb Chapters</th>
                        <td>{{ $plan->nb_chapters }}</td>
                    </tr>
                    <tr>
                        <th>Nb Students</th>
                        <td>{{ $plan->nb_students }}</td>
                    </tr>
                    <tr>
                        <th>Nb Submissions</th>
                        <td>{{ $plan->nb_submissions }}</td>
                    </tr>
                    <tr>
                        <th>Nb Assignments</th>
                        <td>{{ $plan->nb_assignments }}</td>
                    </tr>
                    <tr>
                        <th>Max Upload Size</th>
                        <td>{{ $plan->max_upload_size }}</td>
                    </tr>
                </tbody>
            </table>
      </div>
      <div class="col form-section layer-2">
        
          <h3 class="title-3">Payment Options</h3>
          <div>
              <div class="align-self-stretch d-flex justify-content-between align-items-center mt-2">
                  <div><h3 class="d-inline-block">{{ $plan->monthly_price }} &#8364</h3> / MONTH</div>
              </div>
              </div>
              <div class="align-self-stretch d-flex justify-content-between align-items-center mt-2">
                <div><h3 class="d-inline-block">{{ $plan->semiyearly_price }} &#8364</h3> / 6 MONTHS</div>
              </div>
              <div class="align-self-stretch d-flex justify-content-between align-items-center mt-2">
                <div><h3 class="d-inline-block">{{ $plan->yearly_price }} &#8364</h3> / YEAR</div>
                 
              </div>
              <div class="d-flex justify-content-end">
                <a class="myButton" href="{{ route('register') }}">Register</a>
              </div>
          </div>
      </div>
  </div>
  @endforeach

  <h2 class="light-card block-title layer-2" style="padding:15px;">Custom Plan</h2>

      <div class="form-section layer-2">
        <h3 class=title-3">What's that ?</h3>
        <p class="w-100">If none of the plans above seem to suit your needs, please get in touch with us and we can determine
          an offer adapted specifically to you. </p>
          <div class="d-flex justify-content-end">
              <a href="{{ route('contact') }}" class="highlight"><i class="fas fa-arrow-square-right"></i>Get in Touch</a>
          </div>
      </div>




</section>
</x-guest-layout>