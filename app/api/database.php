<?php

class Database
{
    private static $conn;

    /**
     * برقراری ارتباط با پایگاه داده
     *
     * @return mysqli
     */
    protected function db_connect(): mysqli
    {
        require_once('dbConnection.php');
        if (!isset(self::$conn)) {
            self::$conn = dbConnection::getInstance();
        }
        return self::$conn;
    }

    /**
     * دریافت رکوردهای جدول بر اساس شرط مشخص شده
     *
     * @param string $tblname نام جدول
     * @param string $where شرط WHERE (اختیاری)
     * @return array آرایه حاوی رکوردها
     */
    public function getRecord(string $tblname, string $where = '1'): array
    {
        $con = $this->db_connect();

        $query = "SELECT * FROM $tblname WHERE $where";
        $result = mysqli_query($con, $query);

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * افزودن رکورد جدید به جدول
     *
     * @param string $tblname نام جدول
     * @param array|null $values آرایه حاوی فیلدها و مقادیر (اختیاری)
     * @return bool نتیجه عملیات
     */
    public function addRecord(string $tblname, array $values = null): bool
    {
        require_once('functions.php');
        $con = $this->db_connect();
        $tblname = cleanData($tblname);

        if ($values === null) {
            return false;
        }

        if (is_array($values)) {
            $keys = array_map(function($key) {
                return '' . cleanData($key) . '';
            }, array_keys($values));

            $cleanedValues = array_map(function($value) use ($con) {
                return "'" . mysqli_real_escape_string($con, cleanData($value)) . "'";
            }, array_values($values));

            $keyString = implode(',', $keys);
            $valueString = implode(',', $cleanedValues);

            $query = "INSERT INTO $tblname ($keyString) VALUES ($valueString)";
            $result = mysqli_query($con, $query);

            return $result !== false;
        }

        return false;
    }

    /**
     * به‌روزرسانی رکورد در جدول
     *
     * @param string $tblname نام جدول
     * @param array $values آرایه حاوی فیلدها و مقادیر
     * @param string $where شرط WHERE
     * @return bool نتیجه عملیات
     */
    public function updateRecord(string $tblname, array $values, string $where): bool
    {
        require_once('functions.php');
        $con = $this->db_connect();
        $tblname = cleanData($tblname);

        if (is_array($values)) {

            $setValues = [];
            foreach ($values as $key => $value) {
                $key = cleanData($key);
                $cleanedValue = mysqli_real_escape_string($con, cleanData($value));
                $setValues[] = "$key='$cleanedValue'";
            }

            $setString = implode(',', $setValues);
            $query = "UPDATE $tblname SET $setString WHERE $where";

            $result = mysqli_query($con, $query);

            return $result !== false;
        }

        return false;
    }

    public function deleteRecord($tblname, $where): bool
    {
        require_once('functions.php');
        $con = $this->db_connect();

        $query = "DELETE FROM $tblname WHERE $where";
        $result = mysqli_query($con, $query);

        return $result !== false;
    }

    public function getCount($tblname, $where = '1'): int
    {
        $records = $this->getRecord($tblname, $where);
        return count($records);
    }
}