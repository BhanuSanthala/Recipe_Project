<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Website</title>
    <link rel="stylesheet" href="mainpagestyle.css">
    <script src="images/chickencurry.jpg"></script>
    <script>
        $(document).ready(function(){
            $(".show-more").click(function(){
                var recipe_id = $(this).attr("data-recipe-id");
                $.post("get_recipe_details.php", {recipe_id: recipe_id}, function(data){
                    $("#recipe-details-" + recipe_id).html(data);
                });
            });
        });
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/fruit-logo-food-recipe-business-png-favpng-HUvujmv3a23dftJfpeGxyFeaq.jpg" alt="Logo">
        </div>
        <div class="header-right">
            <a href="logout.php">Logout</a>
            <a href="aboutUs.html">About Us</a>
            <a href="contactUs.html">Contact Us</a>
        </div>
    </header>

    <div class="recipe-container">
        <!-- Recipes with "Click Here" button -->
        <?php
        // Fetch recipes from database or any other data source
        // Example: $recipes = fetchDataFromDatabase();
        // Loop through recipes and display each one
        for ($i = 1; $i <= 6; $i++) { // Assuming there are 6 recipes
            echo '<div class="product new">';
            echo '<div class="Recipe-Picture">';
            echo '<img src="images/recipe_'.$i.'.jpg" alt="recipe '.$i.'">';
            echo '</div>';
            echo '<div class="recipe-info">';
            echo '<h5 class="categories">Recipe '.$i.'</h5>';
            echo '<h4 class="title">Title '.$i.'</h4>';
            echo '<button class="show-more" data-recipe-id="'.$i.'">Click Here</button>';
            echo '<div id="recipe-details-'.$i.'" class="recipe-details"></div>'; // Container for recipe details
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
