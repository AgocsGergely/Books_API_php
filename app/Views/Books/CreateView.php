<?php

namespace App\Views\Counties;

use App\Views\Layout\LayoutView;

class CreateView
{
    public function render(): string
    {
        $content = <<<HTML
        <h1>Új megye létrehozása</h1>

        <form method="post" action="/books/create" class="form">

            <label for="name">Megye neve</label>
            <input type="text" id="name" name="name" required>

            <br><br>

            <button type="submit" class="btn btn-primary">Mentés</button>
            <a href="/books" class="btn btn-secondary">Mégse</a>

        </form>
        HTML;

        return (new LayoutView($content, "Új könyv"))->render();
    }
}