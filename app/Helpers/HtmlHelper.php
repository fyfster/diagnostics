<?php

namespace App\Helpers;

class HtmlHelper
{
    public const OK = 200;
    public const UNAUTHORIZED = 401;
    public const NOT_FOUND = 404;
    public const INTERNAL_SERVER_ERROR = 500;

    public static function button(array $dataAttributes, array $customClass, string $buttonText): string
    {
        $dataAttributesString = '';
        foreach ($dataAttributes as $key => $value) {
            $dataAttributesString .= 'data-' . $key . '="' . $value . '" ';
        }

        $customClassString = '';
        foreach ($customClass as $class) {
            $customClassString .= $class . ' ';
        }

        return '<button ' . $dataAttributesString . 'class="btn ' . $customClassString . '">' . $buttonText . '</button>';
    }

    public static function anchor(string $href, array $customClass, string $buttonText): string
    {
        $dataAttributesString = '';
        $dataAttributesString .= 'href="' . $href . '" ';

        $customClassString = '';
        foreach ($customClass as $class) {
            $customClassString .= $class . ' ';
        }

        return '<a ' . $dataAttributesString . 'class="btn ' . $customClassString . '">' . $buttonText . '</a>';
    }

    public static function smallCircleButton(array $dataAttributes, array $customClass, string $buttonText): string
    {
        return self::button($dataAttributes, array_merge($customClass, ['btn-sm', 'btn-circle']), $buttonText);
    }

    public static function smallCircleAnchor(string $href, array $customClass, string $buttonText): string
    {
        return self::anchor($href, array_merge($customClass, ['btn-sm', 'btn-circle']), $buttonText);
    }
}