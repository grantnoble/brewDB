function calc_og()
{
	var max_ppg = 0;
	var kgs = 0;
	var lbs = 0;
	var litres = document.recipeform.batch_size.value;
	var gallons = 0;
	var eff = document.recipeform.mash_efficiency.value / 100;
	var gravity_points = 0;
	var og = 0;
	var fg = 0;
	var atten = document.recipeform.yeast0_attenuation.value / 100;
	var abv = 0;
	var flag = 0;

	for (var i = 0; i < 15; i++)
	{
		if (document.recipeform["fermentable"+i+"_name"].value)
		{
			max_ppg = document.recipeform["fermentable"+i+"_yield"].value * .47;
			kgs = document.recipeform["fermentable"+i+"_amount"].value;
			lbs = kgs * 2.20462;
			gallons = litres * 0.264172;
			gravity_points += max_ppg * eff * lbs / gallons;
			flag = 1;
		}
	}
	if (flag)
	{
		og = 1 + (gravity_points / 1000);
		document.recipeform.est_og.value = og.toFixed(3);
	}

	if (document.recipeform.yeast0_attenuation.value)
	{
		fg = 1 + ((gravity_points - (gravity_points * atten)) / 1000)
		document.recipeform.est_fg.value = fg.toFixed(3);
		abv = (og-fg) * 131;
		document.recipeform.est_abv.value = abv.toFixed(1);
	}
}
