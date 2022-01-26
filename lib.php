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
 * Library of interface functions and constants for module forcotutors
 *
 * @package   mod_forcotutors
 * @copyright 2022 Samuel Calegari <samuel.calegari@univ-perp.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $forcotutors An object from the form in mod_form.php
 * @return int The id of the newly inserted forcotutors record
 */
function forcotutors_add_instance($forcotutors) {
    global $DB;

    $forcotutors->timecreated = time();

    return $DB->insert_record('forcotutors', $forcotutors);
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param object $forcotutors An object from the form in mod_form.php
 * @return boolean Success/Fail
 */
function forcotutors_update_instance($forcotutors) {
    global $DB;

    $forcotutors->timemodified = time();
    $forcotutors->id = $forcotutors->instance;

    return $DB->update_record('forcotutors', $forcotutors);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function forcotutors_delete_instance($id) {
    global $DB;

    if (! $forcotutors = $DB->get_record('forcotutors', array('id' => $id))) {
        return false;
    }

    // Delete any dependent records here.

    $DB->delete_records('forcotutors', array('id' => $forcotutors->id));

    return true;
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @return boolean
 **/
function forcotutors_cron () {
    return true;
}

/**
 * Execute post-uninstall custom actions for the module
 * This function was added in 1.9
 *
 * @return boolean true if success, false on error
 */
function forcotutors_uninstall() {
    return true;
}
