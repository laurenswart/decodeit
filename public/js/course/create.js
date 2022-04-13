let nbEnrolments = -1;
let nbSkills = -1;
let enrolmentsDiv = document.getElementById('enrolments');
let skillsDiv = document.getElementById('skills');
let addEnrolmentBtn = document.getElementById('addEnrolment');
let addSkillBtn = document.getElementById('addSkill');


addEnrolmentBtn.addEventListener('click', newEnrolment);

addSkillBtn.addEventListener('click', newSkill);


function newEnrolment(){
    nbEnrolments++;
    let newDiv = document.createElement('div');
    newDiv.classList.add('mb-3');
    newDiv.innerHTML = '<input type="text" class="form-control" id="skills['+nbEnrolments+']" placeholder="Student">';
    enrolmentsDiv.appendChild(newDiv);
}

function newSkill(){
    nbSkills++;
    let newDiv = document.createElement('div');
    newDiv.classList.add('mb-2');
    newDiv.innerHTML = '<div class="mb-2"><div class="mb-3"><input type="text" class="form-control" name="skills['+nbSkills+'][title]" placeholder="Skill Name"></div><div class="mb-3 ml-4"><textarea class="form-control" name="skills['+nbSkills+'][description]" rows="3" placeholder="Skill Description .. "></textarea></div></div>';
    skillsDiv.appendChild(newDiv);
}

newEnrolment();
newEnrolment();
newEnrolment();
newEnrolment();

newSkill();
newSkill();
newSkill();
