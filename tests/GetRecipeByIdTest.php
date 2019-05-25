<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GetRecipeByIdTest extends TestCase
{
    public function testShouldReturnExistingRecipe()
    {
        $this->get('/api/recipes/1');

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
    }

    public function testShouldReturnEmptyForNonexistingRecipe()
    {
        $this->get('/api/recipes/0');

        $this->seeStatusCode(200);
        $this->seeJsonStructure([]);
    }

    public function testShouldReturn404ForMalformedId()
    {
        $this->get('/api/recipes/one');

        $this->seeStatusCode(404);
    }
}
