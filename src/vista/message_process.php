<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }
   //var_dump($_SESSION);
?>
<script type="text/javascript">
    var timeleft = 10;
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0){
        clearInterval(downloadTimer);
        window.location.href = "index.php";
    }
    },1000);
</script>

<div id="step1contain" style="background-image: url('img/roof.home.wiz.bg.png'); width: 50%; height: 500px;">
    <div class="panel panel-primary" id="step-1">
        <div id="zip-panel-heading" class="panel-heading wizhead ">
            <h3 class="panel-title colorStandarWhite"><?php echo $_SESSION['response']['title'] ?></h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label text-center h1 colorStandarWhite"><big><?php echo $_SESSION['response']['subtitle'] ?></big></label>
                <label class="control-label text-center h1 colorStandarWhite" id="answerZipCode"><big><?php echo $_SESSION['response']['content'] ?></big></label>
            </div>        
            <div>
                <div class="form-group">
                    <center><p class="colorStandarWhite"> You will redirect to home in <span id="countdowntimer">10 </span> Seconds</p></center>
                </div>
            </div>
        </div>
    </div>
</div>



