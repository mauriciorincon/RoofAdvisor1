function getRequestType(requestType){
    var RequestType="";
    switch (requestType) {
        case "E":
            RequestType = "Emergency";
            break;
        case "S":
            RequestType = "Schedule";
            break;
        case "R":
            RequestType = "RoofReport";
            break;
        case "P":
            RequestType = "PostCard";
            break;
        case "M":
            RequestType = "Re-roof or New";
            break;
        default:
            RequestType = "No value found";
    }
    return RequestType;
}

function getStatus(status){
    var orderStatus="";
    switch (status) {
        case "A":
            orderStatus = "Order Open";
            break;
        case "C":
            orderStatus = "Acepted Order";
            break;
        case "D":
            orderStatus = "Order Assigned";
            break;
        case "E":
            orderStatus = "Contractor Just Arrived";
            break;
        case "F":
            orderStatus = "Estimate Sent";
            break;
        case "G":
            orderStatus = "Estimate Approved";
            break;
        case "H":
            orderStatus = "Work In Progress";
            break;
        case "I":
            orderStatus = "Work Completed";
            break;
        case "J":
            orderStatus = "Final Bill";
            break;
        case "K":
            orderStatus = "Order Completed Paid";
            break;
        case "Z":
            orderStatus = "Cancel work";
            break;
        case "P":
            orderStatus = "Report In Progress";
            break;
        case "R":
            orderStatus = "Report In Progress";
            break;
        case "S":
            orderStatus = "Report Complete";
            break;
        case "T":
            orderStatus = "Orden In Progress";
            break;
        case "U":
            orderStatus = "Orden Asigned";
            break;
        case "M":
            orderStatus = "Mailed";
            break;
        default:
            orderStatus = "Undefined";
    }
    return orderStatus;
}

function getIconImage(Status){
    var image="";
    if(Status==='A'){
        image="open_service.png";
    }else if(Status=='D'){
        image="open_service_d.png";
    }else if(Status=='E'){
        image="open_service_e.png";
    }else if(Status=='F'){
        image="open_service_f.png";
    }else if(Status=='G'){
        image="open_service_g.png";
    }else if(Status=='H'){
        image="open_service_h.png";
    }else if(Status=='I'){
        image="open_service_i.png";
    }else if(Status=='J'){
        image="open_service_j.png";
    }else if(Status=='K'){
        image="open_service_k.png";
    }else if(Status=='C'){
        image="open_service_c.png";
    }else if(Status=='P'){
        image="open_service_p.png";
    }else if(Status=='R'){
        image="open_service_r.png";
    }else if(Status=='S'){
        image="open_service_s.png";
    }else{
        image="if_sign-error_299045.png";
    }
    return image;
}

function actionsCustomer(dataOrder){
    if((dataOrder.Status=="A" || dataOrder.Status=="D" || dataOrder.Status=="E" || dataOrder.Status=="F") && dataOrder.RequestType!="R"){
        actions='<a class="btn-danger btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Cancel service" '+  
                'href="" '+
                'onClick="cancelService(\''+dataOrder.FBID+'\',\'Status,Z\')">'+
                '<span class="glyphicon glyphicon-trash"></span> '+
            '</a>';
    }else{
        actions='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Cancel service" '+  
                    'href="" '+
                    'onClick="alert(\'Order cant be cancel\')">'+
                    '<span class="glyphicon glyphicon-trash"></span> '+
                '</a>';
    }
    if((dataOrder.Status=="A" || dataOrder.Status=="D" || dataOrder.Status=="C" || dataOrder.Status=="P") && dataOrder.RequestType!="R"){
        actions+='<a class="btn-primary btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Change Schedule" '+
                'href="#myScheduleChange" '+
                'onClick="getOrderScheduleDateTime(\''+dataOrder.FBID+'\')"> '+ 
                '<span class="glyphicon glyphicon-calendar"></span> '+
            '</a>';
    }else{
        actions+='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Change Schedule" '+
                'href="" '+
                'onClick="alert(\'the schedule can not be readjusted\')">'+
                '<span class="glyphicon glyphicon-calendar"></span> '+
            '</a>';
    }
    if(dataOrder.Status=="S" || dataOrder.Status=="K"){
        actions+='<a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Rating Service" '+
                    'href="#myRatingScore" '+
                    'onClick="setOrderSelected(\''+dataOrder.OrderNumber+'\',\''+dataOrder.FBID+'\')"> '+ 
                    '<span class="glyphicon glyphicon-star"></span>'+
                '</a>';
    }else{
        actions+='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Rating Service" '+
                    'href="" '+
                    'onClick="alert(\'Order must be complete to make rating\')">'+ 
                    '<span class="glyphicon glyphicon-star-empty"></span>'+
                '</a>';
    }
    actions+='<a class="btn-info btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Invoice Info"  '+
                'href="" '+
                'onClick="getInvoices(\''+dataOrder.FBID+'\')"> '+
                '<span class="glyphicon glyphicon-list-alt"></span>'+
            '</a>';
    actions+='<a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                        'href="" '+
                        'onClick="getCommentary(\''+dataOrder.FBID+'\')">'+ 
                        '<span class="glyphicon glyphicon-comment"></span>'+
                    '</a>';
    actions+='<a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="View Report"  '+
                    'href="#" '+
                    'onClick="getListReportFile(\''+dataOrder.FBID+'\')"> '+
                    '<span class="glyphicon glyphicon-download-alt"></span>'+
                '</a>';
    return actions;

}



