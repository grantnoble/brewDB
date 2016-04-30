function calc_boil_size()
{
   if (document.recipeform.batch_size.value && document.recipeform.boil_time.value && document.recipeform.evaporation_rate.value)
	{
		var batch_size = document.recipeform.batch_size.value;
		var boil_time = document.recipeform.boil_time.value;
		var evaporation_rate = document.recipeform.evaporation_rate.value;
		document.recipeform.boil_size.value = Number(batch_size) + (evaporation_rate * boil_time / 60);

		calc_og_color_ibu();
	}
}
