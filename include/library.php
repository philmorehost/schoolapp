	<div style="" class="container-box bg-2  border-style-bottom-1 border-color-5 border-width-1 mobile-width-92 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-5 system-margin-left-2">
		<?php
    		if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
		?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=issue_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'issue_list'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2'; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				ISSUE LIST
			</button>
		</a>
		<?php } ?>

		<?php
    		if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
		?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=book_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'book_list'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				BOOK LIST
			</button>
		</a>
		<?php } ?>

		<?php
    		if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
		?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=add_book&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'add_book'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				ADD BOOK
			</button>
		</a>
		<?php } ?>

		<?php
    		if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
		?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=issue_book&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'issue_book'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				ISSUE BOOK
			</button>
		</a>
		<?php } ?>
	</div>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == "issue_list"){ ?>
	<?php
	    if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_issue_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth)) > 0){
			$count_issue_list_listed = mysqli_num_rows($select_all_issue_list_table_lists);
	?>
	<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
		<div style="text-align: left;" class="scroll-box bg-2 mobile-width-96 system-width-96">
		<?php
			if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
		?>
    	<form method="post">
    		<div class="form-group-borderless mobile-width-20 system-width-7 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
    			<select onchange="pageListNumber();" id="page_list_number" class="form-select">
    				<option <?php if(trim(strip_tags($_GET["pnum"])) == 10){ echo "selected"; } ?> value="10">10</option>
    				<option <?php if(trim(strip_tags($_GET["pnum"])) == 25){ echo "selected"; } ?> value="25">25</option>
    				<option <?php if(trim(strip_tags($_GET["pnum"])) == 50){ echo "selected"; } ?> value="50">50</option>
						<option <?php if(trim(strip_tags($_GET["pnum"])) == 100){ echo "selected"; } ?> value="100">100</option>
    			</select>
    			<span class="form-span mobile-font-size-12 system-font-size-14"></span>
    		</div>
    		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_issue_list_listed; ?> entries</span>
    	
    		<div class="form-group-borderless mobile-width-85 system-width-50 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-14 mobile-margin-right-2 system-margin-right-1">
    			<input name="search-item" value="<?php echo $search_text; ?>" type="text" placeholder="Search... " class="form-input" />
    			<span class="form-span mobile-font-size-12 system-font-size-14"></span>
    		</div>
       	</form>
		<?php } ?>
       	<form method="post" enctype="multipart/form-data">
       		<table class="table-tag-borderless mobile-font-size-12 system-font-size-14 mobile-margin-left-3 system-margin-left-2">
       			<tr>
				   	<?php
						if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
					?>
       				<td>Tick</td>
					<?php } ?>
       				<td class="mobile-width-10 system-width-10">Student</td>
       				<td class="mobile-width-10 system-width-15">Name</td>
       				<td>Issue Date</td>
       				<td>Return Date</td>
					<td>Book Category</td>
       				<td>Book Name</td>
				   	<?php
						if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
					?>
           			<td style="width:10%;">Action</td>
					<?php } ?>
       			</tr>
					<?php
						
						function bookCategoryName($category_info,$school_id){
							global $connection_server;
							
							$get_issue_name = mysqli_query($connection_server,"SELECT * FROM sm_book_category WHERE school_id_number='$school_id' && id_number='$category_info'");
							if(mysqli_num_rows($get_issue_name) == 1){
								while($issue_name_array = mysqli_fetch_array($get_issue_name)){
									$issue_name .= $issue_name_array["category_name"];
								}
							}else{
								$issue_name = "N/A";
							}
							
							return $issue_name;
						}
						
						function bookName($book_info,$school_id){
							global $connection_server;
							
							$get_book_name = mysqli_query($connection_server,"SELECT * FROM sm_book_lists WHERE school_id_number='$school_id' && book_id='$book_info'");
							if(mysqli_num_rows($get_book_name) == 1){
								while($book_name_array = mysqli_fetch_array($get_book_name)){
									$book_name .= $book_name_array["book_name"];
								}
							}else{
								$book_name = "N/A";
							}
							
							return $book_name;
						}

						function studentName($student_info,$school_id){
							global $connection_server;
							
							$get_student_name = mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$student_info'");
							if(mysqli_num_rows($get_student_name) == 1){
								while($student_name_array = mysqli_fetch_array($get_student_name)){
									$student_name .= $student_name_array["firstname"]." ".$student_name_array["lastname"]." ".$student_name_array["othername"].'<br><span class="color-5">'.$student_name_array["email"].'</span>';
								}
							}else{
								$student_name = "N/A";
							}
							
							return $student_name;
						}

						if(mysqli_num_rows($select_all_issue_list_table_lists) > 0){
							while(($issue_list_details = mysqli_fetch_assoc($select_issue_list_table_lists))){
								$issue_list_view_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=issue_book',$_SERVER['REQUEST_URI'])."&view=".$issue_list_details["issue_id"];
								$issue_list_edit_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=issue_book',$_SERVER['REQUEST_URI'])."&edit=".$issue_list_details["issue_id"];
								if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
									$dcheck_button = '<td>
														<input type="checkbox" name="issue_id[]" value="'.$issue_list_details["issue_id"].'" class="issueListChecked" />
														<input hidden type="text" name="school_id[]" value="'.$issue_list_details["school_id_number"].'" />
													</td>';
									$action_button = '<td>
														<img onclick="return popUpAlert([``,``,`'.$issue_list_edit_link.'`,``],[`View`,``,`Edit`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}
								echo '<tr>
									'.$dcheck_button.'
									<td><img style="position: relative; margin: -1.5% 0 0 -2%;" src="imgfile/Student.png" class="mobile-width-100 system-width-50 avatar_icon_height" /></td>
									<td>'.studentName($issue_list_details["admission_number"], $issue_list_details["school_id_number"]).'</td>
       								<td>'.str_replace("-","/",$issue_list_details["issue_date"]).'</td>
       								<td>'.str_replace("-","/",$issue_list_details["return_date"]).'</td>
									<td>'.bookCategoryName($issue_list_details["book_category_id"], $issue_list_details["school_id_number"]).'</td>
       								<td>'.bookName($issue_list_details["book_id_number"], $issue_list_details["school_id_number"]).'</td>
									'.$action_button.'
									</tr>';
							}
						}
					?>
       		</table>
				   
       		<div style="float: right;" class="container-box bg-3 mobile-width-100 system-width-22">
					<a style="text-decoration: none;" href="<?php echo $page_prevnext_link.'&prevnext='.$prev_btn; ?>">
						<button type="button" class="button-box color-7 bg-6 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-5 mobile-padding-right-5 system-padding-right-5 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
							Previous
						</button>
					</a>
					<button type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-8 mobile-padding-right-5 system-padding-right-8 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
						<?php echo $current_page_no; ?>
					</button>
					<a style="text-decoration: none;" href="<?php echo $page_prevnext_link.'&prevnext='.$next_btn; ?>">
						<button type="button" class="button-box color-7 bg-6 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-5 mobile-padding-right-5 system-padding-right-5 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
							Next
						</button>
					</a>
				</div>
			<?php
				if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
			?>
       		<button type="button" onclick="checkALL();" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
       			<input type="checkbox" onclick="checkALL();" class="checkALL" value="2" />
       			SELECT ALL
       		</button>
       		<a style="cursor: pointer;" onclick="deleteItems();">
       			<img src="imgfile/Delete.png" style="position: relative; height: 2.6rem; margin: 0 0 -14px 0; pointer-events: none;" class="mobile-width-12 system-width-5" />
       		</a>
				<button name="delete-issue-list" type="submit" id="delissueList" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
       			Delete issue List
       		</button><br>
			<?php } ?>
			</form>
		</div>
		</center>
		
		<script>
			function pageListNumber(){
				var pageListNo = document.getElementById("page_list_number");
				if((pageListNo.value > 0) && (pageListNo.value != "")){
					window.location.href = '<?php echo $page_list_number_link; ?>'+pageListNo.value;
				}
			}

			function checkALL(){
				var allBoxToChecked = document.getElementsByClassName("issueListChecked");
				if(document.getElementsByClassName("issueListChecked")[0].checked != true){
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked != true){
							document.getElementsByClassName("checkALL")[0].checked = "checked";
						}
						document.getElementsByClassName("issueListChecked")[i].checked = "checked";
					}
				}else{
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked == true){
							document.getElementsByClassName("checkALL")[0].checked = false;
						}
						document.getElementsByClassName("issueListChecked")[i].checked = false;
					}
				}
			}

			function deleteItems(){
				var allBoxToChecked = document.getElementsByClassName("issueListChecked");
				checkBoxCount = 0;
					for(i = 0; i < allBoxToChecked.length; i++){
						if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
							checkBoxCount++;
						}
					}
				if(checkBoxCount == 1){
					if(confirm("Are you sure you want to delete this issue List?")){
						document.getElementById("delissueList").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one issue List");
						if(confirm("Are you sure you want to delete this issue List?")){
							document.getElementById("delissueList").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one issue List");
					}
				}
					
			}
		</script>
	</div>
    <?php }else{ include("include/no-data-img.php"); } ?>
