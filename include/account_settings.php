<?php
if (($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")) {
    ?>
    <?php if (strip_tags($_GET['page']) == 'smgt_user_settings') { ?>
        <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
            <center>
                <?php
                $edit_user_checkmate = mysqli_query($connection_server, "SELECT * FROM " . $user_account_table_name_auth . " WHERE school_id_number='" . $get_logged_user_details['school_id_number'] . "' " . $user_account_table_id_auth);
                if ((isset($_GET['id'])) && (trim(strip_tags($_GET['id'])) !== "") && (mysqli_num_rows($edit_user_checkmate) == 1)) {
                    if (mysqli_num_rows($edit_user_checkmate) == 1) {
                        $edit_user_detail = mysqli_fetch_array($edit_user_checkmate);
                    }
                }
                ?>
                <?php if ((isset($_GET['id'])) && (trim(strip_tags($_GET['id'])) !== "") && (mysqli_num_rows($edit_user_checkmate) == 1)) { ?>
                    <form method="post" enctype="multipart/form-data">

                        <?php if (!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))) { ?>
                            <div style="display: inline-block;"
                                class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
                                <?php echo $err_msg; ?>
                            </div>
                        <?php } ?>

                        <div style="text-align: left;"
                            class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                            ACCOUNT INFORMATION
                        </div>

                        <div
                            class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <?php if (file_exists("dataimg/" . $user_profile_photo_auth[0])) { ?>
                                <input name="photo" type="file" class="form-file-chooser" />
                            <?php } else { ?>
                                <input name="photo" type="file" class="form-file-chooser" required />
                            <?php } ?>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Profile Picture</span>
                        </div>

                        <div
                            class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <input name="home-address" value="<?php echo $edit_user_detail['home_address']; ?>" type="text"
                                placeholder="" class="form-input" required />
                            <span class="form-span mobile-font-size-12 system-font-size-14">Home Address*</span>
                        </div>

                        <div style="text-align: left;"
                            class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                            ACCOUNT PASSWORD [AUTHENTICATION]
                        </div>

                        <div style="float: left; clear: both;"
                            class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                            <input name="acc-pass-auth" type="password" pattern="[a-zA-Z0-9]{8,}"
                                title="Password must be Alphanumeric and not less than 8 character (No Special Character)"
                                placeholder="" class="form-input" required />
                            <span class="form-span mobile-font-size-12 system-font-size-14">Password*</span>
                        </div>

                        <?php if (file_exists("dataimg/" . $user_profile_photo_auth[0])) { ?>
                            <img style="float: left; clear: both;" src="dataimg/<?php echo $user_profile_photo_auth[0]; ?>"
                                class="mobile-width-30 system-width-10 mobile-margin-left-5 system-margin-left-3" /><br>
                        <?php } else { ?>
                            <img style="float: left; clear: both;" src="imgfile/<?php echo $user_profile_photo_auth[1]; ?>"
                                class="mobile-width-30 system-width-10 mobile-margin-left-5 system-margin-left-3" /><br>
                        <?php } ?>
                        <button style="float: left; clear: both;" name="update-user" type="submit"
                            class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                            UPDATE ACCOUNT
                        </button>
                    </form>
                <?php } ?>

            </center>
        </div>
    <?php } ?>
<?php } ?>

<?php
if (($user_identifier_auth_id == "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")) {
    ?>
    <?php if (strip_tags($_GET['page']) == 'smgt_admin_settings') { ?>
        <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
            <center>
                <?php
                $sup_admin_email = $_SESSION["sup_adm_session"];
                $edit_user_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_super_moderators WHERE email = '$sup_admin_email'");
                if (mysqli_num_rows($edit_user_checkmate) == 1) {
                    $edit_user_detail = mysqli_fetch_array($edit_user_checkmate);
                }
                ?>
                <?php if (mysqli_num_rows($edit_user_checkmate) == 1) { ?>
                    <form method="post" enctype="multipart/form-data">

                        <?php if (!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))) { ?>
                            <div style="display: inline-block;"
                                class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
                                <?php echo $err_msg; ?>
                            </div>
                        <?php } ?>
                        <?php
                        if (isset($_SESSION["super_rec_vericode"])) {
                            $admin_first_name = $_SESSION['super_fname'];
                            $admin_last_name = $_SESSION['super_lname'];
                            $admin_email = $_SESSION['super_email'];
                            $admin_home_address = $_SESSION['super_address'];
                            $admin_gender = $_SESSION['super_gender'];

                        } else {
                            $admin_first_name = $edit_user_detail['firstname'];
                            $admin_last_name = $edit_user_detail['lastname'];
                            $admin_email = $edit_user_detail['email'];
                            $admin_home_address = $edit_user_detail['home_address'];
                            $admin_gender = $edit_user_detail['gender'];

                        }
                        ?>
                        <div style="text-align: left;"
                            class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                            ACCOUNT INFORMATION
                        </div>

                        <div
                            class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <input name="fname" value="<?php echo $admin_first_name; ?>" type="text" placeholder=""
                                class="form-input" required />
                            <span class="form-span mobile-font-size-12 system-font-size-14">Firstname*</span>
                        </div>

                        <div
                            class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <input name="lname" value="<?php echo $admin_last_name; ?>" type="text" placeholder=""
                                class="form-input" required />
                            <span class="form-span mobile-font-size-12 system-font-size-14">Lastname*</span>
                        </div>

                        <div
                            class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <input name="email" value="<?php echo $admin_email; ?>" type="text" placeholder="" class="form-input"
                                required />
                            <span class="form-span mobile-font-size-12 system-font-size-14">Email*</span>
                        </div>

                        <div
                            class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <input name="home-address" value="<?php echo $admin_home_address; ?>" type="text" placeholder=""
                                class="form-input" required />
                            <span class="form-span mobile-font-size-12 system-font-size-14">Home Address*</span>
                        </div>

                        <div style="float: left; clear: both;"
                            class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                            <select name="gender" class="form-select" required>
                                <option disabled hidden selected value="">Select Gender</option>
                                <option value="male" <?php if ($admin_gender == "male") {
                                    echo 'selected';
                                } ?>>Male</option>
                                <option value="female" <?php if ($admin_gender == "female") {
                                    echo 'selected';
                                } ?>>Female</option>
                            </select>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Gender*</span>
                        </div>

                        <?php if (isset($_SESSION["super_rec_vericode"])) { ?>
                            <div style="text-align: left; float: left; clear: both;"
                                class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                                EMAIL VERIFICATION CODE [AUTHENTICATION]
                            </div>

                            <div style="float: left; clear: both;"
                                class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                                <input name="acc-update-pin" type="text" pattern="[0-9]{6}" title="Verification code must be six digits"
                                    placeholder="" class="form-input" required />
                                <span class="form-span mobile-font-size-12 system-font-size-14">Verification Code*</span>
                            </div>
                        <?php } ?>

                        <button style="float: left; clear: both;" name="update-admin" type="submit"
                            class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                            UPDATE ACCOUNT
                        </button>
                    </form>

                    <?php if (isset($_SESSION["super_rec_vericode"])) { ?>
                        <form method="post" enctype="multipart/form-data">
                            <button style="float: left; clear: both;" name="reset-admin-update" type="submit"
                                class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                                RESET
                            </button>
                        </form>
                    <?php } ?>
                <?php } ?>

            </center>
        </div>
    <?php } ?>
<?php } ?>