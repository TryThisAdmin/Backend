# Getting Started

## Developing
- make sure you have PHP v7 or later installed
- make sure your PHP supports SQLite
- customize the functionality to your likings

## Testing
- tests can be created in the folder `test/cases`
- tests must have the extension `.test.php`
- an example can be found [here](../test/cases/Demo.test.php) or [here](../test/cases/API.test.php)
- core functionality already has test cases set up
- tests can be run by executing the `test.php` file and optional giving it specified test
    ```sh
    php test.php Token
    php test.php Assert
    ```

## Deploying

Deploying the application is simple:
1. ensure your server uses Apache and supports rewriting
2. configure the backend in `config.php`
    - replace the `TOKEN_KEY` with your secret key for generating hashes.
    - replace the `TOKEN_EXP` with a duration in hours stating how long tokens are valid
    - replace `FILES_DIR` with a directory to store files, if you use file uploading
    - replace `DATABASE` with the desired name for your SQLite database
3. copy the entire directory to your server and call the `setup.php`
    - only `src/`, `config.php`, `main.php` and `setup.php` are really needed
4. login with default login `Admin:12345678` as specified in `setup.php`