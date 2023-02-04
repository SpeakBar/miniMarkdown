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
            "/\~\~(.*?)\~\~/" => "<s>$1</s>",
        ],
        "bbcode" => [],
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
     * Search and replace values
     *
     * @param string[] $rules
     * @return string
     */
    protected function replace(array $rules): string
    {
        $text = $this::$text;
        foreach ($rules as $key => $value) {
            $text = preg_replace($key, $value, $text);
        }
        return $text;
    }

    /**
     * custom rules
     *
     * @param string[] $rules
     * @return string
     */
    public function customRules(array $rules): string
    {
        return $this->replace($rules);
    }

    /**
     * Add rules
     *
     * @param string $key
     * @param string[] $rules
     * @return self
     */
    public function addRules(string $key, array $rules): self
    {
        $this->rules[$key] = array_merge($this->rules[$key], $rules);
        return $this;
    }

    /**
     * Get text with html attribute
     *
     * @return string
     */
    public function toHtml(): string
    {
        return $this->replace($this->rules['html']);
    }

    /**
     * Get text with bbcode attribute
     *
     * @return string
     */
    public function toBbcode(): string
    {
        return $this->replace($this->rules['bbcode']);
    }
}