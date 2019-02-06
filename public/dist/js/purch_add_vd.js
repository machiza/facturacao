$('document').ready(function()
{

	$('#suppID').change(function()
	{

		if($('#suppID').val()=='')
		{
			$('.suppVal').prop('hidden', false);
			$('#suppID').focus();
		}
		else
		{
			$('.suppVal').prop('hidden', true);
		}

	});

	$('#loc').change(function () 
	{
		if($('#loc').val()=='')
		{
			$('.locVal').prop('hidden', false);
			$('#loc').focus();
		}
		else
		{
			$('.locVal').prop('hidden', true);

		}
		
	});

});

