| URL                    | HTTP Method | Auth | JSON Response                       |
| ---------------------- | ----------- | ---- | ----------------------------------- |
| /books                 | GET         | No   | List of all books                   |
| /books/{id}            | GET         | No   | Details of a single book by ID      |
| /books                 | POST        | Yes  | Add a new book                      |
| /books/{id}            | PUT         | Yes  | Update a book by ID                 |
| /books/{id}            | DELETE      | Yes  | Delete a book by ID                 |
| /authors               | GET         | No   | List of all authors                 |
| /authors/{id}          | GET         | No   | Details of a single author by ID    |
| /authors               | POST        | Yes  | Add a new author                    |
| /authors/{id}          | PUT         | Yes  | Update an author by ID              |
| /authors/{id}          | DELETE      | Yes  | Delete an author by ID              |
| /authors/{id}/books    | GET         | No   | List all books of a specific author |
| /categories            | GET         | No   | List of all categories              |
| /categories/{id}       | GET         | No   | Details of a single category by ID  |
| /categories            | POST        | Yes  | Add a new category                  |
| /categories/{id}       | PUT         | Yes  | Update a category by ID             |
| /categories/{id}       | DELETE      | Yes  | Delete a category by ID             |
| /categories/{id}/books | GET         | No   | List all books in a category        |
| /publishers            | GET         | No   | List of all publishers              |
| /publishers            | POST        | Yes  | Add a new publisher                 |
| /publishers/{id}       | PUT         | Yes  | Update a publisher by ID            |
| /publishers/{id}       | DELETE      | Yes  | Delete a publisher by ID            |
| /series                | GET         | No   | List of all series                  |
| /series                | POST        | Yes  | Add a new series                    |
| /series/{id}           | PUT         | Yes  | Update a series by ID               |
| /series/{id}           | DELETE      | Yes  | Delete a series by ID               |
