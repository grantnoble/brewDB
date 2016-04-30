function validate_amount() 
{
	var i;
	var error = "";

	for (i=0; i<=14; i++)
	{
		var name = document.recipeform["fermentable"+i+"_name"].value;
		var amount = document.recipeform["fermentable"+i+"_amount"].value;
		var yield = document.recipeform["fermentable"+i+"_yield"].value;
		var color = document.recipeform["fermentable"+i+"_color"].value;

		if (name)
		{
			document.recipeform["fermentable"+i+"_amount"].setCustomValidity("This email is already registered!");
		}
	}
    return;
}
