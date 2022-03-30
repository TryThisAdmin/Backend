# Unsave idea

> Unsaves an idea

- Endpoint: `/idea/save`
- Method: `DELETE`
- Parameters:
    - `id` [required]
    - `token` [required]
- Return:
    ```ts
    {}
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/idea/save?id=1&token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxIiwicm9sZSI6ImFkbWluIiwiZXhwIjoiMjAyMi0wMS0wMSAwMDowMDowMCJ9.pXj82eZW-VXjYgIx1L9GrHWn-tcvNg-_mGpEBySaKAg" 
        -X DELETE
    ```
- Answer:
    ```json
    {}
    ```