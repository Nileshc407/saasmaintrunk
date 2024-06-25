<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Shopping Cart</title>    
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-1.11.2.min.js" integrity="sha256-Ls0pXSlb7AYs7evhd+VLnWsZ/AqEHcXBeMZUycz/CcA="  crossorigin="anonymous"></script>
    <script>
        var cart = [];
        $(function () {
            if(localStorage.cart)
            {
                cart = JSON.parse(localStorage.cart);
                showCart();
            }			
			if (cart.length == 0) {
                alert("You don't have any item(s) into cart");
				
				window.location.href = "index.php"; 
            }
        });
        

        function showCart() {
            if (cart.length == 0) {
                $("#cart").css("visibility", "hidden");
				$("#submit").css("visibility", "hidden");
                return;
            }

            $("#cart").css("visibility", "visible");
            $("#submit").css("visibility", "visible");
            $("#cartBody").empty();
			var Total=0;
            for (var i in cart) {
				
                var item = cart[i];
                var row = "<tr> <td>" + item.Product + "</td> <td>" +
                             item.Price + "</td><td>" + item.Qty + "</td><td>"
                             + item.Qty * item.Price + "</td><td>"
                             + "<button onclick='deleteItem(" + i + ")'>Delete</button></td></tr>";
					Total  = Total + (item.Qty * item.Price);
				//alert(Total);
                $("#cartBody").append(row);
				
            }
			var row1 = "<tr> <td> </td> <td> </td><td> Total: </td><td>"
                             + Total + "</td><td>"
                             + " </td></tr>";
			// $("#TotalPrice").html(Total);
			$("#cartBody").append(row1);
        }
		
		function deleteItem(index){
            cart.splice(index,1); // delete item at index
            showCart();
            saveCart();
        }
		function saveCart() {
            if ( window.localStorage)
            {
                localStorage.cart = JSON.stringify(cart);
            }
			if (cart.length == 0) {
				
                alert("You don't have any item(s) into cart");				
				window.location.href = "index.php";
            }
        }
    </script>
</head>
<body>
<br>
<div class="container">	
<h2> Your Shopping Items</h2>
		
   
	<div class="table-responsive">
    <table class="table" id="cart" border="1" style="visibility:hidden;">
         <thead>
              <tr>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Total</th>
                  <th></th>
             </tr>
         </thead>
         <tbody id="cartBody">

         </tbody>
    </table>	
</div>
</body>
</html>