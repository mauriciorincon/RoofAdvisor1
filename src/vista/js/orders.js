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
        case "G":
            RequestType = "Generic";
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
                'onClick="getInvoices(\''+dataOrder.FBID+'\',\'customer\')"> '+
                '<span class="glyphicon glyphicon-list-alt"></span>'+
            '</a>';
    actions+='<a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                        'href="" '+
                        'onClick="getCommentary(\''+dataOrder.FBID+'\')">'+ 
                        '<span class="glyphicon glyphicon-comment"></span>'+
                    '</a>';
    actions+='<a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Doc Share"  '+
                    'href="#" '+
                    'onClick="getListReportFile(\''+dataOrder.FBID+'\')"> '+
                    '<span class="glyphicon glyphicon-download-alt"></span>'+
                '</a>';
    return actions;

}



function actionsCompany(dataOrder,companyStatus){
    
        actions='<a class="btn-info btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Invoice Info" '+
                                    'href="" '+ 
                                    'onClick="getInvoices(\''+dataOrder.FBID+'\',\'company\')">'+ 
                                    '<span class="glyphicon glyphicon-list-alt"></span>'+
                                '</a>';
        if(dataOrder.ContractorID==null || dataOrder.ContractorID==""){ 
            if(companyStatus!="Active"){  
                actions+='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+ 
                    'href="" '+
                    'onClick="alert(\'You can not create comment until the company is active\')"> '+
                    '<span class="glyphicon glyphicon-comment"></span>'+
                    '</a>';
                actions+='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files" '+ 
                    'href="#" ' +
                    'onClick="alert(\'You can not upload files until the company is active\')"> '+
                    '<span class="glyphicon glyphicon-upload"></span>'+
                '</a>';
            }else{
                actions+='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                            'href="" '+
                            'onClick="alert(\'You can not create comments to an order that you have not taken\')"> '+
                            '<span class="glyphicon glyphicon-comment"></span>'+
                        '</a>';
                actions+='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files" '+ 
                        'href="" ' +
                        'onClick="alert(\'You can not upload files to an order that you have not taken\')"> '+
                        '<span class="glyphicon glyphicon-upload"></span>'+
                    '</a>';
            } 
            
        }else{
            actions+='<a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                            'href="" '+
                            'onClick="getCommentary(\''+dataOrder.FBID+'\')">'+ 
                            '<span class="glyphicon glyphicon-comment"></span>'+
                        '</a>';    
            actions+='<a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files" '+ 
                        'href="" ' +
                        'onClick="getListReportFile(\''+dataOrder.FBID+'\')">'+ 
                        '<span class="glyphicon glyphicon-upload"></span>'+
                    '</a>';
        }
        actions+='<a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Rating Service" '+
        'href="#myRatingScore" '+
        'onClick="setOrderSelected(\''+dataOrder.OrderNumber+'\',\''+dataOrder.FBID+'\')"> '+ 
        '<span class="glyphicon glyphicon-star"></span>'+
        '</a>';   
    return actions;
}

function takeJobCompany(dataOrder,companyStatus,contractorName){
    if(dataOrder.ContractorID=="" || dataOrder.ContractorID==null){
        if(dataOrder.RequestType=='R' || dataOrder.RequestType=='P'){
            dataContractor='<a class="btn-default btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the work"'+
                    'href="" '+
                    'onClick="alert(\'Only RoofServiceNow can take this type of service\')"> '+
                    '<span class="glyphicon glyphicon-check"></span>Take work</a>';

        }else{
            
                if(companyStatus=='Active'){
                    dataContractor='<a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the work"'+
                                'href="#myModalGetWork" '+
                                'onClick="setOrderId(\''+dataOrder.FBID+'\',\''+dataOrder.RequestType+'\',\''+getTypePricing(dataOrder)+'\')" > '+
                                '<span class="glyphicon glyphicon-check"></span>Take work</a>';        
                }else{
                        dataContractor='<a class="btn-danger btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the work"'+
                            'href="" '+
                            'onClick="alert(\'You can not take the job until the company is active\')"> '+
                            '<span class="glyphicon glyphicon-check"></span>Take work</a>';
                } 
        }
        
    }else{
        var nextStatus="";
        var nextStatusTitle="";
        switch (dataOrder.Status) {
            case "D":
                nextStatusTitle= "Arrived";
                titleMessage="Arrived";
                nextStatus = "E";
                break;
            case "E":
                nextStatusTitle= "Send Estimate";
                titleMessage="Estimate Sent";
                nextStatus = "F";
                break;
            case "G":
                nextStatusTitle= "Work In Progress";
                titleMessage="Work in Progress";
                nextStatus = "H";
                break;
            case "H":
                nextStatusTitle= "Work Completed";
                titleMessage="Work Completed";
                nextStatus = "I";
                break;
            case "I":
                nextStatusTitle= "Final Bill";
                titleMessage="Final Bill";
                nextStatus = "J";
                break;
            default:
                nextStatus = "";
                nextStatusTitle= "";
                titleMessage="";
                break;
        }
        if(nextStatus==""){
            dataContractor=contractorName;
        }else{
            if(nextStatus=="F"){
                dataContractor='<a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Estimate Amount"'+
                'href="#myEstimateAmount" '+
                'onClick="setOrder(\''+dataOrder.FBID+'\',\'orderID\')" > '+
                '<span class="glyphicon glyphicon-check"></span>'+contractorName+' '+nextStatusTitle+'</a>';
            }else if (nextStatus=="J"){
                dataContractor='<a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Final Amount"'+
                'href="#myFinalAmount" '+
                'onClick="setOrder(\''+dataOrder.FBID+'\',\'orderIDFinal\')" > '+
                '<span class="glyphicon glyphicon-check"></span>'+contractorName+' '+nextStatusTitle+'</a>';
            }else{
                dataContractor='<a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the work"'+
                'href="" '+
                'onClick="updateOrder(\''+dataOrder.FBID+'\',\'Status,'+nextStatus+'\',\'\',\''+titleMessage+'\')" > '+
                '<span class="glyphicon glyphicon-check"></span>'+contractorName+' '+nextStatusTitle+'</a>';
            }
            
        }
    }
    
    return dataContractor;
}

function getTypePricing(dataOrder){
    if (dataOrder.CompanyID=='' || dataOrder.CompanyID==null || dataOrder.CompanyID==undefined){
        var option='L';
        switch(dataOrder.RequestType){
            case "S":
                option += "R";
                break;
            case "M":
                option += "N";
                break;
            default:
                option = "";
        }
        switch(dataOrder.Rtype){
            case "Flat":
                option += "F";
                break;
            case "Asphalt":
                option += "A";
                break;
            case "Wood Shake/Composite":
                option += "W";
                break;
            case "Metal":
                option += "M";
                break;
            case "Tile":
                option += "T";
                break;
            case "Do not know":
                option += "A";
                break;
            default:
                option = "";
        }
    }else{
        option = "";
    }
    
    return option;
}
