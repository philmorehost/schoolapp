<?php
// This file is for the SMS phone book for school admins.
?>
<?php
if (isset($_SESSION['feedback_message'])) {
    echo '<div class="feedback-message">' . htmlspecialchars($_SESSION['feedback_message']) . '</div>';
    unset($_SESSION['feedback_message']);
}
?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <div class="mobile-width-95 system-width-95 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">
            <?php if (!isset($_GET['tab']) || ($_GET['tab'] != 'add_external' && $_GET['tab'] != 'edit_external')) { ?>
                <div class="container-box bg-3 mobile-width-100 system-width-100 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                    <div class="mobile-width-90 system-width-90">
                        <div class="tab">
                            <button class="tablinks" onclick="openTab(event, 'Parents')" id="defaultOpen">Parents</button>
                            <button class="tablinks" onclick="openTab(event, 'External')">External</button>
                        </div>

                        <div id="Parents" class="tabcontent">
                            <h3>Parents</h3>
                            <table class="table-2">
                                <thead>
                                    <tr>
                                        <th>Father's Name</th>
                                        <th>Father's Phone</th>
                                        <th>Mother's Name</th>
                                        <th>Mother's Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $school_id = $get_logged_user_details['school_id_number'];
                                    $get_parents = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number = '$school_id'");
                                    if (mysqli_num_rows($get_parents) > 0) {
                                        while ($parent = mysqli_fetch_array($get_parents)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $parent['father_first_name'] . ' ' . $parent['father_last_name']; ?></td>
                                                <td><?php echo $parent['father_phone_number']; ?></td>
                                                <td><?php echo $parent['mother_first_name'] . ' ' . $parent['mother_last_name']; ?></td>
                                                <td><?php echo $parent['mother_phone_number']; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="4">No parents found.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div id="External" class="tabcontent">
                            <h3>External Contacts</h3>
                            <a href="/bc-admin.php?page=smgt_sms_phonebook&tab=add_external&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
                                <button class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16">
                                    Add External Contact
                                </button>
                            </a>
                            <table class="table-2">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $get_external_contacts = mysqli_query($connection_server, "SELECT * FROM sm_sms_phonebook WHERE school_id_number = '$school_id' AND is_parent = 0");
                                    if (mysqli_num_rows($get_external_contacts) > 0) {
                                        while ($contact = mysqli_fetch_array($get_external_contacts)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $contact['name']; ?></td>
                                                <td><?php echo $contact['phone_number']; ?></td>
                                                <td>
                                                    <a href="/bc-admin.php?page=smgt_sms_phonebook&tab=edit_external&id=<?php echo $get_logged_user_details['school_id_number']; ?>&contact_id=<?php echo $contact['id']; ?>">Edit</a>
                                                    <a href="/bc-admin.php?page=smgt_sms_phonebook&tab=delete_external&id=<?php echo $get_logged_user_details['school_id_number']; ?>&contact_id=<?php echo $contact['id']; ?>" onclick="return confirm('Are you sure you want to delete this contact?');">Delete</a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="3">No external contacts found.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } else if ($_GET['tab'] == 'add_external') { ?>
                <div class="container-box bg-3 mobile-width-100 system-width-100 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                    <div class="mobile-width-90 system-width-90">
                        <h3>Add External Contact</h3>
                        <form method="post" action="/bc-admin.php?page=smgt_sms_phonebook&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
                            <div class="form-group">
                                <input type="text" name="name" class="form-input" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone-number" class="form-input" placeholder="Phone Number" required>
                            </div>
                            <button type="submit" name="add-external-contact" class="button-box color-2 bg-4 onhover-bg-color-7">Add Contact</button>
                        </form>
                    </div>
                </div>
            <?php } else if ($_GET['tab'] == 'edit_external' && isset($_GET['contact_id'])) {
                $contact_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET['contact_id'])));
                $get_contact = mysqli_query($connection_server, "SELECT * FROM sm_sms_phonebook WHERE id = '$contact_id' AND school_id_number = '" . $get_logged_user_details['school_id_number'] . "'");
                if (mysqli_num_rows($get_contact) > 0) {
                    $contact = mysqli_fetch_array($get_contact);
            ?>
                    <div class="container-box bg-3 mobile-width-100 system-width-100 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                        <div class="mobile-width-90 system-width-90">
                            <h3>Edit External Contact</h3>
                            <form method="post" action="/bc-admin.php?page=smgt_sms_phonebook&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
                                <input type="hidden" name="contact-id" value="<?php echo $contact['id']; ?>">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-input" placeholder="Name" value="<?php echo $contact['name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="phone-number" class="form-input" placeholder="Phone Number" value="<?php echo $contact['phone_number']; ?>" required>
                                </div>
                                <button type="submit" name="edit-external-contact" class="button-box color-2 bg-4 onhover-bg-color-7">Update Contact</button>
                            </form>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </center>
</div>

<script>
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
