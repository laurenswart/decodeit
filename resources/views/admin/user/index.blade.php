@extends('layouts.admin')

@section('title')
 Users
@endsection

@section('content')
<div class="row">
  <div class="layer-2 admin-box col-7"></div>
  <div class="layer-2 admin-box col">
    <div class="d-flex justify-content-between align-items-center">
      <h3>Teachers</h3><a href="{{ route('adminTeachersIndex')}}">{{ $nbTeachers }}<i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <h3>Students</h3><a href="{{ route('adminStudentsIndex')}}">{{ $nbStudents }}<i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <h3>Deleted Accounts</h3><a href="{{ route('adminTeachersIndex')}}">{{ $nbDeletes }}<i class="fas fa-arrow-right"></i></a>
    </div>
  </div>
</div>
<div class="row">
  <div id="inscriptionsPerMonth" style="height: 500px;" class="layer-2 admin-box col"></div>
  <div id="teachersPerStudent" style="height: 500px;" class="layer-2 admin-box col"></div>
</div>

<div id="studentsPerTeacher" style="height: 300px;" class="layer-2 admin-box"></div>
@endsection
  
@section('endScripts')
  <script>
  const inscriptionsPerMonth = new Chartisan({
  el: '#inscriptionsPerMonth',
  url: "@chart('inscriptionsPerMonth')",
  hooks: new ChartisanHooks()
    .colors(['#fdb03d', '#702c94'])
    .legend({ position: 'bottom'})
    .title('Monthly Inscriptions')
    .datasets(['line', 'line'])
    });
const studentsPerTeacher = new Chartisan({
  el: '#studentsPerTeacher',
  url: "@chart('studentsPerTeacher')",
  hooks: new ChartisanHooks()
    .colors(['#9044b9'])
    .legend({ position: 'bottom' })
    .title('Number of Students per Teacher')
    });
const teachersPerStudent = new Chartisan({
  el: '#teachersPerStudent',
  url: "@chart('teachersPerStudent')",
  hooks: new ChartisanHooks()
    .colors(['#9044b9'])
    .legend({ position: 'bottom' })
    .title('Number of Teachers per Student')
    
    });</script>
@endsection


