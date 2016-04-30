function calc_color()
{
	var color = 0;
	var mcu = 0;
	var kgs = 0;
	var lbs = 0;
	var litres = document.recipeform.batch_size.value;
	var gallons = 0;
	var flag = 0;

	for (var i = 0; i < 15; i++)
	{
		if (document.recipeform["fermentable"+i+"_name"].value)
		{
			color = document.recipeform["fermentable"+i+"_color"].value;
			kgs = document.recipeform["fermentable"+i+"_amount"].value;
			lbs = kgs * 2.20462;
			gallons = litres * 0.264172;
			mcu += color * lbs / gallons;
			flag = 1;
		}
	}
	if (flag)
	{
		adjust_mcu = 1.49 * Math.pow(mcu,0.69);
		document.recipeform.est_color.value = adjust_mcu.toFixed(0);
	}
}
