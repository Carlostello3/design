<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>CT Designs - Home</title>
    </head>
    <?php
        session_start();
        
        if($_SESSION['username']){
        } else {
            header("location:index.html");
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
        
            <div id=customerInfo class="flex-child">
                <p id=customerName><?php Print "$userFirst $userLast ($username)"?></p>
                <p id=customerEmail><?php Print "$userEmail"?></p>
                <p id=customerId><?php Print "CID: $updatedUserId"?></p>
                <p><a href="logout.php">Log Out</a></p>
            </div>
        
        </div>
        
        <hr>
        
        
        <div class="flex-container-tables">
            <div class="flex-child-tables">
                <?php
                    //DISPLAY PRODCUTS
                    $sql = "SELECT * FROM products";
                    $result = $conn -> query($sql);

                    if($result->num_rows > 0){
                        echo "<table id='products'>
                            <h3>PRODUCTS</h3>
                            <tbody>
                            <tr>
                                <th>Item</th>
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
                ?>
            </div>


            <div class="flex-child-tables">
                <?php
                    //DISPLAY SERVICES
                    $sql = "SELECT * FROM services";
                    $result = $conn -> query($sql);

                    if($result->num_rows > 0){
                        echo "<table id='services'>
                            <h3>SERVICES</h3>
                            <tbody>
                            <tr>
                                <th>Item</th>
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

        <footer>
                CT Designs &#169 - 2020
        </footer>

        <!-- JAVASCRIPT -->
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
            var userFirstLast = document.getElementById('customerName').innerHTML
            var userEmail = document.getElementById('customerEmail').innerHTML
            var userID = document.getElementById('customerId').innerHTML
            var cartTable = document.getElementById("cart");
            var invoiceNumber = "Invoice #: " + Math.floor(Math.random() * (100000 - 1 + 1)) + 1;
            var today = new Date();
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

            function printInvoice(){
                pdf.setFontSize(12);

                var logo = new Image();
                
                //HEADER
                logo.onload = function(){ 
                    alert("Invoice is Ready")
                }

                logo.onerror = function(){
                    alert("Error creating Invoice, Please try again")
                }
                logo.src = "images/ctLogo.png"
                pdf.addImage(logo, "PNG", 15, 15, 178, 109);

                pdf.text(date, 500, 80);
                pdf.text(invoiceNumber, 500, 100);
                
                pdf.setLineWidth(1);
                pdf.line(25, 120, 590, 120);
                
                //BILL TO INFORMATION
                pdf.setFontType('bold');
                pdf.text("Bill To:", 25, 150);

                pdf.setFontType('normal');
                pdf.text(userFirstLast, 25, 170);
                pdf.text(userEmail, 25, 190);
                pdf.text(userID, 25, 210);
                
                
                //BODY
                pdf.fromHTML(cartTable, 30, 250);

                pdf.setFontSize(10);
                pdf.setFontType('bold');
                pdf.text("Payment Instructions:", 25, 700);

                pdf.setFontType('normal');
                pdf.text("Please send payment to payments@CTDesigns.com within 24 hours of receiving this invoice. \nThere will be a 5% fee added to late invoices.", 25, 710);

                pdf.text("\nIf you are happy with your service today, please take a minute to leave a review!", 25, 720);
                //FOOTER
                pdf.line(25, 750, 590, 750);
                pdf.setFontSize(8);
                pdf.text("CT Designs - 2020", 265, 765);


                pdf.save("Invoice.pdf");
            }
        </script>
            
        <br>
        
    </body>
</html>