<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$search_cbt_activated_schools = mysqli_query($connection_server, "SELECT * FROM sm_cbt_activated_schools WHERE school_id_number='" . $get_logged_user_details['school_id_number'] . "'");
if (mysqli_num_rows($search_cbt_activated_schools) == 1) {
	include("include/func/cbtest.php");
?>
<div style=""
    class="container-box bg-2  border-style-bottom-1 border-color-5 border-width-1 mobile-width-92 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-5 system-margin-left-2">
    <?php
		$page = strip_tags($_GET['page'] ?? '');
		$tab = strip_tags($_GET['tab'] ?? '');
		if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
			?>
    <a style="text-decoration: none;"
        href="/bc-admin.php?page=<?php echo $page; ?>&tab=scheldule_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
        <button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if ($tab == 'scheldule_list') {
						echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 ';
					} else {
						echo 'color-5 border-style-bottom-1 border-color-3 border-width-2';
					} ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
            SCHELDULE LIST
        </button>
    </a>
    <a style="text-decoration: none;"
        href="/bc-admin.php?page=<?php echo $page; ?>&tab=past_questions_teacher&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
        <button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if ($tab == 'past_questions_teacher') {
						echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 ';
					} else {
						echo 'color-5 border-style-bottom-1 border-color-3 border-width-2';
					} ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
            PAST QUESTIONS
        </button>
    </a>
    <?php } ?>

    <?php
		if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
			?>
    <?php if (in_array($tab, array("scheldule_list", "add_cbt"))) { ?>
    <a style="text-decoration: none;"
        href="/bc-admin.php?page=<?php echo $page; ?>&tab=add_cbt&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
        <button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if ($tab == 'add_cbt') {
							echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 ';
						} else {
							echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 ';
						} ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
            ADD CBT
        </button>
    </a>
    <?php } ?>

    <?php if (in_array($tab, array("add_cbt_quiz"))) { ?>
    <a style="text-decoration: none;"
        href="/bc-admin.php?page=<?php echo $page; ?>&tab=add_cbt_quiz&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
        <button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if ($tab == 'add_cbt_quiz') {
							echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 ';
						} else {
							echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 ';
						} ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
            SET CBT QUESTIONS
        </button>
    </a>
    <?php } ?>

    <?php if (in_array($tab, array("view_cbt"))) { ?>
    <a style="text-decoration: none;"
        href="/bc-admin.php?page=<?php echo $page; ?>&tab=view_cbt&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
        <button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if ($tab == 'view_cbt') {
							echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 ';
						} else {
							echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 ';
						} ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
            VIEW SUBMITTED STUDENT
        </button>
    </a>
    <?php } ?>

    <?php } ?>

    <?php
		if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id == "stu")) {
			?>
    <a style="text-decoration: none;"
        href="/bc-admin.php?page=<?php echo $page; ?>&tab=cbt_tests&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
        <button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if ($tab == 'cbt_tests') {
						echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 ';
					} else {
						echo 'color-5 border-style-bottom-1 border-color-3 border-width-2';
					} ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
            CBT TESTS
        </button>
    </a>

    <?php } ?>
</div>

<?php
	if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
		?>
