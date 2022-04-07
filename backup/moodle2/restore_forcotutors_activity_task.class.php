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
 * Defines restore_forcotutors_activity_task class
 *
 * @package   mod_forcotutors
 * @copyright 2022 Samuel Calegari <samuel.calegari@univ-perp.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/forcotutors/backup/moodle2/restore_forcotutors_stepslib.php'); // Because it exists (must)

/**
 * forcotutors restore task that provides all the settings and steps to perform one complete restore of the activity
 *
 * @package   mod_forcotutors
 * @copyright 2022 Samuel Calegari <samuel.calegari@univ-perp.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_forcotutors_activity_task extends restore_activity_task {

    /**
     * Define (add) particular settings this activity can have
     */
    protected function define_my_settings() {
        // No particular settings for this activity
    }

    /**
     * Define (add) particular steps this activity can have
     */
    protected function define_my_steps() {
        // We have just one structure step here.
        $this->add_step(new restore_forcotutors_activity_structure_step('forcotutors_structure', 'forcotutors.xml'));
    }

    /**
     * Define the contents in the activity that must be
     * processed by the link decoder
     */
    static public function define_decode_contents() {
        $contents = array();
        return $contents;
    }

    /**
     * Define the decoding rules for links belonging
     * to the activity to be executed by the link decoder
     */
    static public function define_decode_rules() {
        $rules = array();

        $rules[] = new restore_decode_rule('FORCOTUTORSVIEWBYID', '/mod/forcotutors/view.php?id=$1', 'course_module');
        $rules[] = new restore_decode_rule('FORCOTUTORSINDEX', '/mod/forcotutors/index.php?id=$1', 'course');

        return $rules;

    }

    /**
     * Define the restore log rules that will be applied
     * when restoring forcotutors logs. It must return one array
     */
    static public function define_restore_log_rules() {
        $rules = array();

        $rules[] = new restore_log_rule('forcotutors', 'add', 'view.php?id={course_module}', '{forcotutors}');
        $rules[] = new restore_log_rule('forcotutors', 'update', 'view.php?id={course_module}', '{forcotutors}');
        $rules[] = new restore_log_rule('forcotutors', 'view', 'view.php?id={course_module}', '{forcotutors}');

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     * when restoring course logs. It must return one array
     *
     * Note this rules are applied when restoring course logs
     * by the restore final task, but are defined here at
     * activity level. All them are rules not linked to any module instance (cmid = 0)
     */
    static public function define_restore_log_rules_for_course() {
        $rules = array();

        $rules[] = new restore_log_rule('forcotutors', 'view all', 'index.php?id={course}', null);

        return $rules;
    }
}
