<?php

namespace GetThingsDone\IdGenerator;

use Exception;
use Illuminate\Support\Facades\DB;

class IdGenerator
{
    protected string $field = 'id';

    protected string $fieldType = 'varchar';

    protected int $fieldLength = 12;

    protected string $table;

    protected int $length;

    protected string $prefix;

    protected array $where = [];

    protected bool $resetOnPrefixChange = false;


    public function __construct(
        $table, $length, $prefix, $field
    ){
        return $this->setTable($table)
                    ->setLength($length)
                    ->setPrefix($prefix)
                    ->setField($field);
    }

    public function make($table, $length, $prefix, $field)
    {
        return new self($table, $length, $prefix, $field);
    }

    public function generate()
    {
        $idLength = $this->getLength() - strlen($this->getPrefix());


        $totalQuery = sprintf("SELECT count(%s) total FROM %s %s", $this->getField(), $this->getTable(), $this->getWhereString());
        $total = DB::select($totalQuery);

        if ($total[0]->total) {
            $maxId = $this->getMaxId();
        }

        return $this->getPrefix() . str_pad($maxId ?? '1', $idLength, '0', STR_PAD_LEFT);
    }

    protected function getMaxId()
    {
        if ($this->getResetOnPrefixChange()) {
            $maxQuery = sprintf("SELECT MAX(%s) maxId from %s WHERE %s like %s", $this->getField(), $this->getTable(), $this->getField(), "'" . $this->getPrefix() . "%'");
        } else {
            $maxQuery = sprintf("SELECT MAX(%s) maxId from %s", $this->getField(), $this->getTable());
        }

        $queryResult = DB::select($maxQuery);
        return $queryResult[0]->maxId;
    }

    protected function getWhereString(): string
    {
        $whereString = '';

        if (!empty($this->getWhere())) {
            $whereString .= " WHERE ";
            foreach ($this->getWhere() as $row) {
                $whereString .= $row[0] . "=" . $row[1] . " AND ";
            }
        }
        $whereString = rtrim($whereString, 'AND ');

        return $whereString;
    }

    /**
     * Get the value of fieldType
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * Set the value of fieldType
     *
     * @return  self
     */
    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    /**
     * Get the value of table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set the value of table
     *
     * @return  self
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get the value of length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set the value of length
     *
     * @return  self
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get the value of prefix
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the value of prefix
     *
     * @return  self
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the value of where
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * Set the value of where
     *
     * @return  self
     */
    public function setWhere($where)
    {
        $this->where = $where;

        return $this;
    }

    /**
     * Get the value of resetOnPrefixChange
     */
    public function getResetOnPrefixChange()
    {
        return $this->resetOnPrefixChange;
    }

    /**
     * Set the value of resetOnPrefixChange
     *
     * @return  self
     */
    public function setResetOnPrefixChange($resetOnPrefixChange)
    {
        $this->resetOnPrefixChange = $resetOnPrefixChange;

        return $this;
    }

    /**
     * Get the value of fieldLength
     */
    public function getFieldLength()
    {
        return $this->fieldLength;
    }

    /**
     * Set the value of fieldLength
     *
     * @return  self
     */
    public function setFieldLength($fieldLength)
    {
        $this->fieldLength = $fieldLength;

        return $this;
    }

    /**
     * Get the value of field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the value of field
     *
     * @return  self
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }
}
