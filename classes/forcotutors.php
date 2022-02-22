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
 * The mod_forcotutors main class.
 *
 * @package   mod_forcotutors
 * @copyright 2022 Samuel Calegari <samuel.calegari@univ-perp.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forcotutors;

use renderable;
use renderer_base;
use templatable;
use context_course;
use stdClass;
use ArrayIterator;
use moodle_url;


/**
 * The mod_forcotutors main class.
 *
 * @package   mod_forcotutors
 * @copyright 2022 Samuel Calegari <samuel.calegari@univ-perp.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class forcotutors implements renderable, templatable {

    /**
     * @var int $course
     */
    private $course;

    /**
     * @var array $students
     */
    private $students = null;

    /**
     * Construct method.
     *
     * @param stdClass $forcotutorsinstance Some text to show how to pass data to a template.
     * @return void
     */
    public function __construct(stdClass $forcotutorsinstance) {
        $this->course = $forcotutorsinstance->course;
        $this->students = [];
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output The output renderer object.
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {

        $coursecontext = context_course::instance($this->course);
        $users = get_enrolled_users($coursecontext, 'moodle/course:isincompletionreports');

        foreach ($users  as $user ) {

            $now = time();
            $class= "";

            $url = get_config('forcotutors', 'mstatsurl') . '/autologin?full=1&email=' . urlencode($user->email) .'&username=' . urlencode($user->username);
            $days = get_config('forcotutors', 'days');
            $days2 = get_config('forcotutors', 'days2');

            $lastaccess = $user->lastaccess == 0 ? 'Non Connecté' : date("d/m/Y à H:i", $user->lastaccess);

            if($user->lastaccess < $now - ($days2*24*60*60))
                $class = 'table-danger';
            else if($user->lastaccess < $now - ($days*24*60*60))
                $class = 'table-warning';
            else
                $class = 'table-success';

            array_push($this->students,
                array(  'id'=>$user->id,
                        'firstname'=>$user->firstname,
                        'lastname'=>$user->lastname,
                        'email'=>$user->email,
                        'class'=>$class,
                        'url'=>$url,
                        'picture' => new moodle_url('/user/pix.php/'.$user->id.'/f2.jpg'),
                        'lastlogin'=> $lastaccess
                )
            );
        }

        $data['students'] = new ArrayIterator( $this->students );
        return $data;
    }
}
