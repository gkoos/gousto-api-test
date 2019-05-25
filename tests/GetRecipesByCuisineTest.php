<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GetRecipesByCuisineTest extends TestCase
{
    public function testShouldReturnRecipeList()
    {
        $this->get('/api/recipes?cuisine=british');

        $this->seeStatusCode(200);
        $this->seeJsonStructure(['*' =>
            [
                'id',
                'title',
                'marketing_description'
            ]]
        );
    }

    public function testShouldReturnRecipeListForExistingPage()
    {
        $this->get('/api/recipes?cuisine=british&page=0');

        $this->seeStatusCode(200);
        $this->seeJsonStructure(['*' =>
                [
                    'id',
                    'title',
                    'marketing_description'
                ]]
        );
    }

    public function testShouldReturnEmptyRecipeListForNonexistentPage()
    {
        $this->get('/api/recipes?cuisine=british&page=1');

        $this->seeStatusCode(200);
        $this->seeJsonStructure([]);
    }

    public function testShouldReturnEmptyRecipeListForNonexistentCuisine()
    {
        $this->get('/api/recipes?cuisine=canadian');

        $this->seeStatusCode(200);
        $this->seeJsonStructure([]);
    }

    public function testShouldReturnErrorIfCuisineIsMissing()
    {
        $this->get('/api/recipes');

        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'cuisine'
        ]);

    }
}
