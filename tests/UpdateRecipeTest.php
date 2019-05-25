<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UpdateRecipeTest extends TestCase
{
    public function testShouldUpdateExistingRecipe()
    {
        $params = ["box_type" => "meat lover"];
        $this->patch('/api/recipes/1', $params);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'id',
                'created_at',
                'updated_at',
                'box_type',
                'title',
                'slug',
                'short_title',
                'marketing_description',
                'calories_kcal',
                'protein_grams',
                'fat_grams',
                'carbs_grams',
                'bulletpoint1',
                'bulletpoint2',
                'bulletpoint3',
                'recipe_diet_type_id',
                'season',
                'base',
                'protein_source',
                'preparation_time_minutes',
                'shelf_life_days',
                'equipment_needed',
                'origin_country',
                'recipe_cuisine',
                'in_your_box',
                'gousto_reference'
            ]
        );

        $this->assertJson('{"box_type": "meat lover"}');
    }

    public function testShouldReturn404ForNonexistingRecipe()
    {
        $params = ["box_type" => "meat lover"];
        $this->patch('/api/recipes/0', $params);

        $this->seeStatusCode(404);
    }

    public function testShouldReturnErrorForMalformedField()
    {
        $params = ["box_type" => "meat lover", "preparation_time_minutes" => "twenty"];
        $this->patch('/api/recipes/1', $params);

        $this->seeStatusCode(422);
        $this->assertJson('{"preparation_time_minutes": ["The preparation time minutes must be an integer."]}');
    }

    public function testShouldDiscardFieldsNotWhitelisted()
    {
        $params = ["box_type" => "meat lover", "other_field" => "something"];
        $this->patch('/api/recipes/1', $params);

        $this->seeStatusCode(200);

        $this->get('/api/recipes/1', $params);
        $this->assertJson('{"box_type": "meat lover"}');
    }
}
