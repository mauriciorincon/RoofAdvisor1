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