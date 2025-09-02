<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
    <?php if(strip_tags($_GET['page']) == "smgt_email_template"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_route_lists WHERE school_id_number='".$get_logged_user_details["school_id_number"]."'")) >= 0){
    ?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-5 system-margin-top-2">
    <center>      
            <!-- Student Registration Mail Template Beginning -->
            <div onclick="displayRouteTable('class-student-reg-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-student-reg-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Student Registration Mail Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-student-reg-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('student-reg','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('student-reg','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{student_name}}</strong> - The student full name or login name (whatever is available)<br/>
                        <strong>{{user_name}}</strong> - User name of student<br/>
                        <strong>{{class_name}}</strong> - Class name of student<br/>
                        <strong>{{email}}</strong> - Email of student<br/>
                        <strong>{{school_name}}</strong> - School name<br/>
                    </span>
                </div> 
                <button name="save-student-reg-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
				    SAVE
			    </button>  
			    </form>
            </div>
            <!-- Student Registration Mail Template End -->
                        
            <!-- Fee Payment Mail Template Beginning -->
            <div onclick="displayRouteTable('class-fee-payment-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-fee-payment-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Fee Payment Mail Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-fee-payment-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('fees-alert','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('fees-alert','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{parent_name}}</strong> - Parent Name<br/>
                        <strong>{{school_name}}</strong> - School name<br/>
                    </span>
                </div> 
                <button name="save-fee-payment-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Fee Payment Mail Template End -->

            <!-- Add User Template Beginning -->
            <div onclick="displayRouteTable('class-add-user-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-add-user-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Add User Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-add-user-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('add-user','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('add-user','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{user_name}}</strong> - The student full name<br/>
                        <strong>{{school_name}}</strong> - School Name<br/>
                        <strong>{{role}}</strong> - Student roll number<br/>
                        <strong>{{login_link}}</strong> - Student roll number<br/>
                        <strong>{{username}}</strong> - Student roll number<br/>
                        <strong>{{password}}</strong> - Student roll number<br/>
                    </span>
                </div> 
                <button name="save-add-user-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Add User Template End -->

            <!-- Student Assign to Teacher Template Beginning -->
            <div onclick="displayRouteTable('class-student-assign-to-teacher-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-student-assign-to-teacher-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Student Assign to Teacher Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-student-assign-to-teacher-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('student-assign-teacher','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('student-assign-teacher','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{student_name}}</strong> - The student full name<br/>
                        <strong>{{school_name}}</strong> - School Name<br/>
                        <strong>{{teacher_name}}</strong> - Teacher Name<br/>
                    </span>
                </div> 
                <button name="save-student-assign-to-teacher-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Student Assign to Teacher Template End -->

            <!-- Student Assigned to Teacher Student Template Beginning -->
            <div onclick="displayRouteTable('class-student-assigned-to-teacher-student-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-student-assigned-to-teacher-student-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Student Assigned to Teacher Student Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-student-assigned-to-teacher-student-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('student-assigned-teacher','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('student-assigned-teacher','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{teacher_name}}</strong> - Teacher Name<br/>
                        <strong>{{school_name}}</strong> - Enter school name<br/>
                        <strong>{{student_name}}</strong> - Enter student name<br/>
                        <strong>{{class_name}}</strong> - Enter Class name<br/>
                    </span>
                </div> 
                <button name="save-student-assigned-to-teacher-student-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Student Assigned to Teacher Student Template End -->

            <!-- Attendance Absent Notification Template Beginning -->
            <div onclick="displayRouteTable('class-attendance-absent-notification-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-attendance-absent-notification-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Attendance Absent Notification Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-attendance-absent-notification-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('attendance-absent','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('attendance-absent','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{child_name}}</strong> - Enter name of child<br/>
                    	<strong>{{school_name}}</strong> - School Name<br/>
                    </span>
                </div> 
                <button name="save-attendance-absent-notification-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Attendance Absent Notification Template End -->

            <!-- Invoice Payment Template Beginning -->
            <div onclick="displayRouteTable('class-invoice-payment-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-invoice-payment-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Invoice Payment Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-invoice-payment-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('payment-invoice','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('payment-invoice','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{school_name}}</strong> - Enter school name<br/>
                        <strong>{{student_name}}</strong> - Enter student name<br/>
                        <strong>{{invoice_no}}</strong> - Enter Invoice No<br/>
                    </span>
                </div> 
                <button name="save-invoice-payment-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Invoice Payment Template End -->

            <!-- Notice Template Beginning -->
            <div onclick="displayRouteTable('class-notice-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-notice-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Notice Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-notice-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('notice','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('notice','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{notice_title}}</strong> - Enter notice title<br/>
                        <strong>{{notice_date}}</strong> - Enter notice date<br/>
                        <strong>{{notice_for}}</strong> - Enter role name for notice<br/>
                        <strong>{{notice_comment}}</strong> - Enter notice comment<br/>
                        <strong>{{school_name}}</strong> - School Name<br/>
                    </span>
                </div> 
                <button name="save-notice-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Notice Template End -->

            <!-- Holiday Template Beginning -->
            <div onclick="displayRouteTable('class-holiday-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-holiday-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Holiday Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-holiday-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('holiday','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('holiday','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{holiday_title}}</strong> - Enter holiday title<br/>
                        <strong>{{holiday_date}}</strong> - Enter holiday date<br/>
                        <strong>{{school_name}}</strong> - School Name<br/>
                    </span>
                </div> 
                <button name="save-holiday-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Holiday Template End -->

            <!-- School bus allocation Template Beginning -->
            <div onclick="displayRouteTable('class-school-bus-allocation-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-school-bus-allocation-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>School Bus Allocation Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-school-bus-allocation-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('school-bus','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('school-bus','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{route_name}}</strong> - Enter route name<br/>
                        <strong>{{vehicle_identifier}}</strong> - Enter Vehicle Identifier<br/>
                        <strong>{{vehicle_registration_number}}</strong> - Enter Vehicle Registration Number<br/>
                        <strong>{{driver_name}}</strong> - Enter Driver Name<br/>
                        <strong>{{driver_phone_number}}</strong> - Enter Driver Phone Number<br/>
                        <strong>{{driver_address}}</strong> - Enter Driver Address<br/>
                        <strong>{{school_name}}</strong> - Enter school name<br/>
                        <strong>{{route_fare}}</strong> - Enter route fare<br/>
                    </span>
                </div> 
                <button name="save-school-bus-allocation-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- School bus allocation Template End -->

            <!-- Hostel Bed Assigned Template Beginning -->
            <div onclick="displayRouteTable('class-hostel-bed-assigned-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-hostel-bed-assigned-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Hostel Bed Assigned Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-hostel-bed-assigned-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('hostel-bed','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('hostel-bed','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{student_name}}</strong> - The student full name<br/>
                        <strong>{{hostel_name}}</strong> - Hostel name<br/>
                        <strong>{{room_id}}</strong> - Room number<br/>
                        <strong>{{bed_id}}</strong> - Bed number<br/>
                        <strong>{{school_name}}</strong> - School name<br/>
                    </span>
                </div> 
                <button name="save-hostel-bed-assigned-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Hostel Bed Assigned Template End -->

            <!-- Assign Subject Template Beginning -->
            <div onclick="displayRouteTable('class-assign-subject-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-assign-subject-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Assign Subject Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-assign-subject-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('subject-assigned','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('subject-assigned','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{teacher_name}}</strong> - Teacher Name<br/>
                        <strong>{{subject_name}}</strong> - Subject Name<br/>
                        <strong>{{school_name}}</strong> - School name<br/>
                    </span>
                </div> 
                <button name="save-assign-subject-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Assign Subject Template End -->

            <!-- Issue book Template Beginning -->
            <div onclick="displayRouteTable('class-issue-book-mail-template');" style="text-align: left; cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-issue-book-mail-template-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                <span class="mobile-font-size-18 system-font-size-20"><strong>Issue Book Template</strong></span>
            </div>
            
            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-issue-book-mail-template container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                <form method="post" enctype="multipart/form-data">
                <div style="display: block; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-2 system-margin-right-2">
                    <input name="email-subject" type="text" value="<?php echo emailTemplateTableExist('issue-book','title','data'); ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Subject</span>
                </div>
                <div style="display: block; float: right; clear: right;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-10 system-margin-right-2">
                    <textarea style="height: 12rem; resize: none;" name="email-message" class="form-textarea" ><?php echo emailTemplateTableExist('issue-book','message','data'); ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject</span>
                </div><br>
                <div style="display: block; float: left; clear: left; text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
                    <span class="form-span mobile-font-size-14 system-font-size-16">
                        You can use following variables in the email template:<br/>
                        <strong>{{student_name}}</strong> - Student name<br/>
                        <strong>{{book_name}}</strong> - Book name<br/>
                        <strong>{{school_name}}</strong> - School name<br/>
                    </span>
                </div> 
                <button name="save-issue-book-mail-template" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>  
                </form>
            </div>
            <!-- Issue book Template End -->
    

    </center>
</div>

<script>
    function displayRouteTable(class_id){
        const allClass_slider = document.getElementsByClassName(class_id+"-slide-btn")[0];
        const allClass = document.getElementsByClassName(class_id);
            
        if(allClass[0].style.display == "none"){
            allClass_slider.setAttribute("class", class_id+"-slide-btn container-box color-2 bg-5 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1");
            for(i = 0; i < allClass.length; i++){
                allClass[i].style.display = "inline-block";
            }
        }else{
            allClass_slider.setAttribute("class", class_id+"-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1");
            for(i = 0; i < allClass.length; i++){
                allClass[i].style.display = "none";
            }
        }
    }

    function removeRouteSubject(subject_id,day_id,class_id,school_id){
        if(confirm("Do you want to delete this record?")){
            const classRouteHttpRequest = new XMLHttpRequest();
            classRouteHttpRequest.open("POST","./del-route.php");
            classRouteHttpRequest.setRequestHeader("Content-Type","application/json");
            const classRouteHttpRequestBody = JSON.stringify({sch_no: school_id, class_id_no: class_id, day: day_id, subject: subject_id});
            classRouteHttpRequest.onload = function(){
                if((classRouteHttpRequest.readyState == 4) && (classRouteHttpRequest.status == 200)){
                    const classRouteResponse = JSON.parse(classRouteHttpRequest.responseText)["response"];
                    if(classRouteResponse == 1){
                        alert("Success");
                        window.location.replace(window.location.href);
                    }else{
                        if(classRouteResponse == 2){
                            alert("Error");
                        }
                    }
                }else{
                    alert(classRouteHttpRequest.status);
                }
            }
            classRouteHttpRequest.send(classRouteHttpRequestBody);
        }else{
            alert("Operation cancelled");
        }
    }
</script>
    <?php }else{ include("include/no-data-img.php"); } ?>
<?php } ?>
<?php } ?>