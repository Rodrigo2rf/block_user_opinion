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

require_once(dirname(__FILE__) . "/output/renderer.php");

class Instance extends Renderer{

    private $id;
    private $userid;
    private $courseid;
    private $timeopen;
    private $timefinish;

    public function __construct( $id = NULL, $userid = NULL, $courseid = NULL, $timeopen = NULL, $timefinish = NULL ){
        $this->id = $id;
        $this->userid = $userid;
        $this->courseid = $courseid;
        $this->timeopen = $timeopen;
        $this->timefinish = $timefinish;
    }

    /**
     *
     * @param 
     * @return 
     */
    function get_instances() {
        global $DB;

        $hoje = time();
    
        $sql = "SELECT c.id, 
            CASE 
                WHEN ( SELECT id FROM mdl_block_user_opinion_config WHERE courseid = c.id )  >= 1 THEN 1
                ELSE 0
            END AS config,
            CASE 
                WHEN ( SELECT timeopen FROM mdl_block_user_opinion_config WHERE courseid = c.id ) <= $hoje AND 
                $hoje <= ( SELECT timefinish FROM mdl_block_user_opinion_config WHERE courseid = c.id ) THEN 1
                ELSE 0
            END AS active,
            CASE
                WHEN ( SELECT COUNT(*) FROM mdl_block_user_opinion_messages WHERE courseid = c.id  ) > 0 THEN 
                    ( SELECT COUNT(*) FROM mdl_block_user_opinion_messages WHERE courseid = c.id )
                ELSE 0
            END AS count_submission, c.fullname FROM mdl_course AS c
        WHERE c.id IN ( SELECT instanceid FROM mdl_context AS cx WHERE cx.id IN ( 
        SELECT parentcontextid FROM mdl_block_instances WHERE blockname = 'user_opinion' ))";

        return $DB->get_records_sql($sql);    
    }

    /**
     * 
     * @param 
     * @return 
     */
    function get_course_by_id( $courseid ){
        global $DB;
        $sql = "SELECT c.id, c.fullname FROM mdl_course AS c WHERE id = " . $courseid;
        return $DB->get_records_sql($sql);
    }

    /**
     * 
     * @param 
     * @return 
     */
    function get_instance_by_courseid( $courseid ){
        global $DB;
        $sql = "SELECT oc.*, c.id AS id_curso, c.fullname FROM mdl_block_user_opinion_config AS oc 
        INNER JOIN mdl_course AS c ON c.id = oc.courseid  
        WHERE courseid = " . $courseid;
        return $DB->get_record_sql($sql);
    }


    /**
     * 
     * @param 
     * @return 
     */
    function get_reviews($courseid){
        global $DB;
        $sql = "SELECT ROW_NUMBER() OVER (ORDER BY bu.id) AS indice, bu.id, bu.timecreated, bu.shared, bu.grades, bu.courseid, bu.userid, bu.message, u.firstname || ' ' || u.lastname AS username, c.fullname FROM mdl_block_user_opinion_messages AS bu 
        INNER JOIN mdl_course AS c ON c.id = bu.courseid 
        INNER JOIN mdl_user AS u ON u.id = bu.userid
        WHERE c.id = " . $courseid;
        return $DB->get_records_sql($sql);
    }


    /**
     * 
     * @param 
     * @return 
     */
    function saveData($instance){
        global $DB;
	    $return = $DB->insert_record('block_user_opinion_config', $instance);
	        
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
    function editData($instance){
        global $DB;
        $DB->update_record( "block_user_opinion_config", $instance );
    }

}