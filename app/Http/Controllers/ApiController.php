<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Recipe;

class ApiController extends BaseController
{
    public function showRecipesByCuisine(Request $request)
    {
        $this->validate($request, [
            'cuisine' => 'required'
        ]);

        $cuisine = $request->get('cuisine');
        $page = $request->get('page') ?: 0;
        $skip = env("RECORDS_PER_PAGE", 10) * $page;

        return response()->json(Recipe::select('id', 'title', 'marketing_description')->where('recipe_cuisine', $cuisine)
            ->skip($skip)->take(10)->get());
    }

    public function showRecipe($id)
    {
        return response()->json(Recipe::find($id));
    }

    public function updateRecipe($id, Request $request)
    {
        $request->only(['box_type', 'title', 'slug', 'short_title', 'marketing_description', 'calories_kcal',
            'protein_grams', 'fat_grams', 'carbs_grams', 'bulletpoint1', 'bulletpoint2', 'bulletpoint3', 'recipe_diet_type_id',
            'season', 'base', 'protein_source', 'preparation_time_minutes', 'shelf_life_days', 'equipment_needed',
            'origin_country', 'recipe_cuisine', 'in_your_box', 'gousto_reference']);

        $this->validate($request, [
            'box_type' => 'string|max:255',
            'title' => 'string|max:255',
            'slug' => 'string|max:255',
            'short_title' => 'string|max:255',
            'marketing_description' => 'string',
            'calories_kcal' => 'integer',
            'protein_grams' => 'integer',
            'fat_grams' => 'integer',
            'carbs_grams' => 'integer',
            'bulletpoint1' => 'string|max:255',
            'bulletpoint2' => 'string|max:255',
            'bulletpoint3' => 'string|max:255',
            'recipe_diet_type_id' => 'string|max:255',
            'season' => 'string|max:255',
            'base' => 'string|max:255',
            'protein_source' => 'string|max:255',
            'preparation_time_minutes' => 'integer',
            'shelf_life_days' => 'integer',
            'equipment_needed' => 'string|max:255',
            'origin_country' => 'string|max:255',
            'recipe_cuisine' => 'string|max:255',
            'in_your_box' => 'string|max:255',
            'gousto_reference' => 'integer',
        ]);

        $recipe = Recipe::findOrFail($id);
        $recipe->update($request->all());

        return response()->json($recipe);
    }
}
