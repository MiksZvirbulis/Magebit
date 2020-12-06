<?php
function translateSort($sort_key) {
    switch($sort_key) {
        case 'date_asc':
            $sort = array(
                "type" => "time",
                "sort" => "ASC"
            );
        break;
        case 'date_desc':
            $sort = array(
                "type" => "time",
                "sort" => "DESC"
            );
        break;
        case 'email_ASC':
            $sort = array(
                "type" => "email",
                "sort" => "ASC"
            );
        break;
        case 'email_desc':
            $sort = array(
                "type" => "email",
                "sort" => "DESC"
            );
        break;
        default:
            $sort = array(
                "type" => "time",
                "sort" => "ASC"
            );
        break;
    }
    return $sort;
}