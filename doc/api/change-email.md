# Change User Email

> Changes the email for an user

- Endpoint: `/user/email`
- Method: `POST`
- Parameters:
    - `email` [required]
    - `token` [required]
- Return:
    ```ts
    {}
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/user/email" 
        -X POST
        -F token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxIiwicm9sZSI6ImFkbWluIiwiZXhwIjoiMjAyMi0wMS0wMSAwMDowMDowMCJ9.pXj82eZW-VXjYgIx1L9GrHWn-tcvNg-_mGpEBySaKAg
        -F email=other@mail.com
    ```
- Answer:
    ```json
    {}
    ```