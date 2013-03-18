<?php

include_once($CFG->dirroot.'/mod/programming/lib.php');
include_once($CFG->dirroot.'/lib/tablelib.php');

class block_programming_latest_ac extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_programming_latest_ac');

    }

    function instance_allow_config() {
        return true;
    }

    function default_config() {
        if (empty($this->config)) {
            $this->config = new stdClass;
        }
        if (!isset($this->config->roleforlatestac)) {
            $this->config->roleforlatestac = 5; // default role id of students
        }

        if (!isset($this->config->listhowmany)) {
            $this->config->listhowmany = 15;
        }

        if (!isset($this->config->perpageonfulllist)) {
            $this->config->perpageonfulllist = 20;
        }
    }

    function get_content() {
        global $PAGE;

        if ($this->content != NULL) {
            return $this->content;
        }

        if (!isset($this->instance)) {
            return '';
        }

        $this->default_config();

        $course = $this->page->context;

        $renderer = $PAGE->get_renderer('block_programming_latest_ac');
        $this->content = new stdClass;
        $this->content->text = $renderer->ac_list($this->config, $course);
        $this->content->footer = $renderer->footer($this->config, $this, $course);

        return $this->content;
    }

    function html_attribute() {
        return array('class' => 'sideblock block_'.$this->name);
    }

}

?>
