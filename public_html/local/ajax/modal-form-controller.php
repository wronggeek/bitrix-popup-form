<?php

use Bitrix\Main\Web\Json;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;

define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");
define('STOP_STATISTICS', true);
define('PUBLIC_AJAX_MODE', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

const IBLOCK_ID = 5;

if ($_REQUEST) {
    try {
        $data = $_REQUEST;

        createFormMessage($data);
        setRequestResult("modal-form", "success", 'ok', $data);
    } catch (Exception $exception) {
        setRequestResult("modal-form",'error', $exception->getMessage());
    }
} else {
    setRequestResult("modal-form", 'error', 'нет данных');
}

function setRequestResult($action = '', $status = '', $description = '', $data = []) {
    echo Json::encode([
        'action'      => $action,
        'status'      => $status ?: 'error',
        'description' => $description,
        'data'        => $data
    ]);
    die();
}

function createFormMessage($data) {
    Loader::includeModule("iblock");

    $element = new CIBlockElement();

    $properties = [
        "NAME"    => $data["name"],
        "PHONE"   => htmlspecialchars($data["phone"]),
        "MESSAGE" => $data["msg"] ? htmlspecialchars($data["msg"]) : ""
    ];

    $fields = [
        'PROPERTY_VALUES' => $properties,
        'IBLOCK_ID'       => IBLOCK_ID,
        'ACTIVE'          => 'Y',
        'NAME'            => "Сообщение формы " . date("d.m.Y"),
    ];

    return $element->Add($fields);
}