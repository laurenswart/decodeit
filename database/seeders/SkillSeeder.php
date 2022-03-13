<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{

    const SKILLS = [
        [
            'title' => 'Respect de la syntaxe', 
            'description'=> "L'étudiant utilise une syntaxe appropriée au langage utilisé",
        ],
        [
            'title' => 'Cohérence et Logique', 
            'description'=> "L'étudiant est capable d'écrire un code 
                        clairement structuré en implémentant la logique demandée",
        ],
        [
            'title' => 'Utilisation des fonctions du langage', 
            'description'=> "L'étudiant sait se servir des fonctions disponibles dans le langage",
        ],
        [
            'title' => 'Implémentation de tests', 
            'description'=> "L'étudiant a su mettre en place une serie de tests",
        ],
        [
            'title' => 'Versionnage', 
            'description'=> "L'étudiant sait se servir d'un outil de versionnage",
        ],
        [
            'title' => 'Manipulation de fonctions', 
            'description'=> "L'étudiant a su créer et utiliser des fonctions, avec et sans paramètres",
        ],
        [
            'title' => 'Structures complexes', 
            'description'=> "L'étudiant sait mettre en place des structures 
                conditionnelles ainsi que des boucles",
        ],
        [
            'title' => 'Structure de fichiers', 
            'description'=> "L'étudiant sait gérer les appels entre plusieurs fichiers",
        ],
        [
            'title' => 'Maîtrise générale', 
            'description'=> "L'étudiant maîtrise-t-il suffisamment les notions requises",
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty the table first
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Skill::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //find courses
        $courses = Course::all();

        foreach($courses as $course){
            //add a random set of skills
            $nbSkills = rand(0, 6);
            if($nbSkills==0) continue;
            $skills = Arr::random(self::SKILLS, $nbSkills);
            foreach($skills as $skill){
                $rows[] = [
                    'course_ref'=>$course->course_id,
                    'title'=> $skill['title'],
                    'description'=> $skill['description'],
                ];
            }
           
        }
        //insert into table
        DB::table('skills')->insert($rows);
    }
}
