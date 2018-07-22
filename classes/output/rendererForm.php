<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

/**
 * User Opinion block
 *
 * @package    block_user_opinion
 * @copyright  Rodrigo Reinaldo <rodrigo_2rf@hotmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

    require_once("$CFG->libdir/formslib.php");

    class rendererForm extends moodleform {
        
        // Add elements to form
        public function definition() {

            global $CFG, $USER, $instance_by_course;

            $courseid = optional_param('courseid', NULL, PARAM_INT);
            $mform = $this->_form;

            if( $instance_by_course != NULL ){
                $mform->addElement('hidden', 'id', $instance_by_course->id);
                $mform->setType('id', PARAM_INT);  
            }
         
            $mform->addElement('hidden', 'userid', $USER->id);
            $mform->setType('userid', PARAM_INT);  

            $mform->addElement('hidden', 'courseid', $courseid);
            $mform->setType('courseid', PARAM_INT);  

            $mform->addElement('date_selector', 'timeopen', 'Open'); 
            if( $instance_by_course != NULL ){
                $mform->setDefault( 'timeopen', $instance_by_course->timeopen );
            }
            
            $mform->addElement('date_selector', 'timefinish', 'Finish'); 
            if( $instance_by_course != NULL ){
                $mform->setDefault( 'timefinish', $instance_by_course->timefinish );
            }
            
            $mform->addElement('static', 'Finish', '', 'Start date can not be greater than end date*');
             
            // button
            $this->add_action_buttons(true, 'Save');
        }
    }

    //