<?php
	/* __________ CONFIGURATION ____________ */
	if (!defined("INCLUDES_PATH")){
		require_once("config.php");
	}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

require_once(INCLUDES_PATH . '/dbi_functions_sqlite.php');

	$error = '';
	$db = new SuperConnection();

	if ($db) {
		// table setup
		$dropStrings = array(
			'drop table measures',
			'drop table types',
			'drop table ingredients',
			'drop table directions',
			'drop table recipes',
			'drop table menus',
			'drop table menus_recipes'
		);

		$createStrings = array(
			'create table measures (id integer, type text, primary key (id))',
			'create table types (id integer, name text, primary key (id))',
			'create table ingredients (id integer, recipe_id integer check (recipes), type text check (types), measure_amount double, measure_id integer check(measures), name text, primary key (id))',
			'create table directions (recipe_id integer check (recipes), step_number integer, direction text, primary key(recipe_id, step_number))',
			'create table recipes (id integer primary key, name text)',
			'create table menus (id integer primary key, name text, menu_start_date text, menu_end_date text)',
			'create table menus_recipes (menu_id integer, recipe_id integer, primary key (menu_id, recipe_id))'
		);
		
		$measureStrings = array(
			'insert into measures (type) values ("")',												// 1
			'insert into measures (type) values ("tbsp(s)")',										// 2
			'insert into measures (type) values ("tsp(s)")',										// 3
			'insert into measures (type) values ("cup(s)")',										// 4
			'insert into measures (type) values ("oz(s)")',											// 5
			'insert into measures (type) values ("can(s)")',										// 6
			'insert into measures (type) values ("clove(s)")',										// 7
			'insert into measures (type) values ("stick(s)")',										// 8
			'insert into measures (type) values ("lb(s)")',											// 9
			'insert into measures (type) values ("jar(s)")',										// 10
			'insert into measures (type) values ("bag(s)")',										// 11
			'insert into measures (type) values ("package(s)")'										// 12
		);
		
		$ingredientTypeStrings = array(
			'insert into types (name) values ("Dairy")',											// 1
			'insert into types (name) values ("Breads, Grains and Pasta")',							// 2
			'insert into types (name) values ("Pre-packaged Stuff")',								// 3
			'insert into types (name) values ("Canned Goods")',										// 4
			'insert into types (name) values ("Liquids")',											// 5
			'insert into types (name) values ("Meats")',											// 6
			'insert into types (name) values ("Fruits, Vegetables and Others")',    				// 7
			'insert into types (name) values ("Herbs, Spices and Seasonings")'						// 8
		);
		
		$initialRecipeStrings = array(
			'insert into recipes (name) values ("Slow Cooker Buffalo Chicken Chili")',				// 1
			'insert into recipes (name) values ("Slow Cooker Jalapeno Popper Chicken Taquitos")',	// 2
			'insert into recipes (name) values ("Baked Chicken Shawarma")',							// 3
			'insert into recipes (name) values ("Creamy Tomato Tortellini Soup")',					// 4
			'insert into recipes (name) values ("Creamy Chicken and Broccoli")'						// 5
		);
		
		$initialIngredientStrings = array(
			// recipe id,
			// type,
			// measure_amount,
			// measure_id,
			// name
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, 6, 2, 9, "Ground chicken")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, 4, 1, 6, "White navy beans")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, 4, 1, 6, "Fire roasted tomatoes")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, 5, 4, 4, "Chicken broth")'/*,
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, x, x, x, "Buffalo wing sauce")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, x, x, x, "Ranch dressing mix")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, x, x, x, "Corn")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, x, x, x, "Onion powder")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, x, x, x, "Garlic powder")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, x, x, x, "Celery salt")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, x, x, x, "Dried cilantro")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, x, x, x, "Salt")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, x, x, x, "Cream cheese")',
			'insert into ingredients (recipe_id, type, measure_amount, measure_id, name) values (1, x, x, x, "Blue cheese crumbles")'*/
		);
		
		$initialDirectionStrings = array(
			'insert into directions (recipe_id, step_number, direction) values (1, 1, "Brown ground chicken until fully cooked, place in slow cooker (or brown ahead of time and store in fridge until ready to assemble).")',
			'insert into directions (recipe_id, step_number, direction) values (1, 2, "Add remaining ingredients except for cream cheese and blue cheese and give it all a stir to combine.")',
			'insert into directions (recipe_id, step_number, direction) values (1, 3, "Add block of cream cheese on the top and cover.")',
			'insert into directions (recipe_id, step_number, direction) values (1, 4, "Cook on high for 4 hours or low on 8.")',
			'insert into directions (recipe_id, step_number, direction) values (1, 5, "Stir to incorporate cream cheese and add additional wing sauce as desired")',
			'insert into directions (recipe_id, step_number, direction) values (1, 6, "Top individual bowls with blue cheese crumbles if desired")'
		);
		
		$initialMenuStrings = array(
			// YYYY-MM-DD
			'insert into menus (name, menu_start_date, menu_end_date) values ("October 13-17", "2014-09-13", "2014-09-17")'
		);
		
		$initialMenuRecipeStrings = array(
			'insert into menus_recipes values (1, 1)',
			'insert into menus_recipes values (1, 2)',
			'insert into menus_recipes values (1, 3)',
			'insert into menus_recipes values (1, 4)',
			'insert into menus_recipes values (1, 5)'
		);
		
		$checkStrings = array(
			'select * from recipes',
			'select * from measures',
			'select * from types',
			'select * from ingredients',
			'select * from directions',
			'select * from menus',
			'select * from menus_recipes'
		);
		
		$checkRecipeIngredients =
			'select ingredients.measure_amount amount,
				measures.type amount_type,
				ingredients.name name
			from ingredients, measures
			where ingredients.recipe_id = 1
				and ingredients.measure_id = measures.id';
		
		$checkRecipeDirections =
			'select directions.step_number step,
				directions.direction direction
			from directions
			where directions.recipe_id = 1';
			
		$checkMenusRecipes =
			'select menus.name menu_name,
				recipes.name recipe_name
			from menus, recipes, menus_recipes
			where menus.id = menus_recipes.menu_id
				and recipes.id = menus_recipes.recipe_id
				and menus.id = 1';
		
		/*processQueries($db, $dropStrings);
		processQueries($db, $createStrings);
		processQueries($db, $measureStrings);
		processQueries($db, $ingredientTypeStrings);
		processQueries($db, $initialRecipeStrings);
		processQueries($db, $initialIngredientStrings);
		processQueries($db, $initialDirectionStrings);
		processQueries($db, $initialMenuStrings);
		processQueries($db, $initialMenuRecipeStrings);*/

        $db->ExecuteQueries($dropStrings);
        $db->ExecuteQueries($createStrings);
        $db->ExecuteQueries($measureStrings);
        $db->ExecuteQueries($ingredientTypeStrings);
        $db->ExecuteQueries($initialRecipeStrings);
        $db->ExecuteQueries($initialIngredientStrings);
        $db->ExecuteQueries($initialDirectionStrings);
        $db->ExecuteQueries($initialMenuStrings);
        $db->ExecuteQueries($initialMenuRecipeStrings);

        echo '<pre>Initialized recipe database.</pre>';
	}
	else {
		echo '<pre>';
		echo 'Could not find or initialize recipe database';
		echo '</pre>';
	}
	
	flush();
	
	function processQueries(&$db, $queries) {
		foreach($queries as $query) {
			try {
				$result = sqlite_query($db, $query);

                if(!$result)
                    echo 'Could not process query: ', $query, PHP_EOL;
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}
	
	function processArrayQueries(&$db, $queries) {
		foreach ($queries as $query) {
			try {
				$result = sqlite_array_query($db, $query);

                if(!$result)
                    echo 'Could not process query: ', $query, PHP_EOL;

				printArray($result);
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}
	
	function printArray($a) {
		echo '<pre>';
		print_r($a);
		echo '</pre>';
	}
	
	function printIngredients($ingredients) {
		echo '<pre>';
		foreach($ingredients as $ingredient) {
			$amount = $ingredient['amount'] . ' ' . $ingredient['amount_type'];
			$name = $ingredient['name'];

			echo $amount . ' ' . $name . PHP_EOL;
		}
		echo '</pre>';
	}
	
	function printDirections($directions) {
		echo '<pre>';
		foreach($directions as $direction) {
			$directionText = $direction['step'] . '. ' . $direction['direction'];

			echo $directionText . PHP_EOL;
		}
		echo '</pre>';
	}
	
	function printMenuRecipes($menuRecipes) {
		echo '<pre>';
		foreach($menuRecipes as $menuRecipe) {
			$recipe = $menuRecipe['menu_name'] . ': ' . $menuRecipe['recipe_name'];

			echo $recipe . PHP_EOL;
		}
		echo '</pre>';
	}
?>
