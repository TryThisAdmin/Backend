# Get User Ideas

> Lists ideas created by given user

- Endpoint: `/idea/user`
- Method: `GET`
- Parameters:
    - `uid` [required]
    - `limit` [optional]
    - `offset` [optional]
- Return:
    ```ts
    {
        entries: {
            id: string,
            title: string,
            authorID: string,
            author: string,
            created: string,
            updated: string,
            likes: string,
            tags: string
        }[]
    }
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/idea/user?uid=1&limit=5" 
        -X GET
    ```
- Answer:
    ```json
    {
        "entries": [
            {
                "id": "1",
                "title": "Idea #1",
                "authorID": "1",
                "author": "User1",
                "created": "2022-01-01 00:00:00",
                "updated": "2022-01-01 00:00:00",
                "likes": "12",
                "tags": "tag1,tag2,tag3"
            },
            {
                "id": "2",
                "title": "Idea #2",
                "authorID": "1",
                "author": "User1",
                "created": "2022-01-01 00:00:00",
                "updated": "2022-01-01 00:00:00",
                "likes": "10",
                "tags": "tag1,tag2,tag3"
            },
            {
                "id": "3",
                "title": "Idea #3",
                "authorID": "1",
                "author": "User1",
                "created": "2022-01-01 00:00:00",
                "updated": "2022-01-01 00:00:00",
                "likes": "8",
                "tags": "tag1,tag2,tag3"
            },
            {
                "id": "4",
                "title": "Idea #4",
                "authorID": "1",
                "author": "User1",
                "created": "2022-01-01 00:00:00",
                "updated": "2022-01-01 00:00:00",
                "likes": "6",
                "tags": "tag1,tag2,tag3"
            },
            {
                "id": "5",
                "title": "Idea #5",
                "authorID": "1",
                "author": "User1",
                "created": "2022-01-01 00:00:00",
                "updated": "2022-01-01 00:00:00",
                "likes": "4",
                "tags": "tag1,tag2,tag3"
            }
        ]
    }
    ```