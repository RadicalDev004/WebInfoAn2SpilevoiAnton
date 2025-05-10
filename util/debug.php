<?php
class Debug {
    public static function printArray(array $array, bool $asHtml = true): void {
        if ($asHtml) {
            echo "<pre>" . htmlspecialchars(print_r($array, true)) . "</pre>";
        } else {
            echo print_r($array, true);
        }
    }
}
