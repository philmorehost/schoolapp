<?php
$school_id = $get_logged_user_details['school_id_number'];

$is_admin = isset($_SESSION["mod_adm_session"]) || isset($_SESSION["adm_staff_session"]);
$is_teacher = isset($_SESSION["teacher_session"]);

$current_session = isset($_GET['session']) ? $_GET['session'] : '';
$current_class = isset($_GET['class']) ? $_GET['class'] : '';
$current_teacher = isset($_GET['teacher']) ? $_GET['teacher'] : '';

if ($is_teacher) {
    // For teachers, get their assigned classes
    $teacher_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE id_number='" . $_SESSION["teacher_session"] . "' LIMIT 1"));
    $school_id = $teacher_details["school_id_number"];
    $teacher_id = $teacher_details["id_number"];
    $teacher_classes_raw = trim($teacher_details["class"]);
    $teacher_classes = array_filter(explode("\n", $teacher_classes_raw));
} elseif ($is_admin) {
    $school_id = $get_logged_user_details["school_id_number"];
    if (!empty($current_teacher)) {
        // Admin has filtered by teacher
        $teacher_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE id_number='$current_teacher' AND school_id_number='$school_id' LIMIT 1"));
        $teacher_classes_raw = trim($teacher_details["class"]);
        $teacher_classes = array_filter(explode("\n", $teacher_classes_raw));
    } else {
        // Admin sees all classes
        $all_classes_query = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='$school_id' GROUP BY numeric_class_name");
        $teacher_classes = [];
        while($class = mysqli_fetch_assoc($all_classes_query)) {
            $teacher_classes[] = $class['numeric_class_name'];
        }
    }
} else {
    // No permission, or other roles
    $teacher_classes = [];
}

// If a specific class is filtered, narrow down the list of classes to loop through
if (!empty($current_class)) {
    // Ensure the selected class is one the user is allowed to see
    if (in_array($current_class, $teacher_classes)) {
        $teacher_classes = [$current_class];
    } else {
        // User might be trying to access a class they are not supposed to.
        // Or, if an admin filters by teacher, the class list changes.
        // For simplicity, if the class is not in the list, show nothing.
        $teacher_classes = [];
    }
}

// Get sessions for the dropdown
$sessions_query = mysqli_query($connection_server, "SELECT * FROM sm_sessions WHERE school_id_number='$school_id' ORDER BY session DESC");

// Get teachers for the dropdown (for admins)
if ($is_admin) {
    $teachers_query = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$school_id' ORDER BY lastname, firstname");
}
?>
<div class="container-box bg-2 mobile-width-100 system-width-100">
    <h2>My Students</h2>

    <form method="get" action="" class="filter-form" style="margin-bottom: 2em; padding: 1em; background: #f9f9f9; border-radius: 5px;">
        <input type="hidden" name="page" value="smgt_teacher_students">
        <input type="hidden" name="tab" value="true">
        <input type="hidden" name="id" value="<?= $school_id ?>">

        <?php if ($is_admin): ?>
            <select name="teacher" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                <option value="">-- Select Teacher --</option>
                <?php mysqli_data_seek($teachers_query, 0); ?>
                <?php while($teacher = mysqli_fetch_assoc($teachers_query)): ?>
                    <option value="<?= $teacher['id_number'] ?>" <?= ($current_teacher == $teacher['id_number']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($teacher['lastname'] . ' ' . $teacher['firstname']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        <?php endif; ?>

        <select name="class" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            <option value="">-- Select Class --</option>
            <?php foreach ($teacher_classes as $class_id):
                $class_name_row = mysqli_fetch_array(mysqli_query($connection_server, "SELECT class_name FROM sm_classes WHERE school_id_number='$school_id' AND numeric_class_name='$class_id' LIMIT 1"));
                $class_name = $class_name_row ? $class_name_row["class_name"] : $class_id;
            ?>
                <option value="<?= $class_id ?>" <?= ($current_class == $class_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($class_name) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="session" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            <option value="">-- Select Session --</option>
            <?php mysqli_data_seek($sessions_query, 0); ?>
            <?php while($session = mysqli_fetch_assoc($sessions_query)): ?>
                <option value="<?= $session['session'] ?>" <?= ($current_session == $session['session']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($session['session']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" style="padding: 8px 12px; border-radius: 4px; border: none; background-color: #4CAF50; color: white; cursor: pointer;">Filter</button>
    </form>

    <?php if (empty($teacher_classes)): ?>
        <p>You are not assigned to any class.</p>
    <?php else: ?>
        <?php foreach ($teacher_classes as $class): ?>
            <?php
                // Get class name (optional)
                $class_name_row = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='$school_id' AND numeric_class_name='$class' LIMIT 1"));
                $class_name = $class_name_row ? $class_name_row["class_name"] : $class;

                // Get students in this class for this teacher's school
                $student_sql = "SELECT * FROM sm_students WHERE school_id_number='$school_id' AND current_class='$class'";
                if (!empty($current_session)) {
                    $student_sql .= " AND session='" . mysqli_real_escape_string($connection_server, $current_session) . "'";
                }
                $students_query = mysqli_query($connection_server, $student_sql);
            ?>
            <div style="margin-bottom:2em;">
                <h3>Class: <?= htmlspecialchars($class_name) ?> (<?= htmlspecialchars($class) ?>)</h3>
                <table class="table-tag mobile-font-size-12 system-font-size-14" style="width:100%; margin-bottom:1em;">
                    <thead>
                        <tr>
                            <th>Admission No</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Session</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($students_query) > 0): ?>
                            <?php while ($student = mysqli_fetch_assoc($students_query)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student["admission_number"]) ?></td>
                                    <td><?= htmlspecialchars($student["lastname"] . ' ' . $student["firstname"] . ' ' . $student["othername"]) ?></td>
                                    <td><?= htmlspecialchars(ucwords($student["gender"])) ?></td>
                                    <td><?= htmlspecialchars($student["session"]) ?></td>
                                    <td><?= htmlspecialchars($student["email"]) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5">No students found for this class.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>