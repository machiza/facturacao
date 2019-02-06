$('document').ready(function()
{
	$('#suppID').change(function()
	{

		if($('#suppID').val()=='')
		{
			$('.suppVal').prop('hidden', false);
			$('#suppID').focus();
			$('#status').val('false');
		}
		else
		{
			$('.suppVal').prop('hidden', true);
			$('#status').val('true');
		}

	});

	$('#loc').change(function () 
	{
		if($('#loc').val()=='')
		{
			$('.locVal').prop('hidden', false);
			$('#loc').focus();
			$('#status').val('false');
		}
		else
		{
			$('.locVal').prop('hidden', true);
			$('#status').val('true');

		}
		
	});

	/*$('#btnSubmit').click(function(e)
	{	
		e.preventDefault();
		if($('#suppID').val()=='')
		{
			$('.suppVal').prop('hidden', false);
			$('#suppID').focus();
			$('#status').val('false');
		}

		if($('#loc').val()=='')
		{
			$('.locVal').prop('hidden', false);
			$('#loc').focus();
			$('#status').val('false');
		}

		if($('#status').val()=='true')
		{
			
			
		}

	});*/

});