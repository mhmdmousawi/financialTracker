
var ELEMENTS_VERIFICATION = {
    request_url : document.getElementById('request_url'),
    csrf_token : document.getElementById('csrf_token'),
    goal_amount : document.getElementById('goal_amount'),
    amount : document.getElementById('amount'),
    currency_id : document.getElementById('currency_id'),
    category_id : $("#add_saving_form input[name=category_id]"),
    title : document.getElementById('title'),
    description : document.getElementById('description'),
    start_date : document.getElementById('start_date'),
    repeat_id : document.getElementById('repeat_id'),
    verify_bnt : document.getElementById('verify_bnt'),
    validation_result : document.getElementById('validation_result'),
    validation_attr_div : document.getElementById('validation_attr_div'),
    validation_question : document.getElementById('validation_question'),
    confirm_btn : document.getElementById('confirm_btn'),
    modal_footer : document.getElementById('modal_footer'),
    submit_btn : document.getElementById('submit_btn'),
    saving_varification_modal : document.getElementById('saving_varification_modal'),
    show_verification_modal : document.getElementById('show_verification_modal'),
}

var VERIFICATION = {
    
    showVarificationModal : function(response){
        
        // let data = response;//.data;
        // alert(response);

        ELEMENTS_VERIFICATION.validation_attr_div.innerHTML = ' '
            + '<p> This Saving Plan of title <b>' + response.request_params.title +'</b>'
            +' would take up to <b>' + response.end_date +'</b> to achieve it\'s  '
            +' <b>' + response.request_params.goal_amount +'</b> goal ..</p> '
            + '<br>';
        ELEMENTS_VERIFICATION.modal_footer.innerHTML="";

        if( response.verified == true ){
            verifiedConfig();
            
        }else{
            notVerifiedConfig();
        }

        ELEMENTS_VERIFICATION.show_verification_modal.click();
        


        function verifiedConfig(){
            ELEMENTS_VERIFICATION.validation_result.innerHTML = ''
                +'Fortunately this plan is <strong>Valid</strong> !';
            ELEMENTS_VERIFICATION.validation_question.innerHTML = 
                'Would you like to confirm on adding the plan?!';
            
            let newConfirmBtn = document.createElement('button');   
            newConfirmBtn.id = 'confirm_btn';
            newConfirmBtn.className="btn btn-default";
            newConfirmBtn.innerHTML = "Confirm";

            newConfirmBtn.addEventListener('click',function(){
                ELEMENTS_VERIFICATION.submit_btn.setAttribute('type','submit');
                ELEMENTS_VERIFICATION.submit_btn.click();
            });
            
            ELEMENTS_VERIFICATION.modal_footer.appendChild(newConfirmBtn);

        }
        function notVerifiedConfig(){
            ELEMENTS_VERIFICATION.validation_result.innerHTML = ''
                +'Unfortunately this plan is <strong>Not Valid</strong> !';
            ELEMENTS_VERIFICATION.validation_question.innerHTML = 
                'Please try another plan...';

            let newCancelBtn = document.createElement('button');
            newCancelBtn.id = 'cancel_btn';
            newCancelBtn.className="btn btn-default";
            newCancelBtn.innerHTML = "Retry";

            var att = document.createAttribute("data-dismiss");
            att.value = "modal";
            newCancelBtn.setAttributeNode(att);

            ELEMENTS_VERIFICATION.modal_footer.appendChild(newCancelBtn);
        }
    },
    
    varify : function(){

        const URL = ELEMENTS_VERIFICATION.request_url.value;
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
                '_token' : ELEMENTS_VERIFICATION.csrf_token.value,
                'goal_amount' : ELEMENTS_VERIFICATION.goal_amount.value,
                'amount' : ELEMENTS_VERIFICATION.amount.value,
                'currency_id' :ELEMENTS_VERIFICATION.currency_id.value,
                'category_id':$("#add_saving_form input[name=category_id]").val(),
                'title':ELEMENTS_VERIFICATION.title.value,
                'description':ELEMENTS_VERIFICATION.description.value,
                'start_date':ELEMENTS_VERIFICATION.start_date.value,
                'repeat_id':ELEMENTS_VERIFICATION.repeat_id.value,
            },
            dataType: 'JSON',
            success: function (data) { 
                console.log("success of request");
                that.showVarificationModal(data);      
            },
            error: function (request, status, error) {
                console.log("error in request");
                console.log(JSON.parse(request.responseText));
                if ( request.status == 401 ) {
                    console.log("error in request 401");
                    let error_msgs = JSON.parse(request.responseText);
                    inputErrorHandler(error_msgs);
                }
            }
        });

        function inputErrorHandler (error_msgs){

            if( typeof error_msgs.goal_amount != "undefined" ){
                ELEMENTS_VERIFICATION.goal_amount.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.goal_amount[0];
                insertAfter(newSpan, ELEMENTS_VERIFICATION.goal_amount);   
            }
            if( typeof error_msgs.amount != "undefined" ){
                ELEMENTS_VERIFICATION.amount.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.amount[0];
                insertAfter(newSpan, ELEMENTS_VERIFICATION.amount);   
            }
            if( typeof error_msgs.title != "undefined" ){
                ELEMENTS_VERIFICATION.title.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.title[0];
                insertAfter(newSpan, ELEMENTS_VERIFICATION.title);   
            }
            if( typeof error_msgs.description != "undefined" ){
                ELEMENTS_VERIFICATION.description.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.description[0];
                insertAfter(newSpan, ELEMENTS_VERIFICATION.description);   
            }
            if( typeof error_msgs.currency_id != "undefined" ){
                ELEMENTS_VERIFICATION.currency_id.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.currency_id[0];
                insertAfter(newSpan, ELEMENTS_VERIFICATION.currency_id);   
            }
            if( typeof error_msgs.category_id != "undefined" ){
                ELEMENTS_VERIFICATION.category_id.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.category_id[0];
                insertAfter(newSpan, ELEMENTS_VERIFICATION.category_id);   
            }
            if( typeof error_msgs.repeat_id != "undefined" ){
                ELEMENTS_VERIFICATION.repeat_id.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.repeat_id[0];
                insertAfter(newSpan, ELEMENTS_VERIFICATION.repeat_id);   
            }
            if( typeof error_msgs.start_date != "undefined" ){
                ELEMENTS_VERIFICATION.start_date.className += " form-control is-invalid";
                let newSpan = document.createElement('span');
                newSpan.className = "invalid-feedback";
                newSpan.innerHTML = error_msgs.start_date[0];
                insertAfter(newSpan, ELEMENTS_VERIFICATION.start_date);   
            }
        }
        function insertAfter(el, referenceNode) {
            referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
        }
    },
    init : function (){
        ELEMENTS_VERIFICATION.verify_bnt.addEventListener('click',this.varify.bind(this));
        
    }
}

window.addEventListener('load',function(){

    verification = Object.create(VERIFICATION);
    verification.init(); 
 
});