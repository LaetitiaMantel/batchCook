<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $recipes = [];

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));

        // Generator
        $faker->foodName();      // A random Food Name
        $faker->beverageName();  // A random Beverage Name
        $faker->dairyName();  // A random Dairy Name
        $faker->vegetableName();  // A random Vegetable Name
        $faker->fruitName();  // A random Fruit Name
        $faker->meatName();  // A random Meat Name
        $faker->sauceName();  // A random Sauce Name

        // Tableau des unités de mesures
        $unit = [ "g","cl","CaS","CaC","pièce",];

        
        // Création de 50 recettes
        for ($i = 0; $i < 50; $i ++) {
            $recipe = new Recipe;
            $recipe->setName($faker->foodName());
            $recipe->setPreparation($faker->text());
            $manager->persist($recipe);    
            $this->recipes[] = $recipe;       
        };
        
        // Création de 150 ingerdients
        for ($i = 0; $i < 150; $i++) {
            $ingredient = new Ingredient;
            $ingredient->setName($faker->vegetableName());
            $ingredient->setUnit($unit[array_rand($unit)]);
            for ($j = 0; $j < random_int(2, 5); $j ++){
                $ingredient->addRecipe($faker->unique()->randomElement($this->recipes));
            }
            $manager->persist($ingredient);
            $ingredientInDb [] = $ingredient;
        };
                
        $manager->flush();
    }
}
