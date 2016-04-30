function validate_fermentables() 
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
			if (amount == null || amount == "")
			{
				error += "- Fermentable requires an amount\n";
			}
			if (yield == null || yield == "")
			{
				error += "- Fermentable requires a yield\n";
			}
			if (color == null || color == "")
			{
				error += "- Fermentable requires a color\n";
			}
		}
	}
    return error;
}
