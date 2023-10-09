<?php
class DateUtil {

    const MONTH_LIST = [
        [1,"Janeiro"],
        [2,"Fevereiro"],
        [3,"Março"],
        [4,"Abril"],
        [5,"Maio"],
        [6,"Junho"],
        [7,"Julho"],
        [8,"Agosto"],
        [9,"Setembro"],
        [10,"Outubro"],
        [11,"Novembro"],
        [12,"Dezembro"]
    ];

    public static function getMonth(int $month) {
        foreach (self::MONTH_LIST as $key => $value) {
            if ($value[0] == $month) {
                return $value[1];
            }
        }
        return "";
    }
}
?>