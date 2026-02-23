<?php

namespace App\Views\Layout;

class LayoutView
{
    public function __construct(
        private string $content,
        private string $title = "REST kliens"
    ) {}

    public function render(): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="hu">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{$this->title}</title>

            <link rel="stylesheet" href="/assets/style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        </head>

        <body>

            {$this->renderMenu()}

            <main class="container">
                {$this->content}
            </main>

        </body>
        </html>
        HTML;
    }

    private function renderMenu(): string
    {
        return <<<HTML
        <nav class="navbar">
            <a href="/books">Könyvek</a>
            <a href="/authors">Írok</a>
        </nav>
        HTML;
    }
}