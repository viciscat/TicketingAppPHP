<?php
$conditions = [];
$params = [];
// TODO check the values are valid one day
if (isset($_GET["filter-type"]) && $_GET["filter-type"] != "all") {
    $conditions[] = "type = :type";
    $params[":type"] = htmlspecialchars($_GET["filter-type"]);
}
if (isset($_GET["filter-status"]) && $_GET["filter-status"] != "all") {
    $conditions[] = "status = :status";
    $params[":status"] = htmlspecialchars($_GET["filter-status"]);
}
$condition = count($conditions) > 0 ? implode(" AND ", $conditions) : "TRUE";
return ["condition" => $condition, "params" => $params];