var ELEMENTS_SMART_VERIF = {

    request_url : document.getElementById('request_url'),
    request_url_confirmed : document.getElementById('request_url_confirmed'),
    csrf_token : document.getElementById('csrf_token'),
    goal_amount : document.getElementById('goal_amount'),
    currency_id : document.getElementById('currency_id'),
    title : document.getElementById('title'),
    description : document.getElementById('description'),
    start_date : document.getElementById('start_date'),
    end_date : document.getElementById('end_date'),
    priority : document.getElementById('priority'),
    verify_bnt : document.getElementById('verify_bnt'),
    show_verification_modal : document.getElementById('show_verification_modal'),
    validation_attr_div : document.getElementById('validation_attr_div'),
    validation_question : document.getElementById('validation_question'),
    modal_footer : document.getElementById('modal_footer'),
}

var SMART_VERIF = {

    showVarificationModal : function(response)
    {    
        if( response.verified == true ){
            verifiedConfig();
            
        }else{
            notVerifiedConfig();
        }

        ELEMENTS_SMART_VERIF.show_verification_modal.click();
        
        function verifiedConfig(){
        
            ELEMENTS_SMART_VERIF.modal_footer.innerHTML = "";
            ELEMENTS_SMART_VERIF.validation_attr_div.innerHTML = ''
            +'<b>The proposed smart planning is valid accourding to the following info:</b><br><br>'
            +'<b>Goal Amount:</b> ' + ELEMENTS_SMART_VERIF.goal_amount.value+'<br>'
            +'<b>Currency:</b> '+ ELEMENTS_SMART_VERIF.currency_id.options[ELEMENTS_SMART_VERIF.currency_id.selectedIndex].text+'<br>'
            +'<b>Title:</b> '+ response.transaction_details.title+'<br>';

            if(response.transaction_details.repeat_id == 1){
                repeat_type = "One Time";
                ELEMENTS_SMART_VERIF.validation_attr_div.innerHTML += ''
                +'<b>Frequency:</b> '+ repeat_type+'<br>'
                +'<b>Amount/Frequency:</b> '+ response.transaction_details.amount+'<br>'
                +'<b>Start Date:</b> '+ response.transaction_details.start_date+'<br>';
            }else if(response.transaction_details.repeat_id == 3){
                repeat_type = "Weekly Basis";
                ELEMENTS_SMART_VERIF.validation_attr_div.innerHTML += ''
                +'<b>Frequency:</b> '+ repeat_type+'<br>'
                +'<b>Amount/Frequency:</b> '+ (Math.round(response.transaction_details.amount * 100) / 100)+'<br>'
                +'<b>Start Date:</b> '+ response.transaction_details.start_date+'<br>'
                +'<b>End Date:</b> '+ response.transaction_details.end_date+'<br>';
            }else if(response.transaction_details.repeat_id == 4){
                repeat_type = "Monthly Basis";
                ELEMENTS_SMART_VERIF.validation_attr_div.innerHTML += ''
                +'<b>Frequency:</b> '+ repeat_type+'<br>'
                +'<b>Amount/Frequency:</b> '+ (Math.round(response.transaction_details.amount * 100) / 100)+'<br>'
                +'<b>Start Date:</b> '+ response.transaction_details.start_date+'<br>'
                +'<b>End Date:</b> '+ response.transaction_details.end_date+'<br>'
                +'';
            }

            ELEMENTS_SMART_VERIF.validation_question.innerHTML = 
                'Would you like to confirm on adding the plan?!';
            
            let newConfirmBtn = document.createElement('button');   
            newConfirmBtn.id = 'confirm_btn';
            newConfirmBtn.className="btn btn-default";
            newConfirmBtn.innerHTML = "Confirm";

            newConfirmBtn.addEventListener('click',function(){
                window.location.assign(ELEMENTS_SMART_VERIF.request_url_confirmed.value);
            });
            
            ELEMENTS_SMART_VERIF.modal_footer.appendChild(newConfirmBtn);

        }
        function notVerifiedConfig(){
            ELEMENTS_SMART_VERIF.modal_footer.innerHTML = "";
            ELEMENTS_SMART_VERIF.validation_attr_div.innerHTML = ''
                +'Unfortunately this plan <strong>cannot be valid</strong>. '
                +'It\'s either your goal amount is bigger than you balance, '
                +'or the time is too short.. ';
            
            ELEMENTS_SMART_VERIF.validation_question.innerHTML = 
                'Please try another plan...';

            let newCancelBtn = document.createElement('button');
            newCancelBtn.id = 'cancel_btn';
            newCancelBtn.className="btn btn-default";
            newCancelBtn.innerHTML = "Retry";

            var att = document.createAttribute("data-dismiss");
            att.value = "modal";
            newCancelBtn.setAttributeNode(att);

            ELEMENTS_SMART_VERIF.modal_footer.appendChild(newCancelBtn);
        }
    },
    varify : function(){

        const URL = ELEMENTS_SMART_VERIF.request_url.value;
        let that = this;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: URL,
            data: {     
                '_token': ELEMENTS_SMART_VERIF.csrf_token.value,
                'goal_amount' : ELEMENTS_SMART_VERIF.goal_amount.value,
                'currency_id' :ELEMENTS_SMART_VERIF.currency_id.value,
                'title':ELEMENTS_SMART_VERIF.title.value,
                'description':ELEMENTS_SMART_VERIF.description.value,
                'start_date':ELEMENTS_SMART_VERIF.start_date.value,
                'end_date':ELEMENTS_SMART_VERIF.end_date.value,
                'priority' : ELEMENTS_SMART_VERIF.priority.value,
            },
            dataType: 'JSON',
            success: function (data) { 
                console.log("success of request");
                console.log(data);
                that.showVarificationModal(data);      
            },
            error: function (request, status, error) {
                console.log("error in request");
                if ( request.status == 401 ) {
                    console.log("error in request 401");
                    let error_msgs = JSON.parse(request.responseText);
                    inputErrorHandler(error_msgs);
                }
            }
        });
        function inputErrorHandler (error_msgs){

            if( typeof error_msgs.goal_amount != "undefined" ){
                ELEMENTS_SMART_VERIF.goal_amount.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.goal_amount[0];
                insertAfter(newSpan, ELEMENTS_SMART_VERIF.goal_amount);   
            }
            if( typeof error_msgs.title != "undefined" ){
                ELEMENTS_SMART_VERIF.title.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.title[0];
                insertAfter(newSpan, ELEMENTS_SMART_VERIF.title);   
            }
            if( typeof error_msgs.description != "undefined" ){
                ELEMENTS_SMART_VERIF.description.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.description[0];
                insertAfter(newSpan, ELEMENTS_SMART_VERIF.description);   
            }
            if( typeof error_msgs.currency_id != "undefined" ){
                ELEMENTS_SMART_VERIF.currency_id.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.currency_id[0];
                insertAfter(newSpan, ELEMENTS_SMART_VERIF.currency_id);   
            }
            if( typeof error_msgs.start_date != "undefined" ){
                ELEMENTS_SMART_VERIF.start_date.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.start_date[0];
                insertAfter(newSpan, ELEMENTS_SMART_VERIF.start_date);   
            }
            if( typeof error_msgs.end_date != "undefined" ){
                ELEMENTS_SMART_VERIF.end_date.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.end_date[0];
                insertAfter(newSpan, ELEMENTS_SMART_VERIF.end_date);   
            }
        }
        function insertAfter(el, referenceNode) {
            referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
        }
    },
    init : function (){
        ELEMENTS_SMART_VERIF.verify_bnt.addEventListener('click',this.varify.bind(this));
    }
}

window.addEventListener('load',function(){

    smart_verif = Object.create(SMART_VERIF);
    smart_verif.init(); 
 
});
