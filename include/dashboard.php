<?php
	//Get Teacher Table
	if(isset($_SESSION["sup_adm_session"])){
		$count_teachers_table = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_teachers"));
		$count_school_admin_table = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs"));
		$count_moderators_table = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_moderators"));
		$count_parents_table = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_parents"));
		$count_students_table = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_students"));
		$count_school_notice = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_notices"));
		$select_all_fees_payment = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists ORDER BY numeric_class_name, session, starting_year, date DESC LIMIT 8");
		$select_all_class = mysqli_query($connection_server, "SELECT * FROM sm_classes ORDER BY numeric_class_name, session DESC LIMIT 5");
		$select_all_exam = mysqli_query($connection_server, "SELECT * FROM sm_exams ORDER BY numeric_class_name, session, term_id_number, exam_start_date DESC LIMIT 5");
		$select_all_attendance = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances GROUP BY numeric_class_name, session ORDER BY numeric_class_name, session DESC LIMIT 5");
		$select_all_notice = mysqli_query($connection_server, "SELECT * FROM sm_notices ORDER BY start_date DESC LIMIT 5");
		$select_all_notification = mysqli_query($connection_server, "SELECT * FROM sm_notifications ORDER BY session DESC LIMIT 5");
		$select_all_holiday = mysqli_query($connection_server, "SELECT * FROM sm_holidays ORDER BY start_date DESC LIMIT 5");
		
	}else{
		$count_teachers_table = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='".$get_school_identification["school_id_number"]."'"));
		$count_school_admin_table = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='".$get_school_identification["school_id_number"]."'"));
		$count_parents_table = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='".$get_school_identification["school_id_number"]."'"));
		$count_students_table = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".$get_school_identification["school_id_number"]."'"));
		$count_school_notice = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_notices WHERE school_id_number='".$get_school_identification["school_id_number"]."' ".$user_notice_statement_auth));
		$select_all_fees_payment = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' ".$user_admission_id_statement_auth." ORDER BY numeric_class_name, session, starting_year, date DESC LIMIT 8");
		$select_all_class = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' ".$user_class_statement_auth." ORDER BY numeric_class_name, session DESC LIMIT 5");
		$select_all_exam = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' ".$user_class_statement_auth." ORDER BY numeric_class_name, session, term_id_number, exam_start_date DESC LIMIT 5");
		$select_all_attendance = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' ".$user_class_statement_auth." GROUP BY numeric_class_name, session ORDER BY numeric_class_name, session DESC LIMIT 5");
		$select_all_notice = mysqli_query($connection_server, "SELECT * FROM sm_notices WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' ".$user_notice_statement_auth." ORDER BY start_date DESC LIMIT 5");
		$select_all_notification = mysqli_query($connection_server, "SELECT * FROM sm_notifications WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' ".$user_notification_statement_auth." ORDER BY session DESC LIMIT 5");
		$select_all_holiday = mysqli_query($connection_server, "SELECT * FROM sm_holidays WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' ORDER BY start_date DESC LIMIT 5");
		
	}

	function smsClassName($class_info,$session_info,$school_id){
		global $connection_server;
		
		$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info' && session='$session_info'");
		if(mysqli_num_rows($get_class_name) == 1){
			while($class_name_array = mysqli_fetch_array($get_class_name)){
				$class_name .= $class_name_array["class_name"];
			}
		}else{
			$class_name = "N/A";
		}
		
		return $class_name;
	}

	function smsSubjectName($subject_info,$school_id){
		global $connection_server;
		
		$get_subject_name = mysqli_query($connection_server,"SELECT * FROM sm_subjects WHERE school_id_number='$school_id' && subject_code='$subject_info'");
		if(mysqli_num_rows($get_subject_name) == 1){
			while($subject_name_array = mysqli_fetch_array($get_subject_name)){
				$subject_name .= $subject_name_array["subject_name"];
			}
		}else{
			$subject_name = "N/A";
		}
		
		return $subject_name;
	}
	
	function smsTermName($terms_info,$school_id){
		global $connection_server;
		
		$get_term_name = mysqli_query($connection_server,"SELECT * FROM sm_terms WHERE school_id_number='$school_id' && id_number='$terms_info'");
		if(mysqli_num_rows($get_term_name) == 1){
			while($term_name_array = mysqli_fetch_array($get_term_name)){
				$term_name .= $term_name_array["term_name"];
			}
		}else{
			$term_name = "N/A";
		}
		
		return $term_name;
	}
	
	function smsStudentName($student_info,$school_id){
		global $connection_server;
		
		$get_student_name = mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$student_info'");
		if(mysqli_num_rows($get_student_name) == 1){
			while($student_name_array = mysqli_fetch_array($get_student_name)){
				$student_name .= $student_name_array["firstname"]." ".$student_name_array["lastname"]." ".$student_name_array["othername"];
			}
		}else{
			$student_name = "N/A";
		}
		
		return $student_name;
	}
	
	function smsFeeTypeName($fee_info,$school_id){
		global $connection_server;
		
		$get_fee_name = mysqli_query($connection_server,"SELECT * FROM sm_fee_type WHERE school_id_number='$school_id' && id_number='$fee_info'");
		if(mysqli_num_rows($get_fee_name) == 1){
			while($fee_name_array = mysqli_fetch_array($get_fee_name)){
				$fee_name .= $fee_name_array["fee_name"];
			}
		}else{
			$fee_name = "N/A";
		}
		
		return $fee_name;
	}
	
