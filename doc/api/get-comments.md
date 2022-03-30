# Get Comments

> Lists comments for a given idea

- Endpoint: `/idea/comments`
- Method: `GET`
- Parameters:
    - `id` [required]
    - `limit` [optional]
    - `offset` [optional]
    - `token` [optional]
- Return:
    ```ts
    {
        entries: {
            id: string,
            idea: string,
            content: string,
            authorID: string,
            author: string,
            created: string,
            updated: string,
            likes: string,
            liked: string
        }[]
    }
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/idea/comments?id=1&limit=3&token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxIiwicm9sZSI6ImFkbWluIiwiZXhwIjoiMjAyMi0wMS0wMSAwMDowMDowMCJ9.pXj82eZW-VXjYgIx1L9GrHWn-tcvNg-_mGpEBySaKAg" 
        -X GET
    ```
- Answer:
    ```json
    {
        "entries": [
            {
                "id": "1",
                "idea": "1",
                "content": "Some Content",
                "authorID": "1",
                "author": "User1",
                "created": "2022-01-01 00:00:00",
                "updated": "2022-01-01 00:00:00",
                "likes": "3",
                "liked": "true"
            },
            {
                "id": "2",
                "idea": "1",
                "content": "Some Content",
                "authorID": "2",
                "author": "User2",
                "created": "2022-01-01 00:00:00",
                "updated": "2022-01-01 00:00:00",
                "likes": "2",
                "liked": ""
            },
            {
                "id": "3",
                "idea": "1",
                "content": "Some Content",
                "authorID": "3",
                "author": "User3",
                "created": "2022-01-01 00:00:00",
                "updated": "2022-01-01 00:00:00",
                "likes": "6",
                "liked": "true"
            }
        ]
    }
    ```