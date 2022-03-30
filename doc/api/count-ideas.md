# Count Ideas

> Counts all ideas in database

- Endpoint: `/info/ideas`
- Method: `GET`
- Parameters:
    - none
- Return:
    ```ts
    {
        ideas: string
    }
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/info/ideas" 
        -X GET
    ```
- Answer:
    ```json
    {
        "ideas": "200"
    }
    ```