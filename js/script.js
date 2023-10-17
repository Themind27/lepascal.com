$(function (){
	
	$('#contact-form').submit(function(e){
		
		e.preventDefault();
		$('.comment').empty();
		var postdata = $('#contact-form').serialize();
		
		$.ajax({
			
			type: 'POST',
			url: 'php/contact.php',
			data: postdata,
			dataType: 'json',
			success: function(result) {
				
				if(result.isallvalidate)
					{
						$('.thank-you').remove();
						$("#contact-form").append("<p class='thank-you'>Your message has successfully been sent. Thank you for contacting me</p>");
						$("#contact-form")[0].reset();
					}
				else
					{
						$("#givenname + .comment").html(result.givennameError);
						$("#surname + .comment").html(result.surnameError);
						$("#mail + .comment").html(result.mailError);
						$("#tel + .comment").html(result.telError);
						$("#message + .comment").html(result.messageError);
					}
				
			}
		});
	});

})