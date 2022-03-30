# Update Comment

> Updates an existing comment

- Endpoint: `/comment`
- Method: `POST`
- Parameters:
    - `id` [required]
    - `idea` [required]
    - `content`[required]
    - `token` [required]
- Return:
    ```ts
    {}
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/comment" 
        -X POST
        -F id=1
        -F idea=1
        -F content=SomeContent
        -F token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxIiwicm9sZSI6ImFkbWluIiwiZXhwIjoiMjAyMi0wMS0wMSAwMDowMDowMCJ9.pXj82eZW-VXjYgIx1L9GrHWn-tcvNg-_mGpEBySaKAg
    ```
- Answer:
    ```json
    {}
    ```