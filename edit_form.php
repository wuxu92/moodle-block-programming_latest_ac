<?php
 
class block_programming_latest_ac_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'listhowmany', get_string('showhowmanyonlist', 'block_programming_latest_ac'));
        $mform->addElement('text', 'perpageonfulllist', get_string('perpageonfulllist', 'block_programming_latest_ac'));
 
    }

    function set_data($defaults) {
        parent::set_data($defaults);

    }

}
