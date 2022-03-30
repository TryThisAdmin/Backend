# Update Existing Idea

> Updates an existing idea

- Endpoint: `/idea`
- Method: `POST`
- Parameters:
    - `id` [required]
    - `title` [required]
    - `content`[required]
    - `tags` [required]
    - `token` [required]
- Return:
    ```ts
    {}
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/idea" 
        -X POST
        -F id=1
        -F title=FirstIdea
        -F content=SomeContent
        -F tags=tag1,tag2,tag3
        -F token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxIiwicm9sZSI6ImFkbWluIiwiZXhwIjoiMjAyMi0wMS0wMSAwMDowMDowMCJ9.pXj82eZW-VXjYgIx1L9GrHWn-tcvNg-_mGpEBySaKAg
    ```
- Answer:
    ```json
    {}
    ```