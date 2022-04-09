<?php
//index.php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>EASYSHOP PAYMENT PAGE</title>
		<link rel="stylesheet" type="text/css" href="about.css">
	<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style>
		.popover
		{
		    width: 100%;
		    max-width: 800px;
		}
		</style>
	</head>
	<body>
	
	<a href="easyshop.html"><i class="fa fa-home btn btn-success btn-lg" role="button">HOME</i></a>
     <a href="logout.php" role="button" align="right" >Logout</a>
		<div class="container">
			<br />
			<h3 align="center"><a href="easyshop.html">WELCOME TO EASYSHOP PRODUCT PAGE</a></h3>
			<br />
			<nav class="navbar navbar-default" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Menu</span>
						<span class="glyphicon glyphicon-menu-hamburger"></span>
						</button>
						<a class="navbar-brand" href="/">Click To View Cart</a>
					</div>
					<div id="navbar-cart" class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li>
								<a id="cart-popover" class="btn" data-placement="bottom" title="Shopping Cart">
									<span class="glyphicon glyphicon-shopping-cart"></span>
									<span class="badge"></span>
									<span class="total_price">Rs. 0.00</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			
			<div id="popover_content_wrapper" style="display: none">
				<span id="cart_details"></span>
				<div align="right">
					<a href="order_process.php" class="btn btn-primary" id="check_out_cart">
						<span class="glyphicon glyphicon-shopping-cart"></span> Check out
					</a>
					<a href="#" class="btn btn-default" id="clear_cart">
						<span class="glyphicon glyphicon-trash"></span> Clear
					</a>
				</div>
			</div>

			
			
			<?php
				if(isset($_SESSION["success_message"]))
				{
					echo '
					<div class="alert alert-success">
					'.$_SESSION["success_message"].'
					</div>
					';
					unset($_SESSION["success_message"]);
				}
				?>

			<div id="display_item" class="row">

			</div>

				
				<br />
				<br />
			</div>
		</div>
	</body>
  <div align="center">
  <a href="getlocation.html"><i class="pl-2 fa fa-google btn btn-success btn-lg" role="button">ET DIRECTION --></i></a></div>
  <br><br>
</html>

<script>  
$(document).ready(function(){

	load_product();

	load_cart_data();

	function load_product()
	{
		$.ajax({
			url:"fetch_item.php",
			method:"POST",
			success:function(data)
			{
				$('#display_item').html(data);
			}
		})
	}

	function load_cart_data()
	{
		$.ajax({
			url:"fetch_cart.php",
			method:"POST",
			dataType:"json",
			success:function(data)
			{
				$('#cart_details').html(data.cart_details);
				$('.total_price').text(data.total_price);
				$('.badge').text(data.total_item);
			}
		})
	}

	$('#cart-popover').popover({
		html : true,
		container : 'body',
		content:function(){
			return $('#popover_content_wrapper').html();
		}
	});

	$(document).on('click', '.add_to_cart', function(){
		var product_id = $(this).attr('id');
		var product_name = $('#name'+product_id+'').val();
		var product_price = $('#price'+product_id+'').val();
		var product_quantity = $('#quantity'+product_id).val();
		var action = 'add';
		if(product_quantity > 0)
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{product_id:product_id, product_name:product_name, product_price:product_price, product_quantity:product_quantity, action:action},
				success:function(data)
				{
					load_cart_data();
					alert("Item has been Added into Cart");
				}
			})
		}
		else
		{
			alert("Please Enter Number of Quantity");
		}
	});

	$(document).on('click', '.delete', function(){
		var product_id = $(this).attr('id');
		var action = 'remove';
		if(confirm("Are you sure you want to remove this product?"))
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{product_id:product_id, action:action},
				success:function(data)
				{
					load_cart_data();
					$('#cart-popover').popover('hide');
					alert("Item has been removed from Cart");
				}
			})
		}
		else
		{
			return false;
		}
	});

	$(document).on('click', '#clear_cart', function(){
		var action = 'empty';
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{action:action},
			success:function()
			{
				load_cart_data();
				$('#cart-popover').popover('hide');
				alert("Your Cart has been clear");
			}
		})
	});
    
});

</script>

<footer >
		<div style="width:100%;">
			<div style="float:left;">
			<p class="text-right text-info">  &copy; 2021 EASYSHOP Ltd .</p>	
			</div>
			<div style="float:right;">
			<p class="text-right text-info">	Desinged By : PHCET_SE_A6</p>
			</div>
		</div>
		</footer>	