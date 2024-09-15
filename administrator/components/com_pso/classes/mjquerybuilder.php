<?php
/**
 * Page Speed Optimizer extension
 * https://www.mobilejoomla.com/
 *
 * @version    1.4.2
 * @license    GNU/GPL v2 - http://www.gnu.org/licenses/gpl-2.0.html
 * @copyright  (C) 2022-2024 Denis Ryabov
 * @date       June 2024
 */
defined('_JEXEC') or die('Restricted access');

class MjQueryBuilder
{
    /** @var JDatabaseDriver */
    protected $dbo;
    /** @var JDatabaseQuery */
    protected $query;
    /** @var int */
    protected $_limit = 0;

    /**
     * @param JDatabaseDriver $dbo
     */
    public function __construct($dbo)
    {
        $this->dbo = $dbo;
        $this->query = $dbo->getQuery(true);
    }

    /**
     * @param string $name
     * @return string
     */
    public function qn($name)
    {
        return $this->query->quoteName($name);
    }

    /**
     * @param string $value
     * @return string
     */
    public function q($value)
    {
        return $this->dbo->quote($value);
    }

    /**
     * @param string $columns,...
     * @return $this
     */
    public function select($columns)
    {
        foreach (func_get_args() as $column) {
            $this->query->select(strpbrk($column, ' (') === false ? $this->qn($column) : $column);
        }
        return $this;
    }

    /**
     * @param string $table
     * @return $this
     */
    public function delete($table = null)
    {
        $this->query->delete($table);
        return $this;
    }

    /**
     * @param string|array $tables
     * @return $this
     */
    public function insert($tables)
    {
        $this->query->insert($tables);
        return $this;
    }

    /**
     * @param string $table
     * @return $this
     */
    public function update($table)
    {
        $this->query->update(strpos($table, ' ') === false ? $this->qn($table) : $table);
        return $this;
    }

    /**
     * @param string $tables,...
     * @return $this
     */
    public function from($tables)
    {
        foreach (func_get_args() as $table) {
            $this->query->from(strpos($table, ' ') === false ? $this->qn($table) : $table);
        }
        return $this;
    }

    /**
     * @param string $type
     * @param string $conditions
     * @return $this
     */
    public function join($type, $conditions)
    {
        $this->query->join($type, $conditions);
        return $this;
    }

    /**
     * @param string|array $conditions
     * @return $this
     */
    public function innerJoin($conditions)
    {
        return $this->join('INNER', $conditions);
    }

    /**
     * @param string|array $conditions
     * @return $this
     */
    public function outerJoin($conditions)
    {
        return $this->join('OUTER', $conditions);
    }

    /**
     * @param string|array $conditions
     * @return $this
     */
    public function leftJoin($conditions)
    {
        return $this->join('LEFT', $conditions);
    }

    /**
     * @param string|array $conditions
     * @return $this
     */
    public function rightJoin($conditions)
    {
        return $this->join('RIGHT', $conditions);
    }

    /**
     * @param string|array $conditions
     * @param string $glue
     * @return $this
     */
    public function set($conditions, $glue = ',')
    {
        $this->query->set($conditions, $glue);
        return $this;
    }

    /**
     * @param string|array $conditions
     * @param string $glue
     * @return $this
     */
    public function where($conditions, $glue = 'AND')
    {
        $this->query->where($conditions, $glue);
        return $this;
    }

    /**
     * @param string $columns,...
     * @return $this
     */
    public function group($columns)
    {
        foreach (func_get_args() as $column) {
            $this->query->group(strpos($column, ' ') === false ? $this->qn($column) : $column);
        }
        return $this;
    }

    /**
     * @param string|array $conditions
     * @param string $glue
     * @return $this
     */
    public function having($conditions, $glue = 'AND')
    {
        $this->query->having($conditions, $glue);
        return $this;
    }

    /**
     * @param string $columns,...
     * @return $this
     */
    public function order($columns)
    {
        foreach (func_get_args() as $column) {
            $this->query->order(strpos($column, ' ') === false ? $this->qn($column) : $column);
        }
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->_limit = $limit;
        return $this;
    }

