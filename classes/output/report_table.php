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
 * Report table class.
 *
 * @package    report_myreports
 * @copyright  2019 Paul Holden (pholden@greenhead.ac.uk)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_myreports\output;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/searchlib.php');
require_once($CFG->libdir . '/tablelib.php');

/**
 * Report table class.
 *
 * @package    report_myreports
 * @copyright  2019 Paul Holden (pholden@greenhead.ac.uk)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class report_table extends \table_sql implements \renderable {

    /**
     * Constructor
     *
     * @param string $search
     */
    public function __construct(string $search) {
        parent::__construct('report-myreports-report-table');

        // Define columns.
        $columns = [
          
            'fullname'     => get_string('name'),
            'timemodified' => get_string('timemodified', 'report_myreports'),
        
         
        ];
        $this->define_columns(array_keys($columns));
        $this->define_headers(array_values($columns));
        $this->useridfield = 'userid';

        // Initialize table SQL properties.
        $this->init_sql();
    }

    /**
     * Initializes table SQL properties
     *
     * @return void
     */
        protected function init_sql() {
        global $DB;

        $userfields = get_all_user_name_fields(true, 'u');
        $fields = 'cl.id, cl.timemodified, cl.userid, ' . $userfields;

        $from = '{config_log} cl
            LEFT JOIN {user} u ON u.id = cl.userid';

        // Report search.
        $where = '1=1';
        $params = [];

        if (!empty($this->search)) {
            // Clean quotes, allow search by 'setting:' prefix.
            $searchstring = str_replace(["\\\"", 'setting:'], ["\"", 'subject:'], $this->search);

            $parser = new \search_parser();
            $lexer = new \search_lexer($parser);

            if ($lexer->parse($searchstring)) {
                $parsearray = $parser->get_parsed_array();

                // Data fields should contain both value/oldvalue.
                $datafields = $DB->sql_concat_join("':'", ['cl.value', 'cl.oldvalue']);
            }
        }
        $this->set_sql($fields, $from, $where, $params);
        $this->set_count_sql('SELECT COUNT(1) FROM ' . $from . ' WHERE ' . $where, $params);
    }

  


 



  
}