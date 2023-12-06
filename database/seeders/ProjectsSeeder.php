<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Project;
use App\Functions\Helper;
use App\Models\Type;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        for ($i = 0; $i < 10; $i++) {
            $new_project = new Project();
            $new_project->type_id = Type::inRandomOrder()->first()->id;
            $new_project->name = $faker->name(1);
            $new_project->slug = Helper::generateSlug($new_project->name, Project::class);
            $new_project->date_start = $faker->date('Y-m-d');
            $new_project->description = $faker->paragraph();
            $new_project->save();
            //dump($new_project);
        }
    }
}
