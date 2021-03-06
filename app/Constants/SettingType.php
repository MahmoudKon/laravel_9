<?php

namespace App\Constants;

use App\Traits\UploadFile;
use Carbon\Carbon;

class SettingType {
    use UploadFile;

    const ADVANCED_TEXT = 1;
    const NORMAL_TEXT   = 2;
    const IMAGE         = 3;
    const AUDIO         = 4;
    const VIDEO         = 5;
    const EXTERNAL_LINK = 6;
    const SELECTOR      = 7;
    const TIME          = 8;
    const WEEKEND_DAYS  = 9;
    const FILE          = 10;
    const PATH  = "uploads/settings/";

    public static function viewHandler(int $type_id) :string
    {
        $view_path = '';
        switch ($type_id) {
            case self::ADVANCED_TEXT:
                $view_path = 'backend.settings.inputs.advanced_text';
                break;

            case self::NORMAL_TEXT:
                $view_path = 'backend.settings.inputs.normal_text';
                break;

            case self::IMAGE:
                $view_path = 'backend.settings.inputs.image';
                break;

            case self::AUDIO:
                $view_path = 'backend.settings.inputs.audio';
                break;

            case self::VIDEO:
                $view_path = 'backend.settings.inputs.video';
                break;

            case self::EXTERNAL_LINK:
                $view_path = 'backend.settings.inputs.external_link';
                break;

            case self::SELECTOR:
                $view_path = 'backend.settings.inputs.selector';
                break;

            case self::TIME:
                $view_path = 'backend.settings.inputs.time';
                break;

            case self::WEEKEND_DAYS:
                $view_path = 'backend.settings.inputs.weekend_days';
                break;

            case self::FILE:
                $view_path = 'backend.settings.inputs.file';
                break;
        }
        return $view_path;
    }

    public static function validaionHandler(int $type_id) :array
    {
        $validations = [];
        switch ($type_id) {
            case self::ADVANCED_TEXT:
            case self::NORMAL_TEXT:
                $validations["value"] = 'required|string';
                break;

            case self::IMAGE:
                $validations["value"] = 'required_without:id|image|mimes:png,jpg,jpeg';
                break;

            case self::AUDIO:
                $validations['value'] = 'required_without:id|mimes:mp3,wav';
                break;

            case self::VIDEO:
                $validations['value'] = 'required_without:id|mimes:mp4';
                break;

            case self::EXTERNAL_LINK:
                $validations['value'] = 'required|url';
                break;

            case self::SELECTOR:
                $validations['value'] = 'required|boolean';
                break;

            case self::TIME:
                $validations['value'] = 'required';
                break;

            case self::WEEKEND_DAYS:
                $validations['value'] = 'required|array';
                $validations['value.*'] = 'required|between:0,6';
                break;

            case self::FILE:
                $validations['value'] = 'required_without:id|file|mimes:xlsx,csv,xls,pdf,doc,docx,jpeg,png';
                break;
        }
        return $validations;
    }

    public function requestHandler(array $request) :string
    {
        $response = [];
        switch ($request['content_type_id']) {
            case self::ADVANCED_TEXT:
            case self::NORMAL_TEXT:
            case self::EXTERNAL_LINK:
            case self::TIME:
            case self::SELECTOR:
                $response = $request['value'];
                break;

            case self::IMAGE:
                [$width, $height] = getimagesize($request['value']);
                $response = $this->uploadImage($request['value'], 'settings', $width, $height, true);
                break;

            case self::AUDIO:
            case self::VIDEO:
            case self::FILE:
                $response = $this->uploadImage($request['value'], 'settings', NUll, NULL, true);
                break;

            case self::WEEKEND_DAYS:
                $response = implode(',', $request['value']);
                break;
        }

        return $response;
    }

    public static function displatHtmlHandler(int $type_id, $value)
    {
        $view_path = '';
        switch ($type_id) {
            case self::ADVANCED_TEXT:
            case self::EXTERNAL_LINK:
            case self::NORMAL_TEXT:
                $view_path = $value;
                break;

            case self::SELECTOR:
                $view_path = $value ? "TURE" : "FALSE";
                break;

            case self::WEEKEND_DAYS:
                foreach (explode(',', $value) as $day)
                    $view_path .= Carbon::getDays()[$day].", ";
                break;

            case self::TIME:
                    $view_path = timeReFormatting($value, 'h:i A');
                break;

            case self::IMAGE:
                $view_path = view('backend.includes.content_types.image', ['image' => $value])->render();
                break;

            case self::AUDIO:
                $view_path = view('backend.includes.content_types.audio', ['audio' => $value])->render();
                break;

            case self::VIDEO:
                $view_path = view('backend.includes.content_types.video', ['video' => $value])->render();
                break;

            case self::FILE:
                $view_path = view('backend.includes.content_types.file', ['file' => $value])->render();
                break;
        }

        return $view_path;
    }
}
