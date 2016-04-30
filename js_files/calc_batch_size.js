function calc_batch_size()
{
   if (document.recipeform.boil_size.value && document.recipeform.boil_time.value && document.recipeform.evaporation_rate.value)
	{
		var boil_size = document.recipeform.boil_size.value;
		var boil_time = document.recipeform.boil_time.value;
		var evaporation_rate = document.recipeform.evaporation_rate.value;
		document.recipeform.batch_size.value = boil_size - (evaporation_rate * boil_time / 60);
	
		calc_og_color_ibu();
	}
}
