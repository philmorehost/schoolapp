<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'payment'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$get_flutterwave_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_fees_payment_gateway WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && gateway_name='flutterwave' LIMIT 1"));
				$edit_fee_list_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && fee_payment_id='".trim(strip_tags($_GET['edit']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_fee_list_checkmate) == 1)){
					if(mysqli_num_rows($edit_fee_list_checkmate) == 1){
						$edit_fee_list_detail = mysqli_fetch_array($edit_fee_list_checkmate);
						
						$edit_fee_list_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
					}
				}
			?>
			<?php
				if($get_flutterwave_details["status"] == "1"){
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_fee_list_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="numeric-class" onchange="findfeefeeClassSession(); feeClassSession(); feeTypeList(); schoolFeeAmount();" id="find-fee-class-session" class="form-select" required>
						<option selected disabled hidden value="">Select Class</option>
						<?php

						function className($class_info, $school_id){
							global $connection_server;
							$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info' GROUP BY numeric_class_name");
							if(mysqli_num_rows($get_class_name) == 1){
								while($class_name_array = mysqli_fetch_array($get_class_name)){
									$class_name .= $class_name_array["class_name"]." (".$class_name_array["numeric_class_name"].")";
								}
							}else{
								$class_name = "N/A";
							}
							return $class_name;
						}
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_admission_id_statement_auth." GROUP BY numeric_class_name");
							
							if(mysqli_num_rows($select_classes_detail_using_id) > 0){
								while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
									echo '<option value="'.$classes_details["numeric_class_name"].'" >'.className($classes_details["numeric_class_name"], $classes_details["school_id_number"]).'</option>';								
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Class Name*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="class-session" onchange="findClassSessionStudent(); feeClassSession();" id="add-fee-class-session" class="form-select" required>
						<option disabled hidden selected value="">Select Class Session</option>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Session Name*</span>
				</div>
				
				<select name="student-roll-number" onchange="feeTypeList();" id="student-roll-id" class="form-select" hidden required></select>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="fee-type" id="select-fee-type-id" onchange="schoolFeeAmount();" class="form-select" required>
						<option disabled hidden selected value="">Select Fee Type</option>
						
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Fee Type*</span>
				</div>
				
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="amount-paid" id="select-fee-type-amount-id" type="text" pattern="[0-9]{1,}" placeholder="" class="form-input" readonly required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Amount Paid*</span>
                </div>

				<?php
					$ref_char = "1234567890123456789012345678901234567890";
        			$online_ref = substr(str_shuffle($ref_char),0,10);
					$school_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='".$get_logged_user_details['school_id_number']."' LIMIT 1"));
	
				?>
                <input hidden id="fee-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
				
				<button onclick="makePaymentFlutterwave();" style="float: left; clear: left;" type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    PAY
				</button>
            </form>
            
			<script>
				function findfeefeeClassSession(){
					const find_fee_class_session = document.getElementById("find-fee-class-session");
					const add_fee_class_session = document.getElementById("add-fee-class-session");
					const fee_school_id_number = document.getElementById("fee-school-id");
					const select_fee_type_amount_id = document.getElementById("select-fee-type-amount-id");
					
					select_fee_type_amount_id.value = "";
					add_fee_class_session.innerHTML = "";
					const createSelectSessionOption = document.createElement("option");
					createSelectSessionOption.hidden = true;
					createSelectSessionOption.disabled = true;
					createSelectSessionOption.selected = true;
					createSelectSessionOption.text = "Select Class Session";
					createSelectSessionOption.value = "";
					add_fee_class_session.add(createSelectSessionOption);

					const classSessionHttpRequest = new XMLHttpRequest();
					classSessionHttpRequest.open("POST","./get-class-session.php");
					classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionHttpRequestBody = JSON.stringify({sch_no: fee_school_id_number.value, class_id_no: find_fee_class_session.value});

					classSessionHttpRequest.onload = function(){
						if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
							
							const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
							
							for(i=0; i < session_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = session_list_array[i].replace("-","/");
								createSelectOption.value = session_list_array[i];
								add_fee_class_session.add(createSelectOption);
							}
						}else{
							alert(classSessionHttpRequest.status);
						}
					}
					classSessionHttpRequest.send(classSessionHttpRequestBody);
					findClassSessionStudent();
				}

				function findClassSessionStudent(){
					const find_fee_class_session = document.getElementById("find-fee-class-session");
					const add_fee_class_session = document.getElementById("add-fee-class-session");
					const student_roll_id = document.getElementById("student-roll-id");
					const fee_school_id_number = document.getElementById("fee-school-id");
					const select_fee_type_amount_id = document.getElementById("select-fee-type-amount-id");
					
					select_fee_type_amount_id.value = "";
					const classSessionStudentHttpRequest = new XMLHttpRequest();
					classSessionStudentHttpRequest.open("POST","./get-student.php");
					classSessionStudentHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionStudentHttpRequestBody = JSON.stringify({sch_no: fee_school_id_number.value, class_id_no: find_fee_class_session.value, session: add_fee_class_session.value});
					classSessionStudentHttpRequest.onload = function(){
						if((classSessionStudentHttpRequest.readyState == 4) && (classSessionStudentHttpRequest.status == 200)){
							
							const student_list_array = Object.entries(JSON.parse(classSessionStudentHttpRequest.responseText)["response"]);
							
							for(i=0; i < student_list_array.length; i++){
								if(student_list_array[i][0] == "<?php echo $get_logged_user_details['admission_number']; ?>"){
									const createSelectOption = document.createElement("option");
									createSelectOption.text = student_list_array[i][1];
									createSelectOption.value = student_list_array[i][0];
									student_roll_id.add(createSelectOption);
								}
							}
						}else{
							alert(classSessionStudentHttpRequest.status);
						}
					}
					classSessionStudentHttpRequest.send(classSessionStudentHttpRequestBody);
					feeTypeList();
				}

				function feeTypeList(){
                    const find_fee_class_session = document.getElementById("find-fee-class-session");
                    const add_fee_class_session = document.getElementById("add-fee-class-session");
                    const student_roll_id = document.getElementById("student-roll-id");
                    const select_fee_type_id = document.getElementById("select-fee-type-id");
                    const fee_school_id_number = document.getElementById("fee-school-id");
					const select_fee_type_amount_id = document.getElementById("select-fee-type-amount-id");
					
					select_fee_type_amount_id.value = "";
                    select_fee_type_id.innerHTML = "";
                    const createSelectStudentOption = document.createElement("option");
                    createSelectStudentOption.hidden = true;
                    createSelectStudentOption.disabled = true;
                    createSelectStudentOption.selected = true;
                    createSelectStudentOption.text = "Select Fee Type";
                    createSelectStudentOption.value = "";
                    select_fee_type_id.add(createSelectStudentOption);

                    const classSessionStudentHttpRequest = new XMLHttpRequest();
                    classSessionStudentHttpRequest.open("POST","./get-student-fee-type.php");
                    classSessionStudentHttpRequest.setRequestHeader("Content-Type","application/json");
                    const classSessionStudentHttpRequestBody = JSON.stringify({sch_no: fee_school_id_number.value, class_id_no: find_fee_class_session.value, session: add_fee_class_session.value});
                    classSessionStudentHttpRequest.onload = function(){
                        if((classSessionStudentHttpRequest.readyState == 4) && (classSessionStudentHttpRequest.status == 200)){
                            
                            const student_list_array = Object.entries(JSON.parse(classSessionStudentHttpRequest.responseText)["response"]);
                            
                            for(i=0; i < student_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = student_list_array[i][1];
								createSelectOption.value = student_list_array[i][0];
								select_fee_type_id.add(createSelectOption);
                            }
                        }else{
                            alert(classSessionStudentHttpRequest.status);
                        }
                    }
                    classSessionStudentHttpRequest.send(classSessionStudentHttpRequestBody);
                }

				function schoolFeeAmount(){
					const select_fee_type_id = document.getElementById("select-fee-type-id");
					const select_fee_type_amount_id = document.getElementById("select-fee-type-amount-id");
					
					select_fee_type_amount_id.value = select_fee_type_id.value.split(" ")[1].trim(); 

				}

				function makePaymentFlutterwave() {
					const numeric_class = document.getElementById("find-fee-class-session").value;
                    const class_session = document.getElementById("add-fee-class-session").value;
                    const student_roll_id = document.getElementById("student-roll-id").value;
                    const fee_type_id = document.getElementById("select-fee-type-id").value.split(" ")[0].trim();
                    const fee_school_id_number = document.getElementById("fee-school-id").value;
					const fee_type_amount_id = document.getElementById("select-fee-type-amount-id").value;
					
					if((numeric_class.trim() != "") && (class_session.trim() != "") && (student_roll_id.trim() != "") && (fee_type_id.trim() != "") && (fee_school_id_number.trim() != "") && (Number(fee_type_amount_id) > 0) && (fee_type_amount_id.trim().length > 0)){
						const classPaymentHttpRequest = new XMLHttpRequest();
						classPaymentHttpRequest.open("POST","./chk-fee.php?type=check");
						classPaymentHttpRequest.setRequestHeader("Content-Type","application/json");
						const classPaymentHttpRequestBody = JSON.stringify({sch_no: fee_school_id_number, class_id_no: numeric_class, session: class_session, fee_type: fee_type_id, admission_no: student_roll_id});
						classPaymentHttpRequest.onload = function(){
							if((classPaymentHttpRequest.readyState == 4) && (classPaymentHttpRequest.status == 200)){
							const classPaymentResponse = JSON.parse(classPaymentHttpRequest.responseText)["response"];
								if(classPaymentResponse == 3){
									alert("Payment has already been made");
								}else{
									if(classPaymentResponse == 1){
										FlutterwaveCheckout({
											public_key: "<?php echo $get_flutterwave_details['public_key']; ?>",
											tx_ref: fee_school_id_number+"-<?php echo $online_ref; ?>",
											amount: fee_type_amount_id,
											currency: "<?php echo $school_details['currency']; ?>",
											payment_options: "card, banktransfer, ussd",
											redirect_url: "",
											meta: {
												consumer_id: student_roll_id,
												consumer_mac: "",
											},
											customer: {
												email: "<?php echo $get_logged_user_details['email']; ?>",
												phone_number: "<?php echo $get_logged_user_details['phone_number']; ?>",
												name: "<?php echo $get_logged_user_details['firstname'].' '.$get_logged_user_details['lastname'].' '.$get_logged_user_details['othername']; ?>",
											},
											customizations: {
												title: "<?php echo $school_details['school_name']; ?>",
												description: "",
												logo: "<?php echo $_SERVER["HTTP_HOST"].'/dataimg/school_'.$get_logged_user_details['school_id_number']; ?>",
											},
											callback: function(payment) {
												paymentCallBackRecord(fee_school_id_number, numeric_class, class_session, student_roll_id, fee_type_id, fee_type_amount_id, '<?php echo $online_ref; ?>');
											}
										});
										
									}else{
										if(classPaymentResponse == 2){
											alert("Payment still in progress, check back later");
										}
									}
								}
							}else{
								alert(classPaymentHttpRequest.status);
							}
						}
						classPaymentHttpRequest.send(classPaymentHttpRequestBody);
					
					}else{
						alert("Some fields are empty! Check and Try Again");
					}
				}

			</script>
            <?php } ?>
			<?php }else{ include("include/no-data-img.php"); } ?>
        </center>
    </div>
<?php } ?>
<?php } ?>