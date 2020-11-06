
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>CT Designs - Home</title>
    </head>
    <?php
        session_start();
        
        if($_SESSION['username']){
        } else {
            header("location:index.php");
        }
        

        $username = $_SESSION['username'];

        //GET CURRENT USER
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "dbPassword";
        $dbName = "design_items";

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

        if($conn -> connect_error){
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn -> query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $userId = $row["id"];
                $userEmail = $row["email_address"];
                $userFirst = $row["first_name"];
                $userLast = $row["last_name"];
            }
            $result->free();
        } else {
            echo 
                $userEmail = "n/a";
                $userFirst = "n/a";
                $userLast = "n/a";
                $userId = "n/a";
        }

        $updatedUserId = 200000 + $userId;
    ?>
    
    <body>
        <div class="flex-container">

            <div class="flex-child">
                <img src="images/ctLogo.png" width="250px"/>
            </div>
        
            <div class="flex-child">
                <p><?php Print "$userFirst $userLast ($username)"?></p>
                <p><?php Print "$userEmail"?></p>
                <p><?php Print "CID: $updatedUserId"?></p>
                <p><a href="logout.php">Log Out</a></p>
            </div>
        
        </div>
        
        <hr>
        
        
        <div class="main_grid">
        <?php
        //DISPLAY PRODCUTS
        $sql = "SELECT * FROM products";
        $result = $conn -> query($sql);

        if($result->num_rows > 0){
            echo "<table id='products'>
                <tbody>
                <tr>
                    <th>Product</th>
                    <th>Cost</th>
                    <th><img src='images/cart.png'width='30px'/></th>
                </tr>";
            while($row = $result->fetch_assoc()){
                $productName = $row["name"];
                $productCost = $row["cost"];

                echo 
                '<tr> 
                    <td>'.$productName.'</td> 
                    <td> $ '.$productCost.'.00 </td> 
                    <td><button class="tableButton" type="button" onclick="addToCart(this)">Add to Cart</button></td>
                </tr>';
            }
            echo "</tbody></table></br></br>";
            $result->free();
        } else {
            echo "0 results";
        }


        //DISPLAY SERVICES
        $sql = "SELECT * FROM services";
        $result = $conn -> query($sql);

        if($result->num_rows > 0){
            echo "<table id='services'>
                <tbody>
                <tr>
                    <th>Service</th>
                    <th>Cost</th>
                    <th><img src='images/cart.png'width='30px'/></th>
                </tr>";
            while($row = $result->fetch_assoc()){
                $serviceName = $row["name"];
                $serviceCost = $row["price"];

                echo 
                '<tr> 
                    <td >'.$serviceName.'</td> 
                    <td > $ '.$serviceCost.'.00 </td> 
                    <td><button class="tableButton" type="button" onclick="addToCart(this)">Add to Cart</button></td>
                </tr>';
            }
            echo "</tbody></table>";
            $result->free();
        } else {
            echo "0 results";
        }
        ?>
        </div>
        <br>
        <div id=cart>

            <table id=cart>
            
            <tr>
                <th>Quantity</th>
                <th>Item</th>
                <th>Cost</th>
            </tr>
            <tbody id=tableCart></tbody>
            <tfooter>
            <tr class="totalValue" >
                <td>TOTAL</td>
                <td> ----------</td>
                <td id=totalValue>$0.00</td>
            </tr>
            
            </tfooter>
            
            </table>
            
        </div>
        <button id="clear" type="button" onclick="emptyCart()">Clear Cart</button>
        <button id="print" type="button" onclick="printInvoice()">Print Invoice</button>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
        <script>
            
            var cart = []
            var total = []
        
            //ADD ITEMS TO TABLE
            function addToCart(element){
                var row = element.parentNode.parentNode.firstElementChild;
                var name = row.innerHTML;
                var price = row.nextElementSibling.innerHTML;
                
                
                cart.push(["1x", name, price])
                total.push(parseInt(price.replace('$ ', '')))
                
                document.getElementById("totalValue").innerHTML = "$ " + total.reduce(addTotal) + ".00"
                updateCartTable(cart)
            }

            //CREATE TABLE
            var tableBody = document.getElementById('tableCart');
                    
            function updateCartTable(cart){
                tableBody.innerHTML = '';
                cart.forEach(function(rowData){
                    var row = document.createElement('tr');

                    rowData.forEach(function(cellData){
                        var cell = document.createElement('td');
                        cell.appendChild(document.createTextNode(cellData));
                        row.appendChild(cell);
                    });
                
                    tableBody.appendChild(row);
                });
            }

            //ADD TOTAL VALUE
            function addTotal(values, num){
                return values + num
            }

            //CLEAR CART
            function emptyCart(){
                tableBody.innerHTML = '';
                totalValue.innerHTML = "$0.00";
                cart = [];
                total = [];

            }

            //PRINT INVOICE PDF
            
            var pdf = new jsPDF('p', 'pt', 'letter');

            function printInvoice(){

                var logo = new Image();
                
                //HEADER
                logo.onload = function(){ 
                    alert("Invoice is Ready")
                }

                logo.onerror = function(){
                    alert("Erro creating Invoice, Please try again")
                }
                logo.src = "images/ctLogo.png"
                pdf.addImage(logo, "PNG", 15, 15, 178, 109);
                
                pdf.setLineWidth(1);
                pdf.line(25, 120, 590, 120);
                
                pdf.text("Customer #: " + totalValue.innerHTML, 282, 50 )
                
                


                //BODY
                var cartTable = document.getElementById("cart");
                pdf.fromHTML(cartTable, 15, 250,{
                    width: 500
                });

                //FOOTER



                pdf.save("Invoice.pdf");
            }
        </script>
            
        <br>
        
    </body>
</html>