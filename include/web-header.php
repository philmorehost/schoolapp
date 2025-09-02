<?php
$page = $_GET['page'] ?? '';
$tab = $_GET['tab'] ?? '';
?>
<div class="web-header">
	<a href="/bc-admin.php?page=smgt_dashboard">
		<?php if(isset($_SESSION["sup_adm_session"])){ ?>
			<img class="header-logo" src="imgfile/logo.png" />
		<?php }else{ ?>
			<?php if(file_exists("dataimg/school_".$get_logged_user_details['school_id_number'].".png")){ ?>
				<img class="header-logo" src="dataimg/school_<?php echo $get_logged_user_details['school_id_number']; ?>.png" />
			<?php }else{ ?>
				<img class="header-logo" src="imgfile/logo.png" />
			<?php } ?>
		<?php } ?>
	</a>
		<button class="header-menu">
			<img id="header-menu-icon" src="imgfile/open-menu.png" />
		</button>
</div>

<div class="menu-div" style="place-items: center; height:0px;">
	<a href="/bc-admin.php?page=smgt_dashboard">
		<button onmouseover="grayImg(this,'dashboard-img','dashboards.png');" onmouseout="whiteImg(this,'dashboard-img','dashboards.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="dashboard-img" src="imgfile/white/dashboards.png"/>
			Dashboard
		</button>
	</a><br>
	
	<?php
		if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
	?>
	<a href="/bc-admin.php?page=smgt_student&tab=add_student&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button onmouseover="grayImg(this,'admission-img','Admission.png');" onmouseout="whiteImg(this,'admission-img','Admission.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="admission-img" src="imgfile/white/Admission.png"/>
			Admit (Student)
		</button>
	</a><br>

	<a href="/bc-admin.php?page=smgt_parent_student&tab=parent_reg&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button onmouseover="grayImg(this,'admit-img','Admission.png');" onmouseout="whiteImg(this,'admit-img','Admission.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="admit-img" src="imgfile/white/Admission.png"/>
			Admit (Parent + Student)
		</button>
	</a><br>

	<?php } ?>
	<?php if(!isset($_SESSION["sup_adm_session"])){ ?>
	<a onclick="osList('sub-class');">
		<button onmouseover="grayImg(this,'class-img','Class.png'); grayDropImg('class-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'class-img','Class.png'); whiteDropImg('class-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="class-img" src="imgfile/white/Class.png"/>
			Class
			<img id="class-drop-img" src="imgfile/white/drop-forward.png" style="float: right;"/>
		</button>
	</a><br>
	<?php } ?>
	<?php
		if(!isset($_SESSION["sup_adm_session"]) && !isset($_SESSION["mod_adm_session"]) && !isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && isset($_SESSION["stu_session"])){
	?>
	<a href="/bc-admin.php?page=smgt_cbt&tab=past_questions&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button onmouseover="grayImg(this,'cbt-img','cbt.png');" onmouseout="whiteImg(this,'cbt-img','cbt.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="cbt-img" src="imgfile/white/cbt.png"/>
			Past Questions
		</button>
	</a><br>
	<?php } ?>
	
	<div id="sub-class" style="display: none; margin: 0 0 0 -16px;" class="color-7 bg-2 mobile-width-100  system-width-100 mobile-padding-left-5 system-padding-left-10 mobile-padding-right-5 system-padding-right-10 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
		<?php
			if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) && !isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_session&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Session</button>
		</a><br>

		<a href="/bc-admin.php?page=smgt_class&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 color-7 bg-6 mobile-font-size-14 system-font-size-14">Class</button>
		</a><br>
		
		<a href="/bc-admin.php?page=smgt_class_category&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 color-7 bg-6 mobile-font-size-14 system-font-size-14">Class Category</button>
		</a><br>
		
		<?php
			}
		?>
		<a href="/bc-admin.php?page=smgt_time_table&tab=route_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Class Time Table</button>
		</a><br>

		<a href="/bc-admin.php?page=smgt_subject&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Subject</button>
		</a>
	</div>
	
	<?php
		if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
	?>
	<a onclick="osList('sub-users');">
		<button onmouseover="grayImg(this,'users-img','user-black.png'); grayDropImg('users-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'users-img','user-white.png'); whiteDropImg('users-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="users-img" src="imgfile/white/user-white.png"/>
			Users
			<img id="users-drop-img" src="imgfile/white/drop-forward.png" style="float: right;"/>
		</button>
	</a><br>
	
	<div id="sub-users" style="display: none; margin: 0 0 0 -16px;" class="color-7 bg-2 mobile-width-100  system-width-100 mobile-padding-left-5 system-padding-left-10 mobile-padding-right-5 system-padding-right-10 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
		<a href="/bc-admin.php?page=smgt_student&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Students</button>
		</a><br>
		
		<a href="/bc-admin.php?page=smgt_teacher&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Teacher</button>
		</a><br>
		<?php
			if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) && !isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_adminstaff&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Admin Staff</button>
		</a><br>
		<?php } ?>
		<a href="/bc-admin.php?page=smgt_parent&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Parent</button>
		</a>
	</div>
	<?php
		}
	?>

	<?php
		if(!isset($_SESSION["sup_adm_session"]) && (isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]) || isset($_SESSION["teacher_session"]))){
	?>
	<a href="/bc-admin.php?page=smgt_teacher_students&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button onmouseover="grayImg(this,'teacher-students-img','Students_dashboard.png');" onmouseout="whiteImg(this,'teacher-students-img','Students_dashboard.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="teacher-students-img" src="imgfile/white/Students_dashboard.png"/>
			Teacher Students
		</button>
	</a><br>
	<?php
		}
	?>
	<?php if(isset($_SESSION["sup_adm_session"])){ ?>
	<a onclick="osList('sub-smts');">
		<button onmouseover="grayImg(this,'smts-img','smts-black.png'); grayDropImg('smts-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'smts-img','smts-white.png'); whiteDropImg('smts-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="smts-img" src="imgfile/white/smts-white.png"/>
			School Management
			<img id="smts-drop-img" src="imgfile/white/drop-forward.png" style="float: right;"/>
		</button>
	</a><br>
	<?php } ?>
	
	<div id="sub-smts" style="display: none; margin: 0 0 0 -16px;" class="color-7 bg-2 mobile-width-100  system-width-100 mobile-padding-left-5 system-padding-left-10 mobile-padding-right-5 system-padding-right-10 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
		<a href="/bc-admin.php?page=smgt_school&tab=true">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Manage Schools</button>
		</a><br>
		
		<a href="/bc-admin.php?page=smgt_cbt_activation&tab=true">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">CBT Activation</button>
		</a>
	</div>
	
	<?php if(!isset($_SESSION["sup_adm_session"])){ ?>
	<a onclick="osList('sub-evaluation');">
		<button onmouseover="grayImg(this,'exam-img','Exam.png'); grayDropImg('exam-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'exam-img','Exam.png'); whiteDropImg('exam-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="exam-img" src="imgfile/white/Exam.png"/>
			Student Evaluation
			<img id="exam-drop-img" src="imgfile/white/drop-forward.png" style="float: right;"/>
		</button>
	</a><br>
	<?php } ?>
	
	<div id="sub-evaluation" style="display: none; margin: 0 0 0 -16px;" class="color-7 bg-2 mobile-width-100  system-width-100 mobile-padding-left-5 system-padding-left-10 mobile-padding-right-5 system-padding-right-10 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
		<a href="/bc-admin.php?page=smgt_exam&tab=time_table&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Exam</button>
		</a><br>
		<?php
			if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_hall&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Exam Hall</button>
		</a><br>
		<?php } ?>
		
		<?php
			if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]) || isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_result&tab=manage_marks&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Manage Marks</button>
		</a><br>
		<?php
			}
		?>
		<?php
			if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) && !isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_grade&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Grade</button>
		</a><br>
		<?php } ?>
		<?php
			if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) && !isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_migration&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Migration</button>
		</a>
		<?php } ?>
		
		<?php
		if(!isset($_SESSION["sup_adm_session"]) && !isset($_SESSION["mod_adm_session"]) && !isset($_SESSION["adm_staff_session"]) && isset($_SESSION["teacher_session"]) || isset($_SESSION["stu_par_session"]) || isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_check_result&tab=view_result&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">View Result</button>
		</a><br>
		<?php } ?>
	</div>
	
	<?php if(!isset($_SESSION["sup_adm_session"])){ ?>
	<a href="/bc-admin.php?page=smgt_student_homework&tab=homework_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button onmouseover="grayImg(this,'homework-img','homework.png');" onmouseout="whiteImg(this,'homework-img','homework.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="homework-img" src="imgfile/white/homework.png"/>
			Homework
		</button>
	</a><br>
	
	<?php
		if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]) || isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
	?>
	<a href="/bc-admin.php?page=smgt_cbt&tab=scheldule_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button onmouseover="grayImg(this,'cbt-img','cbt.png');" onmouseout="whiteImg(this,'cbt-img','cbt.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="cbt-img" src="imgfile/white/cbt.png"/>
			CBT
		</button>
	</a><br>
	<?php } ?>

	<?php
		if(!isset($_SESSION["sup_adm_session"]) && !isset($_SESSION["mod_adm_session"]) && !isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && isset($_SESSION["stu_session"])){
	?>
	<a href="/bc-admin.php?page=smgt_cbt&tab=cbt_tests&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button onmouseover="grayImg(this,'cbt-img','cbt.png');" onmouseout="whiteImg(this,'cbt-img','cbt.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="cbt-img" src="imgfile/white/cbt.png"/>
			<?php echo isset($decode_header_title_jsons[strip_tags($page)]) ? $decode_header_title_jsons[strip_tags($page)] : 'CBT'; ?>
		</button>
	</a><br>
	<?php } ?>

	<a href="/bc-admin.php?page=smgt_attendance&tab=student_attendance&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button onmouseover="grayImg(this,'attendance-img','Attendance.png');" onmouseout="whiteImg(this,'attendance-img','Attendance.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="attendance-img" src="imgfile/white/Attendance.png"/>
			Attendance
		</button>
	</a><br>
	
	<a onclick="osList('sub-payment');">
		<button onmouseover="grayImg(this,'payment-img','Payment.png'); grayDropImg('payment-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'payment-img','Payment.png'); whiteDropImg('payment-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="payment-img" src="imgfile/white/Payment.png"/>
			Payment
			<img id="payment-drop-img" src="imgfile/white/drop-forward.png" style="float: right;"/>
		</button>
	</a><br>
	<?php } ?>
	<div id="sub-payment" style="display: none; margin: 0 0 0 -16px;" class="color-7 bg-2 mobile-width-100  system-width-100 mobile-padding-left-5 system-padding-left-10 mobile-padding-right-5 system-padding-right-10 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
		<a href="/bc-admin.php?page=smgt_fees_payment&tab=fees_payment_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Fees Payment</button>
		</a><br>
		<?php
			if(!isset($_SESSION["sup_adm_session"]) && !isset($_SESSION["mod_adm_session"]) && !isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_payment&tab=payment&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Payment</button>
		</a>
		<?php } ?>
	</div>
	
	<?php if(!isset($_SESSION["sup_adm_session"])){ ?>
	<a href="/bc-admin.php?page=smgt_library&tab=issue_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button onmouseover="grayImg(this,'library-img','Library.png');" onmouseout="whiteImg(this,'library-img','Library.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="library-img" src="imgfile/white/Library.png"/>
			Library
		</button>
	</a><br>
	
	<a onclick="osList('sub-hostel');">
		<button onmouseover="grayImg(this,'hostel-img','hostel.png'); grayDropImg('hostel-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'hostel-img','hostel.png'); whiteDropImg('hostel-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="hostel-img" src="imgfile/white/hostel.png"/>
			Hostel
			<img id="hostel-drop-img" src="imgfile/white/drop-forward.png" style="float: right;"/>
		</button>
	</a><br>
	<?php } ?>
	<div id="sub-hostel" style="display: none; margin: 0 0 0 -16px;" class="color-7 bg-2 mobile-width-100  system-width-100 mobile-padding-left-5 system-padding-left-10 mobile-padding-right-5 system-padding-right-10 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
		<?php
			if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_hostel&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Hostel</button>
		</a><br>
		<?php } ?>

		<?php
			if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_room&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Room</button>
		</a><br>
		<?php } ?>
		<a href="/bc-admin.php?page=smgt_bed&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Beds</button>
		</a>
	</div>
	
	<?php if(!isset($_SESSION["sup_adm_session"])){ ?>
	<a href="/bc-admin.php?page=smgt_transport&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button onmouseover="grayImg(this,'transportation-img','Transportation.png');" onmouseout="whiteImg(this,'transportation-img','Transportation.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="transportation-img" src="imgfile/white/Transportation.png"/>
			Transport
		</button>
	</a><br>
	
	<!-- <a href="/bc-admin.php?page=smgt_report">
		<button onmouseover="grayImg(this,'report-img','report.png');" onmouseout="whiteImg(this,'report-img','report.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="report-img" src="imgfile/white/report.png"/>
			Report
		</button>
	</a><br> -->
	
	<a onclick="osList('sub-notification');">
		<button onmouseover="grayImg(this,'notifications-img','notifications.png'); grayDropImg('notification-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'notifications-img','notifications.png'); whiteDropImg('notification-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="notifications-img" src="imgfile/white/notifications.png"/>
			Notification
			<img id="notification-drop-img" src="imgfile/white/drop-forward.png" style="float: right;"/>
		</button>
	</a><br>
	<?php } ?>
	<div id="sub-notification" style="display: none; margin: 0 0 0 -16px;" class="color-7 bg-2 mobile-width-100  system-width-100 mobile-padding-left-5 system-padding-left-10 mobile-padding-right-5 system-padding-right-10 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
		<a href="/bc-admin.php?page=smgt_notice&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Notice</button>
		</a><br>
		<!-- <a href="/bc-admin.php?page=smgt_message&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Message</button>
		</a><br> -->
		<a href="/bc-admin.php?page=smgt_notification&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Notification</button>
		</a><br>
		<a href="/bc-admin.php?page=smgt_holiday&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Holiday</button>
		</a>
	</div>
	
	<?php
		if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) && !isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
	?>
	<a onclick="osList('sub-system-settings');">
		<button onmouseover="grayImg(this,'system-settings-img','setting.png'); grayDropImg('system-settings-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'system-settings-img','setting.png'); whiteDropImg('system-settings-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="system-settings-img" src="imgfile/white/setting.png"/>
			System Settings
			<img id="system-settings-drop-img" src="imgfile/white/drop-forward.png" style="float: right;"/>
		</button>
	</a><br>
	<div id="sub-system-settings" style="display: none; margin: 0 0 0 -16px;" class="color-7 bg-2 mobile-width-100  system-width-100 mobile-padding-left-5 system-padding-left-10 mobile-padding-right-5 system-padding-right-10 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
		<!-- <a href="/bc-admin.php?page=smgt_custom_fields">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Custom Fields</button>
		</a><br>
		<a href="/bc-admin.php?page=smgt_sms_setting">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">SMS Settings</button>
		</a><br> -->
		<?php
			if(!isset($_SESSION["sup_adm_session"]) && isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
		?>
		<a href="/bc-admin.php?page=smgt_email_template">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Email Template</button>
		</a><br>
		<?php } ?>
		<!-- <a href="/bc-admin.php?page=smgt_access_right">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Access Right</button>
		</a><br> -->
		<a href="/bc-admin.php?page=smgt_general_settings&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">General Settings</button>
		</a>
	</div>
	<?php } ?>
	
	
	<?php
		if(!isset($_SESSION["sup_adm_session"]) && !isset($_SESSION["mod_adm_session"]) && isset($_SESSION["adm_staff_session"]) || isset($_SESSION["teacher_session"]) || isset($_SESSION["stu_par_session"]) || isset($_SESSION["stu_session"])){
	?>
	<a onclick="osList('acc-system-settings');">
		<button onmouseover="grayImg(this,'system-settings-img','setting.png'); grayDropImg('system-settings-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'system-settings-img','setting.png'); whiteDropImg('system-settings-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="system-settings-img" src="imgfile/white/setting.png"/>
			Account
			<img id="system-settings-drop-img" src="imgfile/white/drop-forward.png" style="float: right;"/>
		</button>
	</a><br>
	<div id="acc-system-settings" style="display: none; margin: 0 0 0 -16px;" class="color-7 bg-2 mobile-width-100  system-width-100 mobile-padding-left-5 system-padding-left-10 mobile-padding-right-5 system-padding-right-10 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
		<a href="/bc-admin.php?page=smgt_user_settings&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Account Settings</button>
		</a>
	</div>
	<?php } ?>
	
	<?php
		if(isset($_SESSION["sup_adm_session"]) && !isset($_SESSION["mod_adm_session"]) && !isset($_SESSION["adm_staff_session"]) && !isset($_SESSION["teacher_session"]) && !isset($_SESSION["stu_par_session"]) && !isset($_SESSION["stu_session"])){
	?>
	<a onclick="osList('acc-system-settings');">
		<button onmouseover="grayImg(this,'system-settings-img','setting.png'); grayDropImg('system-settings-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'system-settings-img','setting.png'); whiteDropImg('system-settings-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="system-settings-img" src="imgfile/white/setting.png"/>
			Account
			<img id="system-settings-drop-img" src="imgfile/white/drop-forward.png" style="float: right;"/>
		</button>
	</a><br>
	<div id="acc-system-settings" style="display: none; margin: 0 0 0 -16px;" class="color-7 bg-2 mobile-width-100  system-width-100 mobile-padding-left-5 system-padding-left-10 mobile-padding-right-5 system-padding-right-10 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
		<a href="/bc-admin.php?page=smgt_admin_settings">
			<button style="text-align:left;" type="button" class="button-box color-7 bg-6 mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-14">Account Settings</button>
		</a>
	</div>
	<?php } ?>
	
	<?php if(isset($_SESSION["sup_adm_session_temp"]) && !isset($_SESSION["sup_adm_session"])){ ?>
	<a onclick="javascript:if(confirm('Do you want to switch back? ')){switchBackUser();}">
		<button onmouseover="grayImg(this,'switch-img','logout.png');" onmouseout="whiteImg(this,'switch-img','logout.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="switch-img" src="imgfile/white/logout.png"/>
			Switch Back
		</button>
	</a><br>
	<?php } ?>

	<a onclick="javascript:if(confirm('Do you want to logout? ')){window.location.href='/logout.php'}">
		<button onmouseover="grayImg(this,'logout-img','logout.png'); grayDropImg('logout-drop-img','drop-forward.png');" onmouseout="whiteImg(this,'logout-img','logout.png'); whiteDropImg('logout-drop-img','drop-forward.png');" style="text-align:left;" type="button" class="button-box color-2 bg-3 mobile-font-size-14 system-font-size-14">
			<img id="logout-img" src="imgfile/white/logout.png"/>
			Logout
		</button>
	</a>
	
	<script type="text/javascript">
		function grayImg(x,imgName,imgSrc){
			x.style.backgroundColor = "#ffffff";
			x.classList.remove("color-2");
			x.classList.add("color-7");
			document.getElementById(imgName).src = "imgfile/"+imgSrc;
		}
		
		function whiteImg(x,imgName,imgSrc){
			x.style.backgroundColor = "transparent";
			x.classList.remove("color-7");
			x.classList.add("color-2");
			document.getElementById(imgName).src = "imgfile/white/"+imgSrc;
		}
		
		function grayDropImg(imgName,imgSrc){
			document.getElementById(imgName).src = "imgfile/"+imgSrc;
		}
		
		function whiteDropImg(imgName,imgSrc){
			document.getElementById(imgName).src = "imgfile/white/"+imgSrc;
		}
		
		function osList(idName){
			const idDisplayState = document.getElementById(idName).style.display;
			if(idDisplayState == "none"){
				document.getElementById(idName).style.display = "inline-block";
			}else{
				document.getElementById(idName).style.display = "none";
			}
		
		}
		
	</script>


