<!--<div id="mobilewizardmaster">-->
<div id="smartwizard">

    <!--<ul style="">-->
    <ul style="display:none">
        <li><a href="#step-1">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-2">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-3">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-4">Step Title<br /><small>Step description</small></a></li>
    </ul>

    <div>
        <div id="step-1" class="">
            <input maxlength="100" type="text" required="required" class="form-control input-lg" placeholder="Enter your zip code" id="zipCodeBegin" name="zipCodeBegin" />
            <label class="control-label text-center h1" id="answerZipCode"><big></big></label>
            <div class="list-group" id="step3OtypeService">
                <a href="#" class="list-group-item" name="linkServiceType" onClick="" id="linkServiceTyperoof">
                    <input type="hidden" value="roofreport" name="typeServiceOrder">
                    <div class="row">
                        <div class="col-sx-4"><button class="btn-primary btn-sm" type="button" style="width:160px">Order Roof Report</button></div>    
                        <div class="col-sx-4"><h6>Get a detailed roof report for $29 within 2 hours. We create accurate aerial roof measurements and diagrams you can use to estimates material cost to replace your roof. If we cannot create the roof report for you due to aerial obstructions or roof complexity, we will refund your money guaranteed.</h6></div>
                    </div>
                </a>
            </div>
            <a href="#" onclick="fire_next_step()">Hola</a>
        </div>
        <div id="step-2" class="">
            <div class="list-group" id="step2OtypeService">
                <a href="#" class="list-group-item " name="linkServiceType" id="linkServiceTypeemergency">
                    <input type="hidden" value="emergency" name="typeServiceOrder">
                    <div class="row">
                        <div class="col-sx-6"><button class=" btn-primary   btn-sx" type="button" style="width:160px">Emergency Repair</button></div>
                        <div class="col-sx-6"><h>An emergency repair is a same day service. The first available rated service pro will choose your repair order and provide you with an ETA of when they will arrive at the repair location.  You will be able to review their ratings, communicate, send them pictures, and track their location. An estimate for your approval will be provided prior to start of work. </h6></div>
                    </td>
                </a>
                <a href="#" class="list-group-item" name="linkServiceType" id="linkServiceTypeschedule">
                    <input type="hidden" value="schedule" name="typeServiceOrder">
                    <div class="row">
                        <div class="col-sx-6"><button class=" btn-success   btn-sx" type="button" style="width:160px">Schedule Repair</button></div>
                        <div class="col-sx-6"><h6>A scheduled repair is scheduled a week in advance. You will be able to choose the service pro or allow the first available rated service pro will choose your repair order.</h6></div>
                    </div>
                </a>
                <a href="#" class="list-group-item" name="linkServiceType" id="linkServiceTypereroof">
                    <input type="hidden" value="reroofnew" name="typeServiceOrder">
                    <div class="row">
                        <div class="col-sx-6"><button class=" btn-primary   btn-sx" type="button" style="width:160px">Re-roof or new Roof</button></div>
                        <div class="col-sx-6"><h6>Reroof or new roof estimates are scheduled a week in advance. Choose the qualified, pre-screened service professional from a list or allow the first top rated professional to choose your work order. You can chat and track your order. That easy!</h6></div>
                    </div>
                </a>
            </div>
        </div>
        <div id="step-3" class="">
            Step Content 3
        </div>
        <div id="step-4" class="">
            Step Content 4
        </div>
    </div>
</div>  