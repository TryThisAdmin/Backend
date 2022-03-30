# Register New User

> Registers a new user account.

- Endpoint: `/register`
- Method: `POST`
- Parameters:
    - `username` [required]
    - `email` [required]
    - `password` [required]
- Return:
    ```ts
    {}
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/register" 
        -X POST
        -F username=User1
        -F email=some@mail.com
        -F password=12345678
    ```
- Answer:
    ```json
    {}
    ```