<?php if ($tab == 'scheldule_list') { ?>
<?php
			$id = trim(strip_tags($_GET['id'] ?? ''));
			if (mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE school_id_number='$id' " . $user_class_statement_auth)) > 0) {
				$count_cbt_test_list_listed = mysqli_num_rows($select_all_cbt_test_table_lists);
				?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <div style="text-align: left;" class="scroll-box bg-2 mobile-width-96 system-width-96">
            <?php
							if ($user_identifier_auth_id == "mod_adm" || $user_identifier_auth_id == "adm_staff" || $user_identifier_auth_id == "teacher") {
								?>
            <!-- Filter Form -->
            <?php
								// Get current filter values from URL if they exist
								$current_session = $_GET['session'] ?? '';
								$current_term = $_GET['term'] ?? '';
								?>
            <form method="get"
                style="border: 1px solid #ccc; padding: 10px; border-radius: 5px; display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin: 15px; margin-top: 10px; margin-bottom: 20px;">
                <input type="hidden" name="page" value="<?php echo $page; ?>">
                <input type="hidden" name="tab" value="scheldule_list">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-group-borderless" style="margin: 0;">
                    <label for="session-filter" style="font-weight: bold; margin-right: 5px;">Session:</label>
                    <select name="session" id="session-filter" class="form-select">
                        <option value="">All Sessions</option>
                        <?php
											$sessions_query = mysqli_query($connection_server, "SELECT DISTINCT session FROM sm_classes WHERE school_id_number='$id' ORDER BY session DESC");
											if (mysqli_num_rows($sessions_query) > 0) {
												while ($session_row = mysqli_fetch_assoc($sessions_query)) {
													$session_val = $session_row['session'];
													$selected = ($session_val == $current_session) ? 'selected' : '';
													echo '<option value="' . $session_val . '" ' . $selected . '>' . str_replace("-", "/", $session_val) . '</option>';
												}
											}
											?>
                    </select>
                </div>

                <div class="form-group-borderless" style="margin: 0;">
                    <label for="term-filter" style="font-weight: bold; margin-right: 5px;">Term:</label>
                    <select name="term" id="term-filter" class="form-select">
                        <option value="">All Terms</option>
                        <?php
											$terms_query = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='$id'");
											if (mysqli_num_rows($terms_query) > 0) {
												mysqli_data_seek($terms_query, 0); // Reset pointer
												while ($term_row = mysqli_fetch_assoc($terms_query)) {
													$term_id = $term_row['id_number'];
													$term_name = $term_row['term_name'];
													$selected = ($term_id == $current_term) ? 'selected' : '';
													echo '<option value="' . $term_id . '" ' . $selected . '>' . $term_name . '</option>';
												}
											}
											?>
                    </select>
                </div>

                <button type="submit" class="button-box color-2 bg-4"
                    style="height: 38px; line-height: 2.2; margin-top: 20px;">Filter</button>
            </form>

            <form method="post">
                <div
                    class="form-group-borderless mobile-width-20 system-width-7 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select onchange="pageListNumber();" id="page_list_number" class="form-select">
                        <option <?php if ((isset($_GET["pnum"]) ? trim(strip_tags($_GET["pnum"])) : '') == 10) {
												echo "selected";
											} ?> value="10">10
                        </option>
                        <option <?php if ((isset($_GET["pnum"]) ? trim(strip_tags($_GET["pnum"])) : '') == 25) {
												echo "selected";
											} ?> value="25">25
                        </option>
                        <option <?php if ((isset($_GET["pnum"]) ? trim(strip_tags($_GET["pnum"])) : '') == 50) {
												echo "selected";
											} ?> value="50">50
                        </option>
                        <option <?php if ((isset($_GET["pnum"]) ? trim(strip_tags($_GET["pnum"])) : '') == 100) {
												echo "selected";
											} ?> value="100">100
                        </option>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14"></span>
                </div>
                <span class="color-7 mobile-font-size-16 system-font-size-18">Showing
                    <?php echo ((($page_pnum * $current_page_no) - $page_pnum) + 1); ?> to
                    <?php echo ($page_pnum * $current_page_no); ?> of
                    <?php echo $count_cbt_test_list_listed; ?>
                    entries</span>

                <div
                    class="form-group-borderless mobile-width-85 system-width-50 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-14 mobile-margin-right-2 system-margin-right-1">
                    <input name="search-item" value="<?php echo $search_text; ?>" type="text" placeholder="Search... "
                        class="form-input" />
                    <span class="form-span mobile-font-size-12 system-font-size-14"></span>
                </div>
            </form>
            <?php } ?>
            <form method="post" enctype="multipart/form-data">
                <table
                    class="table-tag-borderless mobile-font-size-12 system-font-size-14 mobile-margin-left-3 system-margin-left-2">
                    <tr>
                        <?php
										if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
											?>
                        <td>Tick</td>
                        <?php } ?>
                        <td class="mobile-width-10 system-width-10">Homework</td>
                        <td>Paper Title</td>
                        <td>Type</td>
                        <td>Class</td>
                        <td>Session</td>
                        <td>Subject</td>
                        <td>Term</td>
                        <td>Details</td>
                        <td>No. Submitted</td>
                        <?php
										if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") || ($user_identifier_auth_id == "stu")) {
											?>
                        <td style="width:10%;">Action</td>
                        <?php } ?>
                    </tr>
                    <?php
									// Helper functions are now defined globally at the top of the file.
									if (mysqli_num_rows($select_all_cbt_test_table_lists) > 0) {
										while (($homework_list_details = mysqli_fetch_assoc($select_all_cbt_test_table_lists))) {
											$homework_list_view_link = str_replace('tab=' . $tab, 'tab=view_cbt', $_SERVER['REQUEST_URI']) . "&view=" . $homework_list_details["cbt_id"];
											$homework_list_add_link = str_replace('tab=' . $tab, 'tab=add_cbt_quiz', $_SERVER['REQUEST_URI']) . "&edit=" . $homework_list_details["cbt_id"];
											$homework_list_edit_link = str_replace('tab=' . $tab, 'tab=add_cbt', $_SERVER['REQUEST_URI']) . "&edit=" . $homework_list_details["cbt_id"];
											$homework_list_submit_link = str_replace('tab=' . $tab, 'tab=sub_homework', $_SERVER['REQUEST_URI']) . "&homework_id=" . (isset($homework_list_details["homework_id"]) ? $homework_list_details["homework_id"] : $homework_list_details["cbt_id"]);

											$submitted_cbt_counter = 0;
											$registered_students = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE (school_id_number='" . $homework_list_details["school_id_number"] . "' && numeric_class_name='" . $homework_list_details["numeric_class_name"] . "' && session='" . $homework_list_details["session"] . "')");
											if (mysqli_num_rows($registered_students) > 0) {
												$count_registered_students = mysqli_num_rows($registered_students);
												while ($each_student_detail = mysqli_fetch_assoc($registered_students)) {
													$check_submitted_student = mysqli_query($connection_server, "SELECT * FROM sm_submitted_cbt_lists WHERE (school_id_number='" . $homework_list_details["school_id_number"] . "' && cbt_id_number='" . $homework_list_details["cbt_id"] . "' && admission_number='" . $each_student_detail["admission_number"] . "')");
													if (mysqli_num_rows($check_submitted_student) == 1) {
														$submitted_cbt_counter += 1;
													}
												}
											} else {
												$count_registered_students = "N/A";
											}

											$dcheck_button = '';
											$action_button = '';
											if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
												$dcheck_button = '<td>
														<input type="checkbox" name="cbt_id[]" value="' . $homework_list_details["cbt_id"] . '" class="homeworkListChecked" />
														<input hidden type="text" name="school_id[]" value="' . $homework_list_details["school_id_number"] . '" />
													</td>';
												$cbt_list_clone_link = str_replace('tab=' . $tab, 'tab=clone_cbt', $_SERVER['REQUEST_URI']) . '&clone_id=' . $homework_list_details["cbt_id"];
												$action_button = '<td>
														<img onclick="return popUpAlert([`' . $homework_list_view_link . '`,`' . $homework_list_add_link . '`,`' . $homework_list_edit_link . '`,`' . $cbt_list_clone_link . '`],[`View Submitted Students`,`Edit Questions`,`Edit CBT`,`Clone CBT`]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
											}

											if ($user_identifier_auth_id == "stu") {
												$action_button = '<td>
														<img onclick="return popUpAlert([``,``,``,``],[``,``,``,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
											}
											echo '<tr>
									' . $dcheck_button . '
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/white/Payment.png" class="mobile-width-60 system-width-30" /></td>
									<td>' . $homework_list_details["paper_title"] . '</td>
                                    <td>' . cbtType($homework_list_details["cbt_type"]) . '</td>
									<td>' . homeworkClassName($homework_list_details["numeric_class_name"], $homework_list_details["session"], $homework_list_details["school_id_number"]) . '</td>
									<td>' . str_replace("-", "/", $homework_list_details["session"]) . '</td>
								<td>' . homeworkSubjectName($homework_list_details["subject_code"], $homework_list_details["school_id_number"]) . '</td>
								<td>' . termName($homework_list_details["term_id_number"], $homework_list_details["school_id_number"]) . '</td>
                                    <td onclick="return popUpSectionAlert(`html`,`CBT INFORMATION`,[`Class Name:' . homeworkClassName($homework_list_details["numeric_class_name"], $homework_list_details["session"], $homework_list_details["school_id_number"]) . '`,`Session:' . str_replace("-", "/", $homework_list_details["session"]) . '`,`No. of Questions:' . $homework_list_details["exam_questions"] . '`,`Exam Duration:' . $homework_list_details["exam_duration"] . '`,`Exam Date:' . str_replace("-", "/", $homework_list_details["exam_date"]) . '`,`Exam Time:' . timeFrame($homework_list_details["exam_time"]) . '`]);"><a style="color: inherit; cursor: pointer;" href="#">SHOW</a></td>
                                    <td>' . $submitted_cbt_counter . ' of ' . $count_registered_students . '</td>
								' . $action_button . '
									</tr>';
										}
									}
									?>
                </table>

                <div style="float: right;" class="container-box bg-3 mobile-width-100 system-width-22">
                    <a style="text-decoration: none;"
                        href="<?php echo $page_prevnext_link . '&prevnext=' . $prev_btn; ?>">
                        <button type="button"
                            class="button-box color-7 bg-6 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-5 mobile-padding-right-5 system-padding-right-5 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
                            Previous
                        </button>
                    </a>
                    <button type="button"
                        class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-8 mobile-padding-right-5 system-padding-right-8 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
                        <?php echo $current_page_no; ?>
                    </button>
                    <a style="text-decoration: none;"
                        href="<?php echo $page_prevnext_link . '&prevnext=' . $next_btn; ?>">
                        <button type="button"
                            class="button-box color-7 bg-6 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-5 mobile-padding-right-5 system-padding-right-5 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
                            Next
                        </button>
                    </a>
                </div>
                <?php
								if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
									?>
                <button type="button" onclick="checkALL();"
                    class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
                    <input type="checkbox" onclick="checkALL();" class="checkALL" value="2" />
                    SELECT ALL
                </button>
                <a style="cursor: pointer;" onclick="deleteItems();">
                    <img src="imgfile/Delete.png"
                        style="position: relative; height: 2.6rem; margin: 0 0 -14px 0; pointer-events: none;"
                        class="mobile-width-12 system-width-5" />
                </a>
                <button name="delete-cbt" type="submit" id="delhomeworkPaymentList" style="display: none;"
                    class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
                    Delete CBT List
                </button><br>
                <?php } ?>
            </form>
        </div>
    </center>

    <script>
    function pageListNumber() {
        var pageListNo = document.getElementById("page_list_number");
        if ((pageListNo.value > 0) && (pageListNo.value != "")) {
            window.location.href = '<?php echo $page_list_number_link; ?>' + pageListNo.value;
        }
    }

    function checkALL() {
        var allBoxToChecked = document.getElementsByClassName("homeworkListChecked");
        if (document.getElementsByClassName("homeworkListChecked")[0].checked != true) {
            for (i = 0; i < allBoxToChecked.length; i++) {
                if (document.getElementsByClassName("checkALL")[0].checked != true) {
                    document.getElementsByClassName("checkALL")[0].checked = "checked";
                }
                document.getElementsByClassName("homeworkListChecked")[i].checked = "checked";
            }
        } else {
            for (i = 0; i < allBoxToChecked.length; i++) {
                if (document.getElementsByClassName("checkALL")[0].checked == true) {
                    document.getElementsByClassName("checkALL")[0].checked = false;
                }
                document.getElementsByClassName("homeworkListChecked")[i].checked = false;
            }
        }
    }

    function deleteItems() {
        var allBoxToChecked = document.getElementsByClassName("homeworkListChecked");
        checkBoxCount = 0;
        for (i = 0; i < allBoxToChecked.length; i++) {
            if ((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)) {
                checkBoxCount++;
            }
        }
        if (checkBoxCount == 1) {
            if (confirm("Are you sure you want to delete this Record?")) {
                document.getElementById("delhomeworkPaymentList").click();
            } else {
                alert("Operation Cancelled");
            }
        } else {
            if (checkBoxCount > 1) {
                //alert("You cannot pick more than one Record");
                if (confirm("Are you sure you want to delete this Record?")) {
                    document.getElementById("delhomeworkPaymentList").click();
                } else {
                    alert("Operation Cancelled");
                }
            } else {
                alert("Pick atleast one Record");
            }
        }

    }
    </script>