function actionsCompany(dataOrder,companyStatus){
    
        actions='<a class="btn-info btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Invoice Info" '+
                                    'href="#" '+ 
                                    'onClick="getInvoices(\''+dataOrder.FBID+'\')">'+ 
                                    '<span class="glyphicon glyphicon-list-alt"></span>'+
                                '</a>';
        if(companyStatus!="Active"){    
            actions+='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+ 
                        'href="" '+
                        'onClick="alert(\'You can not create comment until the company is active\')"> '+
                        '<span class="glyphicon glyphicon-comment"></span>'+
                        '</a>';
        }else{ 
            if(dataOrder.ContractorID==null || dataOrder.ContractorID==""){ 
                actions+='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                                'href="" '+
                                'onClick="alert(\'You can not create comments to an order that you have not taken\')"> '+
                                '<span class="glyphicon glyphicon-comment"></span>'+
                            '</a>';
            }else{
                actions+='<a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                                'href="" '+
                                'onClick="getCommentary(\''+dataOrder.FBID+'\')">'+ 
                                '<span class="glyphicon glyphicon-comment"></span>'+
                            '</a>';    
            }
            actions+='<a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files" '+ 
                            'href="#" ' +
                            'onClick="getListReportFile(\''+dataOrder.FBID+'\')">'+ 
                            '<span class="glyphicon glyphicon-upload"></span>'+
                        '</a>';
        }
    return actions;
}

function takeJobCompany(dataOrder,companyStatus,contractorName){
    if(dataOrder.ContractorID=="" || dataOrder.ContractorID==null){
        if(dataOrder.RequestType=='R' || dataOrder.RequestType=='P'){
            dataContractor='<a class="btn-default btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"'+
                    'href="" '+
                    'onClick="alert(\'Only RoofServiceNow can take this type of service\')"> '+
                    '<span class="glyphicon glyphicon-check"></span>Take work</a>';

        }else{
            
                if(companyStatus=='Active'){
                    dataContractor='<a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"'+
                                'href="#myModalGetWork" '+
                                'onClick="setOrderId(\''+dataOrder.FBID+'\',\''+dataOrder.RequestType+'\')" > '+
                                '<span class="glyphicon glyphicon-check"></span>Take work</a>';        
                }else{
                        dataContractor='<a class="btn-danger btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"'+
                            'href="" '+
                            'onClick="alert(\'You can not take the job until the company is active\')"> '+
                            '<span class="glyphicon glyphicon-check"></span>Take work</a>';
                } 
        }
        
    }else{
        dataContractor=contractorName; 
    }
    
    return dataContractor;
}

function getOrderInfo(){

}
/*echo '<script type="text/javascript">',
												'document.write(\'Hello World\');',
											'</script>';*/
										/*switch ($order['RequestType']) {
											case "E":
												echo "Emergency";
												break;
											case "S":
												echo "Schedule";
												break;
											case "R":
												echo "RoofReport";
												break;
											case "P":
												echo "PostCard";
												break;
											default:
												echo "Undefined";
												break;
                                        }*/
                                        
