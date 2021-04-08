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
 * Config changes report
 *
 * @package    report
 * @subpackage myreports
 * @copyright  2009 Petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');

// Allow searching by setting when providing parameter directly.

admin_externalpage_setup('reportmyreports');

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('configlog', 'report_myreports'));


$searchclauses = [];
$table = new \report_myreports\output\report_table(implode(' ', $searchclauses));
$table->define_baseurl($PAGE->url);

echo $PAGE->get_renderer('report_myreports')->render($table);
