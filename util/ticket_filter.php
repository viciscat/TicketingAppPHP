<?php
$conditions = [];
$params = [];
if (isset($_GET["filter-type"]) && $_GET["filter-type"] != "all") {
    $conditions[] = "type = :type";
    $params[":type"] = $_GET["filter-type"];
}
if (isset($_GET["filter-status"]) && $_GET["filter-status"] != "all") {
    $conditions[] = "status = :status";
    $params[":status"] = $_GET["filter-status"];
}
$condition = count($conditions) > 0 ? implode(" AND ", $conditions) : "TRUE";
return ["condition" => $condition, "params" => $params];