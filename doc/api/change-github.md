# Change User GitHub Username

> Changes the GitHub username for an user

- Endpoint: `/user/github`
- Method: `POST`
- Parameters:
    - `username` [required]
    - `token` [required]
- Return:
    ```ts
    {}
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/user/github" 
        -X POST
        -F token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxIiwicm9sZSI6ImFkbWluIiwiZXhwIjoiMjAyMi0wMS0wMSAwMDowMDowMCJ9.pXj82eZW-VXjYgIx1L9GrHWn-tcvNg-_mGpEBySaKAg
        -F username=user1
    ```
- Answer:
    ```json
    {}
    ```