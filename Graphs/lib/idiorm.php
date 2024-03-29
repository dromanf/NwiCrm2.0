<?php


    class ORM {

        // ----------------------- //
        // --- CLASS CONSTANTS --- //
        // ----------------------- //

        // Where condition array keys
        const WHERE_FRAGMENT = 0;
        const WHERE_VALUES = 1;

        // ------------------------ //
        // --- CLASS PROPERTIES --- //
        // ------------------------ //

        // Class configuration
        protected static $_config = array(
            'connection_string' => 'sqlite::memory:',
            'id_column' => 'id',
            'id_column_overrides' => array(),
            'error_mode' => PDO::ERRMODE_EXCEPTION,
            'username' => null,
            'password' => null,
            'driver_options' => null,
            'identifier_quote_character' => null, // if this is null, will be autodetected
            'logging' => true,
            'caching' => false,
        );

        // Database connection, instance of the PDO class
        protected static $_db;

        // Last query run, only populated if logging is enabled
        protected static $_last_query;

        // Log of all queries run, only populated if logging is enabled
        protected static $_query_log = array();

        // Query cache, only used if query caching is enabled
        protected static $_query_cache = array();

        // --------------------------- //
        // --- INSTANCE PROPERTIES --- //
        // --------------------------- //

        // The name of the table the current ORM instance is associated with
        protected $_table_name;

        // Alias for the table to be used in SELECT queries
        protected $_table_alias = null;

        // Values to be bound to the query
        protected $_values = array();

        // Columns to select in the result
        protected $_result_columns = array('*');

        // Are we using the default result column or have these been manually changed?
        protected $_using_default_result_columns = true;

        // Join sources
        protected $_join_sources = array();

        // Should the query include a DISTINCT keyword?
        protected $_distinct = false;

        // Is this a raw query?
        protected $_is_raw_query = false;

        // The raw query
        protected $_raw_query = '';

        // The raw query parameters
        protected $_raw_parameters = array();

        // Array of WHERE clauses
        protected $_where_conditions = array();

        // LIMIT
        protected $_limit = null;

        // OFFSET
        protected $_offset = null;

        // ORDER BY
        protected $_order_by = array();

        // GROUP BY
        protected $_group_by = array();

        // The data for a hydrated instance of the class
        protected $_data = array();

        // Fields that have been modified during the
        // lifetime of the object
        protected $_dirty_fields = array();

        // Fields that are to be inserted in the DB raw
        protected $_expr_fields = array();

        // Is this a new object (has create() been called)?
        protected $_is_new = false;

        // Name of the column to use as the primary key for
        // this instance only. Overrides the config settings.
        protected $_instance_id_column = null;


        public static function configure($key, $value=null) {
            if (is_array($key)) {
                // Shortcut: If only one array argument is passed,
                // assume it's an array of configuration settings
                foreach ($key as $conf_key => $conf_value) {
                    self::configure($conf_key, $conf_value);
                }
            } else {
                if (is_null($value)) {
                    // Shortcut: If only one string argument is passed, 
                    // assume it's a connection string
                    $value = $key;
                    $key = 'connection_string';
                }
                self::$_config[$key] = $value;
            }
        }


        public static function for_table($table_name) {
            self::_setup_db();
            return new self($table_name);
        }

   
        protected static function _setup_db() {
            if (!is_object(self::$_db)) {
                $connection_string = self::$_config['connection_string'];
                $username = self::$_config['username'];
                $password = self::$_config['password'];
                $driver_options = self::$_config['driver_options'];
                $db = new PDO($connection_string, $username, $password, $driver_options);
                $db->setAttribute(PDO::ATTR_ERRMODE, self::$_config['error_mode']);
                self::set_db($db);
            }
        }


        public static function set_db($db) {
            self::$_db = $db;
            self::_setup_identifier_quote_character();
        }


        public static function _setup_identifier_quote_character() {
            if (is_null(self::$_config['identifier_quote_character'])) {
                self::$_config['identifier_quote_character'] = self::_detect_identifier_quote_character();
            }
        }

        /**
         * Return the correct character used to quote identifiers (table
         * names, column names etc) by looking at the driver being used by PDO.
         */
        protected static function _detect_identifier_quote_character() {
            switch(self::$_db->getAttribute(PDO::ATTR_DRIVER_NAME)) {
                case 'pgsql':
                case 'sqlsrv':
                case 'dblib':
                case 'mssql':
                case 'sybase':
                    return '"';
                case 'mysql':
                case 'sqlite':
                case 'sqlite2':
                default:
                    return '`';
            }
        }

        /**
         * Returns the PDO instance used by the the ORM to communicate with
         * the database. This can be called if any low-level DB access is
         * required outside the class.
         */
        public static function get_db() {
            self::_setup_db(); // required in case this is called before Idiorm is instantiated
            return self::$_db;
        }

        /**
         * Add a query to the internal query log. Only works if the
         * 'logging' config option is set to true.
         *
         * This works by manually binding the parameters to the query - the
         * query isn't executed like this (PDO normally passes the query and
         * parameters to the database which takes care of the binding) but
         * doing it this way makes the logged queries more readable.
         */
        protected static function _log_query($query, $parameters) {
            // If logging is not enabled, do nothing
            if (!self::$_config['logging']) {
                return false;
            }

            if (count($parameters) > 0) {
                // Escape the parameters
                $parameters = array_map(array(self::$_db, 'quote'), $parameters);

                // Avoid %format collision for vsprintf
                $query = str_replace("%", "%%", $query);

                // Replace placeholders in the query for vsprintf
                if(false !== strpos($query, "'") || false !== strpos($query, '"')) {
                    $query = IdiormString::str_replace_outside_quotes("?", "%s", $query);
                } else {
                    $query = str_replace("?", "%s", $query);
                }

                // Replace the question marks in the query with the parameters
                $bound_query = vsprintf($query, $parameters);
            } else {
                $bound_query = $query;
            }

            self::$_last_query = $bound_query;
            self::$_query_log[] = $bound_query;
            return true;
        }

        /**
         * Get the last query executed. Only works if the
         * 'logging' config option is set to true. Otherwise
         * this will return null.
         */
        public static function get_last_query() {
            return self::$_last_query;
        }

        /**
         * Get an array containing all the queries run up to
         * now. Only works if the 'logging' config option is
         * set to true. Otherwise returned array will be empty.
         */
        public static function get_query_log() {
            return self::$_query_log;
        }

        // ------------------------ //
        // --- INSTANCE METHODS --- //
        // ------------------------ //

        /**
         * "Private" constructor; shouldn't be called directly.
         * Use the ORM::for_table factory method instead.
         */
        protected function __construct($table_name, $data=array()) {
            $this->_table_name = $table_name;
            $this->_data = $data;
        }

        /**
         * Create a new, empty instance of the class. Used
         * to add a new row to your database. May optionally
         * be passed an associative array of data to populate
         * the instance. If so, all fields will be flagged as
         * dirty so all will be saved to the database when
         * save() is called.
         */
        public function create($data=null) {
            $this->_is_new = true;
            if (!is_null($data)) {
                return $this->hydrate($data)->force_all_dirty();
            }
            return $this;
        }

        /**
         * Specify the ID column to use for this instance or array of instances only.
         * This overrides the id_column and id_column_overrides settings.
         *
         * This is mostly useful for libraries built on top of Idiorm, and will
         * not normally be used in manually built queries. If you don't know why
         * you would want to use this, you should probably just ignore it.
         */
        public function use_id_column($id_column) {
            $this->_instance_id_column = $id_column;
            return $this;
        }

        /**
         * Create an ORM instance from the given row (an associative
         * array of data fetched from the database)
         */
        protected function _create_instance_from_row($row) {
            $instance = self::for_table($this->_table_name);
            $instance->use_id_column($this->_instance_id_column);
            $instance->hydrate($row);
            return $instance;
        }

        /**
         * Tell the ORM that you are expecting a single result
         * back from your query, and execute it. Will return
         * a single instance of the ORM class, or false if no
         * rows were returned.
         * As a shortcut, you may supply an ID as a parameter
         * to this method. This will perform a primary key
         * lookup on the table.
         */
        public function find_one($id=null) {
            if (!is_null($id)) {
                $this->where_id_is($id);
            }
            $this->limit(1);
            $rows = $this->_run();

            if (empty($rows)) {
                return false;
            }

            return $this->_create_instance_from_row($rows[0]);
        }

        /**
         * Tell the ORM that you are expecting multiple results
         * from your query, and execute it. Will return an array
         * of instances of the ORM class, or an empty array if
         * no rows were returned.
         */
        public function find_many() {
            $rows = $this->_run();
            return array_map(array($this, '_create_instance_from_row'), $rows);
        }

        /**
         * Tell the ORM that you are expecting multiple results
         * from your query, and execute it. Will return an array,
         * or an empty array if no rows were returned.
         * @return array
         */
        public function find_array() {
            return $this->_run(); 
        }

        /**
         * Tell the ORM that you wish to execute a COUNT query.
         * Will return an integer representing the number of
         * rows returned.
         */
        public function count($column = '*') {
            return $this->_call_aggregate_db_function(__FUNCTION__, $column);
        }

        /**
         * Tell the ORM that you wish to execute a MAX query.
         * Will return the max value of the choosen column.
         */
        public function max($column)  {
            return $this->_call_aggregate_db_function(__FUNCTION__, $column);
        }

        /**
         * Tell the ORM that you wish to execute a MIN query.
         * Will return the min value of the choosen column.
         */
        public function min($column)  {
            return $this->_call_aggregate_db_function(__FUNCTION__, $column);
        }

        /**
         * Tell the ORM that you wish to execute a AVG query.
         * Will return the average value of the choosen column.
         */
        public function avg($column)  {
            return $this->_call_aggregate_db_function(__FUNCTION__, $column);
        }

        /**
         * Tell the ORM that you wish to execute a SUM query.
         * Will return the sum of the choosen column.
         */
        public function sum($column)  {
            return $this->_call_aggregate_db_function(__FUNCTION__, $column);
        }

        /**
         * Execute an aggregate query on the current connection.
         * @param string $sql_function The aggregate function to call eg. MIN, COUNT, etc
         * @param string $column The column to execute the aggregate query against
         * @return int
         */
        protected function _call_aggregate_db_function($sql_function, $column) {
            $alias = strtolower($sql_function);
            $sql_function = strtoupper($sql_function);
            if('*' != $column) {
                $column = $this->_quote_identifier($column);
            }
            $this->select_expr("$sql_function($column)", $alias);
            $result = $this->find_one();
            return ($result !== false && isset($result->$alias)) ? (int) $result->$alias : 0;
        }

         /**
         * This method can be called to hydrate (populate) this
         * instance of the class from an associative array of data.
         * This will usually be called only from inside the class,
         * but it's public in case you need to call it directly.
         */
        public function hydrate($data=array()) {
            $this->_data = $data;
            return $this;
        }

        /**
         * Force the ORM to flag all the fields in the $data array
         * as "dirty" and therefore update them when save() is called.
         */
        public function force_all_dirty() {
            $this->_dirty_fields = $this->_data;
            return $this;
        }

        /**
         * Perform a raw query. The query can contain placeholders in
         * either named or question mark style. If placeholders are
         * used, the parameters should be an array of values which will
         * be bound to the placeholders in the query. If this method
         * is called, all other query building methods will be ignored.
         */
        public function raw_query($query, $parameters = array()) {
            $this->_is_raw_query = true;
            $this->_raw_query = $query;
            $this->_raw_parameters = $parameters;
            return $this;
        }

        /**
         * Add an alias for the main table to be used in SELECT queries
         */
        public function table_alias($alias) {
            $this->_table_alias = $alias;
            return $this;
        }

        /**
         * Internal method to add an unquoted expression to the set
         * of columns returned by the SELECT query. The second optional
         * argument is the alias to return the expression as.
         */
        protected function _add_result_column($expr, $alias=null) {
            if (!is_null($alias)) {
                $expr .= " AS " . $this->_quote_identifier($alias);
            }

            if ($this->_using_default_result_columns) {
                $this->_result_columns = array($expr);
                $this->_using_default_result_columns = false;
            } else {
                $this->_result_columns[] = $expr;
            }
            return $this;
        }

        /**
         * Add a column to the list of columns returned by the SELECT
         * query. This defaults to '*'. The second optional argument is
         * the alias to return the column as.
         */
        public function select($column, $alias=null) {
            $column = $this->_quote_identifier($column);
            return $this->_add_result_column($column, $alias);
        }

        /**
         * Add an unquoted expression to the list of columns returned
         * by the SELECT query. The second optional argument is
         * the alias to return the column as.
         */
        public function select_expr($expr, $alias=null) {
            return $this->_add_result_column($expr, $alias);
        }

        /**
         * Add columns to the list of columns returned by the SELECT
         * query. This defaults to '*'. Many columns can be supplied
         * as either an array or as a list of parameters to the method.
         * 
         * Note that the alias must not be numeric - if you want a
         * numeric alias then prepend it with some alpha chars. eg. a1
         * 
         * @example select_many(array('alias' => 'column', 'column2', 'alias2' => 'column3'), 'column4', 'column5');
         * @example select_many('column', 'column2', 'column3');
         * @example select_many(array('column', 'column2', 'column3'), 'column4', 'column5');
         * 
         * @return \ORM
         */
        public function select_many() {
            $columns = func_get_args();
            if(!empty($columns)) {
                $columns = $this->_normalise_select_many_columns($columns);
                foreach($columns as $alias => $column) {
                    if(is_numeric($alias)) {
                        $alias = null;
                    }
                    $this->select($column, $alias);
                }
            }
            return $this;
        }

        /**
         * Add an unquoted expression to the list of columns returned
         * by the SELECT query. Many columns can be supplied as either 
         * an array or as a list of parameters to the method.
         * 
         * Note that the alias must not be numeric - if you want a
         * numeric alias then prepend it with some alpha chars. eg. a1
         * 
         * @example select_many_expr(array('alias' => 'column', 'column2', 'alias2' => 'column3'), 'column4', 'column5')
         * @example select_many_expr('column', 'column2', 'column3')
         * @example select_many_expr(array('column', 'column2', 'column3'), 'column4', 'column5')
         * 
         * @return \ORM
         */
        public function select_many_expr() {
            $columns = func_get_args();
            if(!empty($columns)) {
                $columns = $this->_normalise_select_many_columns($columns);
                foreach($columns as $alias => $column) {
                    if(is_numeric($alias)) {
                        $alias = null;
                    }
                    $this->select_expr($column, $alias);
                }
            }
            return $this;
        }

        /**
         * Take a column specification for the select many methods and convert it
         * into a normalised array of columns and aliases.
         * 
         * It is designed to turn the following styles into a normalised array:
         * 
         * array(array('alias' => 'column', 'column2', 'alias2' => 'column3'), 'column4', 'column5'))
         * 
         * @param array $columns
         * @return array
         */
        protected function _normalise_select_many_columns($columns) {
            $return = array();
            foreach($columns as $column) {
                if(is_array($column)) {
                    foreach($column as $key => $value) {
                        if(!is_numeric($key)) {
                            $return[$key] = $value;
                        } else {
                            $return[] = $value;
                        }
                    }
                } else {
                    $return[] = $column;
                }
            }
            return $return;
        }

        /**
         * Add a DISTINCT keyword before the list of columns in the SELECT query
         */
        public function distinct() {
            $this->_distinct = true;
            return $this;
        }

        /**
         * Internal method to add a JOIN source to the query.
         *
         * The join_operator should be one of INNER, LEFT OUTER, CROSS etc - this
         * will be prepended to JOIN.
         *
         * The table should be the name of the table to join to.
         *
         * The constraint may be either a string or an array with three elements. If it
         * is a string, it will be compiled into the query as-is, with no escaping. The
         * recommended way to supply the constraint is as an array with three elements:
         *
         * first_column, operator, second_column
         *
         * Example: array('user.id', '=', 'profile.user_id')
         *
         * will compile to
         *
         * ON `user`.`id` = `profile`.`user_id`
         *
         * The final (optional) argument specifies an alias for the joined table.
         */
        protected function _add_join_source($join_operator, $table, $constraint, $table_alias=null) {

            $join_operator = trim("{$join_operator} JOIN");

            $table = $this->_quote_identifier($table);

            // Add table alias if present
            if (!is_null($table_alias)) {
                $table_alias = $this->_quote_identifier($table_alias);
                $table .= " {$table_alias}";
            }

            // Build the constraint
            if (is_array($constraint)) {
                list($first_column, $operator, $second_column) = $constraint;
                $first_column = $this->_quote_identifier($first_column);
                $second_column = $this->_quote_identifier($second_column);
                $constraint = "{$first_column} {$operator} {$second_column}";
            }

            $this->_join_sources[] = "{$join_operator} {$table} ON {$constraint}";
            return $this;
        }

        /**
         * Add a simple JOIN source to the query
         */
        public function join($table, $constraint, $table_alias=null) {
            return $this->_add_join_source("", $table, $constraint, $table_alias);
        }

        /**
         * Add an INNER JOIN souce to the query
         */
        public function inner_join($table, $constraint, $table_alias=null) {
            return $this->_add_join_source("INNER", $table, $constraint, $table_alias);
        }

        /**
         * Add a LEFT OUTER JOIN souce to the query
         */
        public function left_outer_join($table, $constraint, $table_alias=null) {
            return $this->_add_join_source("LEFT OUTER", $table, $constraint, $table_alias);
        }

        /**
         * Add an RIGHT OUTER JOIN souce to the query
         */
        public function right_outer_join($table, $constraint, $table_alias=null) {
            return $this->_add_join_source("RIGHT OUTER", $table, $constraint, $table_alias);
        }

        /**
         * Add an FULL OUTER JOIN souce to the query
         */
        public function full_outer_join($table, $constraint, $table_alias=null) {
            return $this->_add_join_source("FULL OUTER", $table, $constraint, $table_alias);
        }

        /**
         * Internal method to add a WHERE condition to the query
         */
        protected function _add_where($fragment, $values=array()) {
            if (!is_array($values)) {
                $values = array($values);
            }
            $this->_where_conditions[] = array(
                self::WHERE_FRAGMENT => $fragment,
                self::WHERE_VALUES => $values,
            );
            return $this;
        }

        /**
         * Helper method to compile a simple COLUMN SEPARATOR VALUE
         * style WHERE condition into a string and value ready to
         * be passed to the _add_where method. Avoids duplication
         * of the call to _quote_identifier
         */
        protected function _add_simple_where($column_name, $separator, $value) {
            // Add the table name in case of ambiguous columns
            if (count($this->_join_sources) > 0 && strpos($column_name, '.') === false) {
                $column_name = "{$this->_table_name}.{$column_name}";
            }
            $column_name = $this->_quote_identifier($column_name);
            return $this->_add_where("{$column_name} {$separator} ?", $value);
        }

        /**
         * Return a string containing the given number of question marks,
         * separated by commas. Eg "?, ?, ?"
         */
        protected function _create_placeholders($fields) {
            if(!empty($fields)) {
                $db_fields = array();
                foreach($fields as $key => $value) {
                    // Process expression fields directly into the query
                    if(array_key_exists($key, $this->_expr_fields)) {
                        $db_fields[] = $value;
                    } else {
                        $db_fields[] = '?';
                    }
                }
                return implode(', ', $db_fields);
            }
        }

        /**
         * Add a WHERE column = value clause to your query. Each time
         * this is called in the chain, an additional WHERE will be
         * added, and these will be ANDed together when the final query
         * is built.
         */
        public function where($column_name, $value) {
            return $this->where_equal($column_name, $value);
        }

        /**
         * More explicitly named version of for the where() method.
         * Can be used if preferred.
         */
        public function where_equal($column_name, $value) {
            return $this->_add_simple_where($column_name, '=', $value);
        }

        /**
         * Add a WHERE column != value clause to your query.
         */
        public function where_not_equal($column_name, $value) {
            return $this->_add_simple_where($column_name, '!=', $value);
        }

        /**
         * Special method to query the table by its primary key
         */
        public function where_id_is($id) {
            return $this->where($this->_get_id_column_name(), $id);
        }

        /**
         * Add a WHERE ... LIKE clause to your query.
         */
        public function where_like($column_name, $value) {
            return $this->_add_simple_where($column_name, 'LIKE', $value);
        }

        /**
         * Add where WHERE ... NOT LIKE clause to your query.
         */
        public function where_not_like($column_name, $value) {
            return $this->_add_simple_where($column_name, 'NOT LIKE', $value);
        }

        /**
         * Add a WHERE ... > clause to your query
         */
        public function where_gt($column_name, $value) {
            return $this->_add_simple_where($column_name, '>', $value);
        }

        /**
         * Add a WHERE ... < clause to your query
         */
        public function where_lt($column_name, $value) {
            return $this->_add_simple_where($column_name, '<', $value);
        }

        /**
         * Add a WHERE ... >= clause to your query
         */
        public function where_gte($column_name, $value) {
            return $this->_add_simple_where($column_name, '>=', $value);
        }

        /**
         * Add a WHERE ... <= clause to your query
         */
        public function where_lte($column_name, $value) {
            return $this->_add_simple_where($column_name, '<=', $value);
        }

        /**
         * Add a WHERE ... IN clause to your query
         */
        public function where_in($column_name, $values) {
            $column_name = $this->_quote_identifier($column_name);
            $placeholders = $this->_create_placeholders($values);
            return $this->_add_where("{$column_name} IN ({$placeholders})", $values);
        }

        /**
         * Add a WHERE ... NOT IN clause to your query
         */
        public function where_not_in($column_name, $values) {
            $column_name = $this->_quote_identifier($column_name);
            $placeholders = $this->_create_placeholders($values);
            return $this->_add_where("{$column_name} NOT IN ({$placeholders})", $values);
        }

        /**
         * Add a WHERE column IS NULL clause to your query
         */
        public function where_null($column_name) {
            $column_name = $this->_quote_identifier($column_name);
            return $this->_add_where("{$column_name} IS NULL");
        }

        /**
         * Add a WHERE column IS NOT NULL clause to your query
         */
        public function where_not_null($column_name) {
            $column_name = $this->_quote_identifier($column_name);
            return $this->_add_where("{$column_name} IS NOT NULL");
        }

        /**
         * Add a raw WHERE clause to the query. The clause should
         * contain question mark placeholders, which will be bound
         * to the parameters supplied in the second argument.
         */
        public function where_raw($clause, $parameters=array()) {
            return $this->_add_where($clause, $parameters);
        }

        /**
         * Add a LIMIT to the query
         */
        public function limit($limit) {
            $this->_limit = $limit;
            return $this;
        }

        /**
         * Add an OFFSET to the query
         */
        public function offset($offset) {
            $this->_offset = $offset;
            return $this;
        }

        /**
         * Add an ORDER BY clause to the query
         */
        protected function _add_order_by($column_name, $ordering) {
            $column_name = $this->_quote_identifier($column_name);
            $this->_order_by[] = "{$column_name} {$ordering}";
            return $this;
        }

        /**
         * Add an ORDER BY column DESC clause
         */
        public function order_by_desc($column_name) {
            return $this->_add_order_by($column_name, 'DESC');
        }

        /**
         * Add an ORDER BY column ASC clause
         */
        public function order_by_asc($column_name) {
            return $this->_add_order_by($column_name, 'ASC');
        }

        /**
         * Add an unquoted expression as an ORDER BY clause
         */
        public function order_by_expr($clause) {
            $this->_order_by[] = $clause;
            return $this;
        }

        /**
         * Add a column to the list of columns to GROUP BY
         */
        public function group_by($column_name) {
            $column_name = $this->_quote_identifier($column_name);
            $this->_group_by[] = $column_name;
            return $this;
        }

        /**
         * Add an unquoted expression to the list of columns to GROUP BY 
         */
        public function group_by_expr($expr) {
            $this->_group_by[] = $expr;
            return $this;
        }

        /**
         * Build a SELECT statement based on the clauses that have
         * been passed to this instance by chaining method calls.
         */
        protected function _build_select() {
            // If the query is raw, just set the $this->_values to be
            // the raw query parameters and return the raw query
            if ($this->_is_raw_query) {
                $this->_values = $this->_raw_parameters;
                return $this->_raw_query;
            }

            // Build and return the full SELECT statement by concatenating
            // the results of calling each separate builder method.
            return $this->_join_if_not_empty(" ", array(
                $this->_build_select_start(),
                $this->_build_join(),
                $this->_build_where(),
                $this->_build_group_by(),
                $this->_build_order_by(),
                $this->_build_limit(),
                $this->_build_offset(),
            ));
        }

        /**
         * Build the start of the SELECT statement
         */
        protected function _build_select_start() {
            $result_columns = join(', ', $this->_result_columns);

            if ($this->_distinct) {
                $result_columns = 'DISTINCT ' . $result_columns;
            }

            $fragment = "SELECT {$result_columns} FROM " . $this->_quote_identifier($this->_table_name);

            if (!is_null($this->_table_alias)) {
                $fragment .= " " . $this->_quote_identifier($this->_table_alias);
            }
            return $fragment;
        }

        /**
         * Build the JOIN sources
         */
        protected function _build_join() {
            if (count($this->_join_sources) === 0) {
                return '';
            }

            return join(" ", $this->_join_sources);
        }

        /**
         * Build the WHERE clause(s)
         */
        protected function _build_where() {
            // If there are no WHERE clauses, return empty string
            if (count($this->_where_conditions) === 0) {
                return '';
            }

            $where_conditions = array();
            foreach ($this->_where_conditions as $condition) {
                $where_conditions[] = $condition[self::WHERE_FRAGMENT];
                $this->_values = array_merge($this->_values, $condition[self::WHERE_VALUES]);
            }

            return "WHERE " . join(" AND ", $where_conditions);
        }

        /**
         * Build GROUP BY
         */
        protected function _build_group_by() {
            if (count($this->_group_by) === 0) {
                return '';
            }
            return "GROUP BY " . join(", ", $this->_group_by);
        }

        /**
         * Build ORDER BY
         */
        protected function _build_order_by() {
            if (count($this->_order_by) === 0) {
                return '';
            }
            return "ORDER BY " . join(", ", $this->_order_by);
        }

        /**
         * Build LIMIT
         */
        protected function _build_limit() {
            if (!is_null($this->_limit)) {
                return "LIMIT " . $this->_limit;
            }
            return '';
        }

        /**
         * Build OFFSET
         */
        protected function _build_offset() {
            if (!is_null($this->_offset)) {
                return "OFFSET " . $this->_offset;
            }
            return '';
        }

        /**
         * Wrapper around PHP's join function which
         * only adds the pieces if they are not empty.
         */
        protected function _join_if_not_empty($glue, $pieces) {
            $filtered_pieces = array();
            foreach ($pieces as $piece) {
                if (is_string($piece)) {
                    $piece = trim($piece);
                }
                if (!empty($piece)) {
                    $filtered_pieces[] = $piece;
                }
            }
            return join($glue, $filtered_pieces);
        }

        /**
         * Quote a string that is used as an identifier
         * (table names, column names etc). This method can
         * also deal with dot-separated identifiers eg table.column
         */
        protected function _quote_identifier($identifier) {
            $parts = explode('.', $identifier);
            $parts = array_map(array($this, '_quote_identifier_part'), $parts);
            return join('.', $parts);
        }

        /**
         * This method performs the actual quoting of a single
         * part of an identifier, using the identifier quote
         * character specified in the config (or autodetected).
         */
        protected function _quote_identifier_part($part) {
            if ($part === '*') {
                return $part;
            }
            $quote_character = self::$_config['identifier_quote_character'];
            return $quote_character . $part . $quote_character;
        }

        /**
         * Create a cache key for the given query and parameters.
         */
        protected static function _create_cache_key($query, $parameters) {
            $parameter_string = join(',', $parameters);
            $key = $query . ':' . $parameter_string;
            return sha1($key);
        }

        /**
         * Check the query cache for the given cache key. If a value
         * is cached for the key, return the value. Otherwise, return false.
         */
        protected static function _check_query_cache($cache_key) {
            if (isset(self::$_query_cache[$cache_key])) {
                return self::$_query_cache[$cache_key];
            }
            return false;
        }

        /**
         * Clear the query cache
         */
        public static function clear_cache() {
            self::$_query_cache = array();
        }

        /**
         * Add the given value to the query cache.
         */
        protected static function _cache_query_result($cache_key, $value) {
            self::$_query_cache[$cache_key] = $value;
        }

        /**
         * Execute the SELECT query that has been built up by chaining methods
         * on this class. Return an array of rows as associative arrays.
         */
        protected function _run() {
            $query = $this->_build_select();
            $caching_enabled = self::$_config['caching'];

            if ($caching_enabled) {
                $cache_key = self::_create_cache_key($query, $this->_values);
                $cached_result = self::_check_query_cache($cache_key);

                if ($cached_result !== false) {
                    return $cached_result;
                }
            }

            self::_log_query($query, $this->_values);
            $statement = self::$_db->prepare($query);
            $statement->execute($this->_values);

            $rows = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $rows[] = $row;
            }

            if ($caching_enabled) {
                self::_cache_query_result($cache_key, $rows);
            }

            return $rows;
        }

        /**
         * Return the raw data wrapped by this ORM
         * instance as an associative array. Column
         * names may optionally be supplied as arguments,
         * if so, only those keys will be returned.
         */
        public function as_array() {
            if (func_num_args() === 0) {
                return $this->_data;
            }
            $args = func_get_args();
            return array_intersect_key($this->_data, array_flip($args));
        }

        /**
         * Return the value of a property of this object (database row)
         * or null if not present.
         */
        public function get($key) {
            return isset($this->_data[$key]) ? $this->_data[$key] : null;
        }

        /**
         * Return the name of the column in the database table which contains
         * the primary key ID of the row.
         */
        protected function _get_id_column_name() {
            if (!is_null($this->_instance_id_column)) {
                return $this->_instance_id_column;
            }
            if (isset(self::$_config['id_column_overrides'][$this->_table_name])) {
                return self::$_config['id_column_overrides'][$this->_table_name];
            } else {
                return self::$_config['id_column'];
            }
        }

        /**
         * Get the primary key ID of this object.
         */
        public function id() {
            return $this->get($this->_get_id_column_name());
        }

        /**
         * Set a property to a particular value on this object.
         * To set multiple properties at once, pass an associative array
         * as the first parameter and leave out the second parameter.
         * Flags the properties as 'dirty' so they will be saved to the
         * database when save() is called.
         */
        public function set($key, $value = null) {
            $this->_set_orm_property($key, $value);
        }

        public function set_expr($key, $value = null) {
            $this->_set_orm_property($key, $value, true);
        }

        /**
         * Set a property on the ORM object.
         * @param string|array $key
         * @param string|null $value
         * @param bool $raw Whether this value should be treated as raw or not
         */
        protected function _set_orm_property($key, $value = null, $expr = false) {
            if (!is_array($key)) {
                $key = array($key => $value);
            }
            foreach ($key as $field => $value) {
                $this->_data[$field] = $value;
                $this->_dirty_fields[$field] = $value;
                if (false === $expr and isset($this->_expr_fields[$field])) {
                    unset($this->_expr_fields[$field]);
                } else if (true === $expr) {
                    $this->_expr_fields[$field] = true;
                }
            }
        }

        /**
         * Check whether the given field has been changed since this
         * object was saved.
         */
        public function is_dirty($key) {
            return isset($this->_dirty_fields[$key]);
        }

        /**
         * Save any fields which have been modified on this object
         * to the database.
         */
        public function save() {
            $query = array();

            // remove any expression fields as they are already baked into the query
            $values = array_values(array_diff_key($this->_dirty_fields, $this->_expr_fields));

            if (!$this->_is_new) { // UPDATE
                // If there are no dirty values, do nothing
                if (count($values) == 0) {
                    return true;
                }
                $query = $this->_build_update();
                $values[] = $this->id();
            } else { // INSERT
                $query = $this->_build_insert();
            }

            self::_log_query($query, $values);
            $statement = self::$_db->prepare($query);
            $success = $statement->execute($values);

            // If we've just inserted a new record, set the ID of this object
            if ($this->_is_new) {
                $this->_is_new = false;
                if (is_null($this->id())) {
                    $this->_data[$this->_get_id_column_name()] = self::$_db->lastInsertId();
                }
            }

            $this->_dirty_fields = array();
            return $success;
        }

        /**
         * Build an UPDATE query
         */
        protected function _build_update() {
            $query = array();
            $query[] = "UPDATE {$this->_quote_identifier($this->_table_name)} SET";

            $field_list = array();
            foreach ($this->_dirty_fields as $key => $value) {
                if(!array_key_exists($key, $this->_expr_fields)) {
                    $value = '?';
                }
                $field_list[] = "{$this->_quote_identifier($key)} = $value";
            }
            $query[] = join(", ", $field_list);
            $query[] = "WHERE";
            $query[] = $this->_quote_identifier($this->_get_id_column_name());
            $query[] = "= ?";
            return join(" ", $query);
        }

        /**
         * Build an INSERT query
         */
        protected function _build_insert() {
            $query[] = "INSERT INTO";
            $query[] = $this->_quote_identifier($this->_table_name);
            $field_list = array_map(array($this, '_quote_identifier'), array_keys($this->_dirty_fields));
            $query[] = "(" . join(", ", $field_list) . ")";
            $query[] = "VALUES";

            $placeholders = $this->_create_placeholders($this->_dirty_fields);
            $query[] = "({$placeholders})";
            return join(" ", $query);
        }

        /**
         * Delete this record from the database
         */
        public function delete() {
            $query = join(" ", array(
                "DELETE FROM",
                $this->_quote_identifier($this->_table_name),
                "WHERE",
                $this->_quote_identifier($this->_get_id_column_name()),
                "= ?",
            ));
            $params = array($this->id());
            self::_log_query($query, $params);
            $statement = self::$_db->prepare($query);
            return $statement->execute($params);
        }

        /**
         * Delete many records from the database
         */
        public function delete_many() {
            // Build and return the full DELETE statement by concatenating
            // the results of calling each separate builder method.
            $query = $this->_join_if_not_empty(" ", array(
                "DELETE FROM",
                $this->_quote_identifier($this->_table_name),
                $this->_build_where(),
            ));
            $statement = self::$_db->prepare($query);
            return $statement->execute($this->_values);
        }

        // --------------------- //
        // --- MAGIC METHODS --- //
        // --------------------- //
        public function __get($key) {
            return $this->get($key);
        }

        public function __set($key, $value) {
            $this->set($key, $value);
        }

        public function __unset($key) {
            unset($this->_data[$key]);
            unset($this->_dirty_fields[$key]);
        }


        public function __isset($key) {
            return isset($this->_data[$key]);
        }
    }

    /**
     * A class to handle str_replace operations that involve quoted strings
     * @example IdiormString::str_replace_outside_quotes('?', '%s', 'columnA = "Hello?" AND columnB = ?');
     * @example IdiormString::value('columnA = "Hello?" AND columnB = ?')->replace_outside_quotes('?', '%s');
     * @author Jeff Roberson <ridgerunner@fluxbb.org>
     * @author Simon Holywell <treffynnon@php.net>
     * @link http://stackoverflow.com/a/13370709/461813 StackOverflow answer
     */
    class IdiormString {
        protected $subject;
        protected $search;
        protected $replace;

        /**
         * Get an easy to use instance of the class
         * @param string $subject
         * @return \self
         */
        public static function value($subject) {
            return new self($subject);
        }

        /**
         * Shortcut method: Replace all occurrences of the search string with the replacement
         * string where they appear outside quotes.
         * @param string $search
         * @param string $replace
         * @param string $subject
         * @return string
         */
        public static function str_replace_outside_quotes($search, $replace, $subject) {
            return self::value($subject)->replace_outside_quotes($search, $replace);
        }

        /**
         * Set the base string object
         * @param string $subject
         */
        public function __construct($subject) {
            $this->subject = (string) $subject;
        }

        /**
         * Replace all occurrences of the search string with the replacement
         * string where they appear outside quotes
         * @param string $search
         * @param string $replace
         * @return string
         */
        public function replace_outside_quotes($search, $replace) {
            $this->search = $search;
            $this->replace = $replace;
            return $this->_str_replace_outside_quotes();
        }

        /**
         * Validate an input string and perform a replace on all ocurrences
         * of $this->search with $this->replace
         * @author Jeff Roberson <ridgerunner@fluxbb.org>
         * @link http://stackoverflow.com/a/13370709/461813 StackOverflow answer
         * @return string
         */
        protected function _str_replace_outside_quotes(){
            $re_valid = '/
                # Validate string having embedded quoted substrings.
                ^                           # Anchor to start of string.
                (?:                         # Zero or more string chunks.
                  "[^"\\\\]*(?:\\\\.[^"\\\\]*)*"  # Either a double quoted chunk,
                | \'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'  # or a single quoted chunk,
                | [^\'"\\\\]+               # or an unquoted chunk (no escapes).
                )*                          # Zero or more string chunks.
                \z                          # Anchor to end of string.
                /sx';
            if (!preg_match($re_valid, $this->subject)) {
                throw new IdiormStringException("Subject string is not valid in the replace_outside_quotes context.");
            }
            $re_parse = '/
                # Match one chunk of a valid string having embedded quoted substrings.
                  (                         # Either $1: Quoted chunk.
                    "[^"\\\\]*(?:\\\\.[^"\\\\]*)*"  # Either a double quoted chunk,
                  | \'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'  # or a single quoted chunk.
                  )                         # End $1: Quoted chunk.
                | ([^\'"\\\\]+)             # or $2: an unquoted chunk (no escapes).
                /sx';
            return preg_replace_callback($re_parse, array($this, '_str_replace_outside_quotes_cb'), $this->subject);
        }

        /**
         * Process each matching chunk from preg_replace_callback replacing
         * each occurrence of $this->search with $this->replace
         * @author Jeff Roberson <ridgerunner@fluxbb.org>
         * @link http://stackoverflow.com/a/13370709/461813 StackOverflow answer
         * @param array $matches
         * @return string
         */
        protected function _str_replace_outside_quotes_cb($matches) {
            // Return quoted string chunks (in group $1) unaltered.
            if ($matches[1]) return $matches[1];
            // Process only unquoted chunks (in group $2).
            return preg_replace('/'. preg_quote($this->search, '/') .'/',
                $this->replace, $matches[2]);
        }
    }

    /**
     * A placeholder for exceptions eminating from the IdiormString class
     */
    class IdiormStringException extends Exception {}