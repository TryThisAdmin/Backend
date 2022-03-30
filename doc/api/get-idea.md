# Get Idea

> Returns idea data

- Endpoint: `/idea`
- Method: `GET`
- Parameters:
    - `id` [required]
    - `token` [optional]
- Return:
    ```ts
    {
        entries: {
            id: string,
            title: string,
            content: string,
            authorID: string,
            author: string,
            created: string,
            updated: string,
            likes: string,
            tags: string,
            liked: string,
            saved: string
        }[]
    }
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/idea?id=1&token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxIiwicm9sZSI6ImFkbWluIiwiZXhwIjoiMjAyMi0wMS0wMSAwMDowMDowMCJ9.pXj82eZW-VXjYgIx1L9GrHWn-tcvNg-_mGpEBySaKAg" 
        -X GET
    ```
- Answer:
    ```json
    {
        "entries": [
            {
                "id": "1",
                "title": "Idea #1",
                "content": "Some Content",
                "authorID": "1",
                "author": "User1",
                "created": "2022-01-01 00:00:00",
                "updated": "2022-01-01 00:00:00",
                "likes": "12",
                "tags": "tag1,tag2,tag3",
                "liked": "true",
                "saved": ""
            }
        ]
    }
    ```