<?php

namespace SpeakBar\MiniMarkdown;
class Markdown
{
    private static string $text;

    private array $rules = [
        "html" => [
            "/\*\*(.*?)\*\*/" => "<strong>$1</strong>",
            "/\*(.*?)\*/" => "<em>$1</em>",
            "/\_\_(.*?)\_\_/" => "<u>$1</u>",
        ]
    ];

    public static function parse(string $text): static
    {
        self::$text = $text;

        return new static();
    }

    public function getText(): string
    {
        return $this::$text;
    }

    /**
     * Get text with html attribute
     *
     * @return string
     */
    public function toHtml(): string
    {
        $text = $this::$text;
        foreach ($this->rules['html'] as $key => $value) {
            $text = preg_replace($key, $value, $text);
        }
        return $text;
    }
}