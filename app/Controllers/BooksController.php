<?php

namespace App\Controllers;

use App\Http\ApiRequest;
use App\Views\Counties\BooksView;
use App\Views\Counties\BookFormView;

class BooksController
{
    private ApiRequest $api;

    public function __construct()
    {
        $this->api = new ApiRequest();
    }

    public function index(): string
    {
        $books = $this->api->get("/books");
        return (new BooksView($books))->render();
    }

    public function create(): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->post("/books", [
                "name" => $_POST["name"]
            ]);

            header("Location: /books");
            exit;
        }

        return (new BookFormView())->render();
    }

    public function edit(?int $id): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->put("/books/$id", [
                "name" => $_POST["name"]
            ]);

            header("Location: /books");
            exit;
        }

        $book = $this->api->get("/books/$id");
        return (new BookFormView($book))->render();
    }

    public function delete(?int $id): void
    {
        $this->api->delete("/books/$id");

        header("Location: /books");
        exit;
    }
}