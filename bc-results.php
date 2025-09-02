<?php session_start(); error_reporting(0);
	
	include("include/config-file.php");
	
	function studentClassName($class_info,$school_id){
		global $connection_server;
		
		$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info' GROUP BY numeric_class_name");
		if(mysqli_num_rows($get_class_name) > 0){
			while($class_name_array = mysqli_fetch_array($get_class_name)){
				$class_name .= $class_name_array["class_name"];
			}
		}else{
			$class_name = "N/A";
		}
		
		return $class_name;
	}
	
	function subjectName($subject_info,$school_id){
		global $connection_server;
		
		
		$get_subject_name = mysqli_query($connection_server,"SELECT * FROM sm_subjects WHERE school_id_number='$school_id' && subject_code='$subject_info'");
		if(mysqli_num_rows($get_subject_name) > 0){
			while($subject_id_array = mysqli_fetch_array($get_subject_name)){
				$subject_name .= $subject_id_array["subject_name"];
			}
		}else{
			$subject_name = "N/A";
		}
		
		if($subject_name == true){
			return $subject_name;
		}else{
			return "N/A";
		}
	}
	
	function termName($terms_info,$school_id){
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
	
	function getScoreGrade($score_info, $type_info, $school_id){
		global $connection_server;
		
		$get_grade_name = mysqli_query($connection_server,"SELECT * FROM sm_grades WHERE school_id_number='$school_id'");
		if(mysqli_num_rows($get_grade_name) > 0){
			while($grade_name_array = mysqli_fetch_array($get_grade_name)){
				if(in_array($score_info,range($grade_name_array["mark_from"],$grade_name_array["mark_upto"]))){
					if($type_info == "grade"){
						$grade_name .= $grade_name_array["grade_name"];
					}
					
					if($type_info == "remark"){
						$grade_name .= $grade_name_array["grade_comment"];
					}
				}
			}
		}else{
			$grade_name = "N/A";
		}
		
		return $grade_name;
	}
	
	function principalRemark($gender, $average_score){
		
		if(strtolower($gender) == "male"){
			$gender_pronoun_1 = "He ";
			$gender_pronoun_2 = "His ";
		}
		
		if(strtolower($gender) == "female"){
			$gender_pronoun_1 = "She ";
			$gender_pronoun_2 = "Her ";
		}
		
		if(!in_array(strtolower($gender),array("male","female"))){
			$gender_pronoun_1 = "He/She ";
			$gender_pronoun_2 = "His/Her ";
		}
		
		if(in_array($average_score,range(70,100))){
			return $gender_pronoun_1." performs independent work with confidence and focus.";
		}
		
		if(in_array($average_score,range(60,69))){
			return $gender_pronoun_1." is focused during classroom activities and willingly participated in class discussions.";
		}
		
		if(in_array($average_score,range(50,59))){
			return $gender_pronoun_1." is an active participant in class.";
		}
		
		if(in_array($average_score,range(45,49))){
			return $gender_pronoun_1." needs frequent reminders to be attentive during class";
		}
		
		if(in_array($average_score,range(40,44))){
			return $gender_pronoun_1." needs to improve on ".strtolower($gender_pronoun_2)." performance.";
		}
		
		if(in_array($average_score,range(0,39))){
			return $gender_pronoun_2." result is not impressive, ".strtolower($gender_pronoun_1)." needs to improve.";
		}
			
	}
	
	function checkPayment($student_info, $class_info, $session_info, $school_id){
		global $connection_server;
		$feeTypeArray = array();
		$select_fee_list = mysqli_query($connection_server, "SELECT * FROM sm_fee_lists WHERE school_id_number='$school_id' && numeric_class_name='$class_info' && session='$session_info'");
		
		if(mysqli_num_rows($select_fee_list) > 0){
			while($fee_list_details = mysqli_fetch_assoc($select_fee_list)){
				$feeTypeArray[] = $fee_list_details['fee_type_id'];
			}
		}
		
		if(count($feeTypeArray) > 0){
			foreach($feeTypeArray as $fee_type_id){
				$feeTypeId .= "fee_type_id='".$fee_type_id."' ";
			}
			$fee_type_id_statement = "(".str_replace(" ", " OR ", trim($feeTypeId)).")";
			
			$search_fee_payment_list = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='$school_id' && ".$fee_type_id_statement." && admission_number='$student_info' && numeric_class_name='$class_info' && session='$session_info'");
			
			if(count($feeTypeArray) === mysqli_num_rows($search_fee_payment_list)){
				$fee_payment_validation = true;
				$fee_bill_overdue = array();
			}else{
				if(count($feeTypeArray) > mysqli_num_rows($search_fee_payment_list)){
					$fee_payment_validation = false;
					$feeTypeArrayAltered = array();
					if(mysqli_num_rows($search_fee_payment_list) > 0){
						foreach($feeTypeArray as $feeTypeIds){
							$search_fee_payment_list_check = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='$school_id' && fee_type_id='$feeTypeIds' && admission_number='$student_info' && numeric_class_name='$class_info' && session='$session_info'");
							if(mysqli_num_rows($search_fee_payment_list_check) == 0){
								$feeTypeArrayAltered[] = $feeTypeIds;
							}
						}
					}else{
						$feeTypeArrayAltered = $feeTypeArray;
					}
					$fee_bill_overdue = $feeTypeArrayAltered;
				}
			}
	    
	    }else{
	    	$fee_payment_validation = true;
	    	$fee_bill_overdue = array();
	    }
	    
	    return 	json_encode(array("fee_status"=>$fee_payment_validation, "fee_overdue"=>$fee_bill_overdue),true);
	}

	if(isset($_GET["view"]) && (!empty(trim(strip_tags($_GET["view"]))))){
		$result_unique_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["view"])));
		$search_student_to_result_list_database = mysqli_query($connection_server, "SELECT * FROM sm_result_lists WHERE result_ref='$result_unique_id'");
		if(mysqli_num_rows($search_student_to_result_list_database) == 1){
			$get_student_result_details = mysqli_fetch_array($search_student_to_result_list_database);
			$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($get_student_result_details["numeric_class_name"])));
			$session = mysqli_real_escape_string($connection_server, trim(strip_tags($get_student_result_details["session"])));
			$term_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($get_student_result_details["term_id_number"])));
			$admission_number = mysqli_real_escape_string($connection_server, trim(strip_tags($get_student_result_details["admission_number"])));
			$school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($get_student_result_details["school_id_number"])));
			
			$get_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
			
			$get_student_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$admission_number'"));
			$search_student_to_results_in_database = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && admission_number='$admission_number' ORDER BY subject_code ASC");
			$search_student_to_result_remarks_in_database = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_result_remarks WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && admission_number='$admission_number' LIMIT 1"));
			$get_result_release_dates = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_result_release_dates WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && term_id_number='$term_id_number' && session='$session'"));
			
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="UTF-8" />
<meta name="description" content="" />
<meta http-equiv="Content-Type" content="text/html; " />
<meta name="theme-color" content="black" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="stylesheet" href="cssfile/font-family.css">
<link rel="stylesheet" href="cssfile/portal.css">
<script src="js/popup.js"></script>