    /**
     * @param string $tables,...
     * @return void
     */
    public function dropTable($tables)
    {
        foreach (func_get_args() as $table) {
            $this->dbo->dropTable($table);
        }
    }

    /**
     * @param string $old
     * @param string $new
     * @return void
     */
    public function renameTable($old, $new)
    {
        $this->dbo->renameTable($old, $new);
    }

    /**
     * @param string $tableName
     * @param array $columns
     * @param array $indices
     * @param array $extra
     * @return void
     */
    public function createTable($tableName, $columns, $indices = array(), $extra = array())
    {
        $config = version_compare(JVERSION, '4.0', '>=') ? MJFactory::getApplication() : JFactory::getConfig();
        $driver = $config->get('dbtype', 'mysql');

        switch ($driver) {
            case 'mysql':
            case 'mysqli':
            case 'pdomysql':
            case 'jdiction_mysqli':
                $this->createTableMysql($tableName, $columns, $indices, $extra);
                break;

            case 'postgresql':
            case 'pgsql':
                $this->createTablePostgresql($tableName, $columns, $indices, $extra);
                break;
            default:
                throw new Exception('Unsupported database driver');
        }
    }

    /** @return void */
    public function execute()
    {
        $this->dbo->setQuery((string)$this->query, 0, $this->_limit);
        $this->dbo->execute();
    }

    /**
     * @return mixed
     */
    public function loadResult()
    {
        $this->dbo->setQuery((string)$this->query, 0, $this->_limit);
        return $this->dbo->loadResult();
    }

    /**
     * @return ?stdClass
     */
    public function loadObject()
    {
        $this->dbo->setQuery((string)$this->query, 0, $this->_limit);
        return $this->dbo->loadObject();
    }

    /**
     * @param string $key
     * @return ?array
     */
    public function loadObjectList($key = '')
    {
        $this->dbo->setQuery((string)$this->query, 0, $this->_limit);
        return $this->dbo->loadObjectList($key);
    }

    /**
     * @param int $offset
     * @return array
     */
    public function loadColumn($offset = 0)
    {
        $this->dbo->setQuery((string)$this->query, 0, $this->_limit);
        return $this->dbo->loadColumn($offset);
    }

    /**
     * @param string $tableName
     * @param array $columns
     * @param array $indices
     * @param array $extra
     * @return void
     */
    private function createTableMysql($tableName, $columns, $indices, $extra)
    {
        $query = 'CREATE TABLE ';
        if (isset($extra['if_not_exists']) && $extra['if_not_exists'] === true) {
            $query .= 'IF NOT EXISTS ';
        }
        $query .= $this->qn($tableName);
        $query .= '(';
        $buffer = array();
        foreach ($columns as $columnName => $columnType) {
            $q = $this->qn($columnName);
            switch ($columnType['type']) {
                case 'int':
                case 'integer':
                    $q .= ' int';
                    break;
                case 'bigint':
                    $q .= ' int(11)';
                    unset($columnType['size']);
                    break;
                case 'serial':
                    $q .= ' int(10) unsigned auto_increment';
                    unset($columnType['size'], $columnType['unsigned'], $columnType['autoincrement']);
                    break;
                case 'varchar':
                case 'char':
                case 'binary':
                case 'text':
                    $q .= ' ' . $columnType['type'];
                    break;
                default:
                    throw new Exception('Unsupported field type ' . $columnType['type']);
            }
            if (isset($columnType['size']) && is_int($columnType['size'])) {
                $q .= '(' . $columnType['size'] . ')';
            }
            if (!empty($columnType['unsigned'])) {
                $q .= ' unsigned';
            }
            if (!empty($columnType['notnull'])) {
                $q .= ' not null';
            }
            if (!empty($columnType['autoincrement'])) {
                $q .= ' auto_increment';
            }
            if (isset($columnType['default'])) {
                $q .= ' default ' . $columnType['default'];
            }
            $buffer[] = $q;
        }

        foreach ($indices as $indexName => $columnList) {
            switch ($indexName) {
                case '@primary':
                    $q = array();
                    foreach ($columnList as $columnName) {
                        $q[] = $this->qn($columnName);
                    }
                    $buffer[] = 'PRIMARY KEY (' . implode(',', $q) . ')';
                    break;
                default:
                    $q = array();
                    foreach ($columnList as $columnName) {
                        $q[] = $this->qn($columnName);
                    }
                    if ($indexName[0] === '!') { // unique
                        $indexName = substr($indexName, 1);
                        $buffer[] = 'UNIQUE ' . ($indexName === '' ? '' : $this->qn($indexName)) . ' (' . implode(',', $q) . ')';
                    } else {
                        $buffer[] = 'INDEX ' . ($indexName === '' ? '' : $this->qn($indexName)) . ' (' . implode(',', $q) . ')';
                    }
            }
        }

        $query .= implode(', ', $buffer);
        $query .= ')';
        if (isset($extra['charset'])) {
            $query .= ' default charset=' . $extra['charset'];
        }
        $this->dbo->setQuery($query);
        $this->dbo->execute();
    }