</div>
<?php } else {
				include("include/no-data-img.php");
			} ?>

<?php } ?>

<?php if ($tab == 'past_questions_teacher') { ?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <?php
        // Build the query for past questions with filters
        $query_parts = array();
        $query_parts[] = "school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "'";

        // Add class filter if provided
        if (isset($_GET['class']) && !empty($_GET['class'])) {
            $class_filter = mysqli_real_escape_string($connection_server, $_GET['class']);
            $query_parts[] = "numeric_class_name='$class_filter'";
        }

        // Add subject filter if provided
        if (isset($_GET['subject']) && !empty($_GET['subject'])) {
            $subject_filter = mysqli_real_escape_string($connection_server, $_GET['subject']);
            $query_parts[] = "subject_code='$subject_filter'";
        }

        // Add session filter if provided
        if (isset($_GET['session']) && !empty($_GET['session'])) {
            $session_filter = mysqli_real_escape_string($connection_server, $_GET['session']);
            $query_parts[] = "session='$session_filter'";
        }

        // Add term filter if provided
        if (isset($_GET['term']) && !empty($_GET['term'])) {
            $term_filter = mysqli_real_escape_string($connection_server, $_GET['term']);
            $query_parts[] = "term_id_number='$term_filter'";
        }

        $query_string = "SELECT * FROM sm_cbt_scheldule_lists WHERE " . implode(' AND ', $query_parts) . " ORDER BY exam_date DESC";
        $past_cbt_query = mysqli_query($connection_server, $query_string);
        ?>
        <div style="text-align: left;" class="scroll-box bg-2 mobile-width-96 system-width-96">
            <!-- Filter Form -->
            <?php
            // Get current filter values from URL if they exist
            $current_class = $_GET['class'] ?? '';
            $current_subject = $_GET['subject'] ?? '';
            $current_session = $_GET['session'] ?? '';
            $current_term = $_GET['term'] ?? '';
            ?>
            <form method="get"
                style="border: 1px solid #ccc; padding: 10px; border-radius: 5px; display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin: 15px; margin-top: 10px; margin-bottom: 20px;">
                <input type="hidden" name="page" value="<?php echo $page; ?>">
                <input type="hidden" name="tab" value="past_questions_teacher">
                <input type="hidden" name="id" value="<?php echo trim(strip_tags($_GET['id'] ?? '')); ?>">

                <div class="form-group-borderless" style="margin: 0;">
                    <label for="class-filter" style="font-weight: bold; margin-right: 5px;">Class:</label>
                    <select name="class" id="class-filter" class="form-select">
                        <option value="">All Classes</option>
                        <?php
                        $classes_query = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "' GROUP BY numeric_class_name ORDER BY class_name ASC");
                        if (mysqli_num_rows($classes_query) > 0) {
                            while ($class_row = mysqli_fetch_assoc($classes_query)) {
                                $class_id = $class_row['numeric_class_name'];
                                $class_name = $class_row['class_name'];
                                $selected = ($class_id == $current_class) ? 'selected' : '';
                                echo '<option value="' . $class_id . '" ' . $selected . '>' . $class_name . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group-borderless" style="margin: 0;">
                    <label for="subject-filter" style="font-weight: bold; margin-right: 5px;">Subject:</label>
                    <select name="subject" id="subject-filter" class="form-select">
                        <option value="">All Subjects</option>
                        <?php
                        $subjects_query = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "' GROUP BY subject_code ORDER BY subject_name ASC");
                        if (mysqli_num_rows($subjects_query) > 0) {
                            while ($subject_row = mysqli_fetch_assoc($subjects_query)) {
                                $subject_code = $subject_row['subject_code'];
                                $subject_name = $subject_row['subject_name'];
                                $selected = ($subject_code == $current_subject) ? 'selected' : '';
                                echo '<option value="' . $subject_code . '" ' . $selected . '>' . $subject_name . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group-borderless" style="margin: 0;">
                    <label for="session-filter" style="font-weight: bold; margin-right: 5px;">Session:</label>
                    <select name="session" id="session-filter" class="form-select">
                        <option value="">All Sessions</option>
                        <?php
                        // Query all distinct sessions for the student's class
                        $sessions_query = mysqli_query($connection_server, "SELECT DISTINCT session FROM sm_cbt_scheldule_lists WHERE school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "' ORDER BY session DESC");
                        if (mysqli_num_rows($sessions_query) > 0) {
                            while ($session_row = mysqli_fetch_assoc($sessions_query)) {
                                $session_val = $session_row['session'];
                                $selected = ($session_val == $current_session) ? 'selected' : '';
                                echo '<option value="' . $session_val . '" ' . $selected . '>' . str_replace("-", "/", $session_val) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group-borderless" style="margin: 0;">
                    <label for="term-filter" style="font-weight: bold; margin-right: 5px;">Term:</label>
                    <select name="term" id="term-filter" class="form-select">
                        <option value="">All Terms</option>
                        <?php
                        $terms_query = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "'");
                        if (mysqli_num_rows($terms_query) > 0) {
                            mysqli_data_seek($terms_query, 0); // Reset pointer
                            while ($term_row = mysqli_fetch_assoc($terms_query)) {
                                $term_id = $term_row['id_number'];
                                $term_name = $term_row['term_name'];
                                $selected = ($term_id == $current_term) ? 'selected' : '';
                                echo '<option value="' . $term_id . '" ' . $selected . '>' . $term_name . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="button-box color-2 bg-4"
                    style="height: 38px; line-height: 2.2; margin-top: 20px;">Filter</button>
            </form>
            <?php
            if (mysqli_num_rows($past_cbt_query) > 0) {
                $past_exams_found = false;
            ?>
            <table class="table-tag-borderless mobile-font-size-12 system-font-size-14 mobile-margin-left-3 system-margin-left-2">
                <thead>
                    <tr>
                        <td>Paper Title</td>
                        <td>Type</td>
                        <td>Class</td>
                        <td>Session</td>
                        <td>Subject</td>
                        <td>Term</td>
                        <td style="width:10%;">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while (($cbt_list_details = mysqli_fetch_assoc($past_cbt_query))) {
                        // Calculate exam end time
                        $exam_start_timestamp = strtotime($cbt_list_details["exam_date"] . ' ' . $cbt_list_details["exam_time"]);
                        list($hours, $minutes) = explode(':', $cbt_list_details["exam_duration"]);
                        $duration_in_seconds = ($hours * 3600) + ($minutes * 60);
                        $exam_end_timestamp = $exam_start_timestamp + $duration_in_seconds;
                        $current_timestamp = time();

                        // Show if exam end time is in the past and it has questions
                        if ($exam_end_timestamp < $current_timestamp && !empty($cbt_list_details['exam_json'])) {
                            $past_exams_found = true;
                            $view_questions_link = "/bc-admin.php?page=" . $page . "&tab=view_past_paper_teacher&id=" . trim(strip_tags($_GET['id'] ?? '')) . "&cbt_id=" . $cbt_list_details["cbt_id"];

                            echo '<tr>
                                    <td>' . htmlspecialchars($cbt_list_details["paper_title"]) . '</td>
                                    <td>' . cbtType($cbt_list_details["cbt_type"]) . '</td>
                                    <td>' . homeworkClassName($cbt_list_details["numeric_class_name"], $cbt_list_details["session"], $cbt_list_details["school_id_number"]) . '</td>
                                    <td>' . str_replace("-", "/", $cbt_list_details["session"]) . '</td>
                                    <td>' . homeworkSubjectName($cbt_list_details["subject_code"], $cbt_list_details["school_id_number"]) . '</td>
                                    <td>' . termName($cbt_list_details["term_id_number"], $cbt_list_details["school_id_number"]) . '</td>
                                    <td><a href="' . $view_questions_link . '" class="button-box-2 bg-4 color-2" style="text-decoration: none; padding: 5px 10px;">View</a></td>
                                </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php
                if (!$past_exams_found) {
                    include("include/no-data-img.php");
                }
            } else {
                include("include/no-data-img.php");
            }
            ?>
        </div>
    </center>
</div>
<?php } ?>

<?php if ($tab == 'view_past_paper_teacher') { ?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <?php
        $cbt_id = trim(strip_tags($_GET['cbt_id'] ?? ''));
        $cbt_query = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE cbt_id='$cbt_id' AND school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "'");

        if (mysqli_num_rows($cbt_query) == 1) {
            $cbt = mysqli_fetch_assoc($cbt_query);
            $exam_json = json_decode($cbt['exam_json'], true);
            ?>
            <div style="text-align: left; padding: 15px;">
                <a href="javascript:history.back()" class="button-box-2 bg-5 color-2"
                    style="text-decoration: none; padding: 5px 10px; margin-bottom: 15px; display: inline-block;">&laquo;
                    Back to List</a>
                <h3><?php echo htmlspecialchars($cbt['paper_title']); ?></h3>
                <h4>Subject: <?php echo homeworkSubjectName($cbt["subject_code"], $cbt["school_id_number"]); ?>
                </h4>
                <hr>
                <?php
                $exam_json_string = $cbt['exam_json'];
                if (empty($exam_json_string)) {
                    echo "<p style='color: red; font-weight: bold;'>Error: This past paper does not contain any question data.</p>";
                } else {
                    $exam_json = json_decode($exam_json_string, true);
                    if ($exam_json === null) {
                        echo "<p style='color: red; font-weight: bold;'>Error: The exam data for this past paper appears to be corrupted or in an invalid format. Please contact an administrator. (JSON Error: " . json_last_error_msg() . ")</p>";
                    } elseif (!isset($exam_json['quiz']) || !is_array($exam_json['quiz']) || empty($exam_json['quiz'])) {
                        echo "<p>No questions found for this CBT.</p>";
                    } else {
                        foreach ($exam_json['quiz'] as $index => $quiz_item) {
                            $question = base64_decode($quiz_item['question']);
                            $correct_answer = base64_decode($quiz_item['answers']['correct']);
                            $wrong_answers = array_map('base64_decode', $quiz_item['answers']['wrong']);
                            $all_options = $wrong_answers;
                            array_push($all_options, $correct_answer);
                            shuffle($all_options);
                            ?>
                            <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #eee; border-radius: 5px;">
                                <div style="display: flex; align-items: baseline;">
                                    <strong style="margin-right: 5px;">Question <?php echo $index + 1; ?>:</strong>
                                    <div><?php echo $question; ?></div>
                                </div>
                                <ul style="list-style-type: none; padding-left: 15px; margin-top: 10px;">
                                    <?php foreach ($all_options as $option) {
                                        $is_correct = ($option == $correct_answer);
                                        $style = $is_correct ? 'color: green; font-weight: bold;' : '';
                                        $indicator = $is_correct ? ' &check;' : '';
                                        ?>
                                        <li style="<?php echo $style; ?>">
                                            <?php echo $option . $indicator; ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
            <?php
        } else {
            echo "<p>Past paper not found.</p>";
        }
        ?>
    </center>
</div>
<?php } ?>

<?php } ?>

<?php
	if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
		?>
<?php if ($tab == 'view_cbt') { ?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <form method="post" enctype="multipart/form-data">
            <input type="number" id="reschedule-id" name="reschedule-id" hidden readonly required />
            <button type="submit" id="reschedule-btn" name="reschedule-btn" hidden>Reschedule CBT</button>
            <?php
						$edit_homework_id = trim(strip_tags($_GET['view'] ?? ''));

						$checkmate_scheldule_list = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "' && cbt_id='" . $edit_homework_id . "'");
						if (mysqli_num_rows($checkmate_scheldule_list) == 1) {
							$fetch_cbt_details = mysqli_fetch_array($checkmate_scheldule_list);

							$get_all_students_in_class = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='" . $fetch_cbt_details["school_id_number"] . "' && numeric_class_name='" . $fetch_cbt_details["numeric_class_name"] . "' && session='" . $fetch_cbt_details["session"] . "'");
							if (mysqli_num_rows($get_all_students_in_class) > 0) {
								$number_of_verified_student_listed = 0;
								while ($add_student_to_result_database = mysqli_fetch_array($get_all_students_in_class)) {
									$check_student_detail = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='" . $fetch_cbt_details["school_id_number"] . "' && admission_number='" . $add_student_to_result_database["admission_number"] . "'");
									$check_cbt_submitted_list = mysqli_query($connection_server, "SELECT * FROM sm_submitted_cbt_lists WHERE cbt_id_number='" . $fetch_cbt_details["cbt_id"] . "' && school_id_number='" . $fetch_cbt_details["school_id_number"] . "' && admission_number='" . $add_student_to_result_database["admission_number"] . "'");
									$check_cbt_started_list = mysqli_query($connection_server, "SELECT * FROM sm_started_cbt_lists WHERE cbt_id_number='" . $fetch_cbt_details["cbt_id"] . "' && school_id_number='" . $fetch_cbt_details["school_id_number"] . "' && admission_number='" . $add_student_to_result_database["admission_number"] . "'");

									if (mysqli_num_rows($check_student_detail) == 1) {
										$get_student_detail = mysqli_fetch_array($check_student_detail);
										if (mysqli_num_rows($check_cbt_submitted_list) == 1) {
											echo
												'<div style="display: flex; flex-direction: row; justify-content: center; align-items: center; text-align: center; padding: 10px; margin: 5px 0 5px 0; border-radius: 20px;" class="container-box color-5 bg-4 text-bold-500 mobile-width-88 system-width-93 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
										<div style="text-align: left; display: inline-block; margin: 5px 0 10px 0;" class="color-2 mobile-font-size-14 system-font-size-20 mobile-width-60 system-width-60">' . $get_student_detail["firstname"] . ' ' . $get_student_detail["lastname"] . ' ' . $get_student_detail["othername"] . ' (Admission No: ' . $get_student_detail["admission_number"] . ' )</div>
										<div style="text-align: left; display: inline-block; margin: 5px 0 10px 0;" class="color-2 mobile-font-size-14 system-font-size-20 mobile-width-20 system-width-20">Status: Submitted</div>
										<button type="button" style="display: inline-block; margin: 5px 0 5px 0; padding: 5px 5px; border-radius: 10px; cursor: pointer;" class="color-6 bg-7 mobile-font-size-14 system-font-size-18 mobile-width-20 system-width-20" student-id="' . $add_student_to_result_database["admission_number"] . '" student-name="' . $get_student_detail["firstname"] . ' ' . $get_student_detail["lastname"] . ' ' . $get_student_detail["othername"] . '" onclick="rescheduleCBTExam(this);">Re-Scheldule Exam</button>
									</div>';
										} else {
											if (mysqli_num_rows($check_cbt_started_list) == 1) {
												echo
													'<div style="display: flex; flex-direction: row; justify-content: center; align-items: center; text-align: center; padding: 10px; margin: 5px 0 5px 0; border-radius: 20px;" class="container-box color-5 bg-4 text-bold-500 mobile-width-88 system-width-93 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
											<div style="text-align: left; display: inline-block; margin: 5px 0 10px 0;" class="color-2 mobile-font-size-14 system-font-size-20 mobile-width-60 system-width-60">' . $get_student_detail["firstname"] . ' ' . $get_student_detail["lastname"] . ' ' . $get_student_detail["othername"] . ' (Admission No: ' . $get_student_detail["admission_number"] . ' )</div>
											<div style="text-align: left; display: inline-block; margin: 5px 0 10px 0;" class="color-2 mobile-font-size-14 system-font-size-20 mobile-width-20 system-width-20">Status: Ongoing</div>
											<button type="button" style="display: inline-block; margin: 5px 0 5px 0; padding: 5px 5px; border-radius: 10px; cursor: pointer;" class="color-6 bg-7 mobile-font-size-14 system-font-size-18 mobile-width-20 system-width-20" student-id="' . $add_student_to_result_database["admission_number"] . '" student-name="' . $get_student_detail["firstname"] . ' ' . $get_student_detail["lastname"] . ' ' . $get_student_detail["othername"] . '" onclick="rescheduleCBTExam(this);">Re-Scheldule Exam</button>
										</div>';
											} else {
												echo
													'<div style="display: flex; flex-direction: row; justify-content: center; align-items: center; text-align: center; padding: 10px; margin: 5px 0 5px 0; border-radius: 20px;" class="container-box color-5 bg-4 text-bold-500 mobile-width-88 system-width-93 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
											<div style="text-align: left; display: inline-block; margin: 5px 0 10px 0;" class="color-2 mobile-font-size-14 system-font-size-20 mobile-width-60 system-width-60">' . $get_student_detail["firstname"] . ' ' . $get_student_detail["lastname"] . ' ' . $get_student_detail["othername"] . ' (Admission No: ' . $get_student_detail["admission_number"] . ' )</div>
											<div style="text-align: left; display: inline-block; margin: 5px 0 10px 0;" class="color-2 mobile-font-size-14 system-font-size-20 mobile-width-40 system-width-40">Status: Pending</div>
										</div>';
											}
										}
										$number_of_verified_student_listed += 1;
									}
								}

								if ($number_of_verified_student_listed == 0) {
									include("include/no-data-img.php");
								}
							} else {
								include("include/no-data-img.php");
							}
						} else {
							include("include/no-data-img.php");
						}
						?>
        </form>
    </center>
    <script>
    function rescheduleCBTExam(cbtRecheduleElement) {
        const studentName = cbtRecheduleElement.getAttribute("student-name");
        const studentId = cbtRecheduleElement.getAttribute("student-id");
        const rescheduleInput = document.getElementById("reschedule-id");
        const rescheduleBtn = document.getElementById("reschedule-btn");

        if (confirm("Do you want to Re-schedule CBT for " + studentName.toUpperCase() + "(Admission No: " + studentId +
                ")?")) {
            rescheduleInput.value = studentId;
            rescheduleBtn.click();
        } else {
            alert("Operation cancelled");
        }
    }
    </script>
</div>
<?php } ?>
<?php } ?>

<?php
	if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id == "stu")) {
		?>
<?php if ($tab == 'cbt_tests') { ?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <?php
					// The query is now built in func/cbtest.php and the result is in $select_all_cbt_test_table_lists
					$checkmate_scheldule_list = $select_all_cbt_test_table_lists; // Use the pre-fetched result

					if ($checkmate_scheldule_list && mysqli_num_rows($checkmate_scheldule_list) > 0) {
						$list_available_cbt_exams = 0;

						while ($cbt_details = mysqli_fetch_assoc($checkmate_scheldule_list)) {
							// Check if the student has already submitted this exam
							$checkmate_submitted = mysqli_query($connection_server, "SELECT * FROM sm_submitted_cbt_lists WHERE school_id_number='" . $cbt_details["school_id_number"] . "' AND cbt_id_number='" . $cbt_details["cbt_id"] . "' AND admission_number='" . $get_logged_user_details['admission_number'] . "'");

							// FINAL FIX: Only proceed if the student has NOT submitted the exam AND the exam actually has questions.
							if (mysqli_num_rows($checkmate_submitted) == 0 && !empty($cbt_details['exam_json'])) {
								$list_available_cbt_exams++;

								// Determine exam status
								$exam_status_text = "Upcoming";
								$button_text = "UPCOMING";
								$button_disabled = "disabled";
								$status_style = "color: orange; font-weight: bold;";

								$exam_start_timestamp = strtotime($cbt_details["exam_date"] . ' ' . $cbt_details["exam_time"]);
								list($hours, $minutes) = explode(':', $cbt_details["exam_duration"]);
								$duration_in_seconds = ($hours * 3600) + ($minutes * 60);
								$exam_end_timestamp = $exam_start_timestamp + $duration_in_seconds;
								$current_timestamp = time();

								// Check if exam is active
								if ($current_timestamp >= $exam_start_timestamp && $current_timestamp <= $exam_end_timestamp) {
									$exam_status_text = "Active";
									$button_text = "START EXAM";
									$button_disabled = "";
									$status_style = "color: green; font-weight: bold;";
								}
								// Check if exam has expired
								elseif ($current_timestamp > $exam_end_timestamp) {
									$exam_status_text = "Expired";
									$button_text = "EXPIRED";
									$status_style = "color: red; font-weight: bold;";
								}

								// Prepare data for the view
								$paper_title = htmlspecialchars($cbt_details["paper_title"]);
								$school_logo = 'dataimg/school_' . $get_logged_user_details['school_id_number'] . '.png';
								$student_image = 'dataimg/student_' . $get_logged_user_details['school_id_number'] . '_' . $get_logged_user_details['admission_number'] . '.png';
								$student_name = $get_logged_user_details['firstname'] . " " . $get_logged_user_details['lastname'];
								$school_logo = file_exists($school_logo) ? $school_logo : 'imgfile/logo.png';
								$student_image = file_exists($student_image) ? $student_image : 'imgfile/Student.png';
								$cbt_exam_type_array = ["1ca" => "1st C.A", "2ca" => "2nd C.A", "3ca" => "3rd C.A", "exam" => "Main Exam"];
								$exam_type_name = $cbt_exam_type_array[$cbt_details["cbt_type"]];

								// Prepare encoded JSON for the start button, only if the exam is active
								$final_cbt_encode_string = '';
								if ($exam_status_text === "Active") {
									$exam_json = $cbt_details["exam_json"];
									$replaced_exam_json = str_replace("\n", "", $exam_json);
									$final_cbt_encode_string = base64_encode(urlencode(base64_encode($replaced_exam_json)));
								}

								// Display the CBT card
								echo '
								<div style="text-align: center; padding: 10px 5px; margin: 5px 0; border-radius: 20px;" class="container-box color-5 bg-4 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3">
									<span style="display: block; margin: 5px 0 2px;" class="color-2 mobile-font-size-14 system-font-size-16">Subject: <big>' . strtoupper(homeworkSubjectName($cbt_details["subject_code"], $cbt_details["school_id_number"])) . '</big></span>
									<span style="display: block; margin: 2px 0;" class="color-2 mobile-font-size-14 system-font-size-16">Title: <big>' . strtoupper($paper_title) . '</big></span>
									<span style="display: block; margin: 2px 0;" class="color-2 mobile-font-size-14 system-font-size-16">Type: <big>' . $exam_type_name . '</big></span>
									<span style="display: block; margin: 2px 0;" class="color-2 mobile-font-size-14 system-font-size-16">Date: <big>' . date("d/m/Y", strtotime($cbt_details["exam_date"])) . '</big></span>
									<span style="display: block; margin: 2px 0;" class="color-2 mobile-font-size-14 system-font-size-16">Time: <big>' . timeFrame($cbt_details["exam_time"]) . '</big></span>
									<span style="display: block; margin: 2px 0;" class="color-2 mobile-font-size-14 system-font-size-16">Duration: <big>' . $cbt_details["exam_duration"] . '</big></span>
									<span style="display: block; margin: 4px 0; ' . $status_style . '" class="mobile-font-size-16 system-font-size-18">Status: ' . strtoupper($exam_status_text) . '</span>
									<button style="display: inline-block; margin: 2px 0 5px; padding: 10px 15px; border-radius: 20px; cursor: pointer;"
											class="color-6 bg-7"
											id="cbt-id-' . $cbt_details["cbt_id"] . '"
											school-logo="' . $school_logo . '"
											student-image="' . $student_image . '"
											school-name="' . htmlspecialchars(homeworkSchoolName($cbt_details["school_id_number"])) . '"
											student-name="' . htmlspecialchars($student_name) . '"
											exam-type="' . $exam_type_name . '"
											exam-cbt-id="' . $cbt_details["cbt_id"] . '"
											cbt-identifier="' . $final_cbt_encode_string . '"
											onclick="startCBTExam(this)" ' . $button_disabled . '>
										' . $button_text . '
									</button>
								</div>';
							}
						}

						if ($list_available_cbt_exams == 0) {
							// This message shows if all exams for the class have been completed or have no questions.
							echo '<div style="text-align: center; padding: 20px;" class="color-5 mobile-font-size-16 system-font-size-18">No upcoming tests available. You may have already completed them, or they may not have questions yet.</div>';
						}

					} else {
						// This message shows if no exams are scheduled at all for the class/session.
						include("include/no-data-img.php");
					}
					?>
    </center>
</div>
<?php } ?>
<?php } ?>

<?php
	if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
		?>
<?php if ($tab == 'add_cbt') { ?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <?php
					// Initialize variables to prevent notices.
					$edit_homework_detail = [];
					$edit_homework_checkmate = null;
					$edit_homework_id = isset($_GET['edit']) ? trim(strip_tags($_GET['edit'])) : '';
					$err_msg = '';

					if (!empty($edit_homework_id)) {
						$edit_homework_checkmate_query = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE (school_id_number='" . trim(strip_tags($_GET['id'])) . "' && cbt_id='" . $edit_homework_id . "')");
						if ($edit_homework_checkmate_query && mysqli_num_rows($edit_homework_checkmate_query) == 1) {
							$edit_homework_detail = mysqli_fetch_array($edit_homework_checkmate_query);
							$edit_homework_checkmate = $edit_homework_checkmate_query; // Keep the result for later checks
						}
					}
					?>
        <?php
					// Determine if we should show the form.
					// Show for "add new" (no edit id) or for a "valid edit" (edit id exists and was found in DB)
					$is_add_mode = empty($edit_homework_id);
					$is_valid_edit = !$is_add_mode && $edit_homework_checkmate && mysqli_num_rows($edit_homework_checkmate) === 1;

					if ($is_add_mode || $is_valid_edit) {
						?>

        <form method="post" enctype="multipart/form-data">
            <?php if (isset($_GET["err"]) && !empty(strip_tags($_GET["err"]))) { ?>
            <div style="display: inline-block;"
                class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
                <?php echo $err_msg; ?>
            </div>
            <?php } ?>

            <div style="text-align: left;"
                class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                CBT INFORMATION
            </div>

            <div
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="paper-title" type="text"
                    value="<?php echo isset($edit_homework_detail['paper_title']) ? htmlspecialchars($edit_homework_detail['paper_title']) : ''; ?>"
                    placeholder="" class="form-input" required />
                <span class="form-span mobile-font-size-12 system-font-size-14">Title*</span>
            </div>

            <div
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <select name="numeric-class" onchange="findClassSession();" id="find-homework-class-session"
                    class="form-select" required>
                    <option selected disabled hidden value="">Select Class</option>
                    <?php
									$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' " . $user_class_statement_auth . " GROUP BY numeric_class_name");

									if (mysqli_num_rows($select_classes_detail_using_id) > 0) {
										while ($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)) {
											$selected = (isset($edit_homework_detail["numeric_class_name"]) && $classes_details["numeric_class_name"] == $edit_homework_detail["numeric_class_name"]) ? "selected" : "";
											echo '<option value="' . $classes_details["numeric_class_name"] . '" ' . $selected . '>' . $classes_details["class_name"] . ' (' . $classes_details["numeric_class_name"] . ')</option>';
										}
									}
									?>
                </select>
                <span class="form-span mobile-font-size-12 system-font-size-14">Select Class*</span>
            </div>

            <div
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <select name="class-session" id="add-homework-class-session" class="form-select" required>
                    <option disabled hidden selected value="">Select Class Session</option>
                    <?php
									if ($is_valid_edit) {
										$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' && numeric_class_name='" . $edit_homework_detail["numeric_class_name"] . "'");

										if (mysqli_num_rows($select_sessions_detail_using_id) > 0) {
											while ($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)) {
												$selected = (isset($edit_homework_detail["session"]) && $sessions_details["session"] == $edit_homework_detail["session"]) ? "selected" : "";
												echo '<option value="' . $sessions_details["session"] . '" ' . $selected . '>' . str_replace("-", "/", $sessions_details["session"]) . '</option>';
											}
										}
									}
									?>
                </select>
                <span class="form-span mobile-font-size-12 system-font-size-14">Class Session*</span>
            </div>

            <div
                class="form-group mobile-width-90 system-width-35 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <select name="term-id" id="select-cbt-term-id" class="form-select" required>
                    <option disabled hidden selected value="">Select Term</option>
                    <?php
									$select_terms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "'");
									if (mysqli_num_rows($select_terms_detail_using_id) > 0) {
										while ($terms_details = mysqli_fetch_assoc($select_terms_detail_using_id)) {
											$selected = (isset($edit_homework_detail['term_id_number']) && $terms_details["id_number"] == $edit_homework_detail['term_id_number']) ? "selected" : "";
											echo '<option value="' . $terms_details["id_number"] . '" ' . $selected . '>' . $terms_details["term_name"] . '</option>';
										}
									}
									?>
                </select>
                <span class="form-span mobile-font-size-12 system-font-size-14">Exam Term*</span>
            </div>

            <?php $sch_id_numb = $get_logged_user_details["school_id_number"]; ?>
            <button
                onclick="largePopUp(`Add Term Category`,`Term Category Name*`,`ADD CATEGORY`,`select-cbt-term-id`,`sm_terms`,`school_id_number='<?php echo $sch_id_numb; ?>' && id_number='null'`,`term_name`);"
                type="button"
                class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-6 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                ADD
            </button>

            <div
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <select name="subject-code" class="form-select" required>
                    <option selected disabled hidden value="">Select Subject</option>
                    <?php
									$select_homeworks_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='" . trim(strip_tags($_GET['id'])) . "' " . $user_class_statement_auth);
									if (mysqli_num_rows($select_homeworks_detail_using_id) > 0) {
										while ($homeworks_details = mysqli_fetch_assoc($select_homeworks_detail_using_id)) {
											$selected = (isset($edit_homework_detail["subject_code"]) && $homeworks_details["subject_code"] == $edit_homework_detail["subject_code"]) ? "selected" : "";
											echo '<option value="' . $homeworks_details["subject_code"] . '" ' . $selected . '>' . $homeworks_details["subject_name"] . ' (' . $homeworks_details["subject_code"] . ')</option>';
										}
									}
									?>
                </select>
                <span class="form-span mobile-font-size-12 system-font-size-14">Subject Name*</span>
            </div>

            <div
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <select name="cbt-type" class="form-select" required>
                    <option selected disabled hidden value="">Select CBT Type</option>
                    <?php
									$cbt_exam_type_array = array("1ca" => "1st C.A", "2ca" => "2nd C.A", "3ca" => "3rd C.A", "exam" => "Main Exam");
									foreach ($cbt_exam_type_array as $cbt_type_id => $cbt_type_label) {
										$selected = (isset($edit_homework_detail["cbt_type"]) && $cbt_type_id == $edit_homework_detail["cbt_type"]) ? "selected" : "";
										echo '<option value="' . $cbt_type_id . '" ' . $selected . '>' . $cbt_type_label . '</option>';
									}
									?>
                </select>
                <span class="form-span mobile-font-size-12 system-font-size-14">CBT Exam Type*</span>
            </div>
            <input hidden id="homework-school-id"
                value="<?php echo $get_logged_user_details['school_id_number']; ?>" />

            <div style=""
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="exam-date" type="date"
                    value="<?php echo isset($edit_homework_detail['exam_date']) ? $edit_homework_detail['exam_date'] : ''; ?>"
                    class="form-input" required />
                <span class="form-span mobile-font-size-12 system-font-size-14">Exam Date*</span>
            </div>

            <div style=""
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="exam-time" type="time"
                    value="<?php echo isset($edit_homework_detail['exam_time']) ? $edit_homework_detail['exam_time'] : ''; ?>"
                    class="form-input" required />
                <span class="form-span mobile-font-size-12 system-font-size-14">Exam Time*</span>
            </div>

            <div
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <select name="exam-questions" class="form-select" required>
                    <option selected disabled hidden value="">Select No. of Question</option>
                    <?php
									foreach (range(1, 100) as $question_no) {
										$selected = (isset($edit_homework_detail["exam_questions"]) && $question_no == $edit_homework_detail["exam_questions"]) ? "selected" : "";
										echo '<option value="' . $question_no . '" ' . $selected . '>' . $question_no . '</option>';
									}
									?>
                </select>
                <span class="form-span mobile-font-size-12 system-font-size-14">No. of Question*</span>
            </div>

            <div
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <select name="exam-question-attempts" class="form-select" required>
                    <option selected disabled hidden value="">Select No. of Question Attemptable</option>
                    <?php
									foreach (range(1, 100) as $question_no) {
										$selected = (isset($edit_homework_detail["exam_question_attempts"]) && $question_no == $edit_homework_detail["exam_question_attempts"]) ? "selected" : "";
										echo '<option value="' . $question_no . '" ' . $selected . '>' . $question_no . '</option>';
									}
									?>
                </select>
                <span class="form-span mobile-font-size-12 system-font-size-14">No. of Question
                    Attemptable*</span>
            </div>

            <div style="float: left; clear: left;"
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                <select name="exam-duration" class="form-select" required>
                    <option selected disabled hidden value="">Select Exam Duration</option>
                    <?php
									$cbt_exam_duration_array = array("00:05:00" => "5 mins", "00:15:00" => "15 mins", "00:25:00" => "25 mins", "00:30:00" => "30 mins", "00:45:00" => "45 mins", "01:00:00" => "1 hr", "01:15:00" => "1hr 15mins", "01:25:00" => "1hr 25mins", "01:30:00" => "1 hr 30mins", "01:45:00" => "1hr 45mins", "02:00:00" => "2hr");
									foreach ($cbt_exam_duration_array as $cbt_duration_id => $cbt_duration_label) {
										$selected = (isset($edit_homework_detail["exam_duration"]) && $cbt_duration_id == $edit_homework_detail["exam_duration"]) ? "selected" : "";
										echo '<option value="' . $cbt_duration_id . '" ' . $selected . '>' . $cbt_duration_label . '</option>';
									}
									?>
                </select>
                <span class="form-span mobile-font-size-12 system-font-size-14">Exam Duration*</span>
            </div><br />

            <?php if (!$is_valid_edit) { ?>
            <button name="add-cbt" style="float: left; clear: left;" type="submit"
                class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                ADD CBT
            </button>
            <?php } else { ?>
            <button name="update-cbt" style="float: left; clear: left;" type="submit"
                class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                UPDATE CBT
            </button>

            <?php } ?>

        </form>

        <script>
        function findClassSession() {
            const find_homework_class_session = document.getElementById("find-homework-class-session");
            const add_homework_class_session = document.getElementById("add-homework-class-session");
            const homework_school_id_number = document.getElementById("homework-school-id");

            add_homework_class_session.innerHTML = "";
            const createSelectSessionOption = document.createElement("option");
            createSelectSessionOption.hidden = true;
            createSelectSessionOption.disabled = true;
            createSelectSessionOption.selected = true;
            createSelectSessionOption.text = "Select Class Session";
            createSelectSessionOption.value = "";
            add_homework_class_session.add(createSelectSessionOption);

            const classSessionHttpRequest = new XMLHttpRequest();
            classSessionHttpRequest.open("POST", "./get-class-session.php");
            classSessionHttpRequest.setRequestHeader("Content-Type", "application/json");
            const classSessionHttpRequestBody = JSON.stringify({
                sch_no: homework_school_id_number.value,
                class_id_no: find_homework_class_session.value
            });
            classSessionHttpRequest.onload = function() {
                if ((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)) {

                    const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];

                    for (i = 0; i < session_list_array.length; i++) {
                        const createSelectOption = document.createElement("option");
                        createSelectOption.text = session_list_array[i].replace("-", "/");
                        createSelectOption.value = session_list_array[i];
                        add_homework_class_session.add(createSelectOption);
                    }
                } else {
                    alert(classSessionHttpRequest.status);
                }
            }
            classSessionHttpRequest.send(classSessionHttpRequestBody);

        }
        </script>
    </center>
</div>
<?php
					}
		}

	?>
<?php } ?>

<?php
	if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
		?>
<?php if ($tab == 'add_cbt_quiz') { ?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <?php
					$edit_homework_id = trim(strip_tags($_GET['edit'] ?? ''));
					$err_msg = '';

					$edit_homework_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE (school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "' && cbt_id='" . $edit_homework_id . "')");
					if (!empty($edit_homework_id) && mysqli_num_rows($edit_homework_checkmate) == 1) {
						$edit_homework_detail = mysqli_fetch_array($edit_homework_checkmate);
					}
					?>
        <?php if (!empty($edit_homework_detail)) { ?>

        <form method="post" enctype="multipart/form-data">
            <?php if (!empty(strip_tags($_GET["err"] ?? ''))) { ?>
            <div style="display: inline-block;"
                class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
                <?php echo $err_msg; ?>
            </div>
            <?php } ?>
            <?php
							$sample_exam_question_json = $edit_homework_detail["exam_json"];

							?>
            <div style="text-align: left;"
                class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                CBT QUESTIONS INFORMATION
            </div>

            <?php
							if (!empty($sample_exam_question_json)) {
								$exam_json_encode = str_replace("\n", "", $sample_exam_question_json);
								$exam_json_encode = json_decode($exam_json_encode, true);
								if ($exam_json_encode == true) {
									if (count($exam_json_encode["quiz"]) == $edit_homework_detail["exam_questions"]) {
										$verified_exam_json = $exam_json_encode;
									} else {
										if (count($exam_json_encode["quiz"]) > $edit_homework_detail["exam_questions"]) {
											$verified_exam_json = $exam_json_encode;
										} else {
											if (count($exam_json_encode["quiz"]) < $edit_homework_detail["exam_questions"]) {
												$verified_exam_json = $exam_json_encode;
											} else {
												$verified_exam_json = false;
											}
										}
									}
								} else {
									$verified_exam_json = false;
								}
							} else {
								$verified_exam_json = false;
							}

							$quiz_question_json_array = array();
							for ($i = 0; $i < $edit_homework_detail["exam_questions"]; $i++) {
								if ($verified_exam_json !== false && isset($verified_exam_json["quiz"][$i])) {
									$exam_question = $verified_exam_json["quiz"][$i]["question"] ?? "";
									$exam_question_correct_answer = $verified_exam_json["quiz"][$i]["answers"]["correct"] ?? "";
									$exam_question_wrong_answer_array = $verified_exam_json["quiz"][$i]["answers"]["wrong"] ?? [];
								} else {
									$exam_question = "";
									$exam_question_correct_answer = "";
									$exam_question_wrong_answer_array = array();
								}

								$question_str = $exam_question;
								$correct_answers_array = $exam_question_correct_answer;
								$wrong_answers_array = $exam_question_wrong_answer_array;
								$answers_array = array("correct" => $correct_answers_array, "wrong" => $wrong_answers_array);
								$answers_json = $answers_array;
								$sample_create_question_array = array("question" => $question_str, "answers" => $answers_json);
								$sample_create_question_json = $sample_create_question_array;
								array_push($quiz_question_json_array, $sample_create_question_json);
							}

							$sample_create_exam_array = array("exams" => [homeworkSubjectName($edit_homework_detail["subject_code"], $edit_homework_detail["school_id_number"])], "time" => $edit_homework_detail["exam_duration"], "examAttempts" => $edit_homework_detail["exam_questions"], "quiz" => $quiz_question_json_array);
							$sample_create_exam_json_encode = json_encode($sample_create_exam_array, true);
							$sample_create_exam_json_decode = json_decode($sample_create_exam_json_encode, true);

							if (!empty(homeworkSubjectName($edit_homework_detail["subject_code"], $edit_homework_detail["school_id_number"]))) {
								echo '<span class="color-5 text-bold-600 mobile-font-size-18 system-font-size-20">SUBJECT: ' . homeworkSubjectName($edit_homework_detail["subject_code"], $edit_homework_detail["school_id_number"]) . ' ( ' . $edit_homework_detail["subject_code"] . ' )</span><br>';
							}
							foreach ($sample_create_exam_json_decode["quiz"] as $index => $question_json) {
								$question_numbering = ($index + 1);
								$each_question_json = $question_json;
								$each_question_text_word = !empty(trim(base64_decode($each_question_json["question"]))) ? str_replace(["\r\n"], "\n", base64_decode($each_question_json["question"])) : "";
								$each_question_correct_answer_text_word = !empty(trim(base64_decode($each_question_json["answers"]["correct"]))) ? str_replace(["\r\n"], "\n", base64_decode($each_question_json["answers"]["correct"])) : "";
								$each_question_wrong_answer_1_text_word = !empty(trim(base64_decode($each_question_json["answers"]["wrong"][0] ?? ''))) ? str_replace(["\r\n"], "\n", base64_decode($each_question_json["answers"]["wrong"][0] ?? '')) : "";
								$each_question_wrong_answer_2_text_word = !empty(trim(base64_decode($each_question_json["answers"]["wrong"][1] ?? ''))) ? str_replace(["\r\n"], "\n", base64_decode($each_question_json["answers"]["wrong"][1] ?? '')) : "";
								$each_question_wrong_answer_3_text_word = !empty(trim(base64_decode($each_question_json["answers"]["wrong"][2] ?? ''))) ? str_replace(["\r\n"], "\n", base64_decode($each_question_json["answers"]["wrong"][2] ?? '')) : "";

								echo
									'<span class="color-5 text-bold-600 mobile-font-size-18 system-font-size-20">QUESTION ' . $question_numbering . '</span><br>
					<div class="form-group mobile-width-90 system-width-95 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-1 system-margin-bottom-1 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
						<textarea id="question-' . $question_numbering . '-textarea" name="exam_question[]"  placeholder="" hidden required>' . $each_question_text_word . '</textarea>
						<div id="editor-question-' . $question_numbering . '" class="pell"></div>
						<span class="form-span mobile-font-size-12 system-font-size-14">Exam Question*</span>
					</div><br>

					<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
						<textarea id="option-1-' . $question_numbering . '-textarea" name="option_1[]" placeholder="Correct Answer" class="" style="" hidden required>' . $each_question_correct_answer_text_word . '</textarea>
						<div id="editor-option-1-' . $question_numbering . '" class="pell"></div>
						<span class="form-span mobile-font-size-12 system-font-size-14">Option 1 - Correct*</span>
					</div>

					<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
						<textarea id="option-2-' . $question_numbering . '-textarea" name="option_2[]" placeholder="Wrong Answer" class="" style="" hidden required>' . $each_question_wrong_answer_1_text_word . '</textarea>
						<div id="editor-option-2-' . $question_numbering . '" class="pell"></div>
						<span class="form-span mobile-font-size-12 system-font-size-14">Option 2 - Wrong*</span>
					</div>

					<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
						<textarea id="option-3-' . $question_numbering . '-textarea" name="option_3[]" placeholder="Wrong Answer" class="" style="" hidden required>' . $each_question_wrong_answer_2_text_word . '</textarea>
						<div id="editor-option-3-' . $question_numbering . '" class="pell"></div>
						<span class="form-span mobile-font-size-12 system-font-size-14">Option 3 - Wrong*</span>
					</div>

					<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-4 system-margin-bottom-4 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
						<textarea id="option-4-' . $question_numbering . '-textarea" name="option_4[]" placeholder="Wrong Answer" class="" style="" hidden required>' . $each_question_wrong_answer_3_text_word . '</textarea>
						<div id="editor-option-4-' . $question_numbering . '" class="pell"></div>
						<span class="form-span mobile-font-size-12 system-font-size-14">Option 4 - Wrong*</span>
					</div>
					';
							}

							?>

            <button name="update-cbt-question" style="float: left; clear: left;" type="submit"
                class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                UPDATE CBT
            </button>
        </form>

        <script>
        function findClassSession() {
            const find_homework_class_session = document.getElementById("find-homework-class-session");
            const add_homework_class_session = document.getElementById("add-homework-class-session");
            const homework_school_id_number = document.getElementById("homework-school-id");

            add_homework_class_session.innerHTML = "";
            const createSelectSessionOption = document.createElement("option");
            createSelectSessionOption.hidden = true;
            createSelectSessionOption.disabled = true;
            createSelectSessionOption.selected = true;
            createSelectSessionOption.text = "Select Class Session";
            createSelectSessionOption.value = "";
            add_homework_class_session.add(createSelectSessionOption);

            const classSessionHttpRequest = new XMLHttpRequest();
            classSessionHttpRequest.open("POST", "./get-class-session.php");
            classSessionHttpRequest.setRequestHeader("Content-Type", "application/json");
            const classSessionHttpRequestBody = JSON.stringify({
                sch_no: homework_school_id_number.value,
                class_id_no: find_homework_class_session.value
            });
            classSessionHttpRequest.onload = function() {
                if ((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)) {

                    const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];

                    for (i = 0; i < session_list_array.length; i++) {
                        const createSelectOption = document.createElement("option");
                        createSelectOption.text = session_list_array[i].replace("-", "/");
                        createSelectOption.value = session_list_array[i];
                        add_homework_class_session.add(createSelectOption);
                    }
                } else {
                    alert(classSessionHttpRequest.status);
                }
            }
            classSessionHttpRequest.send(classSessionHttpRequestBody);

        }
        </script>
    </center>
</div>
<?php
					} else {
						include("include/no-data-img.php");
					}
		}

	?>
