<?php

namespace App\Views\Counties;

use App\Views\Layout\LayoutView;

class EditView
{
    public function __construct(private array $county) {}

    public function render(): string
    {
        $county = $this->county['entity'];
        $id = $county["id"];
        $name = htmlspecialchars($county["name"]);

        $content = <<<HTML
        <h1>Könyv módosítása</h1>

        <form method="post" action="/books/edit/{$id}" class="form">

            <label for="name">Könyv neve</label>
            <input type="text" id="name" name="name" value="{$name}" required>

            <br><br>

            <button type="submit" class="btn btn-primary">Mentés</button>
            <a href="/books" class="btn btn-secondary">Mégse</a>

        </form>
        HTML;

        return (new LayoutView($content, "Könyv módosítása"))->render();
    }
}