<?php
class dbConnection
{
    private static $mysqli;

    final private function __construct() {}

    public static function getInstance()
    {
        $HOST = "localhost";
        $USER = "root";
        $PASS = "";
        $DB_NAME = "romano";

        /*
        $HOST = "localhost";
        $USER = "mgjnsteq_romano";
        $PASS = "Keyvan021";
        $DB_NAME = "mgjnsteq_romano";
        */

        // بررسی اینکه آیا اتصال به پایگاه داده قبلاً برقرار شده است یا خیر
        if (!is_object(self::$mysqli)) {
            // ایجاد یک نمونه از کلاس mysqli برای اتصال به پایگاه داده با استفاده از مقادیر متغیرهای تعریف شده
            self::$mysqli = new mysqli($HOST , $USER , $PASS ,$DB_NAME );

            // تنظیم مجموعه کاراکتر به utf8mb4 برای پشتیبانی از کاراکترهای چندبایتی
            self::$mysqli->set_charset("utf8mb4");

            // بازگشت نام مجموعه کاراکتری فعلی
            self::$mysqli->character_set_name();
        }

        return self::$mysqli;
    }

    private function __destruct()
    {
        // بستن اتصال به پایگاه داده در هنگام نابودی شیء
        if (self::$mysqli) {
            self::$mysqli->close();
        }
    }

    private function __clone() {}

}