</head>
<body>

<?php
$result_release_date = new DateTime($get_result_release_dates["release_date"]);
$today_date = new DateTime();
	if(mysqli_num_rows($search_student_to_results_in_database) > 0){
		if((json_decode(checkPayment($admission_number, $numeric_class, $session, $school_id),true)["fee_status"] == true) || (1 == 1)){
?>

<div id="printDiv" class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<div style="border:1px solid var(--color-4); " class="container-box bg-2 mobile-width-96 system-width-70 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
				<div style="border:1px solid var(--color-4v); text-align: left;" class="container-box bg-3 mobile-width-96 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
					<div style="display: block; text-align: center;" class="container-box bg-3 mobile-width-100 system-width-100">
							
						<?php if(file_exists("dataimg/school_".$school_id.".png")){ ?>
						<img style="display: inline-block;" class="mobile-width-50 system-width-40" src="dataimg/school_<?php echo $school_id; ?>.png" /><br>
						<?php }else{ ?>
						<img style="display: inline-block;" class="mobile-width-50 system-width-40" src="imgfile/logo.png" /><br>
						<?php } ?>
						
						<div style="display: inline-block;" class="container-box bg-3 mobile-width-80 system-width-80">
							<!-- Name -->
							<span style="display: inline-block;" class="color-1 mobile-font-size-17 system-font-size-25"><?php echo $get_sch_name["school_name"]; ?></span><br>
							<span style="display: inline-block;" class="color-1 mobile-font-size-17 system-font-size-25"><?php echo $get_sch_name["school_address"].", ".$get_sch_name["city"]." ".$get_sch_name["state"]; ?></span><br>
							
							<!-- Title -->
							<span style="display: inline-block;" class="color-1 mobile-font-size-15 system-font-size-18">PROGRESS REPORT <?php echo strtoupper(termName($term_id_number, $school_id))." ".str_replace("-","/",$session); ?></span>
						
						</div>
					</div>
				</div>
				<div style="border:1px solid var(--color-4v);" class="container-box bg-3 mobile-width-96 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
					<div style="border:1px solid var(--color-4); text-align: left; display: flex; flex-direction: row;" id="student-detail-container" class="container-box bg-3 mobile-width-100 system-width-90 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-0 system-padding-top-0 mobile-padding-bottom-0 system-padding-bottom-0">
						<div style="display: inline-block;" class="container-box bg-3 mobile-width-75 system-width-80 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-0 system-padding-top-0 mobile-padding-bottom-0 system-padding-bottom-0">
							<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Title Name -->
								<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Full-Name</span>
							
							</div>
							<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: ;" class="container-box bg-3 mobile-width-72 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Full-Name -->
								<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo strtoupper($get_student_details["lastname"]).", ".ucwords($get_student_details["firstname"]." ".$get_student_details["othername"]); ?></span>
							
							</div><br>

							<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Title Name -->
								<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Student ID</span>
							
							</div>
							<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: ;" class="container-box bg-3 mobile-width-72 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Matric No -->
								<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo "ST/".$school_id."/".$admission_number; ?></span>
							
							</div><br>

							<?php
								$get_current_class_category_details = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE numeric_class_category_name='".$view_student_detail["numeric_class_category_name"]."'");
								if(mysqli_num_rows($get_current_class_category_details) == 1){
									$current_class_category_name = " '" . mysqli_fetch_array($get_current_class_category_details)["class_category_name"] . "' ";
								}else{
									$current_class_category_name = "";
								}
							?>
							<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Class Name -->
								<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Class</span>
							
							</div>
							<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: ;" class="container-box bg-3 mobile-width-72 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Class-Name -->
								<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo ucwords(studentClassName($numeric_class,$school_id)); ?></span>
							
							</div><br>
							
							<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Term -->
								<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Term</span>
							
							</div>
							<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: ;" class="container-box bg-3 mobile-width-72 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Term -->
								<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo ucwords(termName($term_id_number, $school_id)); ?></span>
							
							</div>
							<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Gender -->
								<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Gender</span>
							
							</div>
							<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: ;" class="container-box bg-3 mobile-width-72 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Gender -->
								<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo ucwords($get_student_details["gender"]); ?></span>
							
							</div>
							
						</div>

						<div style="display: inline-block; text-align: center;" id="student-passport-container" class="container-box bg-3 mobile-width-24 system-width-19 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-0 system-padding-top-0 mobile-padding-bottom-0 system-padding-bottom-0">
							<?php if(file_exists("dataimg/student_".$school_id."_".$admission_number.".png")){ ?>
							<img style="display: inline-block; object-fit: cover; height: 0px; margin: 0; padding: 0;" id="student-passport" class="mobile-margin-top-0 system-margin-top-0" src="dataimg/student_<?php echo $school_id.'_'.$admission_number; ?>.png" /><br>
							<?php }else{ ?>
							<img style="display: inline-block; object-fit: cover; height: 0px; margin: 0; padding: 0;" id="student-passport" class="mobile-margin-top-0 system-margin-top-0" src="imgfile/Student.png" /><br>
							<?php } ?>
						</div>
					</div>
				</div>
				<div style="border:1px solid var(--color-4v);" class="container-box bg-3 mobile-width-96 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
					<div style="display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-90 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-0 system-padding-top-0 mobile-padding-bottom-0 system-padding-bottom-0">
						<div class="scroll-box bg-2 mobile-width-100 system-width-100">
							<table class="result-table-tag mobile-font-size-12 system-font-size-14">
							<tr>
								<th>Subject</th>
								<th>1st C.A</th>
								<th>2nd C.A</th>
								<th>3rd C.A</th>
								<th>Exam</th>
								<th>Total Mark</th>
								<th>Mark Obtainable</th>
								<th>Grade</th>
								<th>Remark</th>
							</tr>
							<?php
								
								$subject_count = 0;
								$mark_obtained_count = 0;
								$mark_obtainable_count = 0;
								
								if(mysqli_num_rows($search_student_to_results_in_database) > 0){
									while($student_exam_subject_details = mysqli_fetch_array($search_student_to_results_in_database)){
										if($student_exam_subject_details["first_ca"] == ""){
											$first_ca = "-";
											$first_ca_mark = 0;
										}else{
											if($student_exam_subject_details["first_ca"] > 0){
												$first_ca = $student_exam_subject_details["first_ca"];
												$first_ca_mark = $student_exam_subject_details["first_ca"];
											}else{
												$first_ca = 0;
												$first_ca_mark = 0;
											}
										}
										
										if($student_exam_subject_details["second_ca"] == ""){
											$second_ca = "-";
											$second_ca_mark = 0;
										}else{
											if($student_exam_subject_details["second_ca"] > 0){
												$second_ca = $student_exam_subject_details["second_ca"];
												$second_ca_mark = $student_exam_subject_details["second_ca"];
											}else{
												$second_ca = 0;
												$second_ca_mark = 0;
											}
										}
										
										if($student_exam_subject_details["third_ca"] == ""){
											$third_ca = "-";
											$third_ca_mark = 0;
										}else{
											if($student_exam_subject_details["third_ca"] > 0){
												$third_ca = $student_exam_subject_details["third_ca"];
												$third_ca_mark = $student_exam_subject_details["third_ca"];
											}else{
												$third_ca = 0;
												$third_ca_mark = 0;
											}
										}
										
										if($student_exam_subject_details["exam"] == ""){
											$exam_mark = "-";
											$examination_mark = 0;
										}else{
											if($student_exam_subject_details["exam"] > 0){
												$exam_mark = $student_exam_subject_details["exam"];
												$examination_mark = $student_exam_subject_details["exam"];
											}else{
												$exam_mark = 0;
												$examination_mark = 0;
											}
										}
										
										if(($first_ca_mark+$second_ca_mark+$third_ca_mark+$examination_mark) === 0){
											$aggregate_score = 0;
										}else{
											$aggregate_score = $first_ca_mark+$second_ca_mark+$third_ca_mark+$examination_mark;
										}
										
										if($aggregate_score > 0){
											echo
											'<tr>
												<td>'.subjectName($student_exam_subject_details["subject_code"], $school_id).'</td>
												<td>'.$first_ca.'</td>
												<td>'.$second_ca.'</td>
												<td>'.$third_ca.'</td>
												<td>'.$exam_mark.'</td>
												<td>'.($aggregate_score).'</td>
												<td>100</td>
												<td>'.getScoreGrade($aggregate_score,'grade',$school_id).'</td>
												<td>'.getScoreGrade($aggregate_score,'remark',$school_id).'</td>
											</tr>';
										
										$subject_count += 1;
										$mark_obtained_count += $aggregate_score;
										$mark_obtainable_count += 100;
										}
									}
								}
							?>
							
							</table>
						</div>
						
					</div>

				</div>
				<div style="display: inline-block; text-align: left;" class="container-box bg-3 mobile-width-90 system-width-80 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-0 system-padding-top-0 mobile-padding-bottom-0 system-padding-bottom-0">
					<!-- No of Subjects -->
					<span style="display: inline-block;" class="color-1 mobile-font-size-12 system-font-size-14 mobile-margin-top-2 system-margin-top-2 mobile-margin-right-30 system-margin-right-5">
						<strong>No. of Subject</strong>: <?php echo $subject_count; ?>
					</span>
					<?php
						$average_mark_obtained = substr((($mark_obtained_count / $mark_obtainable_count) * 100),0,5);
					?>
					<!-- Average Mark -->
					<span style="display: inline-block;" class="color-1 mobile-font-size-12 system-font-size-14 mobile-margin-right-0 system-margin-right-5">
						<strong>Average Mark (%)</strong>: <?php echo $average_mark_obtained."%"; ?>
					</span>
					
					<!-- Principal Remark -->
					<span style="display: inline-block;" class="color-1 mobile-font-size-12 system-font-size-14 mobile-margin-top-2 system-margin-top-2">
						<strong>Principal Remark</strong>: 
						<?php
							if(!empty(trim($search_student_to_result_remarks_in_database["principal_remark"]))){
								echo trim($search_student_to_result_remarks_in_database["principal_remark"]);
							}else{
								echo principalRemark($get_student_details["gender"],explode(".",trim($average_mark_obtained))[0]);
							}
						?>
					</span>
					
				</div>
			</div>
			
		</center>
	</div><br>
	<center>
		<span style="display: inline-block; text-decoration: underline; cursor: pointer;" class="color-4 mobile-font-size-14 system-font-size-16" onclick="printPage();">Print Result</span>
						
		<script>
			
			//Receipt & Result Image set
				setInterval(function(){
					const studentPassport = document.getElementById("student-passport");
					studentPassport.style.height = "0px";
					const studentDetailContainerHeight = document.getElementById("student-detail-container").clientHeight;
					if(studentDetailContainerHeight != studentPassport.clientHeight){
						studentPassport.style.width = "80%";
						studentPassport.style.height = (studentDetailContainerHeight*(100/100))+"px";
					}
				},1000);
			
			function printPage(){
	
				var receiptDiv = document.getElementById("printDiv").innerHTML;
				const html = [];
				html.push('<html><head>');
				html.push('<link rel="stylesheet" href="cssfile/portal.css">');
				html.push('</head><body onload="window.focus(); window.print()"><div>');
				html.push(receiptDiv);
				html.push('</div></body></html>');
				
				var mywindow = window.open('', '', 'width=640,height=480');
				mywindow.document.open("text/html");
				mywindow.document.write(html.join(""));
				mywindow.document.close();
				
			}

			window.addEventListener('keydown', function(e){
				if(e.ctrlKey && e.keyCode == 80){
					e.preventDefault();
					printPage();
				}
			});
		</script>
		
<?php
		}else{
		$outstandingFeeTypeArr = json_decode(checkPayment($admission_number, $numeric_class, $session, $school_id),true)["fee_overdue"];
?>
			<center>
				<div style="border:1px solid var(--color-4); " class="container-box bg-2 mobile-width-96 system-width-70 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
					<span class="mobile-font-size-30 system-font-size-40 text-bold-700">Action Required: Some bills remain unpaid. Please address this promptly.</span><br>
					<span class="mobile-font-size-18 system-font-size-25 text-bold-700">Pay all Outstanding Fees below:</span><br>
					<div style="text-align: left; " class="container-box bg-2 mobile-width-96 system-width-70">
					<span class="m-font-size-16 s-font-size-20 text-bold-700">
						<ol>
						<?php
							foreach($outstandingFeeTypeArr as $feeTypeId){
								$feeTypeName = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_fee_type WHERE school_id_number='$school_id' && id_number='$feeTypeId' LIMIT 1"));
								echo '<li class="mobile-margin-top-1">'.$feeTypeName["fee_name"].'</li>';
							}
						?>
						</ol>
					</span>
					</div>
					<span class="mobile-font-size-14 system-font-size-20 text-bold-700">Pay all the above fee to view result</span><br>
				</div>
			</center>
<?php
		}
	}
?>
</body>
</html>