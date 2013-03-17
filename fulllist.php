<?php

    include_once('../../config.php');
    include_once('../../mod/programming/lib.php');
    include_once('../../lib/tablelib.php');

    require_login();

    $id = required_param('id', PARAM_INT);    // Block ID
    $courseid = required_param('course', PARAM_INT);    // Course ID
    $page = optional_param('page', 0, PARAM_INT);

    if (!$course = $DB->get_record('course', array('id' => $courseid))) {
        print_error('course misconfigured');
    }

    $instance = $DB->get_record('block_instances', array('id' => $id));
    $block = block_instance('programming_latest_ac', $instance);
    $block->default_config();
    $blockcontext = get_context_instance(CONTEXT_BLOCK, $id);

    $perpage = $block->config->perpageonfulllist;

    $params = array('id' => $id, 'course' => $courseid, 'page' => $page, 'perpage' => $perpage);

    require_login($course->id, true);
    $context = get_context_instance(CONTEXT_COURSE, $courseid);
    $PAGE->set_course($course);
    $PAGE->set_url('/mod/programming/view.php', $params);

/// Print the page header
    $PAGE->set_heading(format_string($course->fullname));
    echo $OUTPUT->header();

/// Print the main part of the page
    $offset = $perpage * $page;
    $tops = programming_latest_ac($courseid, $block->config->roleforlatestac, $totalcount, $offset, $perpage);

    $c = html_writer::start_tag('h1');
    $c .= get_string('pluginname', 'block_programming_latest_ac');
    $c .= html_writer::end_tag('h1');

    $table = new flexible_table('programming-latest-ac');
    $table->define_columns(array('number', 'user', 'name', 'time'));
    $table->define_headers(array(
        get_string('no.', 'block_programming_latest_ac'),
        get_string('who', 'block_programming_latest_ac'),
        get_string('which', 'block_programming_latest_ac'),
        get_string('submittime', 'block_programming_latest_ac'),
    ));
    $table->set_attribute('cellspacing', '1');
    $table->set_attribute('cellpadding', '3');
    $table->set_attribute('id', 'programming-latest-ac');
    $table->set_attribute('class', 'generaltable generalbox');
    $table->set_attribute('align', 'center');
    $table->define_baseurl(new moodle_url('/blocks/programming_latest_ac/fulllist.php', $params));
    $table->pagesize($perpage, $totalcount);
    $table->setup();

    $i = $totalcount - $page * $perpage;
    if ($tops) {
        foreach ($tops as $t) {
            $table->add_data(array(
                $i--,
                has_capability('block/programming_latest_ac:view', $context) ? $OUTPUT->action_link(new moodle_url('/user/view.php', array('id' => $t->user->id, 'course' => $course->id)), fullname($t->user)) : '???',
                $OUTPUT->action_link(new moodle_url('/mod/programming/view.php', array('pid' => $t->pid)), $t->pname),
                userdate($t->timemodified, '%Y-%m-%d %H:%M:%S'),
            ));
        }
    }

    $table->print_html();

/// Finish the page
    echo $OUTPUT->footer($course);
?>