<!--<center>
	<a href="/admin/login.php">
		<button type="button"><img src="/images/log.png"/>Login</button> <br/>
	</a>
</center>-->

</div>

		<script>
			function openManageAPILists(){
				if(document.getElementById('manageapilist-1').style.display == "none"){
					for(x=1; x<1+2; x++){
						document.getElementById('manageapilist-'+x).style.display = "inline-block";
					}
				}else{
					for(x=1; x<1+12; x++){
						document.getElementById('manageapilist-'+x).style.display = "none";
					}
				}
			}				
		</script>
				
<script>

document.getElementsByClassName("header-menu")[0].onclick = function(){
	if(document.getElementsByClassName("menu-div")[0].style.height == "0px"){
		setTimeout(function(){
			document.getElementsByClassName("menu-div")[0].style.height = ((70/100)*(document.documentElement.clientHeight))+"px";
		},100);
		//document.getElementsByClassName("header-menu")[0].style.backgroundColor = "orange";
		document.getElementById("header-menu-icon").src = "imgfile/close-menu.png";
	}else{
		document.getElementsByClassName("menu-div")[0].style.height = "0px";
		document.getElementsByClassName("header-menu")[0].style.backgroundColor = "";
		document.getElementById("header-menu-icon").src = "imgfile/open-menu.png";
	}
}

