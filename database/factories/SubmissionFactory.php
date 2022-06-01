<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{

    const CODES = [
        'javascript' => [
'let name="Henry";
let age = 6;
console.log(name+" is "+age)',
"function welcome(){
    console.log('Hello!');
}

welcome();",
"let options = document.getElementById('options');
let students = document.getElementById('students');
let searchInput = document.getElementById('search');",
"function createFlashPopUp(msg, error = false){
    let div = document.createElement('div');
    div.classList.add('alert', 'flash-popup');
    if(error){
        div.classList.add('alert-danger');
    } else {
        div.classList.add('alert-success');
    }
    div.innerText = msg;
    setTimeout(() => {
        div.remove(); 
    }, 5000);
    document.body.appendChild(div);
}",
        ],
        'python' => [
"x =5
y = 6
print(x+y)",
"print('Hello !')",
"def sum(x,y):
    return x + y",
"def welcome(name):
    print('Welcome '+ name + ' !')"
        ],
        'html' => [
"<div>
    <p>Voici un paragraphe</p>
</div>",
"<div>
    <h1 style='color:red'>Un titre rouge</h1>
    <p>Voici un paragraphe</p>
</div>",
'<!DOCTYPE html>
    <html>
        <body>
    
        <h1 id="myH"></h1>
        <p id="myP"></p>
    
        <script>
            // Change heading:
            document.getElementById("myH").innerHTML = "JavaScript Comments";
            // Change paragraph:
            document.getElementById("myP").innerHTML = "My first paragraph.";
        </script>
        </body>
    </html>',
'<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
    </body>
</html>',
        ]
        
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        return [
            'status' => 'ran',
            'console' => null,
            'question' =>  rand(1,10)<5 ? $this->faker->realText(500) : null,
        ];
    }

    /**
     * Indicate the model's role
     *
     * @return static
     */
    public function assignment($assignment)
    {
        return $this->state(function ($attributes) use ($assignment) {
            $created = $this->faker->dateTimeBetween($assignment->start_time_carbon(), min(now(), $assignment->end_time_carbon() ));
            $feedback =  rand(1,10)<5 ? $this->faker->realText(500) : null;
            $lang = $assignment->language;
            return [
                'created_at' => $created,
                'updated_at' => $created,
                'feedback' =>  $feedback,
                'content' => self::CODES[$lang][array_rand(self::CODES[$lang])],
                'feedback_at' => $feedback ? $this->faker->dateTimeBetween($created, min(now(), $assignment->end_time_carbon() )) : null,
            ];
        });
    }
}
