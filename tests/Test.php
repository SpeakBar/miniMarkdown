<?php

namespace SpeakBar\tests;

use PHPUnit\Framework\TestCase;
use SpeakBar\MiniMarkdown\Markdown;

class Test extends TestCase
{
    public function test_get_text() {
        $text = "John **Doe**";
        $obj = Markdown::parse($text);

        $this->assertEquals($text, $obj->getText());
    }

    public function test_one_strong_element() {
        $html = Markdown::parse("John **Doe**")->toHtml();

        $this->assertEquals(expected: "John <strong>Doe</strong>", actual: $html);
    }

    public function test_more_strong_element() {
        $html = Markdown::parse("John **Doe** and **Me**")->toHtml();

        $this->assertEquals(
            expected: "John <strong>Doe</strong> and <strong>Me</strong>",
            actual: $html
        );
    }

    public function test_many_tokens() {
        $html = Markdown::parse("John **Doe** and *Me*. __Good bye__")->toHtml();

        $this->assertEquals("John <strong>Doe</strong> and <em>Me</em>. <u>Good bye</u>", $html);
    }

    public function test_combine_token() {
        $html = Markdown::parse("John ***Doe*** *__and__* **__Me__**")->toHtml();

        $this->assertEquals("John <strong><em>Doe</strong></em> <em><u>and</u></em> <strong><u>Me</u></strong>", $html);
    }
}
