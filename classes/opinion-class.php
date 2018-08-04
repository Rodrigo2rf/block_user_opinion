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

/**
 * User Opinion block
 *
 * @package    block_user_opinion
 * @copyright  Rodrigo Reinaldo <rodrigo_2rf@hotmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class Opinion {

    private $id;
    private $userid;
    private $instance;
    private $grades;
    private $timecreated;
    private $message;
    private $shared;

    public function __construct( $id = NULL, $userid = NULL, $instance = NULL, $grades = NULL, $timecreated = NULL, $message = NULL, $shared = NULL ){
        $this->id = $id;
        $this->userid = $userid;
        $this->instance = $instance;
        $this->grades = $grades;
        $this->timecreated = $timecreated;
        $this->message = $message;
        $this->shared = $shared;
    }

    /**
     * 
     * @param 
     * @return 
     */
    function saveData($record){
        global $DB;
	    $return = $DB->insert_record('block_user_opinion_messages', $record);
	    if($return){
            return true;
	    }else{
	        return false;
	    }
    }

    /**
     * 
     * @param 
     * @return 
     */
    function edit_review($review){
        global $DB;
        $DB->update_record( "block_user_opinion_messages", $review );
    }

    /**
     * 
     * @param 
     * @return 
     */
    function check_answer($course, $user){
        global $DB;
        $return = $DB->get_records('block_user_opinion_messages', array('courseid' => $course, 'userid' => $user));
        if(!empty($return)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 
     * @param 
     * @return 
     */
    function get_all_can_shared(){
        global $DB;
        $sql = "SELECT bu.id, bu.timecreated, bu.message, 
        u.firstname || ' ' || u.lastname AS username, c.fullname AS curso FROM mdl_block_user_opinion_messages AS bu 
                INNER JOIN mdl_course AS c ON c.id = bu.courseid 
                INNER JOIN mdl_user AS u ON u.id = bu.userid
                WHERE bu.shared = 1";
        return $DB->get_records_sql($sql);
    }

    /**
     * 
     * @param 
     * @return 
     */
    function get_review_by_id($id){
        global $DB;
        $return = $DB->get_record('block_user_opinion_messages', array('id' => $id));
        return $return;
    }

}
