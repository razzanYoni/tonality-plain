## Overview
Tonality is a monolithic web application to stream your personal music collection. It's built using HTML, CSS, JavaScript, PHP, and MySQL.

## Prerequisites
- [Docker](https://docs.docker.com/get-docker/)

## How to Install
1. Download the latest release and extract it to a folder.
2. Create an `.env` file with environment variables as specified in `.env.docker`. Specify the empty values.

## How to Start the Server
1. Navigate to the root directory of the project.
2. Run the following command to create and start Docker containers for the project.
  
    ```shell
    docker compose up
    ```
3. You can now access the web application at `localhost:8080`.

## Screenshots

WIP

## Task Distribution

### Team Members
| Student ID | GitHub                                          |
|------------|-------------------------------------------------|
| 13521063   | [Salomo309](https://github.com/Salomo309)       |
| 13521087   | [razzanYoni](https://github.com/razzanYoni)     |
| 13521096   | [noelsimbolon](https://github.com/noelsimbolon) |

### Server Side
| Task                              | Student ID         |
|-----------------------------------|--------------------|
| User CRUD Operations and Auth     | 13521063, 13521087 |
| Delete Operations                 | 13521063, 13521087 |
| Searching, Filtering, and Sorting | 13521087           |
| Pagination                        | 13521087           |
| Create and Update Operations      | 13521096, 13521063 |
| Database                          | 13521096, 13521087 |
| Docker                            | 13521096           |


### Client Side
| Task                     | Student ID                   |
|--------------------------|------------------------------|
| Form                     | 13521063, 13521087, 13521096 |
| Navigation Bar           | 13521096, 13521063           |
| Album and Playlist Card  | 13521096                     |
| Filter and Sort Controls | 13521063, 13521096           |
| Table                    | 13521063                     |
| Audio Player             | 13521063                     |
| Pagination               | 13521087, 13521096           |
| AJAX                     | 13521087                     |
