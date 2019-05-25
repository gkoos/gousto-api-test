<?php

use Illuminate\Database\Seeder;
use App\Recipe;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = array_map('str_getcsv', file('database/recipe-data.csv'));
        $header = true;
        foreach($csv as $line) {
            if ($header) {
                $fieldNames = $line;
                $header = false;
            }
            else {
                $data = [];
                for ($i = 0; $i < count($line); $i++) {
                    $data[$fieldNames[$i]] = $line[$i];
                }
                unset($data["created_at"]); unset($data["updated_at"]); // or reformat
                Recipe::create($data);
            }
        }
    }
}
