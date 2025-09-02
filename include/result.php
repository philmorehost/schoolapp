<?php
if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
	?>
	<div style=""
		class="container-box bg-2  border-style-bottom-1 border-color-5 border-width-1 mobile-width-92 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-5 system-margin-left-2">
		<a style="text-decoration: none;"
			href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=manage_marks&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit"
				class="button-box-2 <?php if (strip_tags($_GET['tab']) == 'manage_marks') {
					echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 ';
				} else {
					echo 'color-5 border-style-bottom-1 border-color-3 border-width-2';
				} ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				MANAGE MARKS
			</button>
		</a>
		<a style="text-decoration: none;"
			href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=multiple_subject_marks&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit"
				class="button-box-2 <?php if (strip_tags($_GET['tab']) == 'multiple_subject_marks') {
					echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 ';
				} else {
					echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 ';
				} ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				ADD MULTIPLE SUBJECT MARKS
			</button>
		</a>
		<?php
		if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
			?>
			<a style="text-decoration: none;"
				href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=view_result&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
				<button style="margin-bottom: -0.1px;" type="submit"
					class="button-box-2 <?php if (strip_tags($_GET['tab']) == 'view_result') {
						echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 ';
					} else {
						echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 ';
					} ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
					VIEW RESULT
				</button>
			</a>
		<?php } ?>
		<a style="text-decoration: none;"
			href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=add_remarks&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit"
				class="button-box-2 <?php if (strip_tags($_GET['tab']) == 'add_remarks') {
					echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 ';
				} else {
					echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 ';
				} ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				ADD REMARKS
			</button>
		</a>
	</div>

	<?php
	function studentName($student_info, $school_id)
	{
		global $connection_server;
		$student_name = "N/A"; // Initialize
		$get_student_name = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$student_info' LIMIT 1");
		if (mysqli_num_rows($get_student_name) == 1) {
			$student_name_array = mysqli_fetch_assoc($get_student_name);
			$student_name = $student_name_array["lastname"] . " " . $student_name_array["firstname"] . " " . $student_name_array["othername"];
		}
		return $student_name;
	}

	function getScoreGrade($score_info, $type_info, $school_id)
	{
		global $connection_server;

		$grade_name = "N/A"; // Initialize to a default value
		$get_grade_name = mysqli_query($connection_server, "SELECT * FROM sm_grades WHERE school_id_number='$school_id'");
		if (mysqli_num_rows($get_grade_name) > 0) {
			while ($grade_name_array = mysqli_fetch_array($get_grade_name)) {
				if (in_array($score_info, range($grade_name_array["mark_from"], $grade_name_array["mark_upto"]))) {
					if ($type_info == "grade") {
						$grade_name = $grade_name_array["grade_name"];
					}

					if ($type_info == "remark") {
						$grade_name = $grade_name_array["grade_comment"];
					}
					break; // Exit loop once grade is found
				}
			}
		}

		return $grade_name;
	}
	?>

	<?php if (strip_tags($_GET['tab']) == 'manage_marks') { ?>
		<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
			<center>
				<?php
				$view_session = array_filter(explode("_", trim(strip_tags($_GET['view']))))[0];
				$view_numeric_class_name = array_filter(explode("_", trim(strip_tags($_GET['view']))))[1];
				$view_term_id_number = array_filter(explode("_", trim(strip_tags($_GET['view']))))[2];
				$view_subject_code = array_filter(explode("_", trim(strip_tags($_GET['view']))))[3];
				$view_numeric_class_category_name = trim(strip_tags($_GET['class_category']));

				?>
				<?php if (((isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) !== "")) || ((!isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) == "") && (isset($_GET['tab'])))) { ?>
					<form method="post" enctype="multipart/form-data">
						<div
							class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<select name="numeric-class" onchange="findClassSession();" id="find-result-class-session"
								class="form-select" required>
								<option selected disabled hidden value="">Select Class</option>
								<?php

								$select_class_list_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' " . $user_admission_id_statement_auth . " GROUP BY numeric_class_name");

								if (mysqli_num_rows($select_class_list_detail_using_id) > 0) {
									while ($class_list_details = mysqli_fetch_assoc($select_class_list_detail_using_id)) {
										$class_numeric_names .= "numeric_class_name='" . $class_list_details["numeric_class_name"] . "'" . "\n";
										$class_numeric_names_ids .= $class_list_details["numeric_class_name"] . "\n";
									}
								}

								$class_numeric_names_sqli_statements .= " && (" . str_replace("\n", " OR ", trim($class_numeric_names)) . ")";

								$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' " . $class_numeric_names_sqli_statements . " GROUP BY numeric_class_name");

								if (mysqli_num_rows($select_classes_detail_using_id) > 0) {
									while ($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)) {
										if ($classes_details["numeric_class_name"] == $view_numeric_class_name) {
											$selected = "selected";
											echo '<option value="' . $classes_details["numeric_class_name"] . '" ' . $selected . '>' . $classes_details["class_name"] . ' (' . $classes_details["numeric_class_name"] . ')</option>';
										} else {
											echo '<option value="' . $classes_details["numeric_class_name"] . '" >' . $classes_details["class_name"] . ' (' . $classes_details["numeric_class_name"] . ')</option>';
										}

									}
								}

								?>
							</select>
							<span class="form-span mobile-font-size-12 system-font-size-14">Select Class</span>
						</div>

						<div
							class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<select name="session" id="add-result-class-session" class="form-select" required>
								<option disabled hidden selected value="">Select Class Session</option>
								<?php
								if ((!empty($view_session))) {
									$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='$view_numeric_class_name'");

									if (mysqli_num_rows($select_sessions_detail_using_id) > 0) {
										while ($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)) {
											if ($sessions_details["session"] == $view_session) {
												$selected = "selected";
												echo '<option value="' . $sessions_details["session"] . '" ' . $selected . '>' . str_replace("-", "/", $sessions_details["session"]) . '</option>';
											} else {
												echo '<option value="' . $sessions_details["session"] . '" >' . str_replace("-", "/", $sessions_details["session"]) . '</option>';
											}

										}
									}
								}

								?>
							</select>
							<span class="form-span mobile-font-size-12 system-font-size-14">Class Session</span>
						</div>

						<div
							class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<select name="term" class="form-select" required>
								<option disabled hidden selected value="">Select Term</option>
								<?php
								$select_terms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "'");

								if (mysqli_num_rows($select_terms_detail_using_id) > 0) {
									while ($terms_details = mysqli_fetch_assoc($select_terms_detail_using_id)) {
										if ($terms_details["id_number"] == $view_term_id_number) {
											$selected = "selected";
											echo '<option value="' . $terms_details["id_number"] . '" ' . $selected . '>' . $terms_details["term_name"] . '</option>';
										} else {
											echo '<option value="' . $terms_details["id_number"] . '">' . $terms_details["term_name"] . '</option>';
										}

									}
								}

								?>
							</select>
							<span class="form-span mobile-font-size-12 system-font-size-14">Term</span>
						</div>

						<div
							class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<select name="subject-code" class="form-select" required>
								<option selected disabled hidden value="">Select Subject</option>
								<?php
								$select_results_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "'");

								if (mysqli_num_rows($select_results_detail_using_id) > 0) {
									while ($results_details = mysqli_fetch_assoc($select_results_detail_using_id)) {
										if ($results_details["subject_code"] == $view_subject_code) {
											$selected = "selected";
											echo '<option value="' . $results_details["subject_code"] . '" ' . $selected . '>' . $results_details["subject_name"] . ' (' . $results_details["subject_code"] . ')</option>';
										} else {
											echo '<option value="' . $results_details["subject_code"] . '" >' . $results_details["subject_name"] . ' (' . $results_details["subject_code"] . ')</option>';
										}

									}
								}

								?>
							</select>
							<span class="form-span mobile-font-size-12 system-font-size-14">Subject Name*</span>
						</div>

						<div
							class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<select name="class-category" class="form-select">
								<option selected disabled hidden value="">Select Class Category</option>
								<?php
								$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "'");

								if (mysqli_num_rows($select_classes_detail_using_id) > 0) {
									while ($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)) {
										if ($classes_details["numeric_class_category_name"] == $view_numeric_class_category_name) {
											$selected = "selected";
											echo '<option value="' . $classes_details["numeric_class_category_name"] . '" ' . $selected . '>' . $classes_details["class_category_name"] . '</option>';
										} else {
											echo '<option value="' . $classes_details["numeric_class_category_name"] . '" >' . $classes_details["class_category_name"] . '</option>';
										}

									}
								}

								?>
							</select>
							<span class="form-span mobile-font-size-12 system-font-size-14">Assign Class Category</span>
						</div>

						<input hidden id="result-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />

						<button name="manage-marks" style="float: right; clear: right;" type="submit"
							class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-1 system-margin-left-3 mobile-margin-right-2 system-margin-right-1">
							MANAGE MARKS
						</button>
					</form>

					<form method="post" enctype="multipart/form-data">
						<?php if (!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))) { ?>
							<div style="display: inline-block;"
								class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
								<?php echo $err_msg; ?>
							</div>
						<?php } ?>

						<?php

						if (isset($_GET['view']) && !empty(trim(strip_tags($_GET['view'])))) {
							$get_result_manage_marks = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='$view_numeric_class_name' && term_id_number='$view_term_id_number' && session='$view_session' && subject_code='$view_subject_code'");
							$get_result_release_dates = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_result_release_dates WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='$view_numeric_class_name' && term_id_number='$view_term_id_number' && session='$view_session'"));

							if ((in_array($view_numeric_class_name, array_filter(explode("\n", trim($class_numeric_names_ids))))) || (isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]))) {
								if (mysqli_num_rows($get_result_manage_marks) >= 1) {
									$show_result_table = true;

								} else {
									$show_result_table = false;
								}
							} else {
								$show_result_table = false;
							}
						} else {
							$show_result_table = false;
						}
						?>

						<?php if ($show_result_table === true) { ?>
							<div style="float: left; clear: left;"
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
								<input type="file" id="manageMarkFile" accept="csv" class="form-file-chooser" />
								<span class="form-span mobile-font-size-12 system-font-size-14">Document Upload</span>
								<div style="float: left; clear: left; text-align: left;"
									class="form-group mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-16 text-bold-light mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-0 system-margin-bottom-0 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
									Required Columns: <br>
									<b>student_roll_no</b> - Student Admission Number,<br>
									<b>ca_1</b> - 1st C.A,<br>
									<b>ca_2</b> - 2nd C.A,<br>
									<b>ca_3</b> - 3rd C.A,<br>
									<b>exam</b> - Examination</b><br>
									Note: Document must be CSV file
								</div>
							</div><br>

							<div class="scroll-box bg-2 mobile-width-96 system-width-96">
								<table class="table-tag mobile-font-size-12 system-font-size-14">
									<tr>
										<th>Roll No</th>
										<th>Name</th>
										<th>1st C.A</th>
										<th>2nd C.A</th>
										<th>3rd C.A</th>
										<th>Exam</th>
										<!--<th>Comment</th>-->
									</tr>
									<?php
									if (mysqli_num_rows($get_result_manage_marks) > 0) {
										while (($result_manage_marks_details = mysqli_fetch_assoc($get_result_manage_marks))) {
											$search_student_with_admission_no = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE (school_id_number='" . $result_manage_marks_details["school_id_number"] . "' && admission_number='" . $result_manage_marks_details["admission_number"] . "')");
											if (mysqli_num_rows($search_student_with_admission_no) == 1) {
												$get_search_student_with_admission_no = mysqli_fetch_array($search_student_with_admission_no);
												if (!empty(trim(strip_tags($_GET['class_category'])))) {
													$checkmate_class_category = ($get_search_student_with_admission_no["numeric_class_category_name"] == trim(strip_tags($_GET['class_category'])));
												} else {
													$checkmate_class_category = "1 == 1";
												}
												if ($checkmate_class_category) {
													echo '<tr>
													<td>
														' . $result_manage_marks_details["admission_number"] . '
														<input hidden name="admission-number[]" value="' . $result_manage_marks_details["admission_number"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="" class="form-input" readonly required/>
													</td>
													<td>' . studentName($result_manage_marks_details["admission_number"], $result_manage_marks_details["school_id_number"]) . '</td>
													<td>
														<div class="form-group mobile-width-90 system-width-40">
															<input id="' . $result_manage_marks_details["admission_number"] . '-ca1" name="first-ca[]" value="' . $result_manage_marks_details["first_ca"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="1st CA" class="form-input" required/>
														</div>
													</td>
													<td>
														<div class="form-group mobile-width-90 system-width-40">
															<input id="' . $result_manage_marks_details["admission_number"] . '-ca2" name="second-ca[]" value="' . $result_manage_marks_details["second_ca"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="2nd CA" class="form-input" />
														</div>
													</td>
													<td>
														<div class="form-group mobile-width-90 system-width-40">
															<input id="' . $result_manage_marks_details["admission_number"] . '-ca3" name="third-ca[]" value="' . $result_manage_marks_details["third_ca"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="3rd CA (Optional)" class="form-input" />
														</div>
													</td>
													<td>
														<div class="form-group mobile-width-90 system-width-40">
															<input id="' . $result_manage_marks_details["admission_number"] . '-exam" name="exam[]" value="' . $result_manage_marks_details["exam"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="Exam" class="form-input" />
														</div>
													</td>
													<!--<td>
														<div class="form-group mobile-width-90 system-width-40">
															<input name="comment[]" value="' . $result_manage_marks_details["comment"] . '" type="text" placeholder="Comment" class="form-input" />
														</div>
													</td>-->
												</tr>';
												}
											}
										}
									}
									?>
								</table>
							</div>
							<!--<div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
					<input name="release_date" type="date" value="<?php if (isset($get_result_release_dates['release_date']) && !empty($get_result_release_dates['release_date'])) {
						echo $get_result_release_dates['release_date'];
					} else {
						echo date('Y-m-d');
					} ?>" class="form-input" required/>
					<span class="form-span mobile-font-size-12 system-font-size-14">Result Release Date*</span>
				</div>-->
							<!-- Dummy Release Date -->
							<input name="release_date" type="text" value="" class="" hidden />

							<button name="save-marks" style="float: left; clear: left;" type="submit"
								class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
								SAVE
							</button>
						<?php } ?>
						<script>
							var manageMarkFile = document.getElementById("manageMarkFile");

							manageMarkFile.addEventListener("change",
								function () {
									readMarks = new FileReader();
									readMarks.onload = function () {
										var csvMarksText = readMarks.result;
										csvMarksText = csvMarksText.trim().split("\n");
										var csvHeaders = csvMarksText[0].trim().replaceAll(" ", "").split(",");
										var studentArrIndex = csvHeaders.indexOf("student_roll_no");
										var ca1ArrIndex = csvHeaders.indexOf("ca_1");
										var ca2ArrIndex = csvHeaders.indexOf("ca_2");
										var ca3ArrIndex = csvHeaders.indexOf("ca_3");
										var examArrIndex = csvHeaders.indexOf("exam");

										for (x = 0; x < csvMarksText.length; x++) {
											if (x !== 0) {
												if (csvMarksText[x].trim().length > 0) {
													var eachLineDetails = csvMarksText[x].split(",");
													var studentRollNumber = eachLineDetails[studentArrIndex].replaceAll('"', "").replaceAll("'", "");
													var studentCA1Marks = eachLineDetails[ca1ArrIndex].replaceAll('"', "").replaceAll("'", "");
													var studentCA2Marks = eachLineDetails[ca2ArrIndex].replaceAll('"', "").replaceAll("'", "");
													var studentCA3Marks = eachLineDetails[ca3ArrIndex].replaceAll('"', "").replaceAll("'", "");
													var examMarks = eachLineDetails[examArrIndex].replaceAll('"', "").replaceAll("'", "");

													if ((typeof (document.getElementById(studentRollNumber + "-ca1")) != "undefined") && (document.getElementById(studentRollNumber + "-ca1") != "null")) {
														document.getElementById(studentRollNumber + "-ca1").value = studentCA1Marks;
														document.getElementById(studentRollNumber + "-ca2").value = studentCA2Marks;
														document.getElementById(studentRollNumber + "-ca3").value = studentCA3Marks;
														document.getElementById(studentRollNumber + "-exam").value = examMarks;
													}
												}
											}
										}
									}
									readMarks.readAsText(this.files[0]);
								});

						</script>
					</form>
					<script>
						function findClassSession() {
							const find_result_class_session = document.getElementById("find-result-class-session");
							const add_result_class_session = document.getElementById("add-result-class-session");
							const result_school_id_number = document.getElementById("result-school-id");

							add_result_class_session.innerHTML = "";
							const createSelectSessionOption = document.createElement("option");
							createSelectSessionOption.hidden = true;
							createSelectSessionOption.disabled = true;
							createSelectSessionOption.selected = true;
							createSelectSessionOption.text = "Select Class Session";
							createSelectSessionOption.value = "";
							add_result_class_session.add(createSelectSessionOption);

							const classSessionHttpRequest = new XMLHttpRequest();
							classSessionHttpRequest.open("POST", "./get-class-session.php");
							classSessionHttpRequest.setRequestHeader("Content-Type", "application/json");
							const classSessionHttpRequestBody = JSON.stringify({ sch_no: result_school_id_number.value, class_id_no: find_result_class_session.value });
							classSessionHttpRequest.onload = function () {
								if ((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)) {

									const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];

									for (i = 0; i < session_list_array.length; i++) {
										const createSelectOption = document.createElement("option");
										createSelectOption.text = session_list_array[i].replace("-", "/");
										createSelectOption.value = session_list_array[i];
										add_result_class_session.add(createSelectOption);
									}
								} else {
									alert(classSessionHttpRequest.status);
								}
							}
							classSessionHttpRequest.send(classSessionHttpRequestBody);

						}

						function findClassUsers() {
							const add_result_user = document.getElementById("add-result-user");
							const result_school_id_number = document.getElementById("result-school-id");
							const result_class = document.getElementById("find-result-class-session");
							const result_session = document.getElementById("add-result-class-session");
							if ((result_class.value.trim() != "") && (result_session.value.trim() != "")) {
								add_result_user.innerHTML = "";
								const createSelectUsersOption = document.createElement("option");
								createSelectUsersOption.selected = true;
								createSelectUsersOption.text = "All";
								createSelectUsersOption.value = "all";
								add_result_user.add(createSelectUsersOption);

								const classUsersHttpRequest = new XMLHttpRequest();
								classUsersHttpRequest.open("POST", "./get-student.php");
								classUsersHttpRequest.setRequestHeader("Content-Type", "application/json");
								const classUsersHttpRequestBody = JSON.stringify({ sch_no: result_school_id_number.value, class_id_no: result_class.value, session: result_session.value });
								classUsersHttpRequest.onload = function () {
									if ((classUsersHttpRequest.readyState == 4) && (classUsersHttpRequest.status == 200)) {
										const student_list_array = Object.entries(JSON.parse(classUsersHttpRequest.responseText)["response"]);

										for (i = 0; i < student_list_array.length; i++) {
											const createSelectOption = document.createElement("option");
											createSelectOption.text = student_list_array[i][1];
											createSelectOption.value = student_list_array[i][0];
											add_result_user.add(createSelectOption);
										}
									} else {
										alert(classUsersHttpRequest.status);
									}
								}
								classUsersHttpRequest.send(classUsersHttpRequestBody);
							}
						}
					</script>
				<?php } ?>

			</center>
		</div>
	<?php } ?>

	<?php
	if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
		?>
		<?php if (strip_tags($_GET['tab']) == 'view_result') { ?>
			<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
				<center>
					<?php
					$view_session = array_filter(explode("_", trim(strip_tags($_GET['view']))))[0];
					$view_numeric_class_name = array_filter(explode("_", trim(strip_tags($_GET['view']))))[1];
					$view_term_id_number = array_filter(explode("_", trim(strip_tags($_GET['view']))))[2];
					$view_admission_number = array_filter(explode("_", trim(strip_tags($_GET['view']))))[3];

					?>
					<?php if (((isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) !== "")) || ((!isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) == "") && (isset($_GET['tab'])))) { ?>
						<form method="post" enctype="multipart/form-data">
							<div
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
								<select name="numeric-class" onchange="findResultClassSession(); resultClassSession();"
									id="find-result-class-session" class="form-select" required>
									<option selected disabled hidden value="">Select Class</option>
									<?php
									$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' GROUP BY numeric_class_name");

									if (mysqli_num_rows($select_classes_detail_using_id) > 0) {
										while ($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)) {
											if ($classes_details["numeric_class_name"] == $view_numeric_class_name) {
												$selected = "selected";
												echo '<option value="' . $classes_details["numeric_class_name"] . '" ' . $selected . '>' . $classes_details["class_name"] . ' (' . $classes_details["numeric_class_name"] . ')</option>';
											} else {
												echo '<option value="' . $classes_details["numeric_class_name"] . '" >' . $classes_details["class_name"] . ' (' . $classes_details["numeric_class_name"] . ')</option>';
											}

										}
									}

									?>
								</select>
								<span class="form-span mobile-font-size-12 system-font-size-14">Class Name*</span>
							</div>

							<div
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
								<select name="session" onchange="findClassSessionStudent(); resultClassSession();"
									id="add-result-class-session" class="form-select" required>
									<option disabled hidden selected value="">Select Class Session</option>
									<?php
									if (isset($view_numeric_class_name)) {
										$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='" . $view_numeric_class_name . "'");

										if (mysqli_num_rows($select_sessions_detail_using_id) > 0) {
											while ($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)) {
												if ($sessions_details["session"] == $view_session) {
													$selected = "selected";
													echo '<option value="' . $sessions_details["session"] . '" ' . $selected . '>' . str_replace("-", "/", $sessions_details["session"]) . '</option>';
												} else {
													echo '<option value="' . $sessions_details["session"] . '" >' . str_replace("-", "/", $sessions_details["session"]) . '</option>';
												}

											}
										}
									}

									?>
								</select>
								<span class="form-span mobile-font-size-12 system-font-size-14">Session Name*</span>
							</div>

							<div
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
								<select name="admission-number" id="student-roll-id" class="form-select">
									<option disabled hidden selected value="">Select Student</option>
									<option value="all">All Students</option>
									<?php
									if (isset($view_admission_number)) {
										$select_students_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='" . $view_numeric_class_name . "' && session='" . $view_session . "'");

										if (mysqli_num_rows($select_students_detail_using_id) > 0) {
											while ($students_details = mysqli_fetch_assoc($select_students_detail_using_id)) {
												$get_student_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && admission_number='" . $students_details["admission_number"] . "' LIMIT 1"));
												if ($students_details["admission_number"] == $view_admission_number) {
													$selected = "selected";
													echo '<option value="' . $students_details["admission_number"] . '" ' . $selected . '>' . $get_student_name["lastname"] . ' ' . $get_student_name["firstname"] . ' ' . $get_student_name["othername"] . '</option>';
												} else {
													echo '<option value="' . $students_details["admission_number"] . '" >' . $get_student_name["lastname"] . ' ' . $get_student_name["firstname"] . ' ' . $get_student_name["othername"] . '</option>';
												}

											}
										}
									}

									?>
								</select>
								<span class="form-span mobile-font-size-12 system-font-size-14">Select Student*</span>
							</div>

							<div
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
								<select name="term" class="form-select" required>
									<option disabled hidden selected value="">Select Term</option>
									<?php
									$select_terms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "'");

									if (mysqli_num_rows($select_terms_detail_using_id) > 0) {
										while ($terms_details = mysqli_fetch_assoc($select_terms_detail_using_id)) {
											if ($terms_details["id_number"] == $view_term_id_number) {
												$selected = "selected";
												echo '<option value="' . $terms_details["id_number"] . '" ' . $selected . '>' . $terms_details["term_name"] . '</option>';
											} else {
												echo '<option value="' . $terms_details["id_number"] . '">' . $terms_details["term_name"] . '</option>';
											}

										}
									}

									?>
								</select>
								<span class="form-span mobile-font-size-12 system-font-size-14">Term</span>
							</div>

							<input hidden id="result-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />

							<button name="view-result" style="float: left; clear: left;" type="submit"
								class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
								PROCEED
							</button>
						</form>

						<script>
							function findResultClassSession() {
								const find_result_class_session = document.getElementById("find-result-class-session");
								const add_result_class_session = document.getElementById("add-result-class-session");
								const result_school_id_number = document.getElementById("result-school-id");

								add_result_class_session.innerHTML = "";
								const createSelectSessionOption = document.createElement("option");
								createSelectSessionOption.hidden = true;
								createSelectSessionOption.disabled = true;
								createSelectSessionOption.selected = true;
								createSelectSessionOption.text = "Select Class Session";
								createSelectSessionOption.value = "";
								add_result_class_session.add(createSelectSessionOption);

								const classSessionHttpRequest = new XMLHttpRequest();
								classSessionHttpRequest.open("POST", "./get-class-session.php");
								classSessionHttpRequest.setRequestHeader("Content-Type", "application/json");
								const classSessionHttpRequestBody = JSON.stringify({ sch_no: result_school_id_number.value, class_id_no: find_result_class_session.value });

								classSessionHttpRequest.onload = function () {
									if ((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)) {

										const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];

										for (i = 0; i < session_list_array.length; i++) {
											const createSelectOption = document.createElement("option");
											createSelectOption.text = session_list_array[i].replace("-", "/");
											createSelectOption.value = session_list_array[i];
											add_result_class_session.add(createSelectOption);
										}
									} else {
										alert(classSessionHttpRequest.status);
									}
								}
								classSessionHttpRequest.send(classSessionHttpRequestBody);
								findClassSessionStudent();
							}

							function findClassSessionStudent() {
								const find_result_class_session = document.getElementById("find-result-class-session");
								const add_result_class_session = document.getElementById("add-result-class-session");
								const student_roll_id = document.getElementById("student-roll-id");

								const result_school_id_number = document.getElementById("result-school-id");

								student_roll_id.innerHTML = "";
								const createSelectStudentOption = document.createElement("option");
								createSelectStudentOption.hidden = true;
								createSelectStudentOption.disabled = true;
								createSelectStudentOption.selected = true;
								createSelectStudentOption.text = "Select Student";
								createSelectStudentOption.value = "";
								student_roll_id.add(createSelectStudentOption);

								const createSelectAllStudentOption = document.createElement("option");
								createSelectAllStudentOption.text = "All Students";
								createSelectAllStudentOption.value = "all";
								student_roll_id.add(createSelectAllStudentOption);

								const classSessionStudentHttpRequest = new XMLHttpRequest();
								classSessionStudentHttpRequest.open("POST", "./get-student.php");
								classSessionStudentHttpRequest.setRequestHeader("Content-Type", "application/json");
								const classSessionStudentHttpRequestBody = JSON.stringify({ sch_no: result_school_id_number.value, class_id_no: find_result_class_session.value, session: add_result_class_session.value });
								classSessionStudentHttpRequest.onload = function () {
									if ((classSessionStudentHttpRequest.readyState == 4) && (classSessionStudentHttpRequest.status == 200)) {

										const student_list_array = Object.entries(JSON.parse(classSessionStudentHttpRequest.responseText)["response"]);

										for (i = 0; i < student_list_array.length; i++) {
											const createSelectOption = document.createElement("option");
											createSelectOption.text = student_list_array[i][1];
											createSelectOption.value = student_list_array[i][0];
											student_roll_id.add(createSelectOption);
										}
									} else {
										alert(classSessionStudentHttpRequest.status);
									}
								}
								classSessionStudentHttpRequest.send(classSessionStudentHttpRequestBody);
							}

						</script>
						<?php if ($show_all_results === true) { ?>
							<div class="scroll-box bg-2 mobile-width-96 system-width-96">
								<table class="table-tag mobile-font-size-12 system-font-size-14">
									<tr>
										<th>Student Name</th>
										<th>Admission No</th>
										<th>1st C.A</th>
										<th>2nd C.A</th>
										<th>3rd C.A</th>
										<th>Exam</th>
										<th>Total</th>
										<th>Grade</th>
										<th>Remark</th>
									</tr>
									<?php
									if (mysqli_num_rows($all_students_results) > 0) {
										while (($result_details = mysqli_fetch_assoc($all_students_results))) {
											$first_ca = (int)$result_details["first_ca"];
											$second_ca = (int)$result_details["second_ca"];
											$third_ca = (int)$result_details["third_ca"];
											$exam = (int)$result_details["exam"];
											$total = $first_ca + $second_ca + $third_ca + $exam;
											$student_name = studentName($result_details["admission_number"], $result_details["school_id_number"]);
											$grade = getScoreGrade($total, 'grade', $result_details["school_id_number"]);
											$remark = getScoreGrade($total, 'remark', $result_details["school_id_number"]);

											echo '<tr>
												<td>' . $student_name . '</td>
												<td>' . $result_details["admission_number"] . '</td>
												<td>' . $first_ca . '</td>
												<td>' . $second_ca . '</td>
												<td>' . $third_ca . '</td>
												<td>' . $exam . '</td>
												<td>' . $total . '</td>
												<td>' . $grade . '</td>
												<td>' . $remark . '</td>
											</tr>';
										}
									}
									?>
								</table>
							</div>
						<?php } ?>
					<?php } ?>

				</center>
			</div>
		<?php } ?>
	<?php } ?>

	<?php
	if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
		?>
		<?php if (strip_tags($_GET['tab']) == 'add_remarks') { ?>
			<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
				<center>
					<?php
					$view_session = array_filter(explode("_", trim(strip_tags($_GET['view']))))[0];
					$view_numeric_class_name = array_filter(explode("_", trim(strip_tags($_GET['view']))))[1];
					$view_term_id_number = array_filter(explode("_", trim(strip_tags($_GET['view']))))[2];
					$view_numeric_class_category_name = trim(strip_tags($_GET['class_category']));
					?>
					<?php if (((isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) !== "")) || ((!isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) == "") && (isset($_GET['tab'])))) { ?>
						<form method="post" enctype="multipart/form-data">
							<div
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
								<select name="numeric-class" onchange="findClassSession();" id="find-result-class-session"
									class="form-select" required>
									<option selected disabled hidden value="">Select Class</option>
									<?php

									$select_class_list_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' " . $user_admission_id_statement_auth . " GROUP BY numeric_class_name");

									if (mysqli_num_rows($select_class_list_detail_using_id) > 0) {
										while ($class_list_details = mysqli_fetch_assoc($select_class_list_detail_using_id)) {
											$class_numeric_names .= "numeric_class_name='" . $class_list_details["numeric_class_name"] . "'" . "\n";
											$class_numeric_names_ids .= $class_list_details["numeric_class_name"] . "\n";
										}
									}

									$class_numeric_names_sqli_statements .= " && (" . str_replace("\n", " OR ", trim($class_numeric_names)) . ")";

									$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' " . $class_numeric_names_sqli_statements . " GROUP BY numeric_class_name");

									if (mysqli_num_rows($select_classes_detail_using_id) > 0) {
										while ($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)) {
											if ($classes_details["numeric_class_name"] == $view_numeric_class_name) {
												$selected = "selected";
												echo '<option value="' . $classes_details["numeric_class_name"] . '" ' . $selected . '>' . $classes_details["class_name"] . ' (' . $classes_details["numeric_class_name"] . ')</option>';
											} else {
												echo '<option value="' . $classes_details["numeric_class_name"] . '" >' . $classes_details["class_name"] . ' (' . $classes_details["numeric_class_name"] . ')</option>';
											}

										}
									}

									?>
								</select>
								<span class="form-span mobile-font-size-12 system-font-size-14">Select Class</span>
							</div>

							<div
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
								<select name="session" id="add-result-class-session" class="form-select" required>
									<option disabled hidden selected value="">Select Class Session</option>
									<?php
									if ((!empty($view_session))) {
										$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='$view_numeric_class_name'");

										if (mysqli_num_rows($select_sessions_detail_using_id) > 0) {
											while ($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)) {
												if ($sessions_details["session"] == $view_session) {
													$selected = "selected";
													echo '<option value="' . $sessions_details["session"] . '" ' . $selected . '>' . str_replace("-", "/", $sessions_details["session"]) . '</option>';
												} else {
													echo '<option value="' . $sessions_details["session"] . '" >' . str_replace("-", "/", $sessions_details["session"]) . '</option>';
												}

											}
										}
									}

									?>
								</select>
								<span class="form-span mobile-font-size-12 system-font-size-14">Class Session</span>
							</div>

							<div
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
								<select name="term" class="form-select" required>
									<option disabled hidden selected value="">Select Term</option>
									<?php
									$select_terms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "'");

									if (mysqli_num_rows($select_terms_detail_using_id) > 0) {
										while ($terms_details = mysqli_fetch_assoc($select_terms_detail_using_id)) {
											if ($terms_details["id_number"] == $view_term_id_number) {
												$selected = "selected";
												echo '<option value="' . $terms_details["id_number"] . '" ' . $selected . '>' . $terms_details["term_name"] . '</option>';
											} else {
												echo '<option value="' . $terms_details["id_number"] . '">' . $terms_details["term_name"] . '</option>';
											}

										}
									}

									?>
								</select>
								<span class="form-span mobile-font-size-12 system-font-size-14">Term</span>
							</div>

							<div
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
								<select name="class-category" class="form-select">
									<option selected disabled hidden value="">Select Class Category</option>
									<?php
									$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "'");

									if (mysqli_num_rows($select_classes_detail_using_id) > 0) {
										while ($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)) {
											if ($classes_details["numeric_class_category_name"] == $view_numeric_class_category_name) {
												$selected = "selected";
												echo '<option value="' . $classes_details["numeric_class_category_name"] . '" ' . $selected . '>' . $classes_details["class_category_name"] . '</option>';
											} else {
												echo '<option value="' . $classes_details["numeric_class_category_name"] . '" >' . $classes_details["class_category_name"] . '</option>';
											}

										}
									}

									?>
								</select>
								<span class="form-span mobile-font-size-12 system-font-size-14">Assign Class Category</span>
							</div>

							<input hidden id="result-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />

							<button name="add-remarks" style="float: left; clear: left;" type="submit"
								class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
								PROCEED
							</button>
						</form>

						<form method="post" enctype="multipart/form-data">
							<?php if (!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))) { ?>
								<div style="display: inline-block;"
									class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
									<?php echo $err_msg; ?>
								</div>
							<?php } ?>

							<?php

							if (isset($_GET['view']) && !empty(trim(strip_tags($_GET['view'])))) {
								$get_result_manage_marks = mysqli_query($connection_server, "SELECT * FROM sm_result_remarks WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='$view_numeric_class_name' && term_id_number='$view_term_id_number' && session='$view_session' GROUP BY admission_number");
								if ((in_array($view_numeric_class_name, array_filter(explode("\n", trim($class_numeric_names_ids))))) || (isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]))) {
									if (mysqli_num_rows($get_result_manage_marks) >= 1) {
										$show_result_table = true;

									} else {
										$show_result_table = false;
									}
								} else {
									$show_result_table = false;
								}
							} else {
								$show_result_table = false;
							}
							?>

							<?php if ($show_result_table === true) { ?>
								<div class="scroll-box bg-2 mobile-width-96 system-width-96">
									<table class="table-tag mobile-font-size-12 system-font-size-14">
										<tr>
											<th>Roll No</th>
											<th>Name</th>
											<th>Average Marks(%)</th>
											<th>Remark</th>
										</tr>
										<?php
										function averageMarkPercent($school_id, $class_info, $session_info, $term_info, $student_id)
										{
											global $connection_server;

											$search_student_to_results_in_database = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='$school_id' && numeric_class_name='$class_info' && session='$session_info' && term_id_number='$term_info' && admission_number='$student_id'");

											$subject_count = 0;
											$mark_obtained_count = 0;
											$mark_obtainable_count = 0;

											if (mysqli_num_rows($search_student_to_results_in_database) > 0) {
												while ($student_exam_subject_details = mysqli_fetch_array($search_student_to_results_in_database)) {
													$first_ca_mark = (int)$student_exam_subject_details["first_ca"];
													$second_ca_mark = (int)$student_exam_subject_details["second_ca"];
													$third_ca_mark = (int)$student_exam_subject_details["third_ca"];
													$examination_mark = (int)$student_exam_subject_details["exam"];

													$aggregate_score = $first_ca_mark + $second_ca_mark + $third_ca_mark + $examination_mark;

													$subject_count += 1;
													$mark_obtained_count += $aggregate_score;
													$mark_obtainable_count += 100;
												}
											}

											$average_mark_obtained = substr((($mark_obtained_count / $mark_obtainable_count) * 100), 0, 5);
											return $average_mark_obtained;
										}

										if (mysqli_num_rows($get_result_manage_marks) > 0) {
											while (($result_manage_marks_details = mysqli_fetch_assoc($get_result_manage_marks))) {
												$search_student_with_admission_no = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE (school_id_number='" . $result_manage_marks_details["school_id_number"] . "' && admission_number='" . $result_manage_marks_details["admission_number"] . "')");
												if (mysqli_num_rows($search_student_with_admission_no) == 1) {
													$get_search_student_with_admission_no = mysqli_fetch_array($search_student_with_admission_no);
													if (!empty(trim(strip_tags($_GET['class_category'])))) {
														$checkmate_class_category = ($get_search_student_with_admission_no["numeric_class_category_name"] == trim(strip_tags($_GET['class_category'])));
													} else {
														$checkmate_class_category = "1 == 1";
													}
													if ($checkmate_class_category) {

														echo '<tr>
													<td>
														' . $result_manage_marks_details["admission_number"] . '
														<input hidden name="admission-number[]" value="' . $result_manage_marks_details["admission_number"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="" class="form-input" readonly required/>
													</td>
													<td>' . studentName($result_manage_marks_details["admission_number"], $result_manage_marks_details["school_id_number"]) . '</td>
													<td>' . averageMarkPercent($result_manage_marks_details["school_id_number"], $result_manage_marks_details["numeric_class_name"], $result_manage_marks_details["session"], $result_manage_marks_details["term_id_number"], $result_manage_marks_details["admission_number"]) . '%</td>
													<td>
														<div class="form-group mobile-width-90 system-width-40">
															<input name="principal-remark[]" value="' . $result_manage_marks_details["principal_remark"] . '" placeholder="Principal Remark" class="form-input" />
														</div>
													</td>
												</tr>';
													}
												}
											}
										}
										?>
									</table>
								</div>
								<button name="save-remarks" style="float: left; clear: left;" type="submit"
									class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
									SAVE
								</button>
							<?php } ?>
						</form>
						<script>
							function findClassSession() {
								const find_result_class_session = document.getElementById("find-result-class-session");
								const add_result_class_session = document.getElementById("add-result-class-session");
								const result_school_id_number = document.getElementById("result-school-id");

								add_result_class_session.innerHTML = "";
								const createSelectSessionOption = document.createElement("option");
								createSelectSessionOption.hidden = true;
								createSelectSessionOption.disabled = true;
								createSelectSessionOption.selected = true;
								createSelectSessionOption.text = "Select Class Session";
								createSelectSessionOption.value = "";
								add_result_class_session.add(createSelectSessionOption);

								const classSessionHttpRequest = new XMLHttpRequest();
								classSessionHttpRequest.open("POST", "./get-class-session.php");
								classSessionHttpRequest.setRequestHeader("Content-Type", "application/json");
								const classSessionHttpRequestBody = JSON.stringify({ sch_no: result_school_id_number.value, class_id_no: find_result_class_session.value });
								classSessionHttpRequest.onload = function () {
									if ((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)) {

										const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];

										for (i = 0; i < session_list_array.length; i++) {
											const createSelectOption = document.createElement("option");
											createSelectOption.text = session_list_array[i].replace("-", "/");
											createSelectOption.value = session_list_array[i];
											add_result_class_session.add(createSelectOption);
										}
									} else {
										alert(classSessionHttpRequest.status);
									}
								}
								classSessionHttpRequest.send(classSessionHttpRequestBody);

							}

							function findClassUsers() {
								const add_result_user = document.getElementById("add-result-user");
								const result_school_id_number = document.getElementById("result-school-id");
								const result_class = document.getElementById("find-result-class-session");
								const result_session = document.getElementById("add-result-class-session");
								if ((result_class.value.trim() != "") && (result_session.value.trim() != "")) {
									add_result_user.innerHTML = "";
									const createSelectUsersOption = document.createElement("option");
									createSelectUsersOption.selected = true;
									createSelectUsersOption.text = "All";
									createSelectUsersOption.value = "all";
									add_result_user.add(createSelectUsersOption);

									const classUsersHttpRequest = new XMLHttpRequest();
									classUsersHttpRequest.open("POST", "./get-student.php");
									classUsersHttpRequest.setRequestHeader("Content-Type", "application/json");
									const classUsersHttpRequestBody = JSON.stringify({ sch_no: result_school_id_number.value, class_id_no: result_class.value, session: result_session.value });
									classUsersHttpRequest.onload = function () {
										if ((classUsersHttpRequest.readyState == 4) && (classUsersHttpRequest.status == 200)) {
											const student_list_array = Object.entries(JSON.parse(classUsersHttpRequest.responseText)["response"]);

											for (i = 0; i < student_list_array.length; i++) {
												const createSelectOption = document.createElement("option");
												createSelectOption.text = student_list_array[i][1];
												createSelectOption.value = student_list_array[i][0];
												add_result_user.add(createSelectOption);
											}
										} else {
											alert(classUsersHttpRequest.status);
										}
									}
									classUsersHttpRequest.send(classUsersHttpRequestBody);
								}
							}
						</script>
					<?php } ?>

				</center>
			</div>
		<?php } ?>
	<?php } ?>

	<?php if (strip_tags($_GET['tab']) == 'multiple_subject_marks') { ?>
		<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
			<center>
				<?php
				$view_session = array_filter(explode("_", trim(strip_tags($_GET['view']))))[0];
				$view_numeric_class_name = array_filter(explode("_", trim(strip_tags($_GET['view']))))[1];
				$view_term_id_number = array_filter(explode("_", trim(strip_tags($_GET['view']))))[2];
				$view_subject_code = array_filter(explode("_", trim(strip_tags($_GET['subjects']))));
				$view_numeric_class_category_name = trim(strip_tags($_GET['class_category']));

				?>
				<?php if (((isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) !== "")) || ((!isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) == "") && (isset($_GET['tab'])))) { ?>
					<form method="post" enctype="multipart/form-data">
						<div
							class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<select name="numeric-class" onchange="findClassSession();" id="find-result-class-session"
								class="form-select" required>
								<option selected disabled hidden value="">Select Class</option>
								<?php

								$select_class_list_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' " . $user_admission_id_statement_auth . " GROUP BY numeric_class_name");

								if (mysqli_num_rows($select_class_list_detail_using_id) > 0) {
									while ($class_list_details = mysqli_fetch_assoc($select_class_list_detail_using_id)) {
										$class_numeric_names .= "numeric_class_name='" . $class_list_details["numeric_class_name"] . "'" . "\n";
										$class_numeric_names_ids .= $class_list_details["numeric_class_name"] . "\n";
									}
								}

								$class_numeric_names_sqli_statements .= " && (" . str_replace("\n", " OR ", trim($class_numeric_names)) . ")";

								$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' " . $class_numeric_names_sqli_statements . " GROUP BY numeric_class_name");

								if (mysqli_num_rows($select_classes_detail_using_id) > 0) {
									while ($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)) {
										if ($classes_details["numeric_class_name"] == $view_numeric_class_name) {
											$selected = "selected";
											echo '<option value="' . $classes_details["numeric_class_name"] . '" ' . $selected . '>' . $classes_details["class_name"] . ' (' . $classes_details["numeric_class_name"] . ')</option>';
										} else {
											echo '<option value="' . $classes_details["numeric_class_name"] . '" >' . $classes_details["class_name"] . ' (' . $classes_details["numeric_class_name"] . ')</option>';
										}

									}
								}

								?>
							</select>
							<span class="form-span mobile-font-size-12 system-font-size-14">Select Class</span>
						</div>

						<div
							class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<select name="session" id="add-result-class-session" class="form-select" required>
								<option disabled hidden selected value="">Select Class Session</option>
								<?php
								if ((!empty($view_session))) {
									$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='$view_numeric_class_name'");

									if (mysqli_num_rows($select_sessions_detail_using_id) > 0) {
										while ($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)) {
											if ($sessions_details["session"] == $view_session) {
												$selected = "selected";
												echo '<option value="' . $sessions_details["session"] . '" ' . $selected . '>' . str_replace("-", "/", $sessions_details["session"]) . '</option>';
											} else {
												echo '<option value="' . $sessions_details["session"] . '" >' . str_replace("-", "/", $sessions_details["session"]) . '</option>';
											}

										}
									}
								}

								?>
							</select>
							<span class="form-span mobile-font-size-12 system-font-size-14">Class Session</span>
						</div>

						<div
							class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<select name="term" class="form-select" required>
								<option disabled hidden selected value="">Select Term</option>
								<?php
								$select_terms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "'");

								if (mysqli_num_rows($select_terms_detail_using_id) > 0) {
									while ($terms_details = mysqli_fetch_assoc($select_terms_detail_using_id)) {
										if ($terms_details["id_number"] == $view_term_id_number) {
											$selected = "selected";
											echo '<option value="' . $terms_details["id_number"] . '" ' . $selected . '>' . $terms_details["term_name"] . '</option>';
										} else {
											echo '<option value="' . $terms_details["id_number"] . '">' . $terms_details["term_name"] . '</option>';
										}

									}
								}

								?>
							</select>
							<span class="form-span mobile-font-size-12 system-font-size-14">Term</span>
						</div>

						<div
							class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<select name="subject-code[]" class="sel-subject-code" hidden multiple required>
								<option disabled hidden value="">Select Subject</option>
								<?php
								$select_results_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "'");

								if (mysqli_num_rows($select_results_detail_using_id) > 0) {
									while ($results_details = mysqli_fetch_assoc($select_results_detail_using_id)) {
										if (in_array($results_details["subject_code"], $view_subject_code)) {
											$selected = "selected";
											echo '<option value="' . $results_details["subject_code"] . '" ' . $selected . '>' . $results_details["subject_name"] . ' (' . $results_details["subject_code"] . ')</option>';
										} else {
											echo '<option value="' . $results_details["subject_code"] . '" >' . $results_details["subject_name"] . ' (' . $results_details["subject_code"] . ')</option>';
										}

									}
								}

								?>
							</select>
							<!-- <span class="form-span mobile-font-size-12 system-font-size-14">Subject Name*</span> -->
							<div class="form-div-container custom_form_div_select_sel-subject-code">
								<div class="form-div custom_select_sel-subject-code">
								</div>
								<script type="text/javascript">
									multipleOptionSelectTag("sel-subject-code");
								</script>
							</div>
						</div>

						<div
							class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<select name="class-category" class="form-select">
								<option selected disabled hidden value="">Select Class Category</option>
								<?php
								$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "'");

								if (mysqli_num_rows($select_classes_detail_using_id) > 0) {
									while ($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)) {
										if ($classes_details["numeric_class_category_name"] == $view_numeric_class_category_name) {
											$selected = "selected";
											echo '<option value="' . $classes_details["numeric_class_category_name"] . '" ' . $selected . '>' . $classes_details["class_category_name"] . '</option>';
										} else {
											echo '<option value="' . $classes_details["numeric_class_category_name"] . '" >' . $classes_details["class_category_name"] . '</option>';
										}

									}
								}

								?>
							</select>
							<span class="form-span mobile-font-size-12 system-font-size-14">Assign Class Category</span>
						</div>

						<input hidden id="result-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />

						<button name="manage-multiple-subject-marks" style="float: right; clear: right;" type="submit"
							class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-1 system-margin-left-3 mobile-margin-right-2 system-margin-right-1">
							MANAGE MULTIPLE MARKS
						</button>
					</form>

					<form method="post" enctype="multipart/form-data">
						<?php if (!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))) { ?>
							<div style="display: inline-block;"
								class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
								<?php echo $err_msg; ?>
							</div>
						<?php } ?>

						<?php

						foreach ($view_subject_code as $view_sub_code) {
							$view_subjects_code .= "subject_code='" . $view_sub_code . "' ";
						}
						$view_all_subjects_code = str_replace(" ", " OR ", trim(strip_tags($view_subjects_code)));

						if (isset($_GET['view']) && !empty(trim(strip_tags($_GET['view'])))) {
							$get_result_manage_marks = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='$view_numeric_class_name' && term_id_number='$view_term_id_number' && session='$view_session' && ($view_all_subjects_code) ORDER BY admission_number");
							$get_result_release_dates = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_result_release_dates WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='$view_numeric_class_name' && term_id_number='$view_term_id_number' && session='$view_session'"));

							if ((in_array($view_numeric_class_name, array_filter(explode("\n", trim($class_numeric_names_ids))))) || (isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]))) {
								if (mysqli_num_rows($get_result_manage_marks) >= 1) {
									$show_result_table = true;
								} else {
									$show_result_table = false;
								}
							} else {
								$show_result_table = false;
							}
						} else {
							$show_result_table = false;
						}
						?>

						<?php if ($show_result_table === true) { ?>
							<div style="float: left; clear: left;"
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
								<input type="file" id="manageMarkFile" accept="csv" class="form-file-chooser" />
								<span class="form-span mobile-font-size-12 system-font-size-14">Document Upload</span>
								<div style="float: left; clear: left; text-align: left;"
									class="form-group mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-16 text-bold-light mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-0 system-margin-bottom-0 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
									Required Columns: <br>
									<b>student_roll_no</b> - Student Admission Number,<br>
									<b>subject_code</b> - Subject Code e.g 001,<br>
									<b>ca_1</b> - 1st C.A,<br>
									<b>ca_2</b> - 2nd C.A,<br>
									<b>ca_3</b> - 3rd C.A,<br>
									<b>exam</b> - Examination</b><br>
									Note: Document must be CSV file
								</div>
							</div><br>

							<div class="scroll-box bg-2 mobile-width-96 system-width-96">
								<table class="table-tag mobile-font-size-12 system-font-size-14">
									<tr>
										<th>Roll No</th>
										<th>Name</th>
										<th>Subject Name</th>
										<th>1st C.A</th>
										<th>2nd C.A</th>
										<th>3rd C.A</th>
										<th>Exam</th>
										<!--<th>Comment</th>-->
									</tr>
									<?php
									function subjectName($subjects_info, $school_id)
									{
										global $connection_server;

										$get_subject_name = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='$school_id' && subject_code='$subjects_info'");
										if (mysqli_num_rows($get_subject_name) == 1) {
											while ($subject_name_array = mysqli_fetch_array($get_subject_name)) {
												$subject_name .= $subject_name_array["subject_name"] . " (" . $subject_name_array["subject_code"] . ")";
											}
										} else {
											$subject_name = "N/A";
										}

										return $subject_name;
									}

									if (mysqli_num_rows($get_result_manage_marks) > 0) {
										while (($result_manage_marks_details = mysqli_fetch_assoc($get_result_manage_marks))) {
											$search_student_with_admission_no = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE (school_id_number='" . $result_manage_marks_details["school_id_number"] . "' && admission_number='" . $result_manage_marks_details["admission_number"] . "')");
											if (mysqli_num_rows($search_student_with_admission_no) == 1) {
												$get_search_student_with_admission_no = mysqli_fetch_array($search_student_with_admission_no);
												if (!empty(trim(strip_tags($_GET['class_category'])))) {
													$checkmate_class_category = ($get_search_student_with_admission_no["numeric_class_category_name"] == trim(strip_tags($_GET['class_category'])));
												} else {
													$checkmate_class_category = "1 == 1";
												}
												if ($checkmate_class_category) {
													if ($result_manage_marks_details["admission_number"] % 2 == 1) {
														echo '<tr>
															<td style="background-color: var(--color-2) !important;">
																' . $result_manage_marks_details["admission_number"] . '
																<input hidden name="admission-number[]" value="' . $result_manage_marks_details["admission_number"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="" class="form-input" readonly required/>
															</td>
															<td style="background-color: var(--color-2) !important;">' . studentName($result_manage_marks_details["admission_number"], $result_manage_marks_details["school_id_number"]) . '</td>
															<td style="background-color: var(--color-2) !important;">
																' . subjectName($result_manage_marks_details["subject_code"], $result_manage_marks_details["school_id_number"]) . '
																<input hidden name="subject-code[]" value="' . $result_manage_marks_details["subject_code"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="" class="form-input" readonly required/>
															</td>
															<td style="background-color: var(--color-2) !important;">
																<div class="form-group mobile-width-90 system-width-40">
																	<input id="' . $result_manage_marks_details["admission_number"] . '-' . $result_manage_marks_details["subject_code"] . '-ca1" name="first-ca[]" value="' . $result_manage_marks_details["first_ca"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="1st CA" class="form-input" required/>
																</div>
															</td>
															<td style="background-color: var(--color-2) !important;">
																<div class="form-group mobile-width-90 system-width-40">
																	<input id="' . $result_manage_marks_details["admission_number"] . '-' . $result_manage_marks_details["subject_code"] . '-ca2" name="second-ca[]" value="' . $result_manage_marks_details["second_ca"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="2nd CA" class="form-input" />
																</div>
															</td>
															<td style="background-color: var(--color-2) !important;">
																<div class="form-group mobile-width-90 system-width-40">
																	<input id="' . $result_manage_marks_details["admission_number"] . '-' . $result_manage_marks_details["subject_code"] . '-ca3" name="third-ca[]" value="' . $result_manage_marks_details["third_ca"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="3rd CA (Optional)" class="form-input" />
																</div>
															</td>
															<td style="background-color: var(--color-2) !important;">
																<div class="form-group mobile-width-90 system-width-40">
																	<input id="' . $result_manage_marks_details["admission_number"] . '-' . $result_manage_marks_details["subject_code"] . '-exam" name="exam[]" value="' . $result_manage_marks_details["exam"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="Exam" class="form-input" />
																</div>
															</td>
															<!--<td style="background-color: var(--color-2) !important;">
																<div class="form-group mobile-width-20 system-width-40">
																	<input name="comment[]" value="' . $result_manage_marks_details["comment"] . '" type="text" placeholder="Comment" class="form-input" />
																</div>
															</td>-->
														</tr>';
													} else {
														echo '<tr>
															<td style="background-color: var(--color-8) !important;">
																' . $result_manage_marks_details["admission_number"] . '
																<input hidden name="admission-number[]" value="' . $result_manage_marks_details["admission_number"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="" class="form-input" readonly required/>
															</td>
															<td style="background-color: var(--color-8) !important;">' . studentName($result_manage_marks_details["admission_number"], $result_manage_marks_details["school_id_number"]) . '</td>
															<td style="background-color: var(--color-8) !important;">
																' . subjectName($result_manage_marks_details["subject_code"], $result_manage_marks_details["school_id_number"]) . '
																<input hidden name="subject-code[]" value="' . $result_manage_marks_details["subject_code"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="" class="form-input" readonly required/>
															</td>
															<td style="background-color: var(--color-8) !important;">
																<div class="form-group mobile-width-90 system-width-40">
																	<input id="' . $result_manage_marks_details["admission_number"] . '-' . $result_manage_marks_details["subject_code"] . '-ca1" name="first-ca[]" value="' . $result_manage_marks_details["first_ca"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="1st CA" class="form-input" required/>
																</div>
															</td>
															<td style="background-color: var(--color-8) !important;">
																<div class="form-group mobile-width-90 system-width-40">
																	<input id="' . $result_manage_marks_details["admission_number"] . '-' . $result_manage_marks_details["subject_code"] . '-ca2" name="second-ca[]" value="' . $result_manage_marks_details["second_ca"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="2nd CA" class="form-input" />
																</div>
															</td>
															<td style="background-color: var(--color-8) !important;">
																<div class="form-group mobile-width-90 system-width-40">
																	<input id="' . $result_manage_marks_details["admission_number"] . '-' . $result_manage_marks_details["subject_code"] . '-ca3" name="third-ca[]" value="' . $result_manage_marks_details["third_ca"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="3rd CA (Optional)" class="form-input" />
																</div>
															</td>
															<td style="background-color: var(--color-8) !important;">
																<div class="form-group mobile-width-90 system-width-40">
																	<input id="' . $result_manage_marks_details["admission_number"] . '-' . $result_manage_marks_details["subject_code"] . '-exam" name="exam[]" value="' . $result_manage_marks_details["exam"] . '" type="text" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="Exam" class="form-input" />
																</div>
															</td>
															<!--<td style="background-color: var(--color-8) !important;">
																<div class="form-group mobile-width-90 system-width-40">
																	<input name="comment[]" value="' . $result_manage_marks_details["comment"] . '" type="text" placeholder="Comment" class="form-input" />
																</div>
															</td>-->
														</tr>';
													}
												}
											}
										}
									}
									?>
								</table>
							</div>
							<div style="float: left; clear: left;"
								class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
								<input name="release_date" type="date" value="<?php if (isset($get_result_release_dates['release_date']) && !empty($get_result_release_dates['release_date'])) {
									echo $get_result_release_dates['release_date'];
								} else {
									echo date('Y-m-d');
								} ?>" class="form-input" required />
								<span class="form-span mobile-font-size-12 system-font-size-14">Result Release Date*</span>
							</div>
							<button name="save-multiple-subject-marks" style="float: left; clear: left;" type="submit"
								class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
								SAVE
							</button>
						<?php } ?>
						<script>
							var manageMarkFile = document.getElementById("manageMarkFile");

							manageMarkFile.addEventListener("change",
								function () {
									readMarks = new FileReader();
									readMarks.onload = function () {
										var csvMarksText = readMarks.result;
										csvMarksText = csvMarksText.trim().split("\n");
										var csvHeaders = csvMarksText[0].trim().replaceAll(" ", "").split(",");
										var studentArrIndex = csvHeaders.indexOf("student_roll_no");
										var subjectCodeArrIndex = csvHeaders.indexOf("subject_code");
										var ca1ArrIndex = csvHeaders.indexOf("ca_1");
										var ca2ArrIndex = csvHeaders.indexOf("ca_2");
										var ca3ArrIndex = csvHeaders.indexOf("ca_3");
										var examArrIndex = csvHeaders.indexOf("exam");

										for (x = 0; x < csvMarksText.length; x++) {
											if (x !== 0) {
												if (csvMarksText[x].trim().length > 0) {
													var eachLineDetails = csvMarksText[x].split(",");
													var studentRollNumber = eachLineDetails[studentArrIndex].replaceAll('"', "").replaceAll("'", "");
													var subjectCode = eachLineDetails[subjectCodeArrIndex].replaceAll('"', "").replaceAll("'", "").trim();
													var studentCA1Marks = eachLineDetails[ca1ArrIndex].replaceAll('"', "").replaceAll("'", "");
													var studentCA2Marks = eachLineDetails[ca2ArrIndex].replaceAll('"', "").replaceAll("'", "");
													var studentCA3Marks = eachLineDetails[ca3ArrIndex].replaceAll('"', "").replaceAll("'", "");
													var examMarks = eachLineDetails[examArrIndex].replaceAll('"', "").replaceAll("'", "");

													if ((typeof (document.getElementById(studentRollNumber + "-" + subjectCode + "-ca1")) != "undefined") && (document.getElementById(studentRollNumber + "-" + subjectCode + "-ca1") != "null")) {
														document.getElementById(studentRollNumber + "-" + subjectCode + "-ca1").value = studentCA1Marks;
														document.getElementById(studentRollNumber + "-" + subjectCode + "-ca2").value = studentCA2Marks;
														document.getElementById(studentRollNumber + "-" + subjectCode + "-ca3").value = studentCA3Marks;
														document.getElementById(studentRollNumber + "-" + subjectCode + "-exam").value = examMarks;
													}
												}
											}
										}
									}
									readMarks.readAsText(this.files[0]);
								});

						</script>
					</form>
					<script>
						function findClassSession() {
							const find_result_class_session = document.getElementById("find-result-class-session");
							const add_result_class_session = document.getElementById("add-result-class-session");
							const result_school_id_number = document.getElementById("result-school-id");

							add_result_class_session.innerHTML = "";
							const createSelectSessionOption = document.createElement("option");
							createSelectSessionOption.hidden = true;
							createSelectSessionOption.disabled = true;
							createSelectSessionOption.selected = true;
							createSelectSessionOption.text = "Select Class Session";
							createSelectSessionOption.value = "";
							add_result_class_session.add(createSelectSessionOption);

							const classSessionHttpRequest = new XMLHttpRequest();
							classSessionHttpRequest.open("POST", "./get-class-session.php");
							classSessionHttpRequest.setRequestHeader("Content-Type", "application/json");
							const classSessionHttpRequestBody = JSON.stringify({ sch_no: result_school_id_number.value, class_id_no: find_result_class_session.value });
							classSessionHttpRequest.onload = function () {
								if ((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)) {

									const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];

									for (i = 0; i < session_list_array.length; i++) {
										const createSelectOption = document.createElement("option");
										createSelectOption.text = session_list_array[i].replace("-", "/");
										createSelectOption.value = session_list_array[i];
										add_result_class_session.add(createSelectOption);
									}
								} else {
									alert(classSessionHttpRequest.status);
								}
							}
							classSessionHttpRequest.send(classSessionHttpRequestBody);

						}

						function findClassUsers() {
							const add_result_user = document.getElementById("add-result-user");
							const result_school_id_number = document.getElementById("result-school-id");
							const result_class = document.getElementById("find-result-class-session");
							const result_session = document.getElementById("add-result-class-session");
							if ((result_class.value.trim() != "") && (result_session.value.trim() != "")) {
								add_result_user.innerHTML = "";
								const createSelectUsersOption = document.createElement("option");
								createSelectUsersOption.selected = true;
								createSelectUsersOption.text = "All";
								createSelectUsersOption.value = "all";
								add_result_user.add(createSelectUsersOption);

								const classUsersHttpRequest = new XMLHttpRequest();
								classUsersHttpRequest.open("POST", "./get-student.php");
								classUsersHttpRequest.setRequestHeader("Content-Type", "application/json");
								const classUsersHttpRequestBody = JSON.stringify({ sch_no: result_school_id_number.value, class_id_no: result_class.value, session: result_session.value });
								classUsersHttpRequest.onload = function () {
									if ((classUsersHttpRequest.readyState == 4) && (classUsersHttpRequest.status == 200)) {
										const student_list_array = Object.entries(JSON.parse(classUsersHttpRequest.responseText)["response"]);

										for (i = 0; i < student_list_array.length; i++) {
											const createSelectOption = document.createElement("option");
											createSelectOption.text = student_list_array[i][1];
											createSelectOption.value = student_list_array[i][0];
											add_result_user.add(createSelectOption);
										}
									} else {
										alert(classUsersHttpRequest.status);
									}
								}
								classUsersHttpRequest.send(classUsersHttpRequestBody);
							}
						}
					</script>
				<?php } ?>

			</center>
		</div>
	<?php } ?>
<?php } ?>