    /**
     * @param string $tableName
     * @param array $columns
     * @param array $indices
     * @param array $extra
     * @return void
     */
    private function createTablePostgresql($tableName, $columns, $indices, $extra)
    {
        $query = 'CREATE TABLE ';
        $query .= $this->qn($tableName);
        $query .= '(';
        $buffer = array();
        foreach ($columns as $columnName => $columnType) {
            $q = $this->qn($columnName);
            switch ($columnType['type']) {
                case 'int':
                case 'integer':
                    $q .= ' int';
                    break;
                case 'bigint':
                    $q .= ' int(11)';
                    unset($columnType['size']);
                    break;
                case 'serial':
                    $q .= ' serial';
                    unset($columnType['size'], $columnType['unsigned'], $columnType['autoincrement']);
                    break;
                case 'varchar':
                case 'char':
                case 'text':
                    $q .= ' ' . $columnType['type'];
                    break;
                case 'uuid':
                    $q .= ' uuid';
                    unset($columnType['size'], $columnType['unsigned'], $columnType['autoincrement']);
                    break;
                default:
                    throw new Exception('Unsupported field type ' . $columnType['type']);
            }
            if (isset($columnType['size']) && is_int($columnType['size'])) {
                $q .= '(' . $columnType['size'] . ')';
            }
            if (!empty($columnType['unsigned'])) {
                $q .= ' unsigned';
            }
            if (!empty($columnType['autoincrement'])) {
            }
            if (isset($columnType['default'])) {
                $q .= ' default ' . $columnType['default'];
            }
            if (!empty($columnType['notnull'])) {
                $q .= ' not null';
            }
            $buffer[] = $q;
        }

        foreach ($indices as $indexName => $columnList) {
            switch ($indexName) {
                case '@primary':
                    $q = array();
                    foreach ($columnList as $columnName) {
                        $q[] = $this->qn($columnName);
                    }
                    $buffer[] = 'PRIMARY KEY (' . implode(',', $q) . ')';
                    break;
                default:
                    if ($indexName[0] === '!') { // unique
                        $indexName = substr($indexName, 1);
                        $q = array();
                        foreach ($columnList as $columnName) {
                            $q[] = $this->qn($columnName);
                        }
                        $buffer[] = 'UNIQUE ' . ($indexName === '' ? '' : $this->qn($indexName)) . ' (' . implode(',', $q) . ')';
                    }
            }
        }

        $query .= implode(', ', $buffer);
        $query .= ')';
        $this->dbo->setQuery($query);
        $this->dbo->execute();

        foreach ($indices as $indexName => $columnList) {
            switch ($indexName) {
                case '@primary':
                    break;
                default:
                    if ($indexName[0] !== '!') { // unique
                        $q = array();
                        foreach ($columnList as $columnName) {
                            $q[] = $this->qn($columnName);
                        }
                        $query = 'CREATE INDEX ' . $this->qn($tableName . '_' . $indexName) . ' ON ' . $this->qn($tableName) . ' (' . implode(',', $q) . ')';
                        $this->dbo->setQuery($query);
                        $this->dbo->execute();
                    }
            }
        }
    }
}