?>
	<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<div class="dash_sys_first_section">
				<div class="dash_sys_div system-width-33">
					<?php if(($user_identifier_auth_id == "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){ ?>
					<a href="/bc-admin.php?page=smgt_school&tab=true">
						<div style="display: inline-block;" class="container-box box-shadow bg-2 mobile-width-90 system-width-45 mobile-margin-top-5 system-margin-top-1 system-margin-left-2 system-margin-right-2 mobile-padding-top-5 system-padding-top-8 mobile-padding-bottom-5 system-padding-bottom-8">
							<img src="imgfile/Supportstaff_dashboard.png" style="" class="bg-8 mobile-width-10 system-width-20 mobile-margin-top-3 system-margin-top-3 mobile-padding-top-5 system-padding-top-8 mobile-padding-left-5 system-padding-left-8 mobile-padding-right-5 system-padding-top-right-8 mobile-padding-bottom-5 system-padding-bottom-8"/><br>
							<span class="color-1 text-bold-500 mobile-font-size-40 system-font-size-30">
								<?php echo $count_moderators_table; ?>
							</span><br>
							<span class="color-5 mobile-font-size-20 system-font-size-18">
								School Admins
							</span>
						</div>
					</a>
					<?php } ?>
					<?php if(($user_identifier_auth_id == "super_mod") || ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){ ?>
					<a <?php if($user_identifier_auth_id == "super_mod"){echo 'style="pointer-events: none;"'; } ?> href="/bc-admin.php?page=smgt_teacher&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
						<div style="display: inline-block;" class="container-box box-shadow bg-2 mobile-width-90 system-width-45 mobile-margin-top-5 system-margin-top-1 system-margin-left-2 system-margin-right-2 mobile-padding-top-5 system-padding-top-8 mobile-padding-bottom-5 system-padding-bottom-8">
							<img src="imgfile/Parents_dashboard.png" style="" class="bg-8 mobile-width-10 system-width-20 mobile-margin-top-3 system-margin-top-3 mobile-padding-top-5 system-padding-top-8 mobile-padding-left-5 system-padding-left-8 mobile-padding-right-5 system-padding-top-right-8 mobile-padding-bottom-5 system-padding-bottom-8"/><br>
							<span class="color-1 text-bold-500 mobile-font-size-40 system-font-size-30">
								<?php echo $count_teachers_table; ?>
							</span><br>
							<span class="color-5 mobile-font-size-20 system-font-size-18">
								Teachers
							</span>
						</div>
					</a>
					<a <?php if($user_identifier_auth_id == "super_mod"){echo 'style="pointer-events: none;"'; } ?> href="/bc-admin.php?page=smgt_adminstaff&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
						<div style="display: inline-block;" class="container-box box-shadow bg-2 mobile-width-90 system-width-45 mobile-margin-top-5 system-margin-top-1 system-margin-left-2 system-margin-right-2 mobile-padding-top-5 system-padding-top-8 mobile-padding-bottom-5 system-padding-bottom-8">
							<img src="imgfile/Supportstaff_dashboard.png" style="" class="bg-8 mobile-width-10 system-width-20 mobile-margin-top-3 system-margin-top-3 mobile-padding-top-5 system-padding-top-8 mobile-padding-left-5 system-padding-left-8 mobile-padding-right-5 system-padding-top-right-8 mobile-padding-bottom-5 system-padding-bottom-8"/><br>
							<span class="color-1 text-bold-500 mobile-font-size-40 system-font-size-30">
								<?php echo $count_school_admin_table; ?>
							</span><br>
							<span class="color-5 mobile-font-size-20 system-font-size-18">
								Admin Staffs
							</span>
						</div>
					</a>
					<a <?php if($user_identifier_auth_id == "super_mod"){echo 'style="pointer-events: none;"'; } ?> href="/bc-admin.php?page=smgt_student&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
						<div style="display: inline-block;" class="container-box box-shadow bg-2 mobile-width-90 system-width-45 mobile-margin-top-5 system-margin-top-5 system-margin-left-2 system-margin-right-2 mobile-padding-top-5 system-padding-top-8 mobile-padding-bottom-5 system-padding-bottom-8">
							<img src="imgfile/Students_dashboard.png" style="" class="bg-8 mobile-width-10 system-width-20 mobile-margin-top-3 system-margin-top-3 mobile-padding-top-5 system-padding-top-8 mobile-padding-left-5 system-padding-left-8 mobile-padding-right-5 system-padding-top-right-8 mobile-padding-bottom-5 system-padding-bottom-8"/><br>
							<span class="color-1 text-bold-500 mobile-font-size-40 system-font-size-30">
								<?php echo $count_students_table; ?>
							</span><br>
							<span class="color-5 mobile-font-size-20 system-font-size-18">
								Students
							</span>
						</div>
					</a>
					<?php } ?>
					<?php if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){ ?>
					<a href="/bc-admin.php?page=smgt_notice&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
						<div style="display: inline-block;" class="container-box box-shadow bg-2 mobile-width-90 system-width-45 mobile-margin-top-5 system-margin-top-5 system-margin-left-2 system-margin-right-2 mobile-padding-top-5 system-padding-top-8 mobile-padding-bottom-5 system-padding-bottom-8">
							<img src="imgfile/Notice_dashboard.png" style="" class="bg-8 mobile-width-10 system-width-20 mobile-margin-top-3 system-margin-top-3 mobile-padding-top-5 system-padding-top-8 mobile-padding-left-5 system-padding-left-8 mobile-padding-right-5 system-padding-top-right-8 mobile-padding-bottom-5 system-padding-bottom-8"/><br>
							<span class="color-1 text-bold-500 mobile-font-size-40 system-font-size-30">
								<?php echo $count_school_notice; ?>
							</span><br>
							<span class="color-5 mobile-font-size-20 system-font-size-18">
								Notices
							</span>
						</div>
					</a>
					<?php } ?>
				</div>
				<?php if(($user_identifier_auth_id == "super_mod") || ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){ ?>
				<div class="dash_sys_div system-width-33">
					<div class="container-box box-shadow bg-2 mobile-width-90 system-width-96 mobile-margin-top-8 system-margin-top-1 mobile-padding-top-5 system-padding-top-7 mobile-padding-bottom-5 system-padding-bottom-7">
						<span style="float: left; clear: left;" class="color-7 text-bold-500 mobile-font-size-20 system-font-size-18 mobile-margin-left-8 system-margin-left-8">
							Students & Parents
						</span>
						<?php if($user_identifier_auth_id != "super_mod"){ ?>
						<a href="/bc-admin.php?page=smgt_parent&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
							<img src="imgfile/Redirect.png" style="float: right; clear: right;" class="mobile-width-6 system-width-5 mobile-margin-top-1 system-margin-top-1 mobile-margin-right-8 system-margin-right-8"/>
						</a><br>
						<?php } ?>
						<div class="container-box bg-3 mobile-width-90 system-width-90 mobile-margin-top-35 system-margin-top-22 mobile-padding-top-5 system-padding-top-5 mobile-padding-bottom-5 system-padding-bottom-10">
							<span class="color-1 mobile-font-size-55 system-font-size-40">
								<?php echo ($count_parents_table + $count_students_table); ?>
							</span><br>
							<span class="color-5 text-bold-400 mobile-font-size-20 system-font-size-18">
								Students & Parents
							</span><br>
							
							<div style="display: inline-block;" class="container-box bg-3 mobile-width-45 system-width-45 mobile-margin-top-25 system-margin-top-10">
								<span class="color-9 text-bold-400 mobile-font-size-40 system-font-size-30">
									•
								</span><br>
								<span class="color-1 text-bold-400 mobile-font-size-40 system-font-size-22">
									<?php echo $count_students_table; ?>
								</span><br>
								<span class="color-5 text-bold-400 mobile-font-size-20 system-font-size-18">
									Students
								</span><br>
							</div>
							<div style="display: inline-block;" class="container-box bg-3 mobile-width-45 system-width-45 mobile-margin-top-25 system-margin-top-10">
								<span class="color-10 text-bold-400 mobile-font-size-40 system-font-size-30">
									•
								</span><br>
								<span class="color-1 text-bold-400 mobile-font-size-40 system-font-size-22">
									<?php echo $count_parents_table; ?>
								</span><br>
								<span class="color-5 text-bold-400 mobile-font-size-20 system-font-size-18">
									Parents
								</span><br>
							</div>
							
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if(($user_identifier_auth_id == "super_mod") || ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){ ?>
				<div class="dash_sys_div system-width-33">
					<div class="container-box box-shadow bg-2 mobile-width-90 system-width-96 mobile-margin-top-8 system-margin-top-1 mobile-padding-top-5 system-padding-top-7 mobile-padding-bottom-5 system-padding-bottom-7">
						<span style="float: left; clear: left;" class="color-7 text-bold-500 mobile-font-size-20 system-font-size-18 mobile-margin-left-8 system-margin-left-8">
							Fees Payment
						</span>
						<?php if($user_identifier_auth_id != "super_mod"){ ?>
						<a href="/bc-admin.php?page=smgt_fees_payment&tab=fees_payment_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
							<img src="imgfile/Redirect.png" style="float: right; clear: right;" class="mobile-width-6 system-width-5 mobile-margin-top-1 system-margin-top-1 mobile-margin-right-8 system-margin-right-8"/>
						</a>
						<?php } ?>
						<div class="container-box bg-3 mobile-width-90 system-width-90 mobile-margin-top-2 system-margin-top-1 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
							<?php
								if(mysqli_num_rows($select_all_fees_payment) < 1){
							?>
							<img src="imgfile/no_data_img.png" class="mobile-width-80 system-width-60 mobile-margin-top-1 system-margin-top-1"/>
							<?php
							}else{
								$fees_payment_count = 0;
								if(mysqli_num_rows($select_all_fees_payment) > 0){
									while($table_detail = mysqli_fetch_assoc($select_all_fees_payment)){
										echo
										'<div onclick="return popUpSectionAlert(`html`,`FEES PAYMENT`,[`Fullname:'.smsStudentName($table_detail["admission_number"], $table_detail["school_id_number"]).'`,`Fee Type:'.smsFeeTypeName($table_detail["fee_type_id"], $table_detail["school_id_number"]).'`,`Class Name:'.smsClassName($table_detail["numeric_class_name"], $table_detail["session"], $table_detail["school_id_number"]).'`,`Session:'.str_replace("-","/",$table_detail["session"]).'`,`Amount:'.$table_detail["amount"].'`,`Amount Paid:'.$table_detail["amount_paid"].'`,`Status:'.ucwords($table_detail["status"]).'`,`Description:'.$table_detail["description"].'`,`Year:'.$table_detail["starting_year"].' till '.($table_detail["starting_year"]+$table_detail["ending_year"]).'`]);" style="cursor: pointer;" class="container-box bg-4 mobile-width-100 system-width-95 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
											<span class="color-2 text-bold-300 mobile-font-size-18 system-font-size-16">
												'.substr(smsFeeTypeName($table_detail["fee_type_id"], $table_detail["school_id_number"]).' | '.smsStudentName($table_detail["admission_number"], $table_detail["school_id_number"]),0,30).'
											</span>
										</div>';
										$fees_payment_count += 1;
									}
								}
								
								if((8-$fees_payment_count) > 0){
									foreach(range(1,(8-$fees_payment_count)) as $dummy_div){
										echo
										'<div style="cursor: pointer;" class="container-box bg-3 mobile-width-0 system-width-95 mobile-margin-top-0 system-margin-top-3 mobile-padding-top-0 system-padding-top-6 mobile-padding-bottom-0 system-padding-bottom-5"></div>';
									}
								}
							}
							?>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="dash_sys_first_section">
				<div class="dash_sys_div system-width-50">
					<div class="container-box box-shadow bg-2 mobile-width-90 system-width-96 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
						<span style="float: left; clear: left;" class="color-7 text-bold-500 mobile-font-size-20 system-font-size-18 mobile-margin-left-8 system-margin-left-8">
							Class
						</span>
						<?php if($user_identifier_auth_id != "super_mod"){ ?>
						<a href="/bc-admin.php?page=smgt_class&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
							<img src="imgfile/Redirect.png" style="float: right; clear: right;" class="mobile-width-6 system-width-4 mobile-margin-top-1 system-margin-top-1 mobile-margin-right-8 system-margin-right-8"/>
						</a>
						<?php } ?>
						<div class="container-box bg-3 mobile-width-90 system-width-90 mobile-margin-top-2 system-margin-top-2 mobile-padding-top-5 system-padding-top-5 mobile-padding-bottom-2 system-padding-bottom-2">
							<?php
								if(mysqli_num_rows($select_all_class) < 1){
							?>
							<img src="imgfile/no_data_img.png" class="mobile-width-80 system-width-50 mobile-margin-top-1 system-margin-top-1"/><br>
							<?php if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){ ?>
							<a href="/bc-admin.php?page=smgt_class&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
								<button type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-16 system-font-size-16 mobile-width-70 system-width-90">
									ADD CLASS
								</button>
							</a>
							<?php } ?>
							<?php
							}else{
								$class_count = 0;
								if(mysqli_num_rows($select_all_class) > 0){
									while($table_detail = mysqli_fetch_assoc($select_all_class)){
										$registered_students = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE (school_id_number='".$get_logged_user_details["school_id_number"]."' && numeric_class_name='".$table_detail["numeric_class_name"]."' && session='".$table_detail["session"]."')");
										if(mysqli_num_rows($registered_students) > 0){
											$count_registered_students = mysqli_num_rows($registered_students);
										}else{
											$count_registered_students = "N/A";
										}
										echo
										'<div onclick="return popUpSectionAlert(`html`,`CLASS`,[`Class Name:'.$table_detail["class_name"].'`,`Session:'.str_replace("-","/",$table_detail["session"]).'`,`Student Capacity:'.$table_detail["student_capacity"].'`,`No. of Student:'.$count_registered_students.'`]);" style="cursor: pointer;" class="container-box bg-4 mobile-width-100 system-width-95 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
											<span class="color-2 text-bold-300 mobile-font-size-18 system-font-size-16">
												<strong>Class:</strong> '.$table_detail["class_name"].' | <strong>Session</strong>: '.str_replace("-","/",$table_detail["session"]).'
											</span>
										</div>';
										$class_count += 1;
									}
								}

								if((5-$class_count) > 0){
									foreach(range(1,(5-$class_count)) as $dummy_div){
										echo
										'<div style="cursor: pointer;" class="container-box bg-3 mobile-width-0 system-width-95 mobile-margin-top-0 system-margin-top-3 mobile-padding-top-0 system-padding-top-6 mobile-padding-bottom-0 system-padding-bottom-5"></div>';
									}
								}
							}
							?>
						</div>
					
					</div>
				</div>
				<div class="dash_sys_div system-width-50">
					<div class="container-box box-shadow bg-2 mobile-width-90 system-width-96 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
						<span style="float: left; clear: left;" class="color-7 text-bold-500 mobile-font-size-20 system-font-size-18 mobile-margin-left-8 system-margin-left-8">
							Exam List
						</span>
						<?php if($user_identifier_auth_id != "super_mod"){ ?>
						<a href="/bc-admin.php?page=smgt_exam&tab=time_table&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
							<img src="imgfile/Redirect.png" style="float: right; clear: right;" class="mobile-width-6 system-width-4 mobile-margin-top-1 system-margin-top-1 mobile-margin-right-8 system-margin-right-8"/>
						</a>
						<?php } ?>
						<div class="container-box bg-3 mobile-width-90 system-width-90 mobile-margin-top-2 system-margin-top-2 mobile-padding-top-5 system-padding-top-5 mobile-padding-bottom-2 system-padding-bottom-2">
							<?php
								if(mysqli_num_rows($select_all_exam) < 1){
							?>
							<img src="imgfile/no_data_img.png" class="mobile-width-80 system-width-50 mobile-margin-top-1 system-margin-top-1"/><br>
							<?php if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){ ?>
							<a href="/bc-admin.php?page=smgt_exam&tab=time_table&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
								<button type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-16 system-font-size-16 mobile-width-70 system-width-90">
									ADD EXAM
								</button>
							</a>
							<?php } ?>
							<?php
							}else{
								$exam_count = 0;
								if(mysqli_num_rows($select_all_exam) > 0){
									while($table_detail = mysqli_fetch_assoc($select_all_exam)){
										echo
										'<div onclick="return popUpSectionAlert(`html`,`EXAM`,[`Subject:'.smsSubjectName($table_detail["subject_code"], $table_detail["school_id_number"]).'`,`Message:'.$table_detail["exam_comment"].'`,`Class:'.smsClassName($table_detail["numeric_class_name"], $table_detail["session"], $table_detail["school_id_number"]).'`,`Session:'.str_replace("-","/",$table_detail["session"]).'`,`Pass Mark:'.$table_detail["pass_mark"].'`,`Total Mark:'.str_replace("-","/",$table_detail["total_mark"]).'`,`Start Date:'.str_replace("-","/",$table_detail["exam_start_date"]).'`,`End Date:'.str_replace("-","/",$table_detail["exam_end_date"]).'`,`Term:'.smsTermName($table_detail["term_id_number"], $table_detail["school_id_number"]).'`]);" style="cursor: pointer;" class="container-box bg-4 mobile-width-95 system-width-95 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
											<span class="color-2 text-bold-300 mobile-font-size-18 system-font-size-16">
												'.smsSubjectName($table_detail["subject_code"], $table_detail["school_id_number"]).' | '.substr(checkIfEmpty($table_detail["exam_comment"]), 0, 20).'...
											</span>
										</div>';
										$exam_count += 1;
									}
								}
								
								if((5-$exam_count) > 0){
									foreach(range(1,(5-$exam_count)) as $dummy_div){
										echo
										'<div style="cursor: pointer;" class="container-box bg-3 mobile-width-0 system-width-95 mobile-margin-top-0 system-margin-top-3 mobile-padding-top-0 system-padding-top-6 mobile-padding-bottom-0 system-padding-bottom-5"></div>';
									}
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
			
			<div class="dash_sys_first_section">
				<div class="dash_sys_div system-width-50">
					<div class="container-box box-shadow bg-2 mobile-width-90 system-width-96 mobile-margin-top-8 system-margin-top-5 mobile-padding-top-5 system-padding-top-3 mobile-padding-bottom-5 system-padding-bottom-2">
						<span style="float: left; clear: left;" class="color-7 text-bold-500 mobile-font-size-20 system-font-size-18 mobile-margin-left-8 system-margin-left-8">
							Today Attendance Report
						</span>
						<?php if($user_identifier_auth_id != "super_mod"){ ?>
						<a href="/bc-admin.php?page=smgt_attendance&tab=student_attendance&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
							<img src="imgfile/Redirect.png" style="float: right; clear: right;" class="mobile-width-6 system-width-4 mobile-margin-top-1 system-margin-top-1 mobile-margin-right-8 system-margin-right-8"/>
						</a>
						<?php } ?>
						<div class="container-box bg-3 mobile-width-90 system-width-90 mobile-margin-top-2 system-margin-top-2 mobile-padding-top-5 system-padding-top-5 mobile-padding-bottom-2 system-padding-bottom-2">
							<?php
								if(mysqli_num_rows($select_all_attendance) < 1){
							?>
							<img src="imgfile/no_data_img.png" attendance="mobile-width-80 system-width-60 mobile-margin-top-1 system-margin-top-1"/>
							<?php
							}else{
								$attendance_count = 0;
								if(mysqli_num_rows($select_all_attendance) > 0){
									while($table_detail = mysqli_fetch_assoc($select_all_attendance)){
										if($user_identifier_auth_id != "super_mod"){
										echo
										'<a style="text-decoration: none;" href="/bc-admin.php?page=smgt_attendance&tab=student_attendance&id='.$get_logged_user_details["school_id_number"].'&view='.$table_detail["session"].'_'.$table_detail["numeric_class_name"].'_'.date("Y-m-d").'" >
											<div style="cursor: pointer;" class="container-box bg-4 mobile-width-100 system-width-95 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
												<span class="color-2 text-bold-300 mobile-font-size-18 system-font-size-16">
													'.smsClassName($table_detail["numeric_class_name"], $table_detail["session"], $table_detail["school_id_number"]).' | <strong>Session</strong>: '.str_replace("-","/",$table_detail["session"]).'
												</span>
											</div>
										</a>';
										}else{
										echo
										'<div style="cursor: pointer;" class="container-box bg-4 mobile-width-100 system-width-95 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
											<span class="color-2 text-bold-300 mobile-font-size-18 system-font-size-16">
												'.smsClassName($table_detail["numeric_class_name"], $table_detail["session"], $table_detail["school_id_number"]).' | <strong>Session</strong>: '.str_replace("-","/",$table_detail["session"]).'
											</span>
										</div>';
										}
										$attendance_count += 1;
									}
								}
							
								if((5-$attendance_count) > 0){
									foreach(range(1,(5-$attendance_count)) as $dummy_div){
										echo
										'<div style="cursor: pointer;" class="container-box bg-3 mobile-width-0 system-width-95 mobile-margin-top-0 system-margin-top-3 mobile-padding-top-0 system-padding-top-6 mobile-padding-bottom-0 system-padding-bottom-5"></div>';
									}
								}
							}
							?>
						</div>
					</div>
				</div>
				
				<div class="dash_sys_div system-width-50">
					<div class="container-box box-shadow bg-2 mobile-width-90 system-width-96 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
						<span style="float: left; clear: left;" class="color-7 text-bold-500 mobile-font-size-20 system-font-size-18 mobile-margin-left-8 system-margin-left-8">
							Notice
						</span>
						<?php if($user_identifier_auth_id != "super_mod"){ ?>
						<a href="/bc-admin.php?page=smgt_notice&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
							<img src="imgfile/Redirect.png" style="float: right; clear: right;" class="mobile-width-6 system-width-4 mobile-margin-top-1 system-margin-top-1 mobile-margin-right-8 system-margin-right-8"/>
						</a>
						<?php } ?>
						<div class="container-box bg-3 mobile-width-90 system-width-90 mobile-margin-top-2 system-margin-top-2 mobile-padding-top-5 system-padding-top-5 mobile-padding-bottom-2 system-padding-bottom-2">
							<?php
								if(mysqli_num_rows($select_all_notice) < 1){
							?>
							<img src="imgfile/no_data_img.png" class="mobile-width-80 system-width-50 mobile-margin-top-1 system-margin-top-1"/><br>
							<?php if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){ ?>
							<a href="/bc-admin.php?page=smgt_notice&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
								<button type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-16 system-font-size-16 mobile-width-70 system-width-90">
									ADD NOTICE
								</button>
							</a>
							<?php } ?>
							<?php
							}else{
								$notice_count = 0;
								if(mysqli_num_rows($select_all_notice) > 0){
									while($table_detail = mysqli_fetch_assoc($select_all_notice)){
										echo
										'<div onclick="return popUpSectionAlert(`html`,`NOTICE`,[`Notice Title:'.$table_detail["notice_title"].'`,`Message:'.$table_detail["notice_comment"].'`,`Start Date:'.str_replace("-","/",$table_detail["start_date"]).'`,`End Date:'.str_replace("-","/",$table_detail["end_date"]).'`]);" style="cursor: pointer;" class="container-box bg-4 mobile-width-100 system-width-95 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
											<span class="color-2 text-bold-300 mobile-font-size-18 system-font-size-16">
												'.$table_detail["notice_title"].' | '.substr(checkIfEmpty($table_detail["notice_comment"]), 0, 20).'...
											</span>
										</div>';
										$notice_count += 1;
									}
								}
								if((5-$notice_count) > 0){
									foreach(range(1,(5-$notice_count)) as $dummy_div){
										echo
										'<div style="cursor: pointer;" class="container-box bg-3 mobile-width-0 system-width-95 mobile-margin-top-0 system-margin-top-3 mobile-padding-top-0 system-padding-top-6 mobile-padding-bottom-0 system-padding-bottom-5"></div>';
									}
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="dash_sys_first_section">
				<div class="dash_sys_div system-width-50">
					<div class="container-box box-shadow bg-2 mobile-width-90 system-width-96 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
						<span style="float: left; clear: left;" class="color-7 text-bold-500 mobile-font-size-20 system-font-size-18 mobile-margin-left-8 system-margin-left-8">
							Notification
						</span>
						<?php if($user_identifier_auth_id != "super_mod"){ ?>
						<a href="/bc-admin.php?page=smgt_notification&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
							<img src="imgfile/Redirect.png" style="float: right; clear: right;" class="mobile-width-6 system-width-4 mobile-margin-top-1 system-margin-top-1 mobile-margin-right-8 system-margin-right-8"/>
						</a>
						<?php } ?>
						<div class="container-box bg-3 mobile-width-90 system-width-90 mobile-margin-top-2 system-margin-top-2 mobile-padding-top-5 system-padding-top-5 mobile-padding-bottom-2 system-padding-bottom-2">
							<?php
								if(mysqli_num_rows($select_all_notification) < 1){
							?>
							<img src="imgfile/no_data_img.png" class="mobile-width-80 system-width-50 mobile-margin-top-1 system-margin-top-1"/><br>
							<?php if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){ ?>
							<a href="/bc-admin.php?page=smgt_notification&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
								<button type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-16 system-font-size-16 mobile-width-70 system-width-90">
									ADD NOTIFICATION
								</button>
							</a>
							<?php } ?>
							<?php
							}else{
								$notification_count = 0;
								if(mysqli_num_rows($select_all_notification) > 0){
									while($table_detail = mysqli_fetch_assoc($select_all_notification)){
										echo
										'<div onclick="return popUpSectionAlert(`html`,`NOTIFICATION`,[`Notification Title:'.$table_detail["title"].'`,`Message:'.$table_detail["message"].'`,`Class:'.smsClassName($table_detail["numeric_class_name"], $table_detail["session"], $table_detail["school_id_number"]).'`,`Session:'.str_replace("-","/",$table_detail["session"]).'`]);" style="cursor: pointer;" class="container-box bg-4 mobile-width-100 system-width-95 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
											<span class="color-2 text-bold-300 mobile-font-size-18 system-font-size-16">
												'.$table_detail["title"].' | '.substr(checkIfEmpty($table_detail["message"]), 0, 20).'...
											</span>
										</div>';
										$notification_count += 1;
									}
								}
								
								if((5-$notification_count) > 0){
									foreach(range(1,(5-$notification_count)) as $dummy_div){
										echo
										'<div style="cursor: pointer;" class="container-box bg-3 mobile-width-0 system-width-95 mobile-margin-top-0 system-margin-top-3 mobile-padding-top-0 system-padding-top-6 mobile-padding-bottom-0 system-padding-bottom-5"></div>';
									}
								}
							}
							?>
						</div>
					</div>
				</div>
				<div class="dash_sys_div system-width-50">
					<div class="container-box box-shadow bg-2 mobile-width-90 system-width-96 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
						<span style="float: left; clear: left;" class="color-7 text-bold-500 mobile-font-size-20 system-font-size-18 mobile-margin-left-8 system-margin-left-8">
							Holiday List
						</span>
						<?php if($user_identifier_auth_id != "super_mod"){ ?>
						<a href="/bc-admin.php?page=smgt_holiday&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
							<img src="imgfile/Redirect.png" style="float: right; clear: right;" class="mobile-width-6 system-width-4 mobile-margin-top-1 system-margin-top-1 mobile-margin-right-8 system-margin-right-8"/>
						</a>
						<?php } ?>
						<div class="container-box bg-3 mobile-width-90 system-width-90 mobile-margin-top-2 system-margin-top-2 mobile-padding-top-5 system-padding-top-5 mobile-padding-bottom-2 system-padding-bottom-2">
							<?php
								if(mysqli_num_rows($select_all_holiday) < 1){
							?>
							<img src="imgfile/no_data_img.png" class="mobile-width-80 system-width-50 mobile-margin-top-1 system-margin-top-1"/><br>
							<?php if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){ ?>
							<a href="/bc-admin.php?page=smgt_holiday&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>" >
								<button type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-16 system-font-size-16 mobile-width-70 system-width-90">
									ADD HOLIDAY
								</button>
							</a>
							<?php } ?>
							<?php
							}else{
								$holiday_count = 0;
								if(mysqli_num_rows($select_all_holiday) > 0){
									while($table_detail = mysqli_fetch_assoc($select_all_holiday)){
										echo
										'<div onclick="return popUpSectionAlert(`html`,`HOLIDAY`,[`Holiday Title:'.$table_detail["holiday_title"].'`,`Description:'.$table_detail["description"].'`,`Start Date:'.str_replace("-","/",$table_detail["start_date"]).'`,`End Date:'.str_replace("-","/",$table_detail["end_date"]).'`]);" style="cursor: pointer;" class="container-box bg-4 mobile-width-95 system-width-100 mobile-margin-top-8 system-margin-top-4 mobile-padding-top-5 system-padding-top-2 mobile-padding-bottom-5 system-padding-bottom-2">
											<span class="color-2 text-bold-300 mobile-font-size-18 system-font-size-16">
												'.$table_detail["holiday_title"].' | '.checkIfEmpty(str_replace("-","/",$table_detail["start_date"])).'
											</span>
										</div>';
										$holiday_count += 1;
									}
								}
								
								if((5-$holiday_count) > 0){
									foreach(range(1,(5-$holiday_count)) as $dummy_div){
										echo
										'<div style="cursor: pointer;" class="container-box bg-3 mobile-width-0 system-width-95 mobile-margin-top-0 system-margin-top-3 mobile-padding-top-0 system-padding-top-6 mobile-padding-bottom-0 system-padding-bottom-5"></div>';
									}
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
			
			
		</center>
	</div>