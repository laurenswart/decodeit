
let nbSkills = -1;

let skillsDiv = document.getElementById('skills');

let addSkillBtn = document.getElementById('addSkill');




addSkillBtn.addEventListener('click', newSkill);

let nbNewSkillsInPage = document.querySelectorAll('#skills input[type=text]');

if(nbNewSkillsInPage!=null){
    nbSkills = nbNewSkillsInPage.length-1;
}

function newSkill(){
    nbSkills++;
    let newDiv = document.createElement('div');
    newDiv.classList.add('mb-2');
    newDiv.innerHTML = '<div class="mb-3"><input type="text" class="form-control" name="skills['+nbSkills+'][title]" placeholder="Skill Name"></div><div class="mb-3 ml-4"><textarea class="form-control" name="skills['+nbSkills+'][description]" rows="3" placeholder="Skill Description .. "></textarea></div>';
    skillsDiv.appendChild(newDiv);
}

