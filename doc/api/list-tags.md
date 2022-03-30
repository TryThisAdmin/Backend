# List Tags

> Lists all used tags in database

- Endpoint: `/info/tags`
- Method: `GET`
- Parameters:
    - none
- Return:
    ```ts
    {
        entries: string[]
    }
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/info/tags" 
        -X GET
    ```
- Answer:
    ```json
    {
        "entries": [
            "tag1",
            "tag2",
            "tag3"
        ]
    }
    ```