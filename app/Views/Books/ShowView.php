<?php

namespace App\Views\Counties;

use App\Views\Layout\LayoutView;

class ShowView
{
    public function __construct(private array $county) {}

    public function render(): string
    {
        $id = $this->county["id"];
        $name = htmlspecialchars($this->county["name"]);

        $content = <<<HTML
        <h1>Megye részletei</h1>

        <table class="table details-table">
            <tr>
                <th>ID</th>
                <td>{$id}</td>
            </tr>
            <tr>
                <th>Megnevezés</th>
                <td>{$name}</td>
            </tr>
        </table>

        <br>

        <a href="/books/edit/{$id}" class="btn btn-warning">Szerkesztés</a>
        <a href="/books/delete/{$id}" class="btn btn-danger" onclick="return confirm('Biztos törlöd?')">Törlés</a>
        <a href="/books" class="btn btn-secondary">Vissza a listához</a>
        HTML;

        return (new LayoutView($content, "Könyv részletei"))->render();
    }
}