<?php } ?>
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == "book_list"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_book_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."'")) > 0){
			$count_book_list_listed = mysqli_num_rows($select_all_book_list_table_lists);
    ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
		<div style="text-align: left;" class="scroll-box bg-2 mobile-width-96 system-width-96">
			<?php
				if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
			?>
        	<form method="post">
        		<div class="form-group-borderless mobile-width-20 system-width-7 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
        			<select onchange="pageListNumber();" id="page_list_number" class="form-select">
        				<option <?php if(trim(strip_tags($_GET["pnum"])) == 10){ echo "selected"; } ?> value="10">10</option>
        				<option <?php if(trim(strip_tags($_GET["pnum"])) == 25){ echo "selected"; } ?> value="25">25</option>
        				<option <?php if(trim(strip_tags($_GET["pnum"])) == 50){ echo "selected"; } ?> value="50">50</option>
						<option <?php if(trim(strip_tags($_GET["pnum"])) == 100){ echo "selected"; } ?> value="100">100</option>
        			</select>
        			<span class="form-span mobile-font-size-12 system-font-size-14"></span>
        		</div>
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_book_list_listed; ?> entries</span>
        	
        		<div class="form-group-borderless mobile-width-85 system-width-50 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-14 mobile-margin-right-2 system-margin-right-1">
        			<input name="search-item" value="<?php echo $search_text; ?>" type="text" placeholder="Search... " class="form-input" />
        			<span class="form-span mobile-font-size-12 system-font-size-14"></span>
        		</div>
           	</form>
           	<?php } ?>
           	<form method="post" enctype="multipart/form-data">
           		<table class="table-tag-borderless mobile-font-size-12 system-font-size-14 mobile-margin-left-3 system-margin-left-2">
           			<tr>
           				<td>Tick</td>
           				<td class="mobile-width-10 system-width-10">Book</td>
           				<td class="mobile-width-10 system-width-15">ISBN</td>
           				<td>Book Name</td>
           				<td>Author Name</td>
						<td>Book Category</td>
           				<td>Rack Location</td>
						<td>Remaining Quantity</td>
						<td>Description</td>
           				<td style="width:10%;">Action</td>
           			</tr>
					<?php
						
						function bookCategoryName($category_info,$school_id){
							global $connection_server;
							
							$get_book_name = mysqli_query($connection_server,"SELECT * FROM sm_book_category WHERE school_id_number='$school_id' && id_number='$category_info'");
							if(mysqli_num_rows($get_book_name) == 1){
								while($book_name_array = mysqli_fetch_array($get_book_name)){
									$book_name .= $book_name_array["category_name"];
								}
							}else{
								$book_name = "N/A";
							}
							
							return $book_name;
						}
						
						function bookRackLocationName($rack_info,$school_id){
							global $connection_server;
							
							$get_book_name = mysqli_query($connection_server,"SELECT * FROM sm_book_rack_location WHERE school_id_number='$school_id' && id_number='$rack_info'");
							if(mysqli_num_rows($get_book_name) == 1){
								while($book_name_array = mysqli_fetch_array($get_book_name)){
									$book_name .= $book_name_array["rack_name"];
								}
							}else{
								$book_name = "N/A";
							}
							
							return $book_name;
						}
						
						if(mysqli_num_rows($select_all_book_list_table_lists) > 0){
							while(($book_list_details = mysqli_fetch_assoc($select_book_list_table_lists))){
								$book_list_view_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=add_book',$_SERVER['REQUEST_URI'])."&view=".$book_list_details["book_id"];
								$book_list_edit_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=add_book',$_SERVER['REQUEST_URI'])."&edit=".$book_list_details["book_id"];
								
								$count_issued_books = mysqli_num_rows(mysqli_query($connection_server,"SELECT * FROM sm_issue_lists WHERE school_id_number='".$book_list_details['school_id_number']."' && book_id_number='".$book_list_details['book_id']."'"));
								
								echo '<tr>
									<td>
										<input type="checkbox" name="book_id[]" value="'.$book_list_details["book_id"].'" class="bookListChecked" />
										<input hidden type="text" name="school_id[]" value="'.$book_list_details["school_id_number"].'" />
									</td>
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/white/Library.png" class="mobile-width-60 system-width-30" /></td>
									<td>'.$book_list_details["isbn"].'</td>
           							<td>'.$book_list_details["book_name"].'</td>
           							<td>'.$book_list_details["author_name"].'</td>
									<td>'.bookCategoryName($book_list_details["book_category_id"], $book_list_details["school_id_number"]).'</td>
           							<td>'.bookRackLocationName($book_list_details["rack_location"], $book_list_details["school_id_number"]).'</td>
           							<td>'.($book_list_details["quantity"]-$count_issued_books).'</td>
           							<td>'.checkIfEmpty($book_list_details["description"]).'</td>
									<td>
										<img onclick="return popUpAlert([``,``,`'.$book_list_edit_link.'`,``],[`View Book List`,``,`Edit Book List`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
									</td>
									</tr>';
							}
						}
					?>
           		</table>
				   
           		<div style="float: right;" class="container-box bg-3 mobile-width-100 system-width-22">
					<a style="text-decoration: none;" href="<?php echo $page_prevnext_link.'&prevnext='.$prev_btn; ?>">
						<button type="button" class="button-box color-7 bg-6 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-5 mobile-padding-right-5 system-padding-right-5 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
							Previous
						</button>
					</a>
					<button type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-8 mobile-padding-right-5 system-padding-right-8 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
						<?php echo $current_page_no; ?>
					</button>
					<a style="text-decoration: none;" href="<?php echo $page_prevnext_link.'&prevnext='.$next_btn; ?>">
						<button type="button" class="button-box color-7 bg-6 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-5 mobile-padding-right-5 system-padding-right-5 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
							Next
						</button>
					</a>
				</div>
           		<button type="button" onclick="checkALL();" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			<input type="checkbox" onclick="checkALL();" class="checkALL" value="2" />
           			SELECT ALL
           		</button>
           		<a style="cursor: pointer;" onclick="deleteItems();">
           			<img src="imgfile/Delete.png" style="position: relative; height: 2.6rem; margin: 0 0 -14px 0; pointer-events: none;" class="mobile-width-12 system-width-5" />
           		</a>
				<button name="delete-book-list" type="submit" id="delBookList" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete Book List
           		</button><br>
			</form>
		</div>
		</center>
		
		<script>
			function pageListNumber(){
				var pageListNo = document.getElementById("page_list_number");
				if((pageListNo.value > 0) && (pageListNo.value != "")){
					window.location.href = '<?php echo $page_list_number_link; ?>'+pageListNo.value;
				}
			}

			function checkALL(){
				var allBoxToChecked = document.getElementsByClassName("bookListChecked");
				if(document.getElementsByClassName("bookListChecked")[0].checked != true){
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked != true){
							document.getElementsByClassName("checkALL")[0].checked = "checked";
						}
						document.getElementsByClassName("bookListChecked")[i].checked = "checked";
					}
				}else{
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked == true){
							document.getElementsByClassName("checkALL")[0].checked = false;
						}
						document.getElementsByClassName("bookListChecked")[i].checked = false;
					}
				}
			}

			function deleteItems(){
				var allBoxToChecked = document.getElementsByClassName("bookListChecked");
				checkBoxCount = 0;
					for(i = 0; i < allBoxToChecked.length; i++){
						if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
							checkBoxCount++;
						}
					}
				if(checkBoxCount == 1){
					if(confirm("Are you sure you want to delete this Book List?")){
						document.getElementById("delBookList").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one Book List");
						if(confirm("Are you sure you want to delete this Book List?")){
							document.getElementById("delBookList").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one Book List");
					}
				}
					
			}
		</script>
	</div>
    <?php }else{ include("include/no-data-img.php"); } ?>
