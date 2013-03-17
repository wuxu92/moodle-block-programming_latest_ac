<?php

class block_programming_latest_ac_renderer extends plugin_renderer_base {

    function ac_list($config, $course) {
        global $OUTPUT;

        $c = '';
        $total = 0;
        $tops = programming_latest_ac($course->instanceid, $config->roleforlatestac, $total, 0, $config->listhowmany);

        if (!empty($tops)) {
            $table = new html_table();
            $table->head = array(
                get_string('who', 'block_programming_latest_ac'),
                get_string('which', 'block_programming_latest_ac'));
            $table->data = array();

            foreach ($tops as $t) {
                $who = $OUTPUT->action_link(new moodle_url('/user/view.php', array('id' => $t->user->id, 'course' => $course->instanceid)), fullname($t->user));
                $which = $t->pname;
                $table->data[] = array($who, $which);
            }

            $c = html_writer::table($table);
        } else {
            $c = get_string('nosubmit', 'block_programming_latest_ac');
        }

        return $c;
    }

    function footer($config, $block, $course) {
        global $OUTPUT;

        $c =  html_writer::start_tag('p', array('class' => 'more'));
        $c .= $OUTPUT->action_link(new moodle_url('/blocks/programming_latest_ac/fulllist.php', array('id' => $block->instance->id, 'course' => $course->instanceid)), get_string('more'));
        $c .= html_writer::end_tag('p');

        return $c;
    }

}
