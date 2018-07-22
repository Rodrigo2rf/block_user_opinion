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
 * Block search forums renderer.
 *
 * @package    block_search_forums
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * User Opinion block
 *
 * @package    block_user_opinion
 * @copyright  Rodrigo Reinaldo <rodrigo_2rf@hotmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . "/rendererForm.php");

class Renderer extends RendererForm{

    /**
     * Render search form.
     *
     * @param renderable $searchform The search form.
     * @return string
     */
    public function renderer_list($list) {
        $output = '<table class="table table-hover">';
        $output .= '<tbody>';
          $i = 0;
          foreach($list as $key => $value){
            $i++;
            $output .= '<tr>';
              $output .= '<th>'.$i.'</th>';
              $output .= '<td><a href="?courseid='.$value->id.'">'.$value->fullname.'</a></td>';
              $output .= $value->config == 1 ? '<td><span class="label label-success">Instance configured</span></td>' : '<td><span class="label label-warning">Instance not configured</span></td>';
              $output .= $value->active == 1 ? '<td><span class="label label-success">Instance enabled</span></td>' : '<td><span class="label label-warning">Instance not enabled</span></td>';
              $output .= $value->count_submission >= 1 ? '<td><span class="label label-success">'.$value->count_submission.' submissions</span></td>' : '<td><span class="label label-warning">No submission</span></td>';
              $output .= '<td><a href="manage_reviews.php?courseid='.$value->id.'">Check reviews</a></td>';
            $output .= '</tr>';
          }
          $output .= '</tbody>';
        $output .= '</table>';
      return $output;
    }

    /**
     * Render search form.
     *
     * @param renderable $searchform The search form.
     * @return string
     */
    public function renderer_reviews_list($reviews){
      $output = '<table class="table table-hover">';
      $output .= '<tbody>';
        $i = 0;
        foreach($reviews as $key => $value){
          $i++;
          $output .= '<tr>';
            $output .= '<th>'.$i.'</th>';
            $output .= '<td>'.$value->username.'</td>';
            $output .= '<td>'.gmdate("d-m-Y", $value->timecreated ).'</td>';
            $output .= '<td>'.$value->grades.'</td>';
            $output .= '<td>'.$value->message.'</td>';
            $output .= $value->shared == 1 ? '<td><span class="label label-success">Shared</span></td>' : '<td><span class="label label-warning">Not share</span></td>';
            if( $value->shared == 1 ){ $option = 0; }else{ $option = 1; }
            $output .= '<td><a href="manage_reviews.php?courseid='.$value->courseid.'&reviewid='.$value->id.'&shared='.$option.'">Share</a></td>';
          $output .= '</tr>';
        }
        $output .= '</tbody>';
        $output .= '</table>';
      return $output;     
    }


    /**
     * Render search form.
     *
     * @param renderable $searchform The search form.
     * @return string
     */
    public function renderer_form() {

        global $CFG, $instance_by_course;

        $form = new rendererForm();
        if($fromform = $form->get_data()){

          $instance = new Instance();

          $record = new stdclass();
          if( $instance_by_course != NULL ){
            $record->id = $fromform->id;
          }
          $record->userid = $fromform->userid;
          $record->courseid = $fromform->courseid;
          $record->timeopen = $fromform->timeopen;
          $record->timefinish = $fromform->timefinish;

          if( $instance_by_course != NULL ){
            $instance->editData($record);
          }else{
            $instance->saveData($record);
          }

          redirect( $CFG->wwwroot . '/blocks/user_opinion/manage_instances.php?courseid='.$fromform->courseid, 'Data was successfully saved !!!', 2);

        }else{
          $form->display();
        }
    }

}