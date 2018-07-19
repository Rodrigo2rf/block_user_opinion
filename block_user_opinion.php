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
 * User Opinion block caps.
 *
 * @package    block_user_opinion
 * @copyright  Rodrigo Reinaldo <rodrigo_2rf@hotmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_user_opinion extends block_list{

    function init() {
        $this->title = get_string('pluginname', 'block_user_opinion');
    }
  
    function get_content() {
        global $CFG, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }
        
        $this->content = new stdClass;
        $this->content->items = array();
        $this->content->footer = '';

        $course = $this->page->course;
        $context_sys = context_system::instance();

        if( has_capability('block/user_opinion:manager', $context_sys) ) {

            $this->content->items[] = html_writer::tag('a', get_string('managereviews', 'block_user_opinion'), array('href' => $CFG->wwwroot.'/blocks/user_opinion/manage_reviews.php'));

            $this->content->items[] = html_writer::tag('a', get_string('manageinstances', 'block_user_opinion'), array('href' => $CFG->wwwroot.'/blocks/user_opinion/manage_instances.php'));

        }

        $this->content->items[] = html_writer::tag('a', get_string('searchavailable', 'block_user_opinion'), array('href' => $CFG->wwwroot.'/blocks/user_opinion/search_available.php'));

        // return $course;

        return $this->content;
    }

    public function applicable_formats() {
        return array('all' => false, 'course-view' => true );
    }

    public function instance_allow_multiple() {
          return false;
    }

    function has_config() {return true;}

}