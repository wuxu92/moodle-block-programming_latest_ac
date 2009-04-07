<?php

include_once($CFG->dirroot.'/mod/programming/lib.php');
include_once($CFG->dirroot.'/lib/tablelib.php');

class block_programming_latest_ac extends block_base {

    function init() {
        $this->title = get_string('programminglatestac', 'block_programming_latest_ac');
        $this->version = 2007060201;

        $this->config->roleforlatestac = 5; // default role id of students
        $this->config->listhowmany = 15;
        $this->config->perpageonfulllist = 20;
    }

    function get_content() {
        global $CFG;

        if ($this->content != NULL) {
            return $this->content;
        }

        if (!isset($this->instance)) {
            return '';
        }
        $total = 0;
        $tops = programming_latest_ac($this->instance->pageid, $this->config->roleforlatestac, $total, 0, $this->config->listhowmany);
        $this->content = new stdClass;
        $c  = '<div id="block-programming-latest-ac">';
        $c .= '<table align="center" class="generaltable generalbox" cellpadding="3" cellspacing="1">';
        $c .= '<tr align="center">';
        $c .= '<th>'.get_string('who', 'block_programming_latest_ac').'</th>';
        $c .= '<th>'.get_string('which', 'block_programming_latest_ac').'</th>';
        $c .= '</tr>';
        if (is_array($tops)) {
            foreach ($tops as $t) {
                $c .= '<tr align="center">';
                $c .= '<td>';
                $c .= '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$t->user->id.'&amp;course='.$this->instance->pageid.'">'.fullname($t->user).'</a>';
                $c .= '</td>';
            
                $c .= '<td>'.$t->globalid.'</td>';
                $c .= '</tr>';
            }
        } else {
            $c .= '<tr><td colspan="3">';
            $c .= get_string('nosubmit', 'block_programming_latest_ac');
            $c .= '</td></tr>';
        }
        $c .= '</table>';
        $c .= '</div>';
        $this->content->text = $c;
        $this->content->footer = '<a href="'.$CFG->wwwroot.'/blocks/programming_latest_ac/fulllist.php?id='.$this->instance->id.'">'.get_string('more').'</a>';

        return $this->content;
    }

    function html_attribute() {
        return array('class' => 'sideblock block_'.$this->name);
    }

    function instance_allow_config() {
        return true;
    }
    
}

?>
