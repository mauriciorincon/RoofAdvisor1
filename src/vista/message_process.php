<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }
   //var_dump($_SESSION);
?>
<!--<script type="text/javascript">
    var timeleft = 10;
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0){
        clearInterval(downloadTimer);
        window.location.href = "index.php?controller=user&accion=dashboardCustomer";
    }
    },1000);
</script>-->

<div id="step1contain" style="background-image: url('img/roof.home.wiz.bg.png'); width: 50%; height: 500px;">
    <div class="panel panel-primary" id="step-1">
        <div id="zip-panel-heading" class="panel-heading wizhead ">
            <h3 class="panel-title colorStandarWhite"><?php echo $_SESSION['response']['title'] ?></h3>
        </div>
        <input type="hidden" value="<?php echo $_SESSION['response']['passUser'] ?>" id="inputPassword" />
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label text-center h1 colorStandarWhite"><big><?php echo $_SESSION['response']['subtitle'] ?></big></label>
                <label class="control-label text-center h1 colorStandarWhite" id="answerZipCode"><big><?php echo $_SESSION['response']['content'] ?></big></label>
            </div>        
            <div>
                <div class="form-group">
                    <h4>Type your activation code</h4>
                    <input type="text" id="activation_code_input" />
                </div>
                <div>
                    <div class="alert alert-danger" role="alert">    
                        <table>
                            <tr>
                                <td><strong>Did not get a code?</strong></td>
                            </tr>
                            <tr>
                                <td>Check your cell phone</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="btn-primary btn-sm" onclick="resendValidationCode('<?php echo $_SESSION['response']['emailUser'];?>','Customer_register','phone','c')">REQUEST A NEW</a></td>
                                <td><a href="#" class="btn-primary btn-sm" onclick="resendValidationCode('<?php echo $_SESSION['response']['emailUser'];?>','Customer_register','email','c')">SEND ME THE VALIDATION CODE BY EMAIL</a></td>
                            </tr>
                        </table>
                    </div>
                    
                    <button type="button" id="finishService" class="btn-success" data-dismiss="modal" onclick="validate_sms_code('c','<?php echo $_SESSION['response']['emailUser'];?>','Customer_register')">Validate Code</button>
                </div>
                <div>
                    <div class="alert alert-primary" role="alert" id="labelResponseValidationCode">
                        Validation Response
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



