@extends( empty(Auth::user()) ? 'layouts.guest' : (Auth::user()->isTeacher()  ?  'layouts.teacher' : ( Auth::user()->isStudent() ? 'layouts.student' : '' )))

@section('content')
    <!--content-->
    <section class="align-center background  u-section-1" id="section1">
        <div class="u-clearfix u-sheet u-sheet-1 ">
            <div class="palette-highlight u-absolute-hcenter-xs u-expanded-height-lg u-expanded-height-md u-expanded-height-xl u-expanded-height-xs u-shape u-shape-rectangle u-shape-1"></div>
            <img class="u-image u-image-1 layer-2 dark-card" src="{{ asset('img/programming.png') }}" data-image-width="1200" data-image-height="900">
            <div class="u-align-left u-container-style u-group u-white u-group-1 foreground dark-card">
                <div class="u-container-layout u-container-layout-1">
                    <h2 class="u-text u-text-1">Coding taught differently</h2>
                    <p class="u-text u-text-2">DecodeIt is a learning management system 
                        designed for teaching programming. Our carefully
                        thoughtout features will enable teachers to expand
                        their teaching methods and motivate students with
                        a more hands-on approach.</p>
                    <p class="u-align-left u-text">Don't want to deprive your students any longer ?</p>
                    <a href="{{ route('register') }}" class="btn btn-left myButton">Subscribe</a>
                </div>
            </div>
            <div class="u-shape u-shape-circle u-white u-shape-2"></div>
        </div>
    </section>

    <section class="u-clearfix  palette-highlight section-2" id="section2">
        <h2 class="u-custom-font u-font-ubuntu u-text u-text-1">Simple, intuitive and efficient.</h2>
    </section>

    <section class="u-clearfix background u-section-5" id="section3">
        <div class="u-clearfix u-sheet u-valign-middle-xl u-valign-middle-xs u-sheet-1">
            <div class="foreground u-clearfix u-layout-wrap u-layout-wrap-1 dark-card">
                <div class="u-layout">
                    <div class="u-layout-row ">
                        <div class="u-align-left u-container-style u-layout-cell u-left-cell u-shape-rectangle u-size-27 u-layout-cell-1">
                            <div class="u-container-layout u-valign-middle u-container-layout-1">
                                <p class="u-text u-text-1">Whether from a teacher's or student's point
                                    of view, DecodeIt centralises all the necessary information in one simple
                                    application.</p>
                                <p class="u-text u-text-1 point"><i class="fas fa-arrow-circle-right"></i>Easily navigate between courses, 
                                    students, assignments</p>
                                <p class="u-text u-text-1 point"><i class="fas fa-arrow-circle-right"></i>Quickly communicate with your teachers,
                                    students and classmates</p>
                                <p class="u-text u-text-1 point"><i class="fas fa-arrow-circle-right"></i>Follow what's new and upcoming on
                                    the DecodeIt dashboard.</p>
                            </div>
                        </div>
                        <div class="u-align-center u-container-style u-image u-layout-cell u-right-cell u-size-33 u-image-1" data-image-width="1000" data-image-height="1233">
                            <div class="u-container-layout u-valign-top u-container-layout-2"><img src="{{ asset('img/onespot.png') }}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="u-align-left u-container-style u-group palette-highlight u-group-1">
                <div class="u-container-layout u-valign-middle u-container-layout-3">
                    <h2 class="u-text-2">Tell me and I forget. Teach me and I remember. Involve me and I learn.</h2>
                </div>
            </div>
        </div>
    </section>


    <section class="u-align-center-lg u-align-center-md u-align-center-sm u-align-center-xs u-clearfix background u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xl u-section-3" id="teachers">
        <div class="palette-highlight u-shape u-shape-rectangle u-shape-1"></div>
        <div class="u-clearfix u-layout-wrap u-layout-wrap-1">
            <div class="u-layout">
                <div class="u-layout-row">
                    <div class="u-container-style u-layout-cell u-size-40 u-layout-cell-1">
                        <div class="u-container-layout u-container-layout-1">
                            <h2 class="u-text u-text-1" id="teachers">For teachers</h2>
                            <img src="{{ asset('img/follow.png') }}" alt="" class=" layer-2 u-expanded-width u-image u-image-default  dark-card" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="u-list u-list-1">
            <div class="u-repeater u-repeater-1">
                <div class="u-container-style u-list-item u-repeater-item">
                    <div class="u-container-layout u-similar-container u-container-layout-3">
                        <h3 class="u-text u-text-3">01. Set up your class</h3>
                        <p class="u-text u-text-6">Create classrooms, add students,create lessons and chapters. 
                            <br>Add assignments and exams for your students to fulfill.</p>
                    </div>
                </div>
                <div class="u-container-style u-list-item u-repeater-item">
                    <div class="u-container-layout u-similar-container u-container-layout-3">
                        <h3 class="u-text u-text-5">02. Follow your students</h3>
                        <p class="u-text u-text-6">Manage assignment submissions, give feedbacks and hints, and assess a students overall progress</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="u-clearfix background u-section-8" id="section5">
        <div class="u-clearfix u-sheet u-valign-middle-lg u-valign-middle-xs u-sheet-1">
        <div class=" u-expanded-height-lg u-expanded-height-md u-expanded-width-sm u-expanded-width-xs palette-highlight u-shape u-shape-rectangle u-shape-1"></div>
        <div class="u-clearfix u-layout-wrap u-layout-wrap-1">
            <div class="u-gutter-0 u-layout">
            <div class="u-layout-row">
                <div class="u-container-style u-image u-layout-cell u-left-cell u-size-30 u-image-1" data-image-width="1200" data-image-height="959">
                <div class="u-container-layout u-container-layout-1 layer-2  dark-card">
                    <h2>Personnalised Tests</h2>
                    <p>Our assignment editor enables you to set up tests and responses to send back to your students upon execution	code of their code. 
                        Helping to guide programming beginners through error messages and bugs is essential in keeping their motivation levels up.
                        </p>
                    <p>For more advanced learners, setting up specific test scenarios they may not have anticipated will help them improve continuously and become
                        evermore rigorous.</p>
                    <p>You will be able to set assignments in <strong>CSS, JSON, XML, HTML,</strong> and also allow them to run code in <strong>Javascript and Python</strong>.<p>
                </div>
                </div>
                <div class="u-align-center u-container-style u-layout-cell u-right-cell u-size-30 u-layout-cell-2">
                <div class="u-container-layout u-valign-middle u-container-layout-2">
                    <div class="u-expanded-width u-form u-form-1">
                            <img src="{{ asset('img/done.png') }}" alt="" class="u-expanded-width u-image u-image-default" >
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>



    <section class="u-clearfix background u-section-6" id="students">
        <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
            <div class="u-clearfix u-expanded-width u-layout-wrap u-layout-wrap-1">
                <div class="u-layout">
                    <div class="u-layout-row">
                        <div class="u-container-style u-layout-cell u-left-cell u-size-30 u-layout-cell-1">
                            <div class="u-container-layout u-valign-top u-container-layout-1">
                                <h2 class="u-text u-text-1">For students</h2>
                                <div class="palette-highlight u-shape u-shape-circle u-shape-1"></div>
                            </div>
                        </div>
                        <div class="u-container-style u-layout-cell u-right-cell u-size-30 u-layout-cell-2">
                            <div class="u-container-layout u-valign-top u-container-layout-2 u-align-right">
                                <p class="u-text u-text-2">DecodeIt aims to improve the learning experience by enabling students to progress autonomously, 
                                while receiving regular personal feedback on assignments</p>
                                <p class="u-text u-text-2">Continuous learning and improvement is the key to succes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="u-align-center u-clearfix background " id="section7">
        <div class="u-clearfix u-sheet u-valign-middle-xl u-valign-middle-xs u-valign-middle-xs u-sheet-1">
            <div class="layer-2  dark-card u-clearfix u-layout-wrap u-layout-wrap-1">
                <div class="u-layout">
                    <div class="u-layout-row " style="padding:50px;">
                        <div class="u-align-left u-container-style u-layout-cell u-left-cell u-shape-rectangle u-size-30 u-layout-cell-1">
                            <div class="u-container-style u-list-item u-repeater-item">
                                <div class="u-container-layout  u-container-layout-2" style="margin:10px;">
                                    <h3 class="u-text u-text-3">01. Always have an overview</h3>
                                    <p class="u-text u-text-4">With the help of your main dashboard, keep track of what's new and your upcoming assignments. Having easy
                                        access to information is essential to be productive.</p>
                                    <h3 class="u-text u-text-3">02. Manage your progress</h3>
                                    <p class="u-text u-text-4">Visualise your progress and easily
                                        assess what you need to catch up will help you keep up to date in all your courses and deliver all assignments on time..</p>
                                </div>
                            </div>
                        </div>
                        <div class=" u-container-style u-image u-layout-cell u-right-cell u-size-30 u-image-1" data-image-width="1000" data-image-height="1233">
                            <div class="u-container-layout u-valign-top u-container-layout-2"><img src="{{ asset('img/progress.png') }}" style="margin:20px;"></div>
                        </div>
                    </div>
                </div>
            </div>
                    
            <h2 class="u-text u-text-1" style="margin-top: 40px;">Learning made easy</h2>
            <p class="u-text u-text-2">With all the necessary tools made available to teachers as well as students, DecodeIt aims to improve the overall 
                success rate in programming courses. </p>
            <p class="u-text u-text-2">Enhanced teaching keeps students motivated and reduces the chances of fully capable students of dropping out.</p>
            
        </div>
    </section>




    <section class="u-align-center u-clearfix background u-valign-middle-sm u-valign-middle-xs u-section-2" id="pricing">
        <h2 class="u-text u-text-1">Pricing</h2>
        <h3 class="u-text u-text-2">We offer various subscriptions</h3>
        <div class="u-expanded-width palette-highlight u-shape u-shape-rectangle u-shape-1"></div>
        <div class="u-list u-list-1">
            <div class="u-repeater u-repeater-1">
                @foreach($plans as $plan)
                <div class=" dark-card foreground u-align-center u-container-style u-list-item u-repeater-item u-shape-rectangle u-white u-list-item-1">
                    <div class="u-container-layout u-similar-container u-valign-top u-container-layout-1 d-flex flex-col justify-content-between">
                        <div>
                            <img src="{{ asset('img/'.$plan->title.'.png') }}" alt="" class="u-expanded-width u-image u-image-default u-image-1" data-image-width="900" data-image-height="878">
                            <h4 class="u-text u-text-3">{{ ucwords($plan->title) }}</h4>
                            <p class="u-text u-text-4">{{ $plan->description }}</p>
                        </div>
                        <a href="{{ route('plans') }}"  class="btn btn-left myButton mx-auto mt-3">Checkout</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection   