<?php } ?>
<?php } ?>


<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'add_book'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_book_list_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_book_lists WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && book_id='".trim(strip_tags($_GET['edit']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_book_list_checkmate) == 1)){
					if(mysqli_num_rows($edit_book_list_checkmate) == 1){
						$edit_book_list_detail = mysqli_fetch_array($edit_book_list_checkmate);
						
						$edit_book_list_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_book_list_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    BOOK INFORMATION
                </div>
				
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="isbn" value="<?php echo $edit_book_list_detail['isbn']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">ISBN*</span>
                </div>
                
				<div class="form-group mobile-width-90 system-width-35 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="book-category" id="select-book-category-id" class="form-select" required>
						<option disabled hidden selected value="">Select Book Category</option>
						<?php
							$select_book_category_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_book_category WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_book_category_detail_using_id) > 0){
								while($book_category_details = mysqli_fetch_assoc($select_book_category_detail_using_id)){
									if($book_category_details["id_number"] == $edit_book_list_detail['book_category_id']){
										$selected = "selected";
										echo '<option value="'.$book_category_details["id_number"].'" '.$selected.'>'.$book_category_details["category_name"].'</option>';
									}else{
										echo '<option value="'.$book_category_details["id_number"].'">'.$book_category_details["category_name"].'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Book Category*</span>
				</div>
				
				<?php $sch_id_numb = $get_logged_user_details["school_id_number"]; ?>
				<button onclick="largePopUp(`Add Book Category`,`Book Category Name*`,`ADD`,`select-book-category-id`,`sm_book_category`,`school_id_number='<?php echo $sch_id_numb; ?>' && id_number='null'`,`category_name`);" type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-6 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD
				</button>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="book-name" value="<?php echo $edit_book_list_detail['book_name']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Book Name*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="author-name" value="<?php echo $edit_book_list_detail['author_name']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Author Name*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-35 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="rack-location" id="select-book-rack-location-id" class="form-select" required>
						<option disabled hidden selected value="">Select Rack Location</option>
						<?php
							$select_book_rack_location_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_book_rack_location WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_book_rack_location_detail_using_id) > 0){
								while($book_rack_location_details = mysqli_fetch_assoc($select_book_rack_location_detail_using_id)){
									if($book_rack_location_details["id_number"] == $edit_book_list_detail['rack_location']){
										$selected = "selected";
										echo '<option value="'.$book_rack_location_details["id_number"].'" '.$selected.'>'.$book_rack_location_details["rack_name"].'</option>';
									}else{
										echo '<option value="'.$book_rack_location_details["id_number"].'">'.$book_rack_location_details["rack_name"].'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Rack Location*</span>
				</div>

				<?php $sch_id_numb_2 = $get_logged_user_details["school_id_number"]; ?>
				<button onclick="largePopUp(`Add Rack Location`,`Add Rack Location Name*`,`ADD`,`select-book-rack-location-id`,`sm_book_rack_location`,`school_id_number='<?php echo $sch_id_numb_2; ?>' && id_number='null'`,`rack_name`);" type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-6 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD
				</button>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="price" value="<?php echo $edit_book_list_detail['price']; ?>" type="text" pattern="[0-9]{1,}" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Price*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="quantity" value="<?php echo $edit_book_list_detail['quantity']; ?>" type="text" pattern="[0-9]{1,}" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Quantity*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="desc" value="<?php echo $edit_book_list_detail['description']; ?>" type="text" placeholder="" class="form-input"/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Description</span>
                </div>
                
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_book_list_checkmate) < 1)){ ?>
                <button name="add-book" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD BOOK
				</button>
				<?php }else{ ?>
				<button name="update-book" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    UPDATE BOOK
				</button>
				<?php } ?>
            </form>
            
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'issue_book'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_book_list_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_issue_lists WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && issue_id='".trim(strip_tags($_GET['edit']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_book_list_checkmate) == 1)){
					if(mysqli_num_rows($edit_book_list_checkmate) == 1){
						$edit_book_list_detail = mysqli_fetch_array($edit_book_list_checkmate);
						
						$edit_book_list_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_book_list_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    ISSUE BOOK INFORMATION
                </div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="numeric-class" onchange="findIssueBookClassSession();" id="find-issue-book-class-session" class="form-select" required>
						<option selected disabled hidden value="">Select Class</option>
						<?php
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' GROUP BY numeric_class_name");
				
							if(mysqli_num_rows($select_classes_detail_using_id) > 0){
								while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
									if($classes_details["numeric_class_name"] == $edit_book_list_detail['numeric_class_name']){
										$selected = "selected";
										echo '<option value="'.$classes_details["numeric_class_name"].'" '.$selected.'>'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
									}else{
										echo '<option value="'.$classes_details["numeric_class_name"].'" >'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Class Name*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="class-session" onchange="findClassSessionStudent();" id="add-issue-book-class-session" class="form-select" required>
						<option disabled hidden selected value="">Select Class Session</option>
						<?php
							if((mysqli_num_rows($edit_book_list_checkmate) == 1)){
								$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$edit_book_list_detail['numeric_class_name']."'");
					
								if(mysqli_num_rows($select_sessions_detail_using_id) > 0){
									while($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)){
										if($sessions_details["session"] == $edit_book_list_detail['session']){
											$selected = "selected";
											echo '<option value="'.$sessions_details["session"].'" '.$selected.'>'.str_replace("-","/",$sessions_details["session"]).'</option>';
										}else{
											echo '<option value="'.$sessions_details["session"].'" >'.str_replace("-","/",$sessions_details["session"]).'</option>';
										}
										
									}
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Session Name*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="student-roll-number" id="student-roll-id" class="form-select" required>
						<option disabled hidden selected value="">Select Student</option>
						<?php
							if((mysqli_num_rows($edit_book_list_checkmate) == 1)){
								$select_students_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && current_class='".$edit_book_list_detail['numeric_class_name']."' && session='".$edit_book_list_detail['session']."'");
					
								if(mysqli_num_rows($select_students_detail_using_id) > 0){
									while($students_details = mysqli_fetch_assoc($select_students_detail_using_id)){
										if($students_details["admission_number"] == $edit_book_list_detail['admission_number']){
											$selected = "selected";
											echo '<option value="'.$students_details["admission_number"].'" '.$selected.'>'.$students_details["firstname"].' '.$students_details["lastname"].' '.$students_details["othername"].'</option>';
										}else{
											echo '<option value="'.$students_details["admission_number"].'" >'.$students_details["firstname"].' '.$students_details["lastname"].' '.$students_details["othername"].'</option>';
										}
										
									}
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Select Student*</span>
				</div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="issue-date" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $edit_book_list_detail['issue_date']; ?>" type="date" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Issue Date*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="return-date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $edit_book_list_detail['return_date']; ?>" type="date" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Return Date*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="book-category" onchange="findLibraryBooks();" id="select-book-category" class="form-select" required>
						<option disabled hidden selected value="">Select Book Category</option>
						<?php
							$select_book_category_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_book_category WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_book_category_detail_using_id) > 0){
								while($book_category_details = mysqli_fetch_assoc($select_book_category_detail_using_id)){
									if($book_category_details["id_number"] == $edit_book_list_detail['book_category_id']){
										$selected = "selected";
										echo '<option value="'.$book_category_details["id_number"].'" '.$selected.'>'.$book_category_details["category_name"].'</option>';
									}else{
										echo '<option value="'.$book_category_details["id_number"].'">'.$book_category_details["category_name"].'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Book Category*</span>
				</div>

                <input hidden id="issue-book-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
				
				<div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
					<select name="book-id" id="library-book-id" class="form-select" required>
						<option disabled hidden selected value="">Select Book</option>
						<?php
							if((mysqli_num_rows($edit_book_list_checkmate) == 1)){
								$select_books_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_book_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && book_category_id='".$edit_book_list_detail['book_category_id']."'");
					
								if(mysqli_num_rows($select_books_detail_using_id) > 0){
									while($books_details = mysqli_fetch_assoc($select_books_detail_using_id)){
										if($books_details["book_id"] == $edit_book_list_detail['book_id_number']){
											$selected = "selected";
											echo '<option value="'.$books_details["book_id"].'" '.$selected.'>'.$books_details["book_name"].'</option>';
										}else{
											echo '<option value="'.$books_details["book_id"].'" >'.$books_details["book_name"].'</option>';
										}
										
									}
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Select Book*</span>
				</div>

				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_book_list_checkmate) < 1)){ ?>
                <button name="issue-book" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ISSUE BOOK
				</button>
				<?php }else{ ?>
				<button name="re-issue-book" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    RE-ISSUE BOOK
				</button>
				<?php } ?>
            </form>
            
			<script>
				function findIssueBookClassSession(){
					const find_issue_book_class_session = document.getElementById("find-issue-book-class-session");
					const add_issue_book_class_session = document.getElementById("add-issue-book-class-session");
					const issue_book_school_id_number = document.getElementById("issue-book-school-id");

					add_issue_book_class_session.innerHTML = "";
					const createSelectSessionOption = document.createElement("option");
					createSelectSessionOption.hidden = true;
					createSelectSessionOption.disabled = true;
					createSelectSessionOption.selected = true;
					createSelectSessionOption.text = "Select Class Session";
					createSelectSessionOption.value = "";
					add_issue_book_class_session.add(createSelectSessionOption);

					const classSessionHttpRequest = new XMLHttpRequest();
					classSessionHttpRequest.open("POST","./get-class-session.php");
					classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionHttpRequestBody = JSON.stringify({sch_no: issue_book_school_id_number.value, class_id_no: find_issue_book_class_session.value});

					classSessionHttpRequest.onload = function(){
						if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
							
							const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
							
							for(i=0; i < session_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = session_list_array[i].replace("-","/");
								createSelectOption.value = session_list_array[i];
								add_issue_book_class_session.add(createSelectOption);
							}
						}else{
							alert(classSessionHttpRequest.status);
						}
					}
					classSessionHttpRequest.send(classSessionHttpRequestBody);
					findClassSessionStudent();
				}

				function findClassSessionStudent(){
					const find_issue_book_class_session = document.getElementById("find-issue-book-class-session");
					const add_issue_book_class_session = document.getElementById("add-issue-book-class-session");
					const student_roll_id = document.getElementById("student-roll-id");
					
					const issue_book_school_id_number = document.getElementById("issue-book-school-id");

					student_roll_id.innerHTML = "";
					const createSelectStudentOption = document.createElement("option");
					createSelectStudentOption.hidden = true;
					createSelectStudentOption.disabled = true;
					createSelectStudentOption.selected = true;
					createSelectStudentOption.text = "Select Student";
					createSelectStudentOption.value = "";
					student_roll_id.add(createSelectStudentOption);

					const classSessionStudentHttpRequest = new XMLHttpRequest();
					classSessionStudentHttpRequest.open("POST","./get-student.php");
					classSessionStudentHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionStudentHttpRequestBody = JSON.stringify({sch_no: issue_book_school_id_number.value, class_id_no: find_issue_book_class_session.value, session: add_issue_book_class_session.value});
					classSessionStudentHttpRequest.onload = function(){
						if((classSessionStudentHttpRequest.readyState == 4) && (classSessionStudentHttpRequest.status == 200)){
							
							const student_list_array = Object.entries(JSON.parse(classSessionStudentHttpRequest.responseText)["response"]);
							
							for(i=0; i < student_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = student_list_array[i][1];
								createSelectOption.value = student_list_array[i][0];
								student_roll_id.add(createSelectOption);
							}
						}else{
							alert(classSessionStudentHttpRequest.status);
						}
					}
					classSessionStudentHttpRequest.send(classSessionStudentHttpRequestBody);
				}

				function findLibraryBooks(){
					const select_book_category = document.getElementById("select-book-category");
					const library_book_id = document.getElementById("library-book-id");
					const issue_book_school_id_number = document.getElementById("issue-book-school-id");

					library_book_id.innerHTML = "";
					const createSelectBookOption = document.createElement("option");
					createSelectBookOption.hidden = true;
					createSelectBookOption.disabled = true;
					createSelectBookOption.selected = true;
					createSelectBookOption.text = "Select Book";
					createSelectBookOption.value = "";
					library_book_id.add(createSelectBookOption);

					const selectBookHttpRequest = new XMLHttpRequest();
					selectBookHttpRequest.open("POST","./get-select-book.php");
					selectBookHttpRequest.setRequestHeader("Content-Type","application/json");
					const selectBookHttpRequestBody = JSON.stringify({sch_no: issue_book_school_id_number.value, category: select_book_category.value});
					selectBookHttpRequest.onload = function(){
						if((selectBookHttpRequest.readyState == 4) && (selectBookHttpRequest.status == 200)){
							
							const book_list_array = Object.entries(JSON.parse(selectBookHttpRequest.responseText)["response"]);
							
							for(i=0; i < book_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = book_list_array[i][1];
								createSelectOption.value = book_list_array[i][0];
								library_book_id.add(createSelectOption);
							}
						}else{
							alert(selectBookHttpRequest.status);
						}
					}
					selectBookHttpRequest.send(selectBookHttpRequestBody);
				}
			</script>
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 
<?php } ?>