/*switch ($order['Status']) {
											case "A":
												echo "Order Open";
												break;
											case "C":
												echo "Acepted Order";
												break;
											case "D":
												echo "Order Assigned";
												break;
											case "E":
												echo "Contractor Just Arrived";
												break;
											case "F":
												echo "Estimate Sent";
												break;
											case "G":
												echo "Estimate Approved";
												break;
											case "H":
												echo "Work In Progress";
												break;
											case "I":
												echo "Work Completed";
												break;
											case "J":
												echo "Final Bill";
												break;
											case "K":
												echo "Order Completed Paid";
												break;
											case "Z":
												echo "Cancel work";
												break;
											case "P":
												echo "Report In Progress";
												break;
											case "R":
												echo "Report In Progress";
												break;
											case "S":
												echo "Report Complete";
												break;
											case "T":
												echo "Orden In Progress";
												break;
											case "U":
												echo "Orden Asigned";
												break;
											case "M":
												echo "Orden Asigned";
												break;
											default:
												echo "Undefined";
												break;
                                        }*/
                                        

                                      /*  
                                      <?php if((strcmp($order['Status'],"A")==0 or strcmp($order['Status'],"D")==0 or strcmp($order['Status'],"E")==0 or strcmp($order['Status'],"F")==0) and strcmp($order['RequestType'],"R")!=0){?>

										<a class="btn-danger btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Cancel service" 
											href="" 
											onClick="<?php echo "cancelService('".$order['FBID']."','Status,Z')"; ?>" > 
											<span class="glyphicon glyphicon-trash"></span>
										</a>
									<?php }else{ ?>
										<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"   title="Cancel service" 
											href="" 
											onClick="alert('Order can\'t be cancel')" > 
											<span class="glyphicon glyphicon-trash"></span>
										</a>
									<?php } ?>
                                      if((strcmp($order['Status'],"A")==0 or strcmp($order['Status'],"D")==0 or strcmp($order['Status'],"C")==0 or strcmp($order['Status'],"P")==0) and strcmp($order['RequestType'],"R")!=0){?>
                                            <a class="btn-primary btn-sm" data-toggle="modal"   data-toggle1="tooltip"  title="Change Schedule" 
                                                        href="#myScheduleChange" 
                                                        onClick="<?php echo "getOrderScheduleDateTime('".$order['FBID']."')" ?>"> 
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                            </a>
                                        <?php }else{ ?>
                                            <a class="btn-default btn-sm" data-toggle="modal"   data-toggle1="tooltip"  title="Change Schedule" 
                                                        href="" 
                                                        onClick="alert('The schedule can not be readjusted')"> 
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                            </a>
                                        <?php } ?>
                                            <?php if(strcmp($order['Status'],"S")==0 or strcmp($order['Status'],"K")==0){ ?>
                                                <a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Rating service"  
                                                            href="#myRatingScore" 
                                                            onClick="<?php echo "setOrderSelected('".$order['OrderNumber']."','".$order['FBID']."')" ?>"> 
                                                            <span class="glyphicon glyphicon-star"></span>
                                                </a>
                                            <?php }else{ ?>
                                                <a class="btn-default btn-sm" data-toggle="modal"   data-toggle1="tooltip"  title="Rating service"  
                                                            href="" 
                                                            onClick="alert('Order must be complete to make rating')" > 
                                                            <span class="glyphicon glyphicon-star-empty"></span>
                                                </a>
                                            <?php } ?>
                                        
        
                                                <a class="btn-info btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Invoice Info"  
                                                            href="#" 
                                                            onClick="<?php echo "getInvoices('".$order['FBID']."')" ?>"> 
                                                            <span class="glyphicon glyphicon-list-alt"></span>
                                                </a>
                                                <a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments"  
                                                href="#" 
                                                onClick="<?php echo "getCommentary('".$order['FBID']."')" ?>"> 
                                                <span class="glyphicon glyphicon-comment"></span>
                                                <a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="View Report"  
                                                    href="#" 
                                                    onClick="<?php echo "getListReportFile('".$order['FBID']."')" ?>"> 
                                                    <span class="glyphicon glyphicon-download-alt"></span>
                                                </a>*/

/*<a class="btn-info btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Invoice Info"  
                                href="" 
                                onClick="<?php echo "getInvoices('".$order['FBID']."')" ?>"> 
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </a>
                            <?php if(strcmp($_actual_company['CompanyStatus'],'Active')!==0){ ?>
                                <a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments"  
                                    href="" 
                                    onClick="alert('You can not create comment until the company is active')"> 
                                    <span class="glyphicon glyphicon-comment"></span>
                                </a>
                            <?php }else{ 
                                    if(!isset($order['ContractorID']) or empty($order['ContractorID'])){ 
                                ?>
                                    <a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments"  
                                        href="" 
                                        onClick="alert('You can not create comments to an order that you have not taken')"> 
                                        <span class="glyphicon glyphicon-comment"></span>
                                    </a>
                                    <?php }else{ ?>
                                        <a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments"  
                                        href="" 
                                        onClick="<?php echo "getCommentary('".$order['FBID']."')" ?>"> 
                                        <span class="glyphicon glyphicon-comment"></span>
                                    </a>
                            <?php 
                            }} ?>
                            <a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files"  
                                href="#" 
                                onClick="<?php echo "getListReportFile('".$order['FBID']."')" ?>"> 
                                <span class="glyphicon glyphicon-upload"></span>
                            </a>*/

/*if(strcmp($order['RequestType'],"R")==0 or strcmp($order['RequestType'],"P")==0){
                                        ?>
                                        <a class="btn-default btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"  
                                            href="" 
                                            onClick="alert('Only RoofServiceNow can take this type of service')"> 
                                            <span class="glyphicon glyphicon-check"></span>Take work
                                        </a>
                                    <?php }else{
                                        if(!isset($order['ContractorID']) or empty($order['ContractorID'])){
                                            if(strcmp($_actual_company['CompanyStatus'],'Active')!==0){
                                            ?>
                                                <a class="btn-danger btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"  
                                                    href="" 
                                                    onClick="alert('You can not take the job until the company is active')"> 
                                                    <span class="glyphicon glyphicon-check"></span>Take work
                                                </a>
                                    <?php   }else{ ?>
                                            <a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"  
                                                    href="#myModalGetWork" 
                                                    onClick="setOrderId('<?php echo $order['FBID']?>')"> 
                                                    <span class="glyphicon glyphicon-check"></span>Take work
                                                </a>
                                       <?php }
                                        }else{
                                            $_contractorName=$this->_userModel->getNode('Contractors/'.$order['ContractorID'].'/ContNameFirst');
                                            $_contractorName.=" ".$this->_userModel->getNode('Contractors/'.$order['ContractorID'].'/ContNameLast');
    
                                            echo $_contractorName;
                                        } 
                                    }*/