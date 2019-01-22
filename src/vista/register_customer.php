<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }
   
?>

<script src='https://www.google.com/recaptcha/api.js'></script>
<br>
<br>
<br>
<br>
<br>
<div class="container" align="center">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panelCustomer">
            <div class="stepwizard-step col-xs-6"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>Register Here</small></p>
            </div>
            
            <div class="stepwizard-step col-xs-6"> 
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>Email Verification</small></p>
            </div>
            
        </div>
    </div>

    <form role="form" action="controlador/ajax/insertCustomer.php" method="POST" align="left" style="background-image: url('img/roof.home.wiz.bg.png'); width: 50%; height: 100%;" >

    <?php
            $_otherModel=new othersController();
            $_array_state=$_otherModel->getParameterValue('Parameters/state');
            include_once('vista/register_customer_screen.php'); 
        ?>
        
        
        
        <div class="panel panel-primary setup-contentCustomer" id="step-2">
            <div class="panel-heading">
                 <h3 class="panel-title">Email Verification</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label labeltwht text-center h1" id="validatingMessajeCode" name="validatingMessajeCode"><big></big></label>
                    
                </div>
                <button class="btn btn-primary prevBtnCustomer pull-left" id="prevBtnRegisterCustomer" name="prevBtnRegisterCustomer" type="button">Register</button>
            </div>
        </div>
        
        
    </form>
    
</div>




<?php
if(isset($_SESSION['post_info'])){
    unset($_SESSION['post_info']);
}

?>