<?php } ?>
<?php
} else {
	include("include/no-data-img.php");
}
?>

<?php
if ($user_identifier_auth_id == "stu") { // Only for students
	?>
<?php } ?>

<?php
if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
	?>
<?php if ($tab == 'clone_cbt') { ?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <?php
				$clone_id = trim(strip_tags($_GET['clone_id'] ?? ''));
				$cbt_to_clone_query = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE cbt_id='$clone_id' AND school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "'");

				if (mysqli_num_rows($cbt_to_clone_query) == 1) {
					$cbt_details = mysqli_fetch_assoc($cbt_to_clone_query);
					?>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="clone_id" value="<?php echo $clone_id; ?>">

            <div style="text-align: left;"
                class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                CLONING CBT: <?php echo htmlspecialchars($cbt_details['paper_title']); ?>
            </div>

            <div
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="paper-title" type="text"
                    value="[CLONE] <?php echo htmlspecialchars($cbt_details['paper_title']); ?>"
                    class="form-input" required />
                <span class="form-span mobile-font-size-12 system-font-size-14">New Title*</span>
            </div>

            <div
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <select name="new-session" class="form-select" required>
                    <option disabled hidden selected value="">Select New Session</option>
                    <?php
									$sessions_query = mysqli_query($connection_server, "SELECT DISTINCT session FROM sm_classes WHERE school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "' ORDER BY session DESC");
									if (mysqli_num_rows($sessions_query) > 0) {
										while ($session_row = mysqli_fetch_assoc($sessions_query)) {
											echo '<option value="' . $session_row['session'] . '">' . str_replace("-", "/", $session_row['session']) . '</option>';
										}
									}
									?>
                </select>
                <span class="form-span mobile-font-size-12 system-font-size-14">New Session*</span>
            </div>

            <div
                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <select name="new-term" class="form-select" required>
                    <option disabled hidden selected value="">Select New Term</option>
                    <?php
									$terms_query = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "'");
									if (mysqli_num_rows($terms_query) > 0) {
										while ($term_row = mysqli_fetch_assoc($terms_query)) {
											echo '<option value="' . $term_row['id_number'] . '">' . $term_row['term_name'] . '</option>';
										}
									}
									?>
                </select>
                <span class="form-span mobile-font-size-12 system-font-size-14">New Term*</span>
            </div>

            <button name="confirm-clone-cbt" style="float: left; clear: left;" type="submit"
                class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                CONFIRM CLONE
            </button>
        </form>
        <?php
				} else {
					echo "<p>CBT not found or you do not have permission to clone it.</p>";
				}
				?>
    </center>
</div>
<?php } ?>
<?php } ?>