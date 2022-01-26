<?php

/**
 * The mod_forcotutors settings.
 *
 * @package   mod_forcotutors
 * @copyright 2022 Samuel Calegari <samuel.calegari@univ-perp.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_configtext('forcotutors/mstatsurl', get_string('mstatsurl', 'forcotutors'),
        get_string('configmstatsurl', 'forcotutors'), '', PARAM_URL));

    $settings->add(new admin_setting_configtext('forcotutors/days', get_string('days', 'forcotutors'),
        get_string('configdays', 'forcotutors'), 7, PARAM_INT));

    $settings->add(new admin_setting_configtext('forcotutors/days2', get_string('days2', 'forcotutors'),
        get_string('configdays2', 'forcotutors'), 30, PARAM_INT));
}
