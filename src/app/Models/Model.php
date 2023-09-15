<?php

abstract class Model
{
    private const DEF_VARIABLES = [
        'id'
    ];

    protected int $id;

    public function getInsertSql(): string
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();
        $tableName = $reflection->getConstant('TABLE_NAME');


        $columnNames = [];
        foreach ($properties as $property){
            if (in_array($property->getName(), self::DEF_VARIABLES)) continue;
            $columnNames[] = $property->getName();
        }
        $columnNames = implode(', ', $columnNames);

        $values = '';
        foreach ($properties as $key => $property) {
            $name = $property->getName();
            if (in_array($name, self::DEF_VARIABLES)) continue;

            $value = $property->getValue($this);
            $type = $property->getType();

            if ($type->isBuiltin() && $type->getName() == 'string') $values .= "'$value'";
            else $values .= $value;

            if ($key < sizeof($properties) - sizeof(self::DEF_VARIABLES) - 1) $values .= ', ';
        }

        return "INSERT INTO $tableName ($columnNames) VALUES($values)";
    }
}