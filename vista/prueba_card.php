<?php
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/ajax/CCreditCard.php"); ?>      
<?php     
 if(!isset($_POST['submit']))      
 {      
 ?>      
      
   <h2>Validate Credit Card</h2>      
   <form name="frmCC" action="prueba_card.php" method="post">      
      
   Cardholders name: <input type="text" name="ccName"><br>      
   Card number: <input type="text" name="ccNum"><br>      
   Card type: <select name="ccType">      
   <option value="1">mastercard</option>      
   <option value="2">Visa</option>      
   <option value="3">Amex</option>      
   <option value="4">Diners</option>      
   <option value="5">Discover</option>      
   <option value="6">JCB</option>      
   </select><br>      
      
   Expiry Date: <select name="ccExpM">       
      
   <?php      
      
     for($i = 1; $i < 13; $i++)      
     { echo '<option>' . $i . '</option>'; }      
      
   ?>       
      
   </select>      
      
   <select name="ccExpY">      
      
   <?php      
      
     for($i = 2002; $i < 2023; $i++)      
     { echo '<option>' . $i . '</option>'; }      
      
   ?>       
      
   </select><br><br>      
      
   <input type="submit" name="submit" value="Validate">      
   </form>      
      
   <?      
      
   }      
   else      
   {      
   // Check if the card is valid 
   $ccName=$_POST['ccName'];
   $ccType=$_POST['ccType'];
   $ccNum=$_POST['ccNum'];
   $ccExpM=$_POST['ccExpM'];
   $ccExpY=$_POST['ccExpY'];
   $cc = new CCreditCard($ccName, $ccType, $ccNum, $ccExpM, $ccExpY);      
      
   ?>      
      
   <h2>Validation Results</h2>      
   <b>Name: </b><?=$cc->Name(); ?><br>      
   <b>Number: </b><?=$cc->SafeNumber('x', 6); ?><br>      
   <b>Type: </b><?=$cc->Type(); ?><br>      
   <b>Expires: </b><?=$cc->ExpiryMonth() . '/' .      
   $cc->ExpiryYear(); ?><br><br>      
      
   <?php      
       
     echo '<font color="blue" size="2"><b>';       
      
     if($cc->IsValid())      
     echo 'VALID CARD';      
     else      
     echo 'INVALID CARD';      
      
     echo '</b></font>';      
   }      
?>