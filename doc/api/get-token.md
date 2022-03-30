# Get a Token

> Generates a new token for authentification.

- Endpoint: `/token`
- Method: `GET`
- Parameters:
    - `username` [required]
    - `password` [required]
- Return:
    ```ts
    {
        token: string
    }
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/token?username=User1&password=12345678" 
        -X GET
    ```
- Answer:
    ```json
    {
        "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxIiwicm9sZSI6ImFkbWluIiwiZXhwIjoiMjAyMi0wMS0wMSAwMDowMDowMCJ9.pXj82eZW-VXjYgIx1L9GrHWn-tcvNg-_mGpEBySaKAg"
    }
    ```