//Destroy Transaction Session
setTimeout(function(){
	var httpDestroyTransactionText = new XMLHttpRequest();
	httpDestroyTransactionText.open("GET","./../include/destroy-transaction-session.php",true);
	httpDestroyTransactionText.setRequestHeader("Content-Type","application/json");
	httpDestroyTransactionText.send();
	
},3000);
</script>

<div class="web-header-second">
	<?php
	if(strip_tags($page) == "smgt_dashboard"){
		if(isset($_SESSION["sup_adm_session"])){
			$session_user_dashboard_firstname = $get_logged_user_details["firstname"]." (Super Admin)";
		}else{
			if(isset($_SESSION["mod_adm_session"])){
				$session_user_dashboard_firstname = $get_logged_user_details["firstname"]." (School Admin)";
			}else{
				if(isset($_SESSION["adm_staff_session"])){
					$session_user_dashboard_firstname = $get_logged_user_details["firstname"]." (Admin Staff)";
				}else{
					if(isset($_SESSION["teacher_session"])){
						$session_user_dashboard_firstname = $get_logged_user_details["firstname"]." (Teacher)";
					}else{
						if(isset($_SESSION["stu_par_session"])){
							$session_user_dashboard_firstname = "Mr/Mrs ".$get_logged_user_details["father_first_name"]." (Parent)";
						}else{
							if(isset($_SESSION["stu_session"])){
								$session_user_dashboard_firstname = $get_logged_user_details["firstname"]." (Student)";
							}else{
								if(isset($_SESSION["sup_adm_session"])){
									$session_user_dashboard_firstname = $get_logged_user_details["firstname"];
								}
							}
						}	
					}
				}	
			}	
		}	
	?>
		<span class="color-7 mobile-font-size-25 system-font-size-25 mobile-margin-left-3 system-margin-left-3">Welcome, <?php echo $session_user_dashboard_firstname; ?></span>
	<?php
		}else{
			//Header Title
		$header_title_arrays = array(
			"smgt_session" => "Session",
			"smgt_class" => "Class",
			"smgt_class_category" => "Class Category",
			"smgt_time_table" => "Class Time Table",
			"smgt_subject" => "Subject",
			"smgt_student" => "Student",
			"smgt_teacher" => "Teacher",
			"smgt_adminstaff" => "Admin Staff",
			"smgt_parent" => "Parent",
			"smgt_school" => "Manage School",
			"smgt_cbt_activation" => "School CBT Activatiom",
			"smgt_exam" => "Exam",
			"smgt_hall" => "Exam Hall",
			"smgt_result" => "Manage Marks",
			"smgt_check_result" => "Check Result",
			"smgt_grade" => "Grade",
			"smgt_migration" => "Migration",
			"smgt_fees_payment" => "Fees Type",
			"smgt_student_homework" => "Homework",
			"smgt_cbt" => "Computer-Based Test",
			"smgt_attendance" => "Attendance",
			"smgt_payment" => "Payment",
			"smgt_library" => "Library",
			"smgt_hostel" => "Hostel",
			"smgt_room" => "Room",
			"smgt_bed" => "Bed",
			"smgt_transport" => "Transport",
			"smgt_report" => "Report",
			"smgt_notice" => "Notice",
			"smgt_message" => "Message",
			"smgt_notification" => "Notification",
			"smgt_holiday" => "Holiday",
			"smgt_custom_fields" => "Custom Fields",
			"smgt_sms_setting" => "SMS Setting",
			"smgt_email_template" => "Email Template",
			"smgt_access_right" => "Access Right",
			"smgt_general_settings" => "General Settings",
			"smgt_user_settings" => "Account Settings",
			"smgt_admin_settings" => "Account Settings",
			"smgt_teacher_students" => "Teacher Students",
			
		);
		$header_title_jsons = json_encode($header_title_arrays,true);
		$decode_header_title_jsons = json_decode($header_title_jsons,true);

		$page_tab_name_arrays = array(
			"add_session" => "Add Session",
			"add_school" => "Register/View School",
			"view_school" => "View School",
			"add_class" => "Create Class",
			"add_class_category" => "Create Class",
			"add_admin_staff" => "Add/Edit Admin Staff",
			"view_admin_staff" => "View Admin Staff",
			"add_teacher" => "Add/Edit Teacher",
			"view_teacher" => "View Teacher",
			"add_parent" => "Add/Edit Parent",
			"view_parent" => "View Parent",
			"parent_reg" => "Step 1 - Parent Registration",
			"add_subject" => "Add/Edit Subject",
			"add_student" => "Add/Edit Student",
			"student_reg" => "Final Step - Student Registration",
			"view_student" => "View Student",
			"admit" => "Admit Student + Parent",
			"add_exam" => "Add/Edit Exam",
			"time_table" => "Exam Time Table",
			"add_hostel" => "Add/Edit Hostel",
			"add_room" => "Add/Edit Room",
			"add_bed" => "Add/Edit Bed",
			"assign_bed" => "Assign Bed",
			"add_hall" => "Exam Hall List",
			"exam_hall_receipt" => "Exam Hall Receipt",
			"add_notice" => "Add/Edit Notice",
			"add_notification" => "Add/Edit Notification",
			"add_holiday" => "Add/Edit Holiday",
			"add_transport" => "Add/Edit Transport",
			"manage_marks" => "Manage Marks",
			"multiple_subject_marks" => "Add Multiple Subject Marks",
			"add_grade" => "Add Grade",
			"migrate_class" => "Migration",
			"export_marks" => "Export Marks",
			"homework_list" => "Homework List",
			"view_submission" => "View Submission",
			"add_homework" => "Add Homework",
			"scheldule_list" => "CBT Scheldule List",
			"view_submitted_cbt" => "View Submitted CBT",
			"add_cbt" => "Add/Edit CBT",
			"add_cbt_quiz" => "Add/Edit CBT Quiz",
			"fees_list" => "Fees Type",
			"fees_payment_type" => "Fees Payment Type",
			"add_fees_type" => "Fees Type",
			"fees_payment_list" => "Fees Payment",
			"add_fees_payment" => "Fees Payment",
			"view_payment_invoice" => "View Payment Invoice",
			"issue_list" => "Library",
			"add_book" => "Book",
			"book_list" => "Book",
			"issue_book" => "Issue Book",
			"student_attendance" => "Student Attendance",
			"teacher_attendance" => "Teacher Attendance",
			"route_list" => "Class Time Table",
			"exam_list" => "Exam Time Table",
			"add_class_time_table" => "Add Class Time Table",
			"add_exam_time_table" => "Add Exam Time Table",
			"view_result" => "Check School Result",
			"add_remarks" => "Add Remarks",
		);
		$page_tab_name_jsons = json_encode($page_tab_name_arrays,true);
		$decode_page_tab_name_jsons = json_decode($page_tab_name_jsons,true);

	?>
		<?php if(isset($decode_page_tab_name_jsons[strip_tags($tab)]) && ($decode_page_tab_name_jsons[strip_tags($tab)] == true) && (isset($show_back_arrow) && $show_back_arrow === true)){ ?>
			<a style="text-decoration: none;" href="<?php echo explode("?",trim($_SERVER['REQUEST_URI']))[0]."?page=".strip_tags($page)."&tab=true".(isset($additional_back_tag) ? $additional_back_tag : ''); ?>">
				<img src="imgfile/Back_Arrow.png" style="position: relative; height: 1rem; object-fit: contain; pointer-events: none;" class="mobile-width-14 system-width-5 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-1" />
			</a>
		<?php } ?>

		<span class="color-7 mobile-font-size-25 system-font-size-25 mobile-margin-left-3 system-margin-left-3">
			<?php
				if(isset($decode_page_tab_name_jsons[strip_tags($tab)]) && $decode_page_tab_name_jsons[strip_tags($tab)] == true){
					echo $decode_page_tab_name_jsons[strip_tags($tab)];
				}else{
					echo isset($decode_header_title_jsons[strip_tags($page)]) ? $decode_header_title_jsons[strip_tags($page)] : '';
				}
				
			?>
		</span>
		
		<?php if(((strip_tags($tab) == "true") && (!isset($decode_page_tab_name_jsons[strip_tags($tab)]) || $decode_page_tab_name_jsons[strip_tags($tab)] == false)) && (!isset($show_hd_add_button) || ($show_hd_add_button === true))){ ?>
			<a style="text-decoration: none;" href="<?php echo str_replace('tab=true','tab='.(isset($header_add_button) ? $header_add_button : ''),$_SERVER['REQUEST_URI']); ?>">
				<img src="imgfile/Add_new_Button.png" style="position: relative; height: 1.8rem; object-fit: contain; pointer-events: none;" class="mobile-width-14 system-width-5 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-1" />
			</a>
		<?php } ?>
	<?php } ?>
	<div class="sec-header-items">
		<?php
			if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
		?>
		<a href="/bc-admin.php?page=smgt_general_settings&id=<?php echo $get_logged_user_details['school_id_number']; ?>" style="text-decoration:none;" >
			<button type="button" class="button-box avatar_icon_height bg-8 mobile-width-15 system-width-23 mobile-margin-left-4 system-margin-left-4 mobile-padding-top-2 system-padding-top-1 mobile-padding-bottom-2 system-padding-bottom-1 mobile-padding-left-2 system-padding-left-1  mobile-padding-right-2 system-padding-right-1">
				<img src="imgfile/Settings.png"/>
			</button>
		</a>
		
		<a href="/bc-admin.php?page=smgt_notice&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>" style="text-decoration:none;" >
			<button type="button" class="button-box avatar_icon_height bg-8 mobile-width-15 system-width-23 mobile-margin-left-6 system-margin-left-6 mobile-padding-top-2 system-padding-top-1 mobile-padding-bottom-2 system-padding-bottom-1 mobile-padding-left-2 system-padding-left-1  mobile-padding-right-2 system-padding-right-1">
				<img src="imgfile/Bell-Notification.png"/>
			</button>
		</a>
		<?php } ?>
		
		<?php
			if(($user_identifier_auth_id == "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
		?>
		<a href="" style="text-decoration:none;" >
			<img src="imgfile/Avatar1.png" style="" class="avatar avatar_icon_height mobile-width-13 system-width-22 mobile-margin-left-4 system-margin-left-4 mobile-margin-right-5 system-margin-right-4"/>
		</a>
		<?php }else{ 
			if(file_exists("dataimg/".$user_profile_photo_auth[0])){
		?>
		<a href="" style="text-decoration:none;" >
			<img src="dataimg/<?php echo $user_profile_photo_auth[0]; ?>" style="" class="avatar avatar_icon_height mobile-width-13 system-width-22 mobile-margin-left-4 system-margin-left-4 mobile-margin-right-5 system-margin-right-4"/>
		</a>
		<?php }else{ ?>
		<a href="" style="text-decoration:none;" >
			<img src="imgfile/<?php echo $user_profile_photo_auth[1]; ?>" style="" class="avatar avatar_icon_height mobile-width-13 system-width-22 mobile-margin-left-4 system-margin-left-4 mobile-margin-right-5 system-margin-right-4"/>
		</a>
		<?php } ?>
		<?php } ?>
	</div><br><br>
</div>

<div class="header-div-space"></div>
<!-- System Mode Div Begin -->
<div class="